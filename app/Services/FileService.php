<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileService
{
    protected string $disk;
    protected array $allowedMimeTypes = [];
    protected array $allowedExtensions = [];
    protected int $maxSize;
    protected string $storagePath;
    protected bool $generateUniqueName;

    public function __construct(
        string $disk = 'public',
        array $allowedMimeTypes = [],
        array $allowedExtensions = [],
        int $maxSize = 20480,
        string $storagePath = '',
        bool $generateUniqueName = true
    ) {
        $this->disk = $disk;
        $this->allowedMimeTypes = $allowedMimeTypes;
        $this->allowedExtensions = $allowedExtensions;
        $this->maxSize = $maxSize;
        $this->storagePath = $storagePath;
        $this->generateUniqueName = $generateUniqueName;
    }

    public static function forTicketAttachments(): self
    {
        return new self(
            disk: 'public',
            allowedMimeTypes: [
                'image/jpeg', 'image/jpg', 'image/png', 'image/gif',
                'video/mp4', 'video/mov', 'video/avi',
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
            ],
            allowedExtensions: ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'mov', 'avi', 'pdf', 'doc', 'docx'],
            maxSize: 20480,
            storagePath: 'ticket-attachments',
            generateUniqueName: true
        );
    }

    public static function forProfilePhotos(): self
    {
        return new self(
            disk: 'public',
            allowedMimeTypes: ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'],
            allowedExtensions: ['jpg', 'jpeg', 'png', 'gif'],
            maxSize: 5120,
            storagePath: 'profile-photos',
            generateUniqueName: true
        );
    }

    public static function forSettings(): self
    {
        return new self(
            disk: 'public',
            allowedMimeTypes: ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/x-icon', 'image/vnd.microsoft.icon'],
            allowedExtensions: ['jpg', 'jpeg', 'png', 'gif', 'ico'],
            maxSize: 2048,
            storagePath: 'settings',
            generateUniqueName: true
        );
    }

    public static function create(
        string $disk = 'public',
        array $allowedMimeTypes = [],
        array $allowedExtensions = [],
        int $maxSizeKB = 20480,
        string $storagePath = '',
        bool $generateUniqueName = true
    ): self {
        return new self(
            disk: $disk,
            allowedMimeTypes: $allowedMimeTypes,
            allowedExtensions: $allowedExtensions,
            maxSize: $maxSizeKB,
            storagePath: $storagePath,
            generateUniqueName: $generateUniqueName
        );
    }

    public function upload(UploadedFile $file, ?string $subPath = null, ?string $customName = null): array
    {
        $this->validateFile($file);

        $fileName = $this->generateFileName($file, $customName);
        $storagePath = $this->buildStoragePath($subPath);

        $path = $file->storeAs($storagePath, $fileName, $this->disk);

        return [
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'file_type' => $this->determineFileType($file->getMimeType()),
            'extension' => $file->getClientOriginalExtension(),
            'storage_disk' => $this->disk,
        ];
    }

    public function uploadToPublic(UploadedFile $file, string $publicPath, ?string $customName = null): array
    {
        $this->validateFile($file);

        $fileName = $customName ? $customName . '.' . $file->getClientOriginalExtension() : $this->generateFileName($file);
        $fullPublicPath = public_path($publicPath);
        
        if (!is_dir($fullPublicPath)) {
            mkdir($fullPublicPath, 0755, true);
        }

        $file->move($fullPublicPath, $fileName);
        $relativePath = $publicPath . '/' . $fileName;

        return [
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $relativePath,
            'public_path' => $fullPublicPath . '/' . $fileName,
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'file_type' => $this->determineFileType($file->getMimeType()),
            'extension' => $file->getClientOriginalExtension(),
            'url' => asset($relativePath),
        ];
    }

    public function uploadMultiple(array $files, ?string $subPath = null): array
    {
        $uploadedFiles = [];
        
        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $uploadedFiles[] = $this->upload($file, $subPath);
            }
        }
        
        return $uploadedFiles;
    }

    public function delete(string $filePath, ?string $disk = null): bool
    {
        $disk = $disk ?? $this->disk;
        
        if (Storage::disk($disk)->exists($filePath)) {
            return Storage::disk($disk)->delete($filePath);
        }
        
        return false;
    }

    public function deleteFromPublic(string $publicPath): bool
    {
        $fullPath = public_path($publicPath);
        
        if (file_exists($fullPath) && is_file($fullPath)) {
            return unlink($fullPath);
        }
        
        return false;
    }

    public function deleteDirectory(string $directoryPath, ?string $disk = null): bool
    {
        $disk = $disk ?? $this->disk;
        
        if (Storage::disk($disk)->exists($directoryPath)) {
            return Storage::disk($disk)->deleteDirectory($directoryPath);
        }
        
        return false;
    }

    public function exists(string $filePath, ?string $disk = null): bool
    {
        $disk = $disk ?? $this->disk;
        return Storage::disk($disk)->exists($filePath);
    }

    public function getUrl(string $filePath, ?string $disk = null): string
    {
        $disk = $disk ?? $this->disk;
        return Storage::disk($disk)->url($filePath);
    }

    public function getPath(string $filePath, ?string $disk = null): string
    {
        $disk = $disk ?? $this->disk;
        return Storage::disk($disk)->path($filePath);
    }

    protected function validateFile(UploadedFile $file): void
    {
        $mimeType = $file->getMimeType();
        $extension = strtolower($file->getClientOriginalExtension());
        $size = $file->getSize();

        if (!empty($this->allowedMimeTypes) && !in_array($mimeType, $this->allowedMimeTypes)) {
            throw new \InvalidArgumentException("File type '{$mimeType}' is not allowed. Allowed types: " . implode(', ', $this->allowedMimeTypes));
        }

        if (!empty($this->allowedExtensions) && !in_array($extension, $this->allowedExtensions)) {
            throw new \InvalidArgumentException("File extension '{$extension}' is not allowed. Allowed extensions: " . implode(', ', $this->allowedExtensions));
        }

        if ($size > ($this->maxSize * 1024)) {
            $maxSizeMB = round($this->maxSize / 1024, 2);
            throw new \InvalidArgumentException("File size exceeds maximum allowed size of {$maxSizeMB} MB");
        }
    }

    protected function generateFileName(UploadedFile $file, ?string $customName = null): string
    {
        if ($customName) {
            return $customName . '.' . $file->getClientOriginalExtension();
        }

        if ($this->generateUniqueName) {
            return Str::random(40) . '.' . $file->getClientOriginalExtension();
        }

        return $file->getClientOriginalName();
    }

    protected function buildStoragePath(?string $subPath = null): string
    {
        if ($subPath) {
            return $this->storagePath ? $this->storagePath . '/' . $subPath : $subPath;
        }
        
        return $this->storagePath;
    }

    protected function determineFileType(string $mimeType): string
    {
        if (str_starts_with($mimeType, 'image/')) {
            return 'image';
        }
        
        if (str_starts_with($mimeType, 'video/')) {
            return 'video';
        }
        
        return 'document';
    }

    public function setDisk(string $disk): self
    {
        $this->disk = $disk;
        return $this;
    }

    public function setAllowedMimeTypes(array $types): self
    {
        $this->allowedMimeTypes = $types;
        return $this;
    }

    public function setAllowedExtensions(array $extensions): self
    {
        $this->allowedExtensions = $extensions;
        return $this;
    }

    public function setMaxSize(int $maxSizeKB): self
    {
        $this->maxSize = $maxSizeKB;
        return $this;
    }

    public function setStoragePath(string $path): self
    {
        $this->storagePath = $path;
        return $this;
    }

    public function setGenerateUniqueName(bool $generate): self
    {
        $this->generateUniqueName = $generate;
        return $this;
    }
}

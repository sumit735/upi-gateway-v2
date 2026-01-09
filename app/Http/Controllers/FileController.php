<?php

namespace App\Http\Controllers;

use App\Models\TicketAttachment;
use App\Enums\PageEnum;
use App\Enums\ActionEnum;
use App\Enums\ScopeEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function downloadAttachment(TicketAttachment $attachment)
    {
        $user = Auth::user();
        $ticket = $attachment->ticket;

        $hasAllScope = $user->hasPermission(PageEnum::TICKETS->value, ActionEnum::VIEW->value, ScopeEnum::ALL->value);
        $hasSelfScope = $user->hasPermission(PageEnum::TICKETS->value, ActionEnum::VIEW->value, ScopeEnum::SELF->value);

        if (!$hasAllScope && !$hasSelfScope) {
            abort(403, 'Unauthorized action.');
        }

        if (!$hasAllScope && $ticket->user_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        if (!Storage::disk('public')->exists($attachment->file_path)) {
            abort(404, 'File not found.');
        }

        $filePath = Storage::disk('public')->path($attachment->file_path);
        return response()->file($filePath, [
            'Content-Type' => $attachment->mime_type,
            'Content-Disposition' => 'inline; filename="' . $attachment->file_name . '"',
        ]);
    }
}

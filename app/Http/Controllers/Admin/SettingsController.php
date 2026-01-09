<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Display settings page with all categories
     */
    public function index()
    {
        $webConfigSettings = Settings::where('category', 'web_config')->get();
        $ratesSettings = Settings::where('category', 'rates')->get();
        $pgConfigSettings = Settings::where('category', 'pg_config')->get();
        $apiConfigSettings = Settings::where('category', 'api_config')->get();
        return view('admin.settings.index', compact(
            'webConfigSettings',
            'ratesSettings',
            'pgConfigSettings',
            'apiConfigSettings'
        ));
    }

    /**
     * Update settings via AJAX
     */
    public function update(Request $request)
    {
        $request->validate([
            'settings' => 'required|array',
            'settings.*.id' => 'required|exists:settings,id',
            'settings.*.value' => 'nullable|string',
            'category' => 'required|string',
        ]);

        try {
            $uploads = [];
            $fileService = \App\Services\FileService::forSettings();
            
            if ($request->hasFile('logo_file')) {
                $logoSetting = Settings::where('key', 'logo')->first();
                if ($logoSetting && $logoSetting->value) {
                    $fileService->deleteFromPublic('admin/assets/img/' . $logoSetting->value);
                }
                
                $logoName = 'logo_' . time();
                $uploadedFile = $fileService->uploadToPublic($request->file('logo_file'), 'admin/assets/img', $logoName);
                
                if ($logoSetting) {
                    $logoSetting->update(['value' => basename($uploadedFile['file_path'])]);
                    $uploads['logo'] = $uploadedFile['url'];
                }
            }
            
            if ($request->hasFile('favicon_file')) {
                $faviconSetting = Settings::where('key', 'favicon')->first();
                if ($faviconSetting && $faviconSetting->value) {
                    $fileService->deleteFromPublic('admin/assets/img/' . $faviconSetting->value);
                }
                
                $faviconName = 'favicon_' . time();
                $uploadedFile = $fileService->uploadToPublic($request->file('favicon_file'), 'admin/assets/img', $faviconName);
                
                if ($faviconSetting) {
                    $faviconSetting->update(['value' => basename($uploadedFile['file_path'])]);
                    $uploads['favicon'] = $uploadedFile['url'];
                }
            }

            // Update other settings
            foreach ($request->settings as $settingData) {
                Settings::where('id', $settingData['id'])->update([
                    'value' => $settingData['value']
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => ucfirst($request->category) . ' settings updated successfully',
                'uploads' => $uploads
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update settings: ' . $e->getMessage()
            ], 500);
        }
    }
}

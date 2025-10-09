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
            
            // Handle file uploads for logo and favicon
            if ($request->hasFile('logo_file')) {
                $logoFile = $request->file('logo_file');
                $logoName = 'logo_' . time() . '.' . $logoFile->getClientOriginalExtension();
                $logoFile->move(public_path('admin/assets/img'), $logoName);
                
                $logoSetting = Settings::where('key', 'logo')->first();
                if ($logoSetting) {
                    $logoSetting->update(['value' => $logoName]);
                    $uploads['logo'] = asset('admin/assets/img/' . $logoName);
                }
            }
            
            if ($request->hasFile('favicon_file')) {
                $faviconFile = $request->file('favicon_file');
                $faviconName = 'favicon_' . time() . '.' . $faviconFile->getClientOriginalExtension();
                $faviconFile->move(public_path('admin/assets/img'), $faviconName);
                
                $faviconSetting = Settings::where('key', 'favicon')->first();
                if ($faviconSetting) {
                    $faviconSetting->update(['value' => $faviconName]);
                    $uploads['favicon'] = asset('admin/assets/img/' . $faviconName);
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

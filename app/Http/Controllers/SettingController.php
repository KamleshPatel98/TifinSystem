<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    public function webData()
    {
        return view('panel.settings.web-data');
    }

    public function webDataSubmit(Request $request)
    {
        $validated = $request->validate([
            'app_name' => 'required|string|max:255',
            'app_url' => 'required|string|max:255',
            'app_phone' => 'required|numeric|digits:10',
            'app_alt_phone' => 'required|numeric|digits:10',
            'app_email' => 'required|email|max:255',
            'app_address' => 'required|string|max:255',
            'app_footer_text' => 'required|string|max:255',
            'page_limit' => 'required|integer|max:250',
        ]);

        $settingsData = [
            'app_name' => $request->app_name,
            'app_url'  => $request->app_url,
            'app_phone'       => $request->app_phone,
            'app_alt_phone'   => $request->app_alt_phone,
            'app_email'        => $request->app_email,
            'app_address'         => $request->app_address,
            'app_footer_text'   => $request->app_footer_text,
            'page_limit'   => $request->page_limit,
        ];

        foreach ($settingsData as $key => $value) {
            Setting::updateOrCreate(
                ['key_name' => $key],
                ['value' => $value]
            );

            Cache::forget('setting_' . $key);
        }

        return back()->with('success', 'Settings updated successfully');
    }
}

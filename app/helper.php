<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

if (!function_exists("getSetting")) { // mobile, email
    function getSetting($key)
    {
        return Cache::rememberForever('setting_' . $key, function () use ($key) {
            return Setting::where('key_name', $key)->value('value');
        });
    }
}

if(!function_exists("uploadFile"))
{
    function uploadFile($file, $path)
    {
        if (!$file) {
            return null;
        }

        $filename = time() . '_' . rand(1111, 9999) . '.' . $file->getClientOriginalExtension();
        $file->storeAs($path, $filename);

        return $filename;
    }
}

if(!function_exists("deleteFile"))
{
    function deleteFile($filename, $path)
    {
        if (!empty($filename) && Storage::exists($path . $filename)) {
            Storage::delete($path . $filename);
        }
    }
}

if(!function_exists('formatDateToYmd'))
{
    function formatDateToYmd($date)
    {
        if(empty($date)){
            return null;
        }
        return date('Y-m-d', strtotime($date));
    }
}
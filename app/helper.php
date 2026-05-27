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

if(!function_exists('formatDateTodmY'))
{
    function formatDateTodmY($date)
    {
        if(empty($date)){
            return null;
        }
        return date('d-m-Y', strtotime($date));
    }
}

if(!function_exists("formatDateTime"))
{
    function formatDateTime($datetime)
    {
        if (!$datetime) return 'N/A';
        $date = \Carbon\Carbon::parse($datetime);
        if ($date->isToday()) {
            return 'Today ' . $date->format('h:i A');
        }
        if ($date->isTomorrow()) {
            return 'Tomorrow ' . $date->format('h:i A');
        }
        return $date->format('d M Y h:i A');
    }
}

if (!function_exists('dueWhatsappUrl')) 
{
    function dueWhatsappUrl($customerName, $mobile, $planName, $lastDate, $dueAmount)
    {
        $msg = "Dear {$customerName},

We hope you're doing well!

This is a friendly reminder that your tiffin subscription payment is pending.

Plan: {$planName}
Last Date: {$lastDate}
Due Amount: ₹{$dueAmount}

To continue your tiffin service without interruption, please renew/pay your subscription at the earliest.

Note: If you have already completed the payment, kindly ignore this message.

Best regards,
".getSetting('app_name')."
+91 ".getSetting('app_phone');


        $phone = "91".$mobile;

        return "https://wa.me/{$phone}?text=" . urlencode($msg);
    }
}

if (!function_exists('expireSoonWhatsappUrl')) 
{
    function expireSoonWhatsappUrl($customerName, $mobile, $planName, $expiryDate)
    {
        $daysLeft = ceil(now()->diffInDays($expiryDate, false));

        $msg = "Dear {$customerName},

We hope you're doing well!

Your tiffin subscription is going to expire soon.

Plan: {$planName}
Expiry Date: {$expiryDate}
Days Left: {$daysLeft} Days

To continue your tiffin service without interruption, kindly renew your subscription before the expiry date.

If you have already renewed your subscription, please ignore this message.

Best regards,
".getSetting('app_name')."
+91 ".getSetting('app_phone');

        $phone = "91".$mobile;

        return "https://wa.me/{$phone}?text=" . urlencode($msg);
    }
}

if (!function_exists('expiredWhatsappUrl')) 
{
    function expiredWhatsappUrl($customerName, $mobile, $planName, $expiryDate)
    {
        $msg = "Dear {$customerName},

We hope you're doing well!

Your tiffin subscription has expired.

Plan: {$planName}
Expired On: {$expiryDate}

To continue your tiffin service without interruption, kindly renew your subscription as soon as possible.

If you have already renewed your subscription, please ignore this message.

Best regards,
".getSetting('app_name')."
+91 ".getSetting('app_phone');

        $phone = "91".$mobile;

        return "https://wa.me/{$phone}?text=" . urlencode($msg);
    }

}
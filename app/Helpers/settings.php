<?php

use App\Models\AppSetting;

if (!function_exists('settings')) {
    function settings($key, $default = null)
    {
        $settings = AppSetting::getAllSettings();
        return $settings[$key] ?? $default;
    }
}
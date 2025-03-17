<?php

use Illuminate\Support\Str;

if (!function_exists('limit_pagination')) {
    function limit_pagination($total = 10)
    {
        return Request()->get('per_page') ?? $total;
    }
}


if (!function_exists('get_user_id')) {
    function get_user_id()
    {
        return optional(auth('sanctum')->user())->id;
    }
}

if (!function_exists('get_uuid')) {
    function get_uuid()
    {
        return (string) Str::uuid();
    }
}

if (!function_exists('uploadFile')) {
    function uploadFile($file, $filename = '')
    {
        if ($file) {
            $folder_name = get_user_id() . '_folder';
            $extension = $file->getClientOriginalExtension();
            $name = $filename . now()->timestamp . '.' . $extension;
            $path = $file->storeAs($folder_name, $name);
            return $path;
        }
        return null;
    }
}

if (!function_exists('get_file_path')) {
    function get_file_path($path)
    {
        $host = Request()->getSchemeAndHttpHost();
        return $path ? $host . '/storage/' . $path : '';
    }
}

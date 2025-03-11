<?php

use Illuminate\Http\Request;
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

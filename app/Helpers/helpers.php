<?php

use Illuminate\Http\Request;

if (!function_exists('limit_pagination')) {
    function limit_pagination($total = 10) {
        return Request()->get('per_page') ?? $total;
    }
}

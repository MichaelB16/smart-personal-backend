<?php

namespace App\Http\Controllers;

use App\Services\SettingService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct(private SettingService $settingService) {}

    public function index()
    {
        return response()->json($this->settingService->getSetting());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'logo' => 'nullable|file'
        ]);

        if (isset($data['logo'])) {
            $data['logo'] = uploadFile($data['logo'], 'logo');
        }

        $resut = $this->settingService->setConfiguration($data);

        return response()->json($resut);
    }
}

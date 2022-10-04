<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\SettingResource;
use App\TuChance\Models\Setting;

class SettingsController extends Controller
{
    /**
     * All countries.
     * @param  \App\TuChance\Models\Setting $banners
     * @return void
     */
    public function index(Setting $settings)
    {
        return SettingResource::collection($settings->all());
    }
}

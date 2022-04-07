<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Settings
        $setting = new Setting();
        $setting->name_company = 'Company test';
        $setting->description = 'description';
        $setting->address = 'address';
        $setting->region = 'region';
        $setting->commune = 'commune';
        $setting->country = 'country';
        $setting->phone = '56952989898';
        $setting->email = 'email@email.com';
        $setting->locale = 'en';
        $setting->timezone = 'UTC';
        $setting->save();
    }
}

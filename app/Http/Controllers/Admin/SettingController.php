<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function edit(): View
    {
        $keys = [
            'site_name', 'site_tagline', 'contact_email', 'contact_phone',
            'contact_address', 'facebook', 'twitter', 'instagram', 'youtube',
            'about_short', 'students_count', 'faculties_count', 'programs_count', 'years_count',
        ];

        $settings = [];
        foreach ($keys as $key) {
            $settings[$key] = Setting::get($key, '');
        }

        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'site_name' => ['required', 'string', 'max:255'],
            'site_tagline' => ['nullable', 'string', 'max:255'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
            'contact_address' => ['nullable', 'string', 'max:500'],
            'facebook' => ['nullable', 'url', 'max:255'],
            'twitter' => ['nullable', 'url', 'max:255'],
            'instagram' => ['nullable', 'url', 'max:255'],
            'youtube' => ['nullable', 'url', 'max:255'],
            'about_short' => ['nullable', 'string', 'max:1000'],
            'students_count' => ['nullable', 'string', 'max:50'],
            'faculties_count' => ['nullable', 'string', 'max:50'],
            'programs_count' => ['nullable', 'string', 'max:50'],
            'years_count' => ['nullable', 'string', 'max:50'],
        ]);

        foreach ($data as $key => $value) {
            Setting::set($key, $value);
        }

        return back()->with('success', 'تم حفظ الإعدادات بنجاح.');
    }
}

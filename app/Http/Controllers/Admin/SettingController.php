<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Support\Media;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function edit(): View
    {
        $keys = [
            'site_name', 'site_tagline', 'site_logo', 'logo_height', 'logo_width',
            'logo_show_name', 'contact_email', 'contact_phone',
            'contact_address', 'facebook', 'twitter', 'instagram', 'youtube',
            'about_short', 'about_image', 'students_count', 'faculties_count', 'programs_count', 'years_count',
        ];

        $settings = [];
        foreach ($keys as $key) {
            $settings[$key] = Setting::get($key, match ($key) {
                'logo_height' => '48',
                'logo_width' => '',
                'logo_show_name' => '1',
                default => '',
            });
        }

        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'site_name' => ['required', 'string', 'max:255'],
            'site_tagline' => ['nullable', 'string', 'max:255'],
            'site_logo' => ['nullable', 'file', 'mimes:png,jpg,jpeg,webp,gif', 'max:2048'],
            'logo_height' => ['nullable', 'integer', 'min:20', 'max:200'],
            'logo_width' => ['nullable', 'integer', 'min:20', 'max:400'],
            'logo_show_name' => ['nullable', 'boolean'],
            'remove_logo' => ['nullable', 'boolean'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
            'contact_address' => ['nullable', 'string', 'max:500'],
            'facebook' => ['nullable', 'url', 'max:255'],
            'twitter' => ['nullable', 'url', 'max:255'],
            'instagram' => ['nullable', 'url', 'max:255'],
            'youtube' => ['nullable', 'url', 'max:255'],
            'about_short' => ['nullable', 'string', 'max:1000'],
            'about_image' => ['nullable', 'file', 'mimes:png,jpg,jpeg,webp,gif', 'max:4096'],
            'remove_about_image' => ['nullable', 'boolean'],
            'students_count' => ['nullable', 'string', 'max:50'],
            'faculties_count' => ['nullable', 'string', 'max:50'],
            'programs_count' => ['nullable', 'string', 'max:50'],
            'years_count' => ['nullable', 'string', 'max:50'],
        ]);

        if ($request->boolean('remove_logo')) {
            Media::delete(Setting::get('site_logo'));
            Setting::set('site_logo', '');
        }

        if ($request->hasFile('site_logo')) {
            Media::delete(Setting::get('site_logo'));
            $relative = Media::store($request->file('site_logo'), 'logos');

            if (! Media::exists($relative)) {
                return back()->with('error', 'فشل حفظ ملف الشعار على السيرفر. تحقق من صلاحيات مجلد public/uploads');
            }

            Setting::set('site_logo', $relative);
        }

        if ($request->boolean('remove_about_image')) {
            Media::delete(Setting::get('about_image'));
            Setting::set('about_image', '');
        }

        if ($request->hasFile('about_image')) {
            Media::delete(Setting::get('about_image'));
            $relative = Media::store($request->file('about_image'), 'about');

            if (! Media::exists($relative)) {
                return back()->with('error', 'فشل حفظ الصورة التعريفية على السيرفر. تحقق من صلاحيات مجلد public/uploads');
            }

            Setting::set('about_image', $relative);
        }

        unset($data['site_logo'], $data['remove_logo'], $data['about_image'], $data['remove_about_image']);

        $data['logo_height'] = (string) ($data['logo_height'] ?? 48);
        $data['logo_width'] = isset($data['logo_width']) && $data['logo_width'] !== null
            ? (string) $data['logo_width']
            : '';
        $data['logo_show_name'] = $request->boolean('logo_show_name') ? '1' : '0';

        foreach ($data as $key => $value) {
            Setting::set($key, $value);
        }

        return back()->with('success', 'تم حفظ الإعدادات بنجاح.');
    }
}

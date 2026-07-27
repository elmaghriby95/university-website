<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function edit(): View
    {
        $keys = [
            'site_name', 'site_tagline', 'site_logo', 'logo_height', 'logo_width',
            'logo_show_name', 'contact_email', 'contact_phone',
            'contact_address', 'facebook', 'twitter', 'instagram', 'youtube',
            'about_short', 'students_count', 'faculties_count', 'programs_count', 'years_count',
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
            'students_count' => ['nullable', 'string', 'max:50'],
            'faculties_count' => ['nullable', 'string', 'max:50'],
            'programs_count' => ['nullable', 'string', 'max:50'],
            'years_count' => ['nullable', 'string', 'max:50'],
        ]);

        if ($request->boolean('remove_logo')) {
            $this->deleteLogoFile(Setting::get('site_logo'));
            Setting::set('site_logo', '');
        }

        if ($request->hasFile('site_logo')) {
            $this->deleteLogoFile(Setting::get('site_logo'));

            $directory = public_path('uploads/logos');
            File::ensureDirectoryExists($directory);

            $extension = strtolower($request->file('site_logo')->getClientOriginalExtension() ?: 'png');
            $filename = 'logo-'.time().'.'.$extension;
            $request->file('site_logo')->move($directory, $filename);

            $relative = 'uploads/logos/'.$filename;
            $full = public_path($relative);

            if (! is_file($full)) {
                return back()->with('error', 'فشل حفظ ملف الشعار على السيرفر. تحقق من صلاحيات مجلد public/uploads/logos');
            }

            Setting::set('site_logo', $relative);
        }

        unset($data['site_logo'], $data['remove_logo']);

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

    private function deleteLogoFile(?string $path): void
    {
        if (! $path) {
            return;
        }

        // New public uploads path
        if (str_starts_with($path, 'uploads/')) {
            $full = public_path($path);
            if (is_file($full)) {
                @unlink($full);
            }

            return;
        }

        // Legacy storage path
        $legacy = storage_path('app/public/'.$path);
        if (is_file($legacy)) {
            @unlink($legacy);
        }
    }
}

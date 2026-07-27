@extends('layouts.admin')

@section('title', 'الإعدادات')
@section('heading', 'إعدادات الموقع')

@section('content')
<div class="form-card">
    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">اسم الجامعة</label>
                <input type="text" name="site_name" value="{{ old('site_name', $settings['site_name']) }}" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">الشعار الفرعي</label>
                <input type="text" name="site_tagline" value="{{ old('site_tagline', $settings['site_tagline']) }}" class="form-control">
            </div>

            <div class="col-12">
                <hr>
                <h2 class="h6 mb-3">شعار الجامعة</h2>
            </div>

            <div class="col-md-6">
                <label class="form-label">رفع الشعار</label>
                <input type="file" name="site_logo" class="form-control @error('site_logo') is-invalid @enderror" accept="image/*">
                <div class="form-text">PNG / JPG / WEBP / GIF — بحد أقصى 2MB</div>
                @error('site_logo')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-3">
                <label class="form-label">ارتفاع الشعار (px)</label>
                <input type="number" name="logo_height" min="20" max="200" value="{{ old('logo_height', $settings['logo_height'] ?: 48) }}" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">عرض الشعار (px)</label>
                <input type="number" name="logo_width" min="20" max="400" value="{{ old('logo_width', $settings['logo_width']) }}" class="form-control" placeholder="تلقائي">
                <div class="form-text">اتركه فارغاً للحفاظ على النسبة</div>
            </div>
            <div class="col-md-6 d-flex align-items-end">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="logo_show_name" value="1" id="logo_show_name" @checked(old('logo_show_name', $settings['logo_show_name']) == '1')>
                    <label class="form-check-label" for="logo_show_name">إظهار اسم الجامعة بجانب الشعار</label>
                </div>
            </div>
            <div class="col-md-6">
                @php
                    $logoUrl = !empty($settings['site_logo']) ? \App\Models\Setting::logoUrl($settings['site_logo']) : null;
                    $logoExists = !empty($settings['site_logo']) && \App\Models\Setting::logoExists($settings['site_logo']);
                @endphp
                @if(!empty($settings['site_logo']))
                    <div class="p-3 rounded border bg-light">
                        <div class="small text-muted mb-2">الشعار الحالي</div>
                        @if($logoUrl && $logoExists)
                            <img src="{{ $logoUrl }}"
                                 alt="شعار الجامعة"
                                 style="height: {{ (int) ($settings['logo_height'] ?: 48) }}px; @if($settings['logo_width']) width: {{ (int) $settings['logo_width'] }}px; @endif object-fit: contain; background:#fff; padding:6px; border-radius:8px;">
                            <div class="small text-success mt-2">الملف موجود ويعمل</div>
                            <div class="small text-muted">الرابط: <a href="{{ $logoUrl }}" target="_blank">{{ $logoUrl }}</a></div>
                        @else
                            <div class="alert alert-danger mb-2">الملف غير موجود على السيرفر. ارفع الشعار من جديد.</div>
                        @endif
                        <div class="small text-muted mt-2">المسار المحفوظ: <code>{{ $settings['site_logo'] }}</code></div>
                        <div class="form-check mt-3 mb-0">
                            <input class="form-check-input" type="checkbox" name="remove_logo" value="1" id="remove_logo">
                            <label class="form-check-label text-danger" for="remove_logo">حذف الشعار الحالي</label>
                        </div>
                    </div>
                @else
                    <div class="alert alert-light mb-0">لم يتم رفع شعار بعد — سيظهر أيقونة افتراضية.</div>
                @endif
            </div>

            <div class="col-12">
                <hr>
                <h2 class="h6 mb-3">معلومات التواصل والإحصائيات</h2>
            </div>

            <div class="col-12">
                <label class="form-label">نبذة قصيرة</label>
                <textarea name="about_short" rows="3" class="form-control">{{ old('about_short', $settings['about_short']) }}</textarea>
            </div>

            <div class="col-12">
                <hr>
                <h2 class="h6 mb-3">الصورة التعريفية (عن الجامعة)</h2>
            </div>
            <div class="col-md-6">
                <label class="form-label">رفع الصورة</label>
                <input type="file" name="about_image" class="form-control @error('about_image') is-invalid @enderror" accept="image/*">
                <div class="form-text">PNG / JPG / WEBP / GIF — بحد أقصى 4MB — تظهر بجانب قسم «عن الجامعة» في الصفحة الرئيسية</div>
                @error('about_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                @php
                    $aboutImageUrl = !empty($settings['about_image']) ? media_url($settings['about_image']) : null;
                @endphp
                @if(!empty($settings['about_image']))
                    <div class="p-3 rounded border bg-light">
                        <div class="small text-muted mb-2">الصورة الحالية</div>
                        @if($aboutImageUrl)
                            <img src="{{ $aboutImageUrl }}"
                                 alt="الصورة التعريفية"
                                 class="rounded"
                                 style="max-height:140px; max-width:100%; object-fit:cover; background:#fff;">
                            <div class="small text-success mt-2">الملف موجود ويعمل</div>
                        @else
                            <div class="alert alert-danger mb-2">الملف غير موجود على السيرفر. ارفع الصورة من جديد.</div>
                        @endif
                        <div class="small text-muted mt-2">المسار المحفوظ: <code>{{ $settings['about_image'] }}</code></div>
                        <div class="form-check mt-3 mb-0">
                            <input class="form-check-input" type="checkbox" name="remove_about_image" value="1" id="remove_about_image">
                            <label class="form-check-label text-danger" for="remove_about_image">حذف الصورة الحالية</label>
                        </div>
                    </div>
                @else
                    <div class="alert alert-light mb-0">لم يتم رفع صورة بعد — سيظهر المربع فارغاً حتى ترفع صورة.</div>
                @endif
            </div>
            <div class="col-md-4">
                <label class="form-label">البريد</label>
                <input type="email" name="contact_email" value="{{ old('contact_email', $settings['contact_email']) }}" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">الهاتف</label>
                <input type="text" name="contact_phone" value="{{ old('contact_phone', $settings['contact_phone']) }}" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">العنوان</label>
                <input type="text" name="contact_address" value="{{ old('contact_address', $settings['contact_address']) }}" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">عدد الطلاب</label>
                <input type="text" name="students_count" value="{{ old('students_count', $settings['students_count']) }}" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">عدد الأقسام</label>
                <input type="text" name="faculties_count" value="{{ old('faculties_count', $settings['faculties_count']) }}" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">عدد البرامج</label>
                <input type="text" name="programs_count" value="{{ old('programs_count', $settings['programs_count']) }}" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">سنوات التميز</label>
                <input type="text" name="years_count" value="{{ old('years_count', $settings['years_count']) }}" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">Facebook</label>
                <input type="url" name="facebook" value="{{ old('facebook', $settings['facebook']) }}" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">X / Twitter</label>
                <input type="url" name="twitter" value="{{ old('twitter', $settings['twitter']) }}" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">Instagram</label>
                <input type="url" name="instagram" value="{{ old('instagram', $settings['instagram']) }}" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">YouTube</label>
                <input type="url" name="youtube" value="{{ old('youtube', $settings['youtube']) }}" class="form-control">
            </div>
            <div class="col-12">
                <button class="btn btn-primary" style="background:#0b2a4a;border:none">حفظ الإعدادات</button>
            </div>
        </div>
    </form>
</div>
@endsection

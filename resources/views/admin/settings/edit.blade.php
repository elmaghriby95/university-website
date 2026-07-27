@extends('layouts.admin')

@section('title', 'الإعدادات')
@section('heading', 'إعدادات الموقع')

@section('content')
<div class="form-card">
    <form method="POST" action="{{ route('admin.settings.update') }}">
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
                <label class="form-label">نبذة قصيرة</label>
                <textarea name="about_short" rows="3" class="form-control">{{ old('about_short', $settings['about_short']) }}</textarea>
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
                <label class="form-label">عدد الكليات</label>
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

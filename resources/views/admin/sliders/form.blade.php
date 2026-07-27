@extends('layouts.admin')

@section('title', $item->exists ? 'تعديل شريحة' : 'إضافة شريحة')
@section('heading', $item->exists ? 'تعديل شريحة' : 'إضافة شريحة')

@section('content')
<div class="form-card">
    <form method="POST" enctype="multipart/form-data" action="{{ $item->exists ? route('admin.sliders.update', $item) : route('admin.sliders.store') }}">
        @csrf
        @if($item->exists) @method('PUT') @endif
        <div class="row g-3">
            <div class="col-12">
                <label class="form-label">العنوان</label>
                <input type="text" name="title" value="{{ old('title', $item->title) }}" class="form-control" required>
            </div>
            <div class="col-12">
                <label class="form-label">النص الفرعي</label>
                <input type="text" name="subtitle" value="{{ old('subtitle', $item->subtitle) }}" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">نص الزر</label>
                <input type="text" name="button_text" value="{{ old('button_text', $item->button_text) }}" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">رابط الزر</label>
                <input type="text" name="button_link" value="{{ old('button_link', $item->button_link) }}" class="form-control" placeholder="/admissions">
            </div>
            <div class="col-md-6">
                <label class="form-label">الترتيب</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $item->sort_order ?? 0) }}" class="form-control" min="0">
            </div>
            <div class="col-md-6">
                <label class="form-label">الصورة</label>
                <input type="file" name="image" class="form-control" accept="image/*">
                @if($item->image && media_url($item->image))<img src="{{ media_url($item->image) }}" class="mt-2 rounded" style="max-height:100px" alt="">@endif
            </div>
            <div class="col-12">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" @checked(old('is_active', $item->is_active ?? true))>
                    <label class="form-check-label" for="is_active">نشطة</label>
                </div>
            </div>
            <div class="col-12">
                <button class="btn btn-primary" style="background:#0b2a4a;border:none">حفظ</button>
                <a href="{{ route('admin.sliders.index') }}" class="btn btn-outline-secondary">رجوع</a>
            </div>
        </div>
    </form>
</div>
@endsection

@extends('layouts.admin')

@section('title', $item->exists ? 'تعديل صفحة' : 'إضافة صفحة')
@section('heading', $item->exists ? 'تعديل صفحة' : 'إضافة صفحة')

@section('content')
<div class="form-card">
    <form method="POST" enctype="multipart/form-data" action="{{ $item->exists ? route('admin.pages.update', $item) : route('admin.pages.store') }}">
        @csrf
        @if($item->exists) @method('PUT') @endif
        <div class="row g-3">
            <div class="col-12">
                <label class="form-label">العنوان</label>
                <input type="text" name="title" value="{{ old('title', $item->title) }}" class="form-control" required>
            </div>
            <div class="col-12">
                <label class="form-label">المحتوى</label>
                <textarea name="content" rows="10" class="form-control">{{ old('content', $item->content) }}</textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label">الصورة</label>
                <input type="file" name="image" class="form-control" accept="image/*">
                @if($item->image && media_url($item->image))<img src="{{ media_url($item->image) }}" class="mt-2 rounded" style="max-height:100px" alt="">@endif
            </div>
            <div class="col-md-6 d-flex align-items-end">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="is_published" value="1" id="is_published" @checked(old('is_published', $item->is_published ?? true))>
                    <label class="form-check-label" for="is_published">منشورة</label>
                </div>
            </div>
            <div class="col-12">
                <button class="btn btn-primary" style="background:#0b2a4a;border:none">حفظ</button>
                <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-secondary">رجوع</a>
            </div>
        </div>
    </form>
</div>
@endsection

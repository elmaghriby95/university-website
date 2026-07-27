@extends('layouts.admin')

@section('title', $item->exists ? 'تعديل خبر' : 'إضافة خبر')
@section('heading', $item->exists ? 'تعديل خبر' : 'إضافة خبر')

@section('content')
<div class="form-card">
    <form method="POST" enctype="multipart/form-data" action="{{ $item->exists ? route('admin.news.update', $item) : route('admin.news.store') }}">
        @csrf
        @if($item->exists) @method('PUT') @endif
        <div class="row g-3">
            <div class="col-12">
                <label class="form-label">العنوان</label>
                <input type="text" name="title" value="{{ old('title', $item->title) }}" class="form-control @error('title') is-invalid @enderror" required>
                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-12">
                <label class="form-label">مقتطف</label>
                <textarea name="excerpt" rows="2" class="form-control">{{ old('excerpt', $item->excerpt) }}</textarea>
            </div>
            <div class="col-12">
                <label class="form-label">المحتوى</label>
                <textarea name="content" rows="8" class="form-control @error('content') is-invalid @enderror" required>{{ old('content', $item->content) }}</textarea>
                @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">الصورة</label>
                <input type="file" name="image" class="form-control" accept="image/*">
                @if($item->image && media_url($item->image))<img src="{{ media_url($item->image) }}" class="mt-2 rounded" style="max-height:100px" alt="">@endif
            </div>
            <div class="col-md-6">
                <label class="form-label">تاريخ النشر</label>
                <input type="datetime-local" name="published_at" value="{{ old('published_at', optional($item->published_at)->format('Y-m-d\TH:i')) }}" class="form-control">
            </div>
            <div class="col-md-6">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="is_published" value="1" id="is_published" @checked(old('is_published', $item->is_published ?? true))>
                    <label class="form-check-label" for="is_published">منشور</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="is_featured" @checked(old('is_featured', $item->is_featured))>
                    <label class="form-check-label" for="is_featured">خبر مميز</label>
                </div>
            </div>
            <div class="col-12">
                <button class="btn btn-primary" style="background:#0b2a4a;border:none">حفظ</button>
                <a href="{{ route('admin.news.index') }}" class="btn btn-outline-secondary">رجوع</a>
            </div>
        </div>
    </form>
</div>
@endsection

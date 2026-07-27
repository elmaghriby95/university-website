@extends('layouts.admin')

@section('title', $item->exists ? 'تعديل فعالية' : 'إضافة فعالية')
@section('heading', $item->exists ? 'تعديل فعالية' : 'إضافة فعالية')

@section('content')
<div class="form-card">
    <form method="POST" enctype="multipart/form-data" action="{{ $item->exists ? route('admin.events.update', $item) : route('admin.events.store') }}">
        @csrf
        @if($item->exists) @method('PUT') @endif
        <div class="row g-3">
            <div class="col-12">
                <label class="form-label">العنوان</label>
                <input type="text" name="title" value="{{ old('title', $item->title) }}" class="form-control" required>
            </div>
            <div class="col-12">
                <label class="form-label">مقتطف</label>
                <textarea name="excerpt" rows="2" class="form-control">{{ old('excerpt', $item->excerpt) }}</textarea>
            </div>
            <div class="col-12">
                <label class="form-label">التفاصيل</label>
                <textarea name="content" rows="6" class="form-control">{{ old('content', $item->content) }}</textarea>
            </div>
            <div class="col-md-4">
                <label class="form-label">المكان</label>
                <input type="text" name="location" value="{{ old('location', $item->location) }}" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">يبدأ في</label>
                <input type="datetime-local" name="starts_at" value="{{ old('starts_at', optional($item->starts_at)->format('Y-m-d\TH:i')) }}" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">ينتهي في</label>
                <input type="datetime-local" name="ends_at" value="{{ old('ends_at', optional($item->ends_at)->format('Y-m-d\TH:i')) }}" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">الصورة</label>
                <input type="file" name="image" class="form-control" accept="image/*">
                @if($item->image)<img src="{{ asset('storage/'.$item->image) }}" class="mt-2 rounded" style="max-height:100px" alt="">@endif
            </div>
            <div class="col-md-6 d-flex align-items-end">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="is_published" value="1" id="is_published" @checked(old('is_published', $item->is_published ?? true))>
                    <label class="form-check-label" for="is_published">منشورة</label>
                </div>
            </div>
            <div class="col-12">
                <button class="btn btn-primary" style="background:#0b2a4a;border:none">حفظ</button>
                <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary">رجوع</a>
            </div>
        </div>
    </form>
</div>
@endsection

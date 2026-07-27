@extends('layouts.admin')

@section('title', $item->exists ? 'تعديل كلية' : 'إضافة كلية')
@section('heading', $item->exists ? 'تعديل كلية' : 'إضافة كلية')

@section('content')
<div class="form-card">
    <form method="POST" enctype="multipart/form-data" action="{{ $item->exists ? route('admin.faculties.update', $item) : route('admin.faculties.store') }}">
        @csrf
        @if($item->exists) @method('PUT') @endif
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">اسم الكلية</label>
                <input type="text" name="name" value="{{ old('name', $item->name) }}" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">العميد</label>
                <input type="text" name="dean" value="{{ old('dean', $item->dean) }}" class="form-control">
            </div>
            <div class="col-12">
                <label class="form-label">الوصف</label>
                <textarea name="description" rows="6" class="form-control">{{ old('description', $item->description) }}</textarea>
            </div>
            <div class="col-md-4">
                <label class="form-label">عدد الطلاب</label>
                <input type="number" name="students_count" value="{{ old('students_count', $item->students_count ?? 0) }}" class="form-control" min="0">
            </div>
            <div class="col-md-4">
                <label class="form-label">عدد الأقسام</label>
                <input type="number" name="departments_count" value="{{ old('departments_count', $item->departments_count ?? 0) }}" class="form-control" min="0">
            </div>
            <div class="col-md-4">
                <label class="form-label">الترتيب</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $item->sort_order ?? 0) }}" class="form-control" min="0">
            </div>
            <div class="col-md-6">
                <label class="form-label">الصورة</label>
                <input type="file" name="image" class="form-control" accept="image/*">
                @if($item->image && media_url($item->image))<img src="{{ media_url($item->image) }}" class="mt-2 rounded" style="max-height:100px" alt="">@endif
            </div>
            <div class="col-md-6 d-flex align-items-end">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" @checked(old('is_active', $item->is_active ?? true))>
                    <label class="form-check-label" for="is_active">نشطة</label>
                </div>
            </div>
            <div class="col-12">
                <button class="btn btn-primary" style="background:#0b2a4a;border:none">حفظ</button>
                <a href="{{ route('admin.faculties.index') }}" class="btn btn-outline-secondary">رجوع</a>
            </div>
        </div>
    </form>
</div>
@endsection

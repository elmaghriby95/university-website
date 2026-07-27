@extends('layouts.admin')

@section('title', $item->exists ? 'تعديل طالب' : 'إضافة طالب')
@section('heading', $item->exists ? 'تعديل طالب' : 'إضافة طالب')

@section('content')
<div class="form-card">
    <form method="POST" action="{{ $item->exists ? route('admin.students.update', $item) : route('admin.students.store') }}">
        @csrf
        @if($item->exists) @method('PUT') @endif
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">الاسم الكامل</label>
                <input type="text" name="full_name" value="{{ old('full_name', $item->full_name) }}" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">الكلية</label>
                <select name="faculty_id" class="form-select">
                    <option value="">—</option>
                    @foreach($faculties as $faculty)
                        <option value="{{ $faculty->id }}" @selected(old('faculty_id', $item->faculty_id) == $faculty->id)>{{ $faculty->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">رقم القيد {{ $item->exists ? '' : '(اختياري — يُولَّد تلقائياً)' }}</label>
                <input type="text" name="registration_number" value="{{ old('registration_number', $item->registration_number) }}" class="form-control" {{ $item->exists ? 'required' : '' }}>
            </div>
            <div class="col-md-4">
                <label class="form-label">الرقم السري {{ $item->exists ? '(اتركه فارغاً للإبقاء)' : '(اختياري)' }}</label>
                <input type="text" name="secret_code" value="{{ old('secret_code') }}" class="form-control" autocomplete="off">
            </div>
            <div class="col-md-4">
                <label class="form-label">الحالة</label>
                <select name="status" class="form-select" required>
                    <option value="approved" @selected(old('status', $item->status ?? 'approved') === 'approved')>مقبول</option>
                    <option value="pending" @selected(old('status', $item->status) === 'pending')>قيد المراجعة</option>
                    <option value="rejected" @selected(old('status', $item->status) === 'rejected')>مرفوض</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">الهاتف</label>
                <input type="text" name="phone" value="{{ old('phone', $item->phone) }}" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">البريد</label>
                <input type="email" name="email" value="{{ old('email', $item->email) }}" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">الرقم الوطني</label>
                <input type="text" name="national_id" value="{{ old('national_id', $item->national_id) }}" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">الجنس</label>
                <select name="gender" class="form-select">
                    <option value="">—</option>
                    <option value="male" @selected(old('gender', $item->gender) === 'male')>ذكر</option>
                    <option value="female" @selected(old('gender', $item->gender) === 'female')>أنثى</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">تاريخ الميلاد</label>
                <input type="date" name="birth_date" value="{{ old('birth_date', optional($item->birth_date)->format('Y-m-d')) }}" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">العنوان</label>
                <input type="text" name="address" value="{{ old('address', $item->address) }}" class="form-control">
            </div>
            <div class="col-12">
                <button class="btn btn-primary" style="background:#0b2a4a;border:none">حفظ</button>
                <a href="{{ route('admin.students.index') }}" class="btn btn-outline-secondary">رجوع</a>
            </div>
        </div>
    </form>
</div>
@endsection

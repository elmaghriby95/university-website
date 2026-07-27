@extends('layouts.front')

@section('title', 'تسجيل طالب جديد | ' . ($siteName ?? 'جامعة النور'))

@section('content')
<section class="page-hero">
    <div class="container">
        <h1>تسجيل طالب جديد</h1>
        <p class="mb-0 opacity-75">أدخل بياناتك للحصول على رقم قيد ورقم سري للاستعلام عن النتائج</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="content-card">
                    <form method="POST" action="{{ route('students.register.store') }}">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">الاسم الكامل</label>
                                <input type="text" name="full_name" value="{{ old('full_name') }}" class="form-control @error('full_name') is-invalid @enderror" required>
                                @error('full_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">الكلية</label>
                                <select name="faculty_id" class="form-select @error('faculty_id') is-invalid @enderror" required>
                                    <option value="">اختر الكلية</option>
                                    @foreach($faculties as $faculty)
                                        <option value="{{ $faculty->id }}" @selected(old('faculty_id') == $faculty->id)>{{ $faculty->name }}</option>
                                    @endforeach
                                </select>
                                @error('faculty_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">الهاتف</label>
                                <input type="text" name="phone" value="{{ old('phone') }}" class="form-control @error('phone') is-invalid @enderror" required>
                                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">البريد الإلكتروني</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror">
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">الرقم الوطني</label>
                                <input type="text" name="national_id" value="{{ old('national_id') }}" class="form-control @error('national_id') is-invalid @enderror">
                                @error('national_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">الجنس</label>
                                <select name="gender" class="form-select">
                                    <option value="">—</option>
                                    <option value="male" @selected(old('gender') === 'male')>ذكر</option>
                                    <option value="female" @selected(old('gender') === 'female')>أنثى</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">تاريخ الميلاد</label>
                                <input type="date" name="birth_date" value="{{ old('birth_date') }}" class="form-control">
                            </div>
                            <div class="col-12">
                                <label class="form-label">العنوان</label>
                                <input type="text" name="address" value="{{ old('address') }}" class="form-control">
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-navy px-4">إتمام التسجيل</button>
                                <a href="{{ route('results.lookup') }}" class="btn btn-outline-secondary">لدي رقم قيد؟ استعلم عن النتيجة</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

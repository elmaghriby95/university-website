@extends('layouts.front')

@section('title', 'الاستعلام عن النتيجة | ' . ($siteName ?? 'جامعة النور'))

@section('content')
<section class="page-hero">
    <div class="container">
        <h1>الاستعلام عن النتيجة</h1>
        <p class="mb-0 opacity-75">أدخل رقم القيد والرقم السري لعرض نتيجتك — بدون تسجيل دخول</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="content-card">
                    <form method="POST" action="{{ route('results.lookup.submit') }}" autocomplete="off">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">رقم القيد</label>
                            <input type="text" name="registration_number" value="{{ old('registration_number') }}" class="form-control @error('registration_number') is-invalid @enderror" required autofocus>
                            @error('registration_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label">الرقم السري</label>
                            <input type="password" name="secret_code" class="form-control @error('secret_code') is-invalid @enderror" required>
                            @error('secret_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <button type="submit" class="btn btn-navy w-100">عرض النتيجة</button>
                    </form>
                    <div class="text-center mt-3">
                        <a href="{{ route('students.register') }}" class="small">ليس لديك رقم قيد؟ سجّل كطالب جديد</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

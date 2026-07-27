@extends('layouts.front')

@section('title', 'تم التسجيل بنجاح | ' . ($siteName ?? 'جامعة النور'))

@section('content')
<section class="page-hero">
    <div class="container">
        <h1>تم تسجيلك بنجاح</h1>
        <p class="mb-0 opacity-75">احفظ رقم القيد والرقم السري جيداً — لن يظهر الرقم السري مرة أخرى</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="content-card text-center">
                    <div class="mb-3 text-success"><i class="bi bi-check-circle" style="font-size:3rem"></i></div>
                    <h2 class="h4 mb-1">مرحباً {{ $student_name }}</h2>
                    <p class="text-muted mb-4">بيانات تسجيل الطالب:</p>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="p-3 rounded-3" style="background:#f3efe6">
                                <div class="small text-muted">رقم القيد</div>
                                <div class="fs-4 fw-bold" style="color:#0b2a4a">{{ $registration_number }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 rounded-3" style="background:#f3efe6">
                                <div class="small text-muted">الرقم السري</div>
                                <div class="fs-4 fw-bold" style="color:#0b2a4a">{{ $secret_code }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-warning text-start">
                        احفظ <strong>رقم القيد</strong> و<strong>الرقم السري</strong> في مكان آمن، ولا تشارك الرقم السري مع أحد.
                    </div>

                    <a href="{{ route('home') }}" class="btn btn-navy px-4">العودة للرئيسية</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

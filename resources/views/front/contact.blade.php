@extends('layouts.front')

@section('title', 'اتصل بنا | ' . ($siteName ?? 'جامعة النور'))

@section('content')
<section class="page-hero">
    <div class="container">
        <h1>اتصل بنا</h1>
        <p class="mb-0 opacity-75">نحن هنا للإجابة على استفساراتك</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-5">
                <div class="content-card h-100">
                    <h5 class="mb-4">معلومات التواصل</h5>
                    <p><i class="bi bi-geo-alt text-primary"></i> {{ $address ?: 'طرابلس، ليبيا' }}</p>
                    <p><i class="bi bi-telephone text-primary"></i> {{ $phone ?: '021-0000000' }}</p>
                    <p class="mb-0"><i class="bi bi-envelope text-primary"></i> {{ $email }}</p>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="content-card">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <form method="POST" action="{{ route('contact.store') }}">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">الاسم</label>
                                <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">البريد الإلكتروني</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">الهاتف</label>
                                <input type="text" name="phone" value="{{ old('phone') }}" class="form-control @error('phone') is-invalid @enderror">
                                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">الموضوع</label>
                                <input type="text" name="subject" value="{{ old('subject') }}" class="form-control @error('subject') is-invalid @enderror" required>
                                @error('subject')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label">الرسالة</label>
                                <textarea name="message" rows="5" class="form-control @error('message') is-invalid @enderror" required>{{ old('message') }}</textarea>
                                @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <button class="btn btn-navy px-4" type="submit">إرسال الرسالة</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

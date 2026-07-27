<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', $siteName ?? 'جامعة النور')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/front.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
    <div class="topbar py-2 d-none d-md-block">
        <div class="container d-flex justify-content-between align-items-center small">
            <div>
                <span class="me-3"><i class="bi bi-envelope"></i> {{ \App\Models\Setting::get('contact_email', 'info@university.edu') }}</span>
                <span><i class="bi bi-telephone"></i> {{ \App\Models\Setting::get('contact_phone', '021-0000000') }}</span>
            </div>
            <div class="social-links">
                @if(\App\Models\Setting::get('facebook'))
                    <a href="{{ \App\Models\Setting::get('facebook') }}" target="_blank" rel="noopener"><i class="bi bi-facebook"></i></a>
                @endif
                @if(\App\Models\Setting::get('twitter'))
                    <a href="{{ \App\Models\Setting::get('twitter') }}" target="_blank" rel="noopener"><i class="bi bi-twitter-x"></i></a>
                @endif
                @if(\App\Models\Setting::get('instagram'))
                    <a href="{{ \App\Models\Setting::get('instagram') }}" target="_blank" rel="noopener"><i class="bi bi-instagram"></i></a>
                @endif
                @if(\App\Models\Setting::get('youtube'))
                    <a href="{{ \App\Models\Setting::get('youtube') }}" target="_blank" rel="noopener"><i class="bi bi-youtube"></i></a>
                @endif
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark site-nav sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
                <span class="brand-mark"><i class="bi bi-mortarboard-fill"></i></span>
                <span>
                    <strong class="d-block lh-1">{{ $siteName }}</strong>
                    <small class="opacity-75">{{ $siteTagline }}</small>
                </span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">الرئيسية</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">عن الجامعة</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('faculties.*') ? 'active' : '' }}" href="{{ route('faculties.index') }}">الكليات</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('admissions') ? 'active' : '' }}" href="{{ route('admissions') }}">القبول والتسجيل</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('students.register*') ? 'active' : '' }}" href="{{ route('students.register') }}">تسجيل طالب</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('news.*') ? 'active' : '' }}" href="{{ route('news.index') }}">الأخبار</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('events.*') ? 'active' : '' }}" href="{{ route('events.index') }}">الفعاليات</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">اتصل بنا</a></li>
                </ul>
                <a href="{{ route('students.register') }}" class="btn btn-accent btn-sm px-3">تسجيل طالب</a>
            </div>
        </div>
    </nav>

    @yield('content')

    <footer class="site-footer pt-5 pb-4 mt-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5 class="text-white mb-3">{{ $siteName }}</h5>
                    <p class="footer-text">{{ \App\Models\Setting::get('about_short', 'جامعة رائدة تهدف إلى إعداد كوادر مؤهلة قادرة على خدمة المجتمع والمساهمة في التنمية.') }}</p>
                </div>
                <div class="col-6 col-lg-2">
                    <h6 class="text-white mb-3">روابط سريعة</h6>
                    <ul class="list-unstyled footer-links">
                        <li><a href="{{ route('about') }}">عن الجامعة</a></li>
                        <li><a href="{{ route('faculties.index') }}">الكليات</a></li>
                        <li><a href="{{ route('students.register') }}">تسجيل طالب</a></li>
                        <li><a href="{{ route('admissions') }}">القبول</a></li>
                    </ul>
                </div>
                <div class="col-6 col-lg-3">
                    <h6 class="text-white mb-3">خدمات</h6>
                    <ul class="list-unstyled footer-links">
                        <li><a href="{{ route('events.index') }}">الفعاليات</a></li>
                        <li><a href="{{ route('contact') }}">تواصل معنا</a></li>
                        <li><a href="{{ route('admin.login') }}">لوحة التحكم</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h6 class="text-white mb-3">تواصل</h6>
                    <p class="footer-text mb-1"><i class="bi bi-geo-alt"></i> {{ \App\Models\Setting::get('contact_address', 'طرابلس، ليبيا') }}</p>
                    <p class="footer-text mb-1"><i class="bi bi-telephone"></i> {{ \App\Models\Setting::get('contact_phone', '021-0000000') }}</p>
                    <p class="footer-text"><i class="bi bi-envelope"></i> {{ \App\Models\Setting::get('contact_email', 'info@university.edu') }}</p>
                </div>
            </div>
            <hr class="border-secondary my-4">
            <div class="text-center footer-text small">
                &copy; {{ date('Y') }} {{ $siteName }}. جميع الحقوق محفوظة.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>

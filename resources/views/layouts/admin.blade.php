<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'لوحة التحكم')</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
</head>
<body>
<div class="d-flex" id="admin-wrap">
    <aside class="admin-sidebar">
        <div class="brand p-3 mb-2">
            <div class="fw-bold">لوحة التحكم</div>
            <small class="opacity-75">إدارة موقع الجامعة</small>
        </div>
        <nav class="nav flex-column px-2">
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i> الرئيسية</a>
            <a class="nav-link {{ request()->routeIs('admin.sliders.*') ? 'active' : '' }}" href="{{ route('admin.sliders.index') }}"><i class="bi bi-images"></i> السلايدر</a>
            <a class="nav-link {{ request()->routeIs('admin.news.*') ? 'active' : '' }}" href="{{ route('admin.news.index') }}"><i class="bi bi-newspaper"></i> الأخبار</a>
            <a class="nav-link {{ request()->routeIs('admin.events.*') ? 'active' : '' }}" href="{{ route('admin.events.index') }}"><i class="bi bi-calendar-event"></i> الفعاليات</a>
            <a class="nav-link {{ request()->routeIs('admin.faculties.*') ? 'active' : '' }}" href="{{ route('admin.faculties.index') }}"><i class="bi bi-building"></i> الأقسام</a>
            <a class="nav-link {{ request()->routeIs('admin.students.*') ? 'active' : '' }}" href="{{ route('admin.students.index') }}"><i class="bi bi-people"></i> الطلاب</a>
            <a class="nav-link {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}" href="{{ route('admin.pages.index') }}"><i class="bi bi-file-earmark-text"></i> الصفحات</a>
            <a class="nav-link {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}" href="{{ route('admin.messages.index') }}"><i class="bi bi-envelope"></i> الرسائل</a>
            <a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" href="{{ route('admin.settings.edit') }}"><i class="bi bi-gear"></i> الإعدادات</a>
            <a class="nav-link" href="{{ route('home') }}" target="_blank"><i class="bi bi-box-arrow-up-right"></i> عرض الموقع</a>
        </nav>
    </aside>
    <main class="admin-main flex-grow-1">
        <header class="admin-topbar d-flex justify-content-between align-items-center px-4 py-3">
            <h1 class="h5 mb-0">@yield('heading', 'لوحة التحكم')</h1>
            <div class="d-flex align-items-center gap-3">
                <span class="small text-muted">{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button class="btn btn-sm btn-outline-danger">خروج</button>
                </form>
            </div>
        </header>
        <div class="p-4">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @yield('content')
        </div>
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

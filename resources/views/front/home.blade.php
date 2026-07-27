@extends('layouts.front')

@section('title', ($siteName ?? 'جامعة النور') . ' | الرئيسية')

@section('content')
<div id="heroCarousel" class="carousel slide hero-slider" data-bs-ride="carousel">
    <div class="carousel-inner">
        @forelse($sliders as $i => $slider)
            <div class="carousel-item {{ $i === 0 ? 'active' : '' }}"
                 style="background-image: url('{{ $slider->image ? asset('storage/'.$slider->image) : 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?auto=format&fit=crop&w=1600&q=80' }}');">
                <div class="container hero-content fade-up">
                    <div class="brand-line">{{ $siteName }}</div>
                    <h1>{{ $slider->title }}</h1>
                    @if($slider->subtitle)
                        <p class="lead mb-4 opacity-90">{{ $slider->subtitle }}</p>
                    @endif
                    <div class="d-flex gap-2 flex-wrap">
                        @if($slider->button_text && $slider->button_link)
                            <a href="{{ $slider->button_link }}" class="btn btn-accent btn-lg px-4">{{ $slider->button_text }}</a>
                        @endif
                        <a href="{{ route('about') }}" class="btn btn-outline-light btn-lg px-4">تعرف علينا</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="carousel-item active"
                 style="background-image: url('https://images.unsplash.com/photo-1541339907198-e08756dedf3f?auto=format&fit=crop&w=1600&q=80');">
                <div class="container hero-content fade-up">
                    <div class="brand-line">{{ $siteName }}</div>
                    <h1>مستقبل أكاديمي يبدأ من هنا</h1>
                    <p class="lead mb-4 opacity-90">نُعدّ جيلاً من المتعلمين والباحثين لخدمة المجتمع وبناء المعرفة.</p>
                    <a href="{{ route('admissions') }}" class="btn btn-accent btn-lg px-4">القبول والتسجيل</a>
                </div>
            </div>
        @endforelse
    </div>
    @if($sliders->count() > 1)
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    @endif
</div>

<div class="container">
    <div class="stat-band p-4 p-md-5">
        <div class="row text-center g-4">
            <div class="col-6 col-md-3">
                <div class="stat-num">{{ \App\Models\Setting::get('students_count', '12000+') }}</div>
                <div>طالب وطالبة</div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-num">{{ \App\Models\Setting::get('faculties_count', '12') }}</div>
                <div>كلية</div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-num">{{ \App\Models\Setting::get('programs_count', '45') }}</div>
                <div>برنامج أكاديمي</div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-num">{{ \App\Models\Setting::get('years_count', '35') }}</div>
                <div>عاماً من التميز</div>
            </div>
        </div>
    </div>
</div>

<section class="py-5 mt-4">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-6 fade-up">
                <h2 class="section-title">عن الجامعة</h2>
                <p class="section-sub mb-4">
                    {{ \App\Models\Setting::get('about_short', $about->excerpt ?? 'جامعة وطنية رائدة تسعى للتميز في التعليم العالي والبحث العلمي وخدمة المجتمع.') }}
                </p>
                <a href="{{ route('about') }}" class="btn btn-navy px-4">اقرأ المزيد</a>
            </div>
            <div class="col-lg-6">
                <div class="rounded-4 overflow-hidden shadow" style="min-height:320px;background:url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&w=1200&q=80') center/cover;"></div>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h2 class="section-title mb-1">كلياتنا</h2>
                <p class="section-sub mb-0">برامج أكاديمية متنوعة تلبي احتياجات سوق العمل</p>
            </div>
            <a href="{{ route('faculties.index') }}" class="btn btn-outline-primary d-none d-md-inline-flex">عرض الكل</a>
        </div>
        <div class="row g-4">
            @foreach($faculties as $faculty)
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('faculties.show', $faculty) }}" class="text-decoration-none text-dark">
                        <article class="feature-tile">
                            <div class="media" @if($faculty->image) style="background-image:url('{{ asset('storage/'.$faculty->image) }}')" @endif></div>
                            <div class="body">
                                <h5 class="mb-2">{{ $faculty->name }}</h5>
                                <p class="text-muted small mb-0">{{ \Illuminate\Support\Str::limit(strip_tags($faculty->description), 90) }}</p>
                            </div>
                        </article>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="py-5 bg-white">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h2 class="section-title mb-1">آخر الأخبار</h2>
                <p class="section-sub mb-0">تابع مستجدات الجامعة وأنشطتها</p>
            </div>
            <a href="{{ route('news.index') }}" class="btn btn-outline-primary d-none d-md-inline-flex">كل الأخبار</a>
        </div>
        <div class="row g-4">
            @forelse($news as $item)
                <div class="col-md-4">
                    <a href="{{ route('news.show', $item) }}" class="text-decoration-none text-dark">
                        <article class="feature-tile">
                            <div class="media" @if($item->image) style="background-image:url('{{ asset('storage/'.$item->image) }}')" @endif></div>
                            <div class="body">
                                <div class="small text-muted mb-2">{{ optional($item->published_at)->format('Y/m/d') }}</div>
                                <h5 class="mb-2">{{ $item->title }}</h5>
                                <p class="text-muted small mb-0">{{ $item->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($item->content), 100) }}</p>
                            </div>
                        </article>
                    </a>
                </div>
            @empty
                <div class="col-12"><p class="text-muted">لا توجد أخبار حالياً.</p></div>
            @endforelse
        </div>
    </div>
</section>

@if($events->count())
<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h2 class="section-title mb-1">الفعاليات القادمة</h2>
                <p class="section-sub mb-0">فعاليات ومؤتمرات وورش عمل</p>
            </div>
            <a href="{{ route('events.index') }}" class="btn btn-outline-primary d-none d-md-inline-flex">كل الفعاليات</a>
        </div>
        <div class="row g-4">
            @foreach($events as $event)
                <div class="col-md-4">
                    <a href="{{ route('events.show', $event) }}" class="text-decoration-none text-dark">
                        <article class="feature-tile">
                            <div class="body">
                                <div class="small text-warning-emphasis fw-bold mb-2">
                                    <i class="bi bi-calendar-event"></i> {{ $event->starts_at->format('Y/m/d H:i') }}
                                </div>
                                <h5>{{ $event->title }}</h5>
                                @if($event->location)
                                    <p class="small text-muted mb-0"><i class="bi bi-geo-alt"></i> {{ $event->location }}</p>
                                @endif
                            </div>
                        </article>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection

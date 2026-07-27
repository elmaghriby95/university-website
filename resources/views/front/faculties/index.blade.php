@extends('layouts.front')

@section('title', 'الأقسام | ' . ($siteName ?? 'جامعة النور'))

@section('content')
<section class="page-hero">
    <div class="container">
        <h1>الأقسام</h1>
        <p class="mb-0 opacity-75">استكشف أقسام الجامعة وبرامجها الأكاديمية</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            @forelse($faculties as $faculty)
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('faculties.show', $faculty) }}" class="text-decoration-none text-dark">
                        <article class="feature-tile">
                            <div class="media" @if($faculty->image && media_url($faculty->image)) style="background-image:url('{{ media_url($faculty->image) }}')" @endif></div>
                            <div class="body">
                                <h5>{{ $faculty->name }}</h5>
                                <p class="text-muted small">{{ \Illuminate\Support\Str::limit(strip_tags($faculty->description), 110) }}</p>
                                <div class="d-flex gap-3 small text-muted">
                                    <span><i class="bi bi-people"></i> {{ $faculty->students_count }} طالب</span>
                                    <span><i class="bi bi-building"></i> {{ $faculty->departments_count }} تخصص</span>
                                </div>
                            </div>
                        </article>
                    </a>
                </div>
            @empty
                <div class="col-12"><div class="alert alert-light">لا توجد أقسام مضافة بعد.</div></div>
            @endforelse
        </div>
    </div>
</section>
@endsection

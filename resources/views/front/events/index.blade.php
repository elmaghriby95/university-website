@extends('layouts.front')

@section('title', 'الفعاليات | ' . ($siteName ?? 'جامعة النور'))

@section('content')
<section class="page-hero">
    <div class="container">
        <h1>الفعاليات</h1>
        <p class="mb-0 opacity-75">مؤتمرات وورش عمل وأنشطة جامعية</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            @forelse($events as $event)
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('events.show', $event) }}" class="text-decoration-none text-dark">
                        <article class="feature-tile">
                            <div class="media" @if($event->image) style="background-image:url('{{ asset('storage/'.$event->image) }}')" @endif></div>
                            <div class="body">
                                <div class="small fw-bold text-warning-emphasis mb-2">
                                    <i class="bi bi-calendar-event"></i> {{ $event->starts_at->format('Y/m/d H:i') }}
                                </div>
                                <h5>{{ $event->title }}</h5>
                                <p class="text-muted small mb-0">{{ $event->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($event->content), 90) }}</p>
                            </div>
                        </article>
                    </a>
                </div>
            @empty
                <div class="col-12"><div class="alert alert-light">لا توجد فعاليات.</div></div>
            @endforelse
        </div>
        <div class="mt-4">{{ $events->links() }}</div>
    </div>
</section>
@endsection

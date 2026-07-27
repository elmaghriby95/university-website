@extends('layouts.front')

@section('title', $event->title . ' | ' . ($siteName ?? 'جامعة النور'))

@section('content')
<section class="page-hero">
    <div class="container">
        <h1>{{ $event->title }}</h1>
        <p class="mb-0 opacity-75">
            <i class="bi bi-calendar-event"></i> {{ $event->starts_at->format('Y/m/d H:i') }}
            @if($event->location) · <i class="bi bi-geo-alt"></i> {{ $event->location }} @endif
        </p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="content-card">
            @if($event->image && media_url($event->image))
                <img src="{{ media_url($event->image) }}" class="img-fluid rounded-3 mb-4 w-100" style="max-height:420px;object-fit:cover" alt="{{ $event->title }}">
            @endif
            <div>{!! nl2br(e($event->content ?: $event->excerpt)) !!}</div>
        </div>
    </div>
</section>
@endsection

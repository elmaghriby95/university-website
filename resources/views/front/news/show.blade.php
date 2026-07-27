@extends('layouts.front')

@section('title', $news->title . ' | ' . ($siteName ?? 'جامعة النور'))

@section('content')
<section class="page-hero">
    <div class="container">
        <div class="small opacity-75 mb-2">{{ optional($news->published_at)->format('Y/m/d') }}</div>
        <h1>{{ $news->title }}</h1>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="content-card">
                    @if($news->image)
                        <img src="{{ asset('storage/'.$news->image) }}" class="img-fluid rounded-3 mb-4 w-100" style="max-height:420px;object-fit:cover" alt="{{ $news->title }}">
                    @endif
                    <div>{!! nl2br(e($news->content)) !!}</div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="content-card">
                    <h5 class="mb-3">أخبار ذات صلة</h5>
                    @forelse($related as $item)
                        <a href="{{ route('news.show', $item) }}" class="d-block text-decoration-none mb-3 pb-3 border-bottom">
                            <div class="fw-bold text-dark">{{ $item->title }}</div>
                            <small class="text-muted">{{ optional($item->published_at)->format('Y/m/d') }}</small>
                        </a>
                    @empty
                        <p class="text-muted mb-0">لا توجد أخبار أخرى.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

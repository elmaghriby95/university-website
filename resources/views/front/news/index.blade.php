@extends('layouts.front')

@section('title', 'الأخبار | ' . ($siteName ?? 'جامعة النور'))

@section('content')
<section class="page-hero">
    <div class="container">
        <h1>الأخبار</h1>
        <p class="mb-0 opacity-75">أحدث أخبار وأنشطة الجامعة</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            @forelse($news as $item)
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('news.show', $item) }}" class="text-decoration-none text-dark">
                        <article class="feature-tile">
                            <div class="media" @if($item->image) style="background-image:url('{{ asset('storage/'.$item->image) }}')" @endif></div>
                            <div class="body">
                                <div class="small text-muted mb-2">{{ optional($item->published_at)->format('Y/m/d') }}</div>
                                <h5>{{ $item->title }}</h5>
                                <p class="text-muted small mb-0">{{ $item->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($item->content), 100) }}</p>
                            </div>
                        </article>
                    </a>
                </div>
            @empty
                <div class="col-12"><div class="alert alert-light">لا توجد أخبار.</div></div>
            @endforelse
        </div>
        <div class="mt-4">{{ $news->links() }}</div>
    </div>
</section>
@endsection

@extends('layouts.front')

@section('title', $page->title . ' | ' . ($siteName ?? 'جامعة النور'))

@section('content')
<section class="page-hero">
    <div class="container">
        <h1>{{ $page->title }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a class="text-white-50" href="{{ route('home') }}">الرئيسية</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">{{ $page->title }}</li>
            </ol>
        </nav>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="content-card">
            @if($page->image)
                <img src="{{ asset('storage/'.$page->image) }}" class="img-fluid rounded-3 mb-4 w-100" style="max-height:420px;object-fit:cover" alt="{{ $page->title }}">
            @endif
            <div class="page-content">{!! nl2br(e($page->content)) !!}</div>
        </div>
    </div>
</section>
@endsection

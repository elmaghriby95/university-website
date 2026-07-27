@extends('layouts.front')

@section('title', $faculty->name . ' | ' . ($siteName ?? 'جامعة النور'))

@section('content')
<section class="page-hero">
    <div class="container">
        <h1>{{ $faculty->name }}</h1>
        @if($faculty->dean)
            <p class="mb-0 opacity-75">عميد الكلية: {{ $faculty->dean }}</p>
        @endif
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="content-card">
                    @if($faculty->image && media_url($faculty->image))
                        <img src="{{ media_url($faculty->image) }}" class="img-fluid rounded-3 mb-4 w-100" style="max-height:360px;object-fit:cover" alt="{{ $faculty->name }}">
                    @endif
                    <div>{!! nl2br(e($faculty->description)) !!}</div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="content-card">
                    <h5 class="mb-3">معلومات سريعة</h5>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><i class="bi bi-people text-primary"></i> عدد الطلاب: <strong>{{ $faculty->students_count }}</strong></li>
                        <li class="mb-2"><i class="bi bi-building text-primary"></i> عدد الأقسام: <strong>{{ $faculty->departments_count }}</strong></li>
                        @if($faculty->dean)
                            <li><i class="bi bi-person-badge text-primary"></i> العميد: <strong>{{ $faculty->dean }}</strong></li>
                        @endif
                    </ul>
                    <a href="{{ route('admissions') }}" class="btn btn-accent w-100 mt-4">التقديم للكلية</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

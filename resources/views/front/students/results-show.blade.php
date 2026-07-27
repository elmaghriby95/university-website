@extends('layouts.front')

@section('title', 'نتيجة الطالب | ' . ($siteName ?? 'جامعة النور'))

@section('content')
<section class="page-hero">
    <div class="container">
        <h1>نتيجة الطالب</h1>
        <p class="mb-0 opacity-75">{{ $student->full_name }} — رقم القيد: {{ $student->registration_number }}</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="content-card mb-4">
            <div class="row g-3">
                <div class="col-md-4"><strong>الاسم:</strong> {{ $student->full_name }}</div>
                <div class="col-md-4"><strong>رقم القيد:</strong> {{ $student->registration_number }}</div>
                <div class="col-md-4"><strong>القسم:</strong> {{ $student->faculty?->name ?? '—' }}</div>
            </div>
        </div>

        @forelse($results as $result)
            <div class="content-card mb-4">
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
                    <div>
                        <h2 class="h5 mb-1">{{ $result->academic_year }} — {{ $result->semester }}</h2>
                        @if($result->gpa !== null)
                            <span class="badge text-bg-primary">المعدل: {{ $result->gpa }}</span>
                        @endif
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>المادة</th>
                                <th>الدرجة</th>
                                <th>الوحدات</th>
                                <th>الحالة</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($result->subjects as $i => $subject)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $subject->subject_name }}</td>
                                <td>{{ $subject->grade }}</td>
                                <td>{{ $subject->credits ?? '—' }}</td>
                                <td>{{ $subject->status ?? '—' }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @if($result->notes)
                    <p class="mt-3 mb-0 text-muted small">{{ $result->notes }}</p>
                @endif
            </div>
        @empty
            <div class="alert alert-light">لا توجد نتائج منشورة لهذا الطالب حالياً.</div>
        @endforelse

        <a href="{{ route('results.lookup') }}" class="btn btn-outline-secondary">استعلام جديد</a>
    </div>
</section>
@endsection

@extends('layouts.admin')

@section('title', 'لوحة التحكم')
@section('heading', 'نظرة عامة')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-3"><div class="stat-card"><div class="text-muted small">الأخبار</div><div class="num">{{ $newsCount }}</div></div></div>
    <div class="col-md-3"><div class="stat-card"><div class="text-muted small">الفعاليات</div><div class="num">{{ $eventsCount }}</div></div></div>
    <div class="col-md-3"><div class="stat-card"><div class="text-muted small">الكليات</div><div class="num">{{ $facultiesCount }}</div></div></div>
    <div class="col-md-3"><div class="stat-card"><div class="text-muted small">رسائل غير مقروءة</div><div class="num">{{ $messagesCount }}</div></div></div>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="table-card">
            <h2 class="h6 mb-3">آخر الأخبار</h2>
            <div class="table-responsive">
                <table class="table table-sm align-middle mb-0">
                    <tbody>
                    @forelse($latestNews as $item)
                        <tr>
                            <td>{{ $item->title }}</td>
                            <td class="text-muted small">{{ $item->created_at->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr><td class="text-muted">لا توجد أخبار</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="table-card">
            <h2 class="h6 mb-3">آخر الرسائل</h2>
            <div class="table-responsive">
                <table class="table table-sm align-middle mb-0">
                    <tbody>
                    @forelse($latestMessages as $msg)
                        <tr>
                            <td>
                                <a href="{{ route('admin.messages.show', $msg) }}" class="text-decoration-none">
                                    {{ $msg->name }} — {{ $msg->subject }}
                                    @unless($msg->is_read)<span class="badge text-bg-warning">جديد</span>@endunless
                                </a>
                            </td>
                            <td class="text-muted small">{{ $msg->created_at->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr><td class="text-muted">لا توجد رسائل</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

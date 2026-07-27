@extends('layouts.admin')

@section('title', 'الأخبار')
@section('heading', 'إدارة الأخبار')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <div></div>
    <a href="{{ route('admin.news.create') }}" class="btn btn-primary btn-sm" style="background:#0b2a4a;border:none">إضافة خبر</a>
</div>
<div class="table-card">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead><tr><th>العنوان</th><th>الحالة</th><th>التاريخ</th><th></th></tr></thead>
            <tbody>
            @foreach($items as $item)
                <tr>
                    <td>{{ $item->title }}</td>
                    <td>
                        @if($item->is_published)<span class="badge text-bg-success">منشور</span>@else<span class="badge text-bg-secondary">مسودة</span>@endif
                        @if($item->is_featured)<span class="badge text-bg-warning">مميز</span>@endif
                    </td>
                    <td>{{ optional($item->published_at)->format('Y-m-d') }}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.news.edit', $item) }}" class="btn btn-sm btn-outline-primary">تعديل</a>
                        <form action="{{ route('admin.news.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('حذف الخبر؟')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">حذف</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {{ $items->links() }}
</div>
@endsection

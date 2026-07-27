@extends('layouts.admin')

@section('title', 'الصفحات')
@section('heading', 'إدارة الصفحات')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <div></div>
    <a href="{{ route('admin.pages.create') }}" class="btn btn-primary btn-sm" style="background:#0b2a4a;border:none">إضافة صفحة</a>
</div>
<div class="table-card">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead><tr><th>العنوان</th><th>الرابط</th><th>الحالة</th><th></th></tr></thead>
            <tbody>
            @foreach($items as $item)
                <tr>
                    <td>{{ $item->title }}</td>
                    <td><code>{{ $item->slug }}</code></td>
                    <td>@if($item->is_published)<span class="badge text-bg-success">منشورة</span>@else<span class="badge text-bg-secondary">مسودة</span>@endif</td>
                    <td class="text-end">
                        <a href="{{ route('admin.pages.edit', $item) }}" class="btn btn-sm btn-outline-primary">تعديل</a>
                        <form action="{{ route('admin.pages.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('حذف الصفحة؟')">
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

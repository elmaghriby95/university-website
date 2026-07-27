@extends('layouts.admin')

@section('title', 'الأقسام')
@section('heading', 'إدارة الأقسام')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <div></div>
    <a href="{{ route('admin.faculties.create') }}" class="btn btn-primary btn-sm" style="background:#0b2a4a;border:none">إضافة قسم</a>
</div>
<div class="table-card">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead><tr><th>الاسم</th><th>رئيس القسم</th><th>الترتيب</th><th>الحالة</th><th></th></tr></thead>
            <tbody>
            @foreach($items as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->dean }}</td>
                    <td>{{ $item->sort_order }}</td>
                    <td>@if($item->is_active)<span class="badge text-bg-success">نشط</span>@else<span class="badge text-bg-secondary">مخفي</span>@endif</td>
                    <td class="text-end">
                        <a href="{{ route('admin.faculties.edit', $item) }}" class="btn btn-sm btn-outline-primary">تعديل</a>
                        <form action="{{ route('admin.faculties.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('حذف القسم؟')">
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

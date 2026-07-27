@extends('layouts.admin')

@section('title', 'السلايدر')
@section('heading', 'إدارة السلايدر')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <div></div>
    <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary btn-sm" style="background:#0b2a4a;border:none">إضافة شريحة</a>
</div>
<div class="table-card">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead><tr><th>العنوان</th><th>الترتيب</th><th>الحالة</th><th></th></tr></thead>
            <tbody>
            @foreach($items as $item)
                <tr>
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->sort_order }}</td>
                    <td>@if($item->is_active)<span class="badge text-bg-success">نشطة</span>@else<span class="badge text-bg-secondary">مخفية</span>@endif</td>
                    <td class="text-end">
                        <a href="{{ route('admin.sliders.edit', $item) }}" class="btn btn-sm btn-outline-primary">تعديل</a>
                        <form action="{{ route('admin.sliders.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('حذف الشريحة؟')">
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

@extends('layouts.admin')

@section('title', 'الفعاليات')
@section('heading', 'إدارة الفعاليات')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <div></div>
    <a href="{{ route('admin.events.create') }}" class="btn btn-primary btn-sm" style="background:#0b2a4a;border:none">إضافة فعالية</a>
</div>
<div class="table-card">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead><tr><th>العنوان</th><th>التاريخ</th><th>المكان</th><th></th></tr></thead>
            <tbody>
            @foreach($items as $item)
                <tr>
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->starts_at->format('Y-m-d H:i') }}</td>
                    <td>{{ $item->location }}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.events.edit', $item) }}" class="btn btn-sm btn-outline-primary">تعديل</a>
                        <form action="{{ route('admin.events.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('حذف الفعالية؟')">
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

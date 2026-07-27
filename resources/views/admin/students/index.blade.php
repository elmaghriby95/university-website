@extends('layouts.admin')

@section('title', 'الطلاب')
@section('heading', 'إدارة الطلاب')

@section('content')
<div class="d-flex flex-wrap justify-content-between gap-2 mb-3">
    <form method="GET" class="d-flex gap-2">
        <input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="بحث بالاسم أو رقم القيد">
        <button class="btn btn-sm btn-outline-secondary">بحث</button>
    </form>
    <a href="{{ route('admin.students.create') }}" class="btn btn-primary btn-sm" style="background:#0b2a4a;border:none">إضافة طالب</a>
</div>
<div class="table-card">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
            <tr>
                <th>رقم القيد</th>
                <th>الاسم</th>
                <th>القسم</th>
                <th>الهاتف</th>
                <th>الحالة</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @forelse($items as $item)
                <tr>
                    <td><code>{{ $item->registration_number }}</code></td>
                    <td>{{ $item->full_name }}</td>
                    <td>{{ $item->faculty?->name ?? '—' }}</td>
                    <td>{{ $item->phone }}</td>
                    <td>
                        @if($item->status === 'approved')
                            <span class="badge text-bg-success">مقبول</span>
                        @elseif($item->status === 'pending')
                            <span class="badge text-bg-warning">قيد المراجعة</span>
                        @else
                            <span class="badge text-bg-danger">مرفوض</span>
                        @endif
                    </td>
                    <td class="text-end text-nowrap">
                        <a href="{{ route('admin.students.edit', $item) }}" class="btn btn-sm btn-outline-primary">تعديل</a>
                        <form action="{{ route('admin.students.reset-secret', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('توليد رقم سري جديد؟')">
                            @csrf
                            <button class="btn btn-sm btn-outline-warning">رقم سري جديد</button>
                        </form>
                        <form action="{{ route('admin.students.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('حذف الطالب؟')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">حذف</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-muted">لا يوجد طلاب.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    {{ $items->links() }}
</div>
@endsection

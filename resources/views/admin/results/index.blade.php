@extends('layouts.admin')

@section('title', 'النتائج')
@section('heading', 'إدارة النتائج')

@section('content')
<div class="d-flex flex-wrap justify-content-between gap-2 mb-3">
    <form method="GET" class="d-flex gap-2">
        <input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="بحث بالطالب أو رقم القيد">
        <button class="btn btn-sm btn-outline-secondary">بحث</button>
    </form>
    <a href="{{ route('admin.results.create') }}" class="btn btn-primary btn-sm" style="background:#0b2a4a;border:none">إضافة نتيجة</a>
</div>
<div class="table-card">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
            <tr>
                <th>الطالب</th>
                <th>رقم القيد</th>
                <th>العام / الفصل</th>
                <th>المعدل</th>
                <th>الحالة</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @forelse($items as $item)
                <tr>
                    <td>{{ $item->student?->full_name }}</td>
                    <td><code>{{ $item->student?->registration_number }}</code></td>
                    <td>{{ $item->academic_year }} — {{ $item->semester }}</td>
                    <td>{{ $item->gpa ?? '—' }}</td>
                    <td>
                        @if($item->is_published)
                            <span class="badge text-bg-success">منشورة</span>
                        @else
                            <span class="badge text-bg-secondary">مخفية</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('admin.results.edit', $item) }}" class="btn btn-sm btn-outline-primary">تعديل</a>
                        <form action="{{ route('admin.results.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('حذف النتيجة؟')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">حذف</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-muted">لا توجد نتائج.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    {{ $items->links() }}
</div>
@endsection

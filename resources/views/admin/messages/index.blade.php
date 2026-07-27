@extends('layouts.admin')

@section('title', 'الرسائل')
@section('heading', 'رسائل التواصل')

@section('content')
<div class="table-card">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead><tr><th>المرسل</th><th>الموضوع</th><th>التاريخ</th><th></th></tr></thead>
            <tbody>
            @forelse($items as $item)
                <tr class="{{ $item->is_read ? '' : 'table-warning' }}">
                    <td>{{ $item->name }}<br><small class="text-muted">{{ $item->email }}</small></td>
                    <td>{{ $item->subject }}</td>
                    <td>{{ $item->created_at->format('Y-m-d H:i') }}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.messages.show', $item) }}" class="btn btn-sm btn-outline-primary">عرض</a>
                        <form action="{{ route('admin.messages.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('حذف الرسالة؟')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">حذف</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-muted">لا توجد رسائل.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    {{ $items->links() }}
</div>
@endsection

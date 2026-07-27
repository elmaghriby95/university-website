@extends('layouts.admin')

@section('title', 'عرض رسالة')
@section('heading', 'تفاصيل الرسالة')

@section('content')
<div class="form-card">
    <div class="mb-3"><strong>المرسل:</strong> {{ $message->name }}</div>
    <div class="mb-3"><strong>البريد:</strong> {{ $message->email }}</div>
    @if($message->phone)<div class="mb-3"><strong>الهاتف:</strong> {{ $message->phone }}</div>@endif
    <div class="mb-3"><strong>الموضوع:</strong> {{ $message->subject }}</div>
    <div class="mb-3"><strong>التاريخ:</strong> {{ $message->created_at->format('Y-m-d H:i') }}</div>
    <hr>
    <p class="mb-4" style="white-space:pre-wrap">{{ $message->message }}</p>
    <a href="{{ route('admin.messages.index') }}" class="btn btn-outline-secondary">رجوع</a>
    <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" class="d-inline" onsubmit="return confirm('حذف الرسالة؟')">
        @csrf @method('DELETE')
        <button class="btn btn-outline-danger">حذف</button>
    </form>
</div>
@endsection

@extends('layouts.admin')

@section('title', $item->exists ? 'تعديل نتيجة' : 'إضافة نتيجة')
@section('heading', $item->exists ? 'تعديل نتيجة' : 'إضافة نتيجة')

@section('content')
<div class="form-card">
    <form method="POST" action="{{ $item->exists ? route('admin.results.update', $item) : route('admin.results.store') }}" id="result-form">
        @csrf
        @if($item->exists) @method('PUT') @endif
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label">الطالب</label>
                <select name="student_id" class="form-select" required>
                    <option value="">اختر الطالب</option>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}" @selected(old('student_id', $item->student_id) == $student->id)>
                            {{ $student->registration_number }} — {{ $student->full_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">العام الدراسي</label>
                <input type="text" name="academic_year" value="{{ old('academic_year', $item->academic_year ?: '2025/2026') }}" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">الفصل</label>
                <input type="text" name="semester" value="{{ old('semester', $item->semester ?: 'الفصل الأول') }}" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">المعدل</label>
                <input type="number" step="0.01" min="0" max="4" name="gpa" value="{{ old('gpa', $item->gpa) }}" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">ملاحظات</label>
                <input type="text" name="notes" value="{{ old('notes', $item->notes) }}" class="form-control">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="is_published" value="1" id="is_published" @checked(old('is_published', $item->is_published ?? true))>
                    <label class="form-check-label" for="is_published">منشورة للطلاب</label>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-2">
            <h2 class="h6 mb-0">المواد والدرجات</h2>
            <button type="button" class="btn btn-sm btn-outline-primary" id="add-subject">إضافة مادة</button>
        </div>
        <div class="table-responsive mb-3">
            <table class="table table-bordered align-middle" id="subjects-table">
                <thead class="table-light">
                <tr>
                    <th>اسم المادة</th>
                    <th style="width:120px">الدرجة</th>
                    <th style="width:100px">الوحدات</th>
                    <th style="width:120px">الحالة</th>
                    <th style="width:60px"></th>
                </tr>
                </thead>
                <tbody>
                @php $oldSubjects = old('subjects', $subjects->toArray()); @endphp
                @foreach($oldSubjects as $i => $subject)
                    <tr>
                        <td><input type="text" name="subjects[{{ $i }}][subject_name]" value="{{ $subject['subject_name'] ?? '' }}" class="form-control form-control-sm" required></td>
                        <td><input type="text" name="subjects[{{ $i }}][grade]" value="{{ $subject['grade'] ?? '' }}" class="form-control form-control-sm" required></td>
                        <td><input type="number" name="subjects[{{ $i }}][credits]" value="{{ $subject['credits'] ?? '' }}" class="form-control form-control-sm" min="0"></td>
                        <td>
                            <select name="subjects[{{ $i }}][status]" class="form-select form-select-sm">
                                <option value="ناجح" @selected(($subject['status'] ?? '') === 'ناجح')>ناجح</option>
                                <option value="راسب" @selected(($subject['status'] ?? '') === 'راسب')>راسب</option>
                                <option value="غير مكتمل" @selected(($subject['status'] ?? '') === 'غير مكتمل')>غير مكتمل</option>
                            </select>
                        </td>
                        <td><button type="button" class="btn btn-sm btn-outline-danger remove-row">×</button></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <button class="btn btn-primary" style="background:#0b2a4a;border:none">حفظ</button>
        <a href="{{ route('admin.results.index') }}" class="btn btn-outline-secondary">رجوع</a>
    </form>
</div>

<script>
(() => {
    const tbody = document.querySelector('#subjects-table tbody');
    let index = tbody.querySelectorAll('tr').length;

    document.getElementById('add-subject').addEventListener('click', () => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td><input type="text" name="subjects[${index}][subject_name]" class="form-control form-control-sm" required></td>
            <td><input type="text" name="subjects[${index}][grade]" class="form-control form-control-sm" required></td>
            <td><input type="number" name="subjects[${index}][credits]" class="form-control form-control-sm" min="0"></td>
            <td>
                <select name="subjects[${index}][status]" class="form-select form-select-sm">
                    <option value="ناجح">ناجح</option>
                    <option value="راسب">راسب</option>
                    <option value="غير مكتمل">غير مكتمل</option>
                </select>
            </td>
            <td><button type="button" class="btn btn-sm btn-outline-danger remove-row">×</button></td>`;
        tbody.appendChild(tr);
        index++;
    });

    tbody.addEventListener('click', (e) => {
        if (e.target.classList.contains('remove-row')) {
            if (tbody.querySelectorAll('tr').length > 1) {
                e.target.closest('tr').remove();
            }
        }
    });
})();
</script>
@endsection

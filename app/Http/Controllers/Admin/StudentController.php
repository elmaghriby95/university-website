<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $items = Student::query()
            ->with('faculty')
            ->when($request->q, function ($q) use ($request) {
                $term = '%'.$request->q.'%';
                $q->where(function ($inner) use ($term) {
                    $inner->where('full_name', 'like', $term)
                        ->orWhere('registration_number', 'like', $term)
                        ->orWhere('phone', 'like', $term)
                        ->orWhere('national_id', 'like', $term);
                });
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.students.index', compact('items'));
    }

    public function create()
    {
        return view('admin.students.form', [
            'item' => new Student,
            'faculties' => Faculty::query()->orderBy('sort_order')->get(),
            'plainSecret' => null,
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $plainSecret = $request->filled('secret_code')
            ? $request->input('secret_code')
            : Student::generateSecretCode();

        $student = Student::query()->create([
            ...$data,
            'registration_number' => $request->input('registration_number') ?: Student::generateRegistrationNumber(),
            'secret_code' => $plainSecret,
        ]);

        return redirect()
            ->route('admin.students.edit', $student)
            ->with('success', 'تم إضافة الطالب. الرقم السري: '.$plainSecret);
    }

    public function edit(Student $student)
    {
        return view('admin.students.form', [
            'item' => $student->load('faculty'),
            'faculties' => Faculty::query()->orderBy('sort_order')->get(),
            'plainSecret' => null,
        ]);
    }

    public function update(Request $request, Student $student)
    {
        $data = $this->validated($request, $student->id);

        if ($request->filled('registration_number')) {
            $data['registration_number'] = $request->input('registration_number');
        }

        if ($request->filled('secret_code')) {
            $data['secret_code'] = $request->input('secret_code');
        }

        $student->update($data);

        $message = 'تم تحديث بيانات الطالب.';
        if ($request->filled('secret_code')) {
            $message .= ' الرقم السري الجديد: '.$request->input('secret_code');
        }

        return redirect()->route('admin.students.index')->with('success', $message);
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('admin.students.index')->with('success', 'تم حذف الطالب.');
    }

    public function resetSecret(Student $student)
    {
        $plainSecret = Student::generateSecretCode();
        $student->update(['secret_code' => $plainSecret]);

        return back()->with('success', 'تم توليد رقم سري جديد: '.$plainSecret);
    }

    private function validated(Request $request, ?int $ignoreId = null): array
    {
        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'national_id' => ['nullable', 'string', 'max:50', 'unique:students,national_id,'.($ignoreId ?: 'NULL')],
            'faculty_id' => ['nullable', 'exists:faculties,id'],
            'gender' => ['nullable', 'in:male,female'],
            'birth_date' => ['nullable', 'date'],
            'address' => ['nullable', 'string', 'max:500'],
            'status' => ['required', 'in:pending,approved,rejected'],
            'registration_number' => ['nullable', 'string', 'max:50', 'unique:students,registration_number,'.($ignoreId ?: 'NULL')],
            'secret_code' => ['nullable', 'string', 'min:4', 'max:50'],
        ]);

        unset($data['registration_number'], $data['secret_code']);

        return $data;
    }
}

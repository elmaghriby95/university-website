<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Result;
use App\Models\ResultSubject;
use App\Models\Student;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index(Request $request)
    {
        $items = Result::query()
            ->with('student')
            ->when($request->q, function ($q) use ($request) {
                $term = '%'.$request->q.'%';
                $q->whereHas('student', function ($s) use ($term) {
                    $s->where('full_name', 'like', $term)
                        ->orWhere('registration_number', 'like', $term);
                });
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.results.index', compact('items'));
    }

    public function create(Request $request)
    {
        return view('admin.results.form', [
            'item' => new Result(['student_id' => $request->student_id]),
            'students' => Student::query()->where('status', 'approved')->orderBy('registration_number')->get(),
            'subjects' => collect([['subject_name' => '', 'grade' => '', 'credits' => '', 'status' => 'ناجح']]),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $subjects = $this->validatedSubjects($request);

        $result = Result::query()->create($data);
        $this->syncSubjects($result, $subjects);

        return redirect()->route('admin.results.index')->with('success', 'تم إضافة النتيجة بنجاح.');
    }

    public function edit(Result $result)
    {
        $result->load('subjects', 'student');

        return view('admin.results.form', [
            'item' => $result,
            'students' => Student::query()->where('status', 'approved')->orderBy('registration_number')->get(),
            'subjects' => $result->subjects->isNotEmpty()
                ? $result->subjects
                : collect([['subject_name' => '', 'grade' => '', 'credits' => '', 'status' => 'ناجح']]),
        ]);
    }

    public function update(Request $request, Result $result)
    {
        $data = $this->validated($request);
        $subjects = $this->validatedSubjects($request);

        $result->update($data);
        $result->subjects()->delete();
        $this->syncSubjects($result, $subjects);

        return redirect()->route('admin.results.index')->with('success', 'تم تحديث النتيجة بنجاح.');
    }

    public function destroy(Result $result)
    {
        $result->delete();

        return redirect()->route('admin.results.index')->with('success', 'تم حذف النتيجة.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'academic_year' => ['required', 'string', 'max:50'],
            'semester' => ['required', 'string', 'max:50'],
            'gpa' => ['nullable', 'numeric', 'min:0', 'max:4'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $data['is_published'] = $request->boolean('is_published');

        return $data;
    }

    private function validatedSubjects(Request $request): array
    {
        $data = $request->validate([
            'subjects' => ['required', 'array', 'min:1'],
            'subjects.*.subject_name' => ['required', 'string', 'max:255'],
            'subjects.*.grade' => ['required', 'string', 'max:50'],
            'subjects.*.credits' => ['nullable', 'integer', 'min:0', 'max:20'],
            'subjects.*.status' => ['nullable', 'string', 'max:50'],
        ], [], [
            'subjects.*.subject_name' => 'اسم المادة',
            'subjects.*.grade' => 'الدرجة',
        ]);

        return $data['subjects'];
    }

    private function syncSubjects(Result $result, array $subjects): void
    {
        foreach (array_values($subjects) as $index => $subject) {
            ResultSubject::query()->create([
                'result_id' => $result->id,
                'subject_name' => $subject['subject_name'],
                'grade' => $subject['grade'],
                'credits' => $subject['credits'] ?? null,
                'status' => $subject['status'] ?? null,
                'sort_order' => $index + 1,
            ]);
        }
    }
}

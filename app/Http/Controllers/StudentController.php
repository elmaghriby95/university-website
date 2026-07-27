<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function registerForm(): View
    {
        return view('front.students.register', [
            'faculties' => Faculty::query()->where('is_active', true)->orderBy('sort_order')->get(),
        ]);
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'national_id' => ['nullable', 'string', 'max:50', 'unique:students,national_id'],
            'faculty_id' => ['required', 'exists:faculties,id'],
            'gender' => ['nullable', 'in:male,female'],
            'birth_date' => ['nullable', 'date', 'before:today'],
            'address' => ['nullable', 'string', 'max:500'],
        ], [], [
            'full_name' => 'الاسم الكامل',
            'email' => 'البريد الإلكتروني',
            'phone' => 'الهاتف',
            'national_id' => 'الرقم الوطني',
            'faculty_id' => 'القسم',
            'gender' => 'الجنس',
            'birth_date' => 'تاريخ الميلاد',
            'address' => 'العنوان',
        ]);

        $plainSecret = Student::generateSecretCode();

        $student = Student::query()->create([
            ...$data,
            'registration_number' => Student::generateRegistrationNumber(),
            'secret_code' => $plainSecret,
            'status' => 'approved',
        ]);

        return redirect()
            ->route('students.register.success')
            ->with([
                'registration_number' => $student->registration_number,
                'secret_code' => $plainSecret,
                'student_name' => $student->full_name,
            ]);
    }

    public function registerSuccess(Request $request)
    {
        if (! $request->session()->has('registration_number')) {
            return redirect()->route('students.register');
        }

        return view('front.students.register-success', [
            'registration_number' => $request->session()->get('registration_number'),
            'secret_code' => $request->session()->get('secret_code'),
            'student_name' => $request->session()->get('student_name'),
        ]);
    }

    public function resultsForm(): View
    {
        return view('front.students.results');
    }

    public function resultsLookup(Request $request)
    {
        $data = $request->validate([
            'registration_number' => ['required', 'string', 'max:50'],
            'secret_code' => ['required', 'string', 'max:50'],
        ], [], [
            'registration_number' => 'رقم القيد',
            'secret_code' => 'الرقم السري',
        ]);

        $student = Student::query()
            ->with(['faculty', 'results' => fn ($q) => $q->where('is_published', true)->latest()->with('subjects')])
            ->where('registration_number', $data['registration_number'])
            ->where('status', 'approved')
            ->first();

        if (! $student || ! $student->verifySecretCode($data['secret_code'])) {
            return back()
                ->withInput($request->only('registration_number'))
                ->withErrors(['registration_number' => 'رقم القيد أو الرقم السري غير صحيح.']);
        }

        return view('front.students.results-show', [
            'student' => $student,
            'results' => $student->results,
        ]);
    }
}

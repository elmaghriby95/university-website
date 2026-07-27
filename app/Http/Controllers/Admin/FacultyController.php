<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Support\Slug;

class FacultyController extends Controller
{
    public function index()
    {
        $items = Faculty::query()->orderBy('sort_order')->paginate(15);

        return view('admin.faculties.index', compact('items'));
    }

    public function create()
    {
        return view('admin.faculties.form', ['item' => new Faculty]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['name']);
        $data['image'] = $this->storeImage($request);

        Faculty::query()->create($data);

        return redirect()->route('admin.faculties.index')->with('success', 'تمت إضافة الكلية بنجاح.');
    }

    public function edit(Faculty $faculty)
    {
        return view('admin.faculties.form', ['item' => $faculty]);
    }

    public function update(Request $request, Faculty $faculty)
    {
        $data = $this->validated($request);
        if ($faculty->name !== $data['name']) {
            $data['slug'] = $this->uniqueSlug($data['name'], $faculty->id);
        }
        if ($request->hasFile('image')) {
            $this->deleteImage($faculty->image);
            $data['image'] = $this->storeImage($request);
        }

        $faculty->update($data);

        return redirect()->route('admin.faculties.index')->with('success', 'تم تحديث الكلية بنجاح.');
    }

    public function destroy(Faculty $faculty)
    {
        $this->deleteImage($faculty->image);
        $faculty->delete();

        return redirect()->route('admin.faculties.index')->with('success', 'تم حذف الكلية.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'dean' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
            'students_count' => ['nullable', 'integer', 'min:0'],
            'departments_count' => ['nullable', 'integer', 'min:0'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['students_count'] = $data['students_count'] ?? 0;
        $data['departments_count'] = $data['departments_count'] ?? 0;
        $data['sort_order'] = $data['sort_order'] ?? 0;

        return $data;
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $slug = Slug::make($name);
        $base = $slug;
        $i = 1;

        while (Faculty::query()->where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }

    private function storeImage(Request $request): ?string
    {
        return $request->hasFile('image') ? $request->file('image')->store('faculties', 'public') : null;
    }

    private function deleteImage(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }
}

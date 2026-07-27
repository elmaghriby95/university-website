<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Support\Media;
use App\Support\Slug;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $items = Page::query()->latest()->paginate(15);

        return view('admin.pages.index', compact('items'));
    }

    public function create()
    {
        return view('admin.pages.form', ['item' => new Page]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['title']);
        $data['image'] = $this->storeImage($request);

        Page::query()->create($data);

        return redirect()->route('admin.pages.index')->with('success', 'تمت إضافة الصفحة بنجاح.');
    }

    public function edit(Page $page)
    {
        return view('admin.pages.form', ['item' => $page]);
    }

    public function update(Request $request, Page $page)
    {
        $data = $this->validated($request);
        if ($page->title !== $data['title'] && ! in_array($page->slug, ['about', 'admissions'], true)) {
            $data['slug'] = $this->uniqueSlug($data['title'], $page->id);
        }
        if ($request->hasFile('image')) {
            $this->deleteImage($page->image);
            $data['image'] = $this->storeImage($request);
        }

        $page->update($data);

        return redirect()->route('admin.pages.index')->with('success', 'تم تحديث الصفحة بنجاح.');
    }

    public function destroy(Page $page)
    {
        $this->deleteImage($page->image);
        $page->delete();

        return redirect()->route('admin.pages.index')->with('success', 'تم حذف الصفحة.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $data['is_published'] = $request->boolean('is_published');

        return $data;
    }

    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $slug = Slug::make($title);
        $base = $slug;
        $i = 1;

        while (Page::query()->where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }

    private function storeImage(Request $request): ?string
    {
        return $request->hasFile('image') ? Media::store($request->file('image'), 'pages') : null;
    }

    private function deleteImage(?string $path): void
    {
        Media::delete($path);
    }
}

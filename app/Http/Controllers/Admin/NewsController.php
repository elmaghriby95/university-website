<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Support\Media;
use App\Support\Slug;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $items = News::query()->latest()->paginate(15);

        return view('admin.news.index', compact('items'));
    }

    public function create()
    {
        return view('admin.news.form', ['item' => new News]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['title']);
        $data['image'] = $this->storeImage($request);

        News::query()->create($data);

        return redirect()->route('admin.news.index')->with('success', 'تمت إضافة الخبر بنجاح.');
    }

    public function edit(News $news)
    {
        return view('admin.news.form', ['item' => $news]);
    }

    public function update(Request $request, News $news)
    {
        $data = $this->validated($request);
        if ($news->title !== $data['title']) {
            $data['slug'] = $this->uniqueSlug($data['title'], $news->id);
        }
        if ($request->hasFile('image')) {
            $this->deleteImage($news->image);
            $data['image'] = $this->storeImage($request);
        }

        $news->update($data);

        return redirect()->route('admin.news.index')->with('success', 'تم تحديث الخبر بنجاح.');
    }

    public function destroy(News $news)
    {
        $this->deleteImage($news->image);
        $news->delete();

        return redirect()->route('admin.news.index')->with('success', 'تم حذف الخبر.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
            'is_published' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
            'published_at' => ['nullable', 'date'],
        ]);

        $data['is_published'] = $request->boolean('is_published');
        $data['is_featured'] = $request->boolean('is_featured');
        $data['published_at'] = $data['published_at'] ?? now();

        return $data;
    }

    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $slug = Slug::make($title);
        $base = $slug;
        $i = 1;

        while (News::query()->where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }

    private function storeImage(Request $request): ?string
    {
        if (! $request->hasFile('image')) {
            return null;
        }

        return Media::store($request->file('image'), 'news');
    }

    private function deleteImage(?string $path): void
    {
        Media::delete($path);
    }
}

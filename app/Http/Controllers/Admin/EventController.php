<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Support\Media;
use App\Support\Slug;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $items = Event::query()->latest('starts_at')->paginate(15);

        return view('admin.events.index', compact('items'));
    }

    public function create()
    {
        return view('admin.events.form', ['item' => new Event]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['title']);
        $data['image'] = $this->storeImage($request);

        Event::query()->create($data);

        return redirect()->route('admin.events.index')->with('success', 'تمت إضافة الفعالية بنجاح.');
    }

    public function edit(Event $event)
    {
        return view('admin.events.form', ['item' => $event]);
    }

    public function update(Request $request, Event $event)
    {
        $data = $this->validated($request);
        if ($event->title !== $data['title']) {
            $data['slug'] = $this->uniqueSlug($data['title'], $event->id);
        }
        if ($request->hasFile('image')) {
            $this->deleteImage($event->image);
            $data['image'] = $this->storeImage($request);
        }

        $event->update($data);

        return redirect()->route('admin.events.index')->with('success', 'تم تحديث الفعالية بنجاح.');
    }

    public function destroy(Event $event)
    {
        $this->deleteImage($event->image);
        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'تم حذف الفعالية.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['nullable', 'string'],
            'location' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:2048'],
            'starts_at' => ['required', 'date'],
            'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
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

        while (Event::query()->where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }

    private function storeImage(Request $request): ?string
    {
        return $request->hasFile('image') ? Media::store($request->file('image'), 'events') : null;
    }

    private function deleteImage(?string $path): void
    {
        Media::delete($path);
    }
}

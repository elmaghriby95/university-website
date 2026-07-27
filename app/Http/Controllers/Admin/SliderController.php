<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Support\Media;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index()
    {
        $items = Slider::query()->orderBy('sort_order')->paginate(15);

        return view('admin.sliders.index', compact('items'));
    }

    public function create()
    {
        return view('admin.sliders.form', ['item' => new Slider]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['image'] = $this->storeImage($request);

        Slider::query()->create($data);

        return redirect()->route('admin.sliders.index')->with('success', 'تمت إضافة الشريحة بنجاح.');
    }

    public function edit(Slider $slider)
    {
        return view('admin.sliders.form', ['item' => $slider]);
    }

    public function update(Request $request, Slider $slider)
    {
        $data = $this->validated($request);
        if ($request->hasFile('image')) {
            $this->deleteImage($slider->image);
            $data['image'] = $this->storeImage($request);
        }

        $slider->update($data);

        return redirect()->route('admin.sliders.index')->with('success', 'تم تحديث الشريحة بنجاح.');
    }

    public function destroy(Slider $slider)
    {
        $this->deleteImage($slider->image);
        $slider->delete();

        return redirect()->route('admin.sliders.index')->with('success', 'تم حذف الشريحة.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'button_text' => ['nullable', 'string', 'max:100'],
            'button_link' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:4096'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        return $data;
    }

    private function storeImage(Request $request): ?string
    {
        return $request->hasFile('image') ? Media::store($request->file('image'), 'sliders') : null;
    }

    private function deleteImage(?string $path): void
    {
        Media::delete($path);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Event;
use App\Models\Faculty;
use App\Models\News;
use App\Models\Page;
use App\Models\Setting;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('front.home', [
            'sliders' => Slider::query()->where('is_active', true)->orderBy('sort_order')->get(),
            'faculties' => Faculty::query()->where('is_active', true)->orderBy('sort_order')->take(6)->get(),
            'news' => News::query()->where('is_published', true)->latest('published_at')->take(3)->get(),
            'events' => Event::query()->where('is_published', true)->where('starts_at', '>=', now())->orderBy('starts_at')->take(3)->get(),
            'about' => Page::query()->where('slug', 'about')->where('is_published', true)->first(),
        ]);
    }

    public function about(): View
    {
        $page = Page::query()->where('slug', 'about')->where('is_published', true)->firstOrFail();

        return view('front.page', compact('page'));
    }

    public function admissions(): View
    {
        $page = Page::query()->where('slug', 'admissions')->where('is_published', true)->firstOrFail();

        return view('front.page', compact('page'));
    }

    public function page(Page $page): View
    {
        abort_unless($page->is_published, 404);

        return view('front.page', compact('page'));
    }

    public function faculties(): View
    {
        $faculties = Faculty::query()->where('is_active', true)->orderBy('sort_order')->get();

        return view('front.faculties.index', compact('faculties'));
    }

    public function faculty(Faculty $faculty): View
    {
        abort_unless($faculty->is_active, 404);

        return view('front.faculties.show', compact('faculty'));
    }

    public function news(): View
    {
        $news = News::query()->where('is_published', true)->latest('published_at')->paginate(9);

        return view('front.news.index', compact('news'));
    }

    public function newsShow(News $news): View
    {
        abort_unless($news->is_published, 404);

        $related = News::query()
            ->where('is_published', true)
            ->where('id', '!=', $news->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('front.news.show', compact('news', 'related'));
    }

    public function events(): View
    {
        $events = Event::query()->where('is_published', true)->orderByDesc('starts_at')->paginate(9);

        return view('front.events.index', compact('events'));
    }

    public function eventShow(Event $event): View
    {
        abort_unless($event->is_published, 404);

        return view('front.events.show', compact('event'));
    }

    public function contact(): View
    {
        return view('front.contact', [
            'email' => Setting::get('contact_email', 'info@university.edu'),
            'phone' => Setting::get('contact_phone', ''),
            'address' => Setting::get('contact_address', ''),
        ]);
    }

    public function contactStore(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ], [], [
            'name' => 'الاسم',
            'email' => 'البريد الإلكتروني',
            'phone' => 'الهاتف',
            'subject' => 'الموضوع',
            'message' => 'الرسالة',
        ]);

        ContactMessage::query()->create($data);

        return back()->with('success', 'تم إرسال رسالتك بنجاح، وسنتواصل معك قريباً.');
    }
}

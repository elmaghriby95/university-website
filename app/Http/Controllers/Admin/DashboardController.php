<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Event;
use App\Models\Faculty;
use App\Models\News;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'newsCount' => News::query()->count(),
            'eventsCount' => Event::query()->count(),
            'facultiesCount' => Faculty::query()->count(),
            'messagesCount' => ContactMessage::query()->where('is_read', false)->count(),
            'latestNews' => News::query()->latest()->take(5)->get(),
            'latestMessages' => ContactMessage::query()->latest()->take(5)->get(),
        ]);
    }
}

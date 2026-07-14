<?php
namespace App\Http\Controllers;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class DashboardBiroController extends Controller {
    public function index() {
        $user = Auth::user();
        $totalReg = \App\Models\Registration::count();
        $eventPending = Event::where('status', 'pending')->count();
        $eventApproved = Event::where('status', 'approved')->count();
        return view('dashboards.biro', compact('user', 'totalReg', 'eventPending', 'eventApproved'));
    }
}
<?php
namespace App\Http\Controllers;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class DashboardBiroController extends Controller {
    public function index() 
{
    // Mengambil jumlah event yang perlu diverifikasi biro
    $pending_events = \App\Models\Event::where('status', 'pending')->count();
    
    return view('dashboards.biro', [
        'pending_events' => $pending_events
    ]);
}
}
<?php
namespace App\Http\Controllers;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class DashboardProdiController extends Controller {
    public function index() {
    // Auth::user() secara otomatis mengambil data user yang SEDANG LOGIN
    $user = Auth::user(); 
    
    // Kirim data user ke view
    return view('dashboards.prodi', compact('user'));
}
}
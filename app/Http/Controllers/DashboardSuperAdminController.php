<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardSuperAdminController extends Controller {
    public function index() {
    $user = Auth::user();
    $allUsers = \App\Models\User::all(); // Mengambil semua user dari DB
    return view('dashboards.superadmin', compact('user', 'allUsers'));
    }
}
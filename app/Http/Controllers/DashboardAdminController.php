<?php

namespace App\Http\Controllers;

use App\Models\Event; // <--- TAMBAHKAN BARIS INI
use Illuminate\Http\Request;

class DashboardAdminController extends Controller
{
    public function index()
{
    $totalEvent = \App\Models\Event::count();
    return view('admin.dashboard', compact('totalEvent'));
}
}

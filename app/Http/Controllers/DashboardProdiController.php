<?php
namespace App\Http\Controllers;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class DashboardProdiController extends Controller {
    public function index() 
{
    return view('dashboards.prodi');
}
}
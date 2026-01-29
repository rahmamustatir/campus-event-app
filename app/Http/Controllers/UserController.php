<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        // Ambil semua user yang BUKAN admin
        // Kita gunakan 'usertype' sesuai perbaikan database terakhir
        $users = User::where('usertype', '!=', 'admin')
                     ->latest()
                     ->get();

        return view('admin.users.index', compact('users'));
    }
}
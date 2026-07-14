<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;

class ScanController extends Controller
{
    // Halaman kamera
    public function index() {
        return view('admin.scan');
    }

    // Proses validasi
    public function verify(Request $request) {
        $registration = Registration::where('registration_code', $request->code)->first();

        if ($registration) {
            $registration->update(['status_presence' => 'present']);
            return response()->json(['success' => true, 'message' => 'Tiket Valid! Peserta hadir.']);
        }
        return response()->json(['success' => false, 'message' => 'Tiket Tidak Ditemukan!']);
    }
}
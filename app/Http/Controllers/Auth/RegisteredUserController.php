<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse; // Tambahan
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse|JsonResponse // Update Return Type
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            // Validasi tambahan
            'nim' => ['nullable', 'string', 'max:20', 'unique:'.User::class],
            'major' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:15'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'student', // Default role
            'nim' => $request->nim,
            'major' => $request->major,
            'phone' => $request->phone,
        ]);

        event(new Registered($user));

        Auth::login($user);

        // --- LOGIKA UNTUK POSTMAN (JSON) ---
        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Registrasi Berhasil!',
                'data' => $user
            ], 201);
        }
        // -----------------------------------

        return redirect(route('dashboard', absolute: false));
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class EventController extends Controller
{
    #[OA\Get(
        path: '/api/events',
        tags: ['Events'],
        summary: 'List Event',
        responses: [
            new OA\Response(response: 200, description: 'Success')
        ]
    )]
    public function index()
    {
        // Contoh return JSON untuk API
        return response()->json([
            'message' => 'List of events',
            'data' => [] 
        ]);
    }
} // <--- INI DIA YANG HILANG! PASTIKAN ADA.
<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0.0',
    title: 'API Campus Event',
    description: 'Dokumentasi API',
    contact: new OA\Contact(email: 'admin@campusevent.com')
)]
#[OA\Server(
    url: 'http://localhost:8000',
    description: 'Local Server'
)]
abstract class Controller
{
    //
}
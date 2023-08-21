<?php

namespace App\Services\ServiciosInterface;
use Illuminate\Http\Request;

interface ServicioLoginI
{
    public function iniciarSesion(Request $request);   
}


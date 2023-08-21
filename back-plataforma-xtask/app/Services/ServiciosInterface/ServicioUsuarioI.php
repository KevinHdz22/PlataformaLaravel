<?php

namespace App\Services\ServiciosInterface;
use Illuminate\Http\Request;

interface ServicioUsuarioI
{
    public function registrarUsuario(array $datos);
    public function obtenerDatos($id_usuario, $id_sesion);
    public function updateUsuario(Request $request);    
}

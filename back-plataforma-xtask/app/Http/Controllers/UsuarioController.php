<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Services\ServiciosInterface\ServicioUsuarioI;
use App\Models\User;
use App\Constants\Responses;

class UsuarioController extends Controller
{
    protected $servicioUsuario;

    public function __construct(ServicioUsuarioI $servicioUsuario)
    {
        $this->servicioUsuario = $servicioUsuario;
    }

    public function obtenerUsuario($id_usuario, $id_sesion)
    {
        return $this->servicioUsuario->obtenerDatos($id_usuario, $id_sesion);
    }

    public function actualizarUsuario(Request $request)
    {
        return $this->servicioUsuario->updateUsuario($request);
    }
}

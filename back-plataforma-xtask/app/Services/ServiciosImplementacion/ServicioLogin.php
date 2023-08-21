<?php
namespace App\Services\ServiciosImplementacion;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Constants\Responses;
use App\Services\ServiciosInterface\ServicioLoginI;
use Tymon\JWTAuth\JWTAuth;

class ServicioLogin implements ServicioLoginI
{
	protected $jwt;

    public function __construct(JWTAuth $jwt)
    {
        $this->jwt = $jwt;
    }
	public function iniciarSesion(Request $request)
    {
        $correo = $request->input('correo');
        $contrasenia = $request->input('contrasenia');

        $user = User::where('correo', $correo)->first();

        if ($user && Hash::check($contrasenia, $user->contrasenia)) {
            // Usuario autenticado correctamente
            $token = $this->jwt->fromUser($user);



            // Obtener los datos relacionados del usuario
            $userData = [
                'user' => [
                    'id' => $user->id,
                    'primer_nombre' => $user->primer_nombre,
                    'primer_apellido' => $user->primer_apellido,
                    'correo' => $user->correo,
                    // ... otros campos relevantes ...
                ], 
                'token' => $token,
        // ... otros datos relacionados ...
            ];

            return ['status' => Responses::STATUS_SATISFACTORIO, 'response' => Responses::RESPONSE_SATISFACTORIO, 'data' => $userData];
        } else {
            // Credenciales incorrectas
            return ['status' => Responses::STATUS_ERROR, 'response' => Responses::RESPONSE_ERROR_CREDENCIALES];
        }
    }
}
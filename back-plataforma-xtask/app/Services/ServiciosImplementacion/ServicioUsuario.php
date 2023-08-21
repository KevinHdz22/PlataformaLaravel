<?php

namespace App\Services\ServiciosImplementacion;

use App\Services\ServiciosInterface\ServicioUsuarioI;
use App\Models\User;
use App\Constants\Responses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth as JWTAuthFacade;
use Illuminate\Support\Facades\Validator;



class ServicioUsuario implements ServicioUsuarioI
{
    public function registrarUsuario(array $datos)
    {
        $datosValidados = $this->validarDatos($datos);

        if ($datosValidados['status'] === Responses::STATUS_ERROR_EMAIL) {
            return $datosValidados;
        }

        $user = new User();
        $user->primer_nombre = $datos['primer_nombre'];
        $user->primer_apellido = $datos['primer_apellido'];
        $user->correo = $datos['correo'];
        $user->contrasenia = bcrypt($datos['contrasenia']);
        $user->save();

        return ['status' => Responses::STATUS_SATISFACTORIO, 'response' => Responses::RESPONSE_REGISTRO];
    }

    public function obtenerDatos($id_usuario, $id_sesion)
    {
        try {
            // Obtener el usuario autenticado a través del token
            $user = JWTAuthFacade::parseToken()->authenticate();

            // Validar si el ID proporcionado coincide con el ID del usuario autenticado y el ID de sesión del token
            if ($user && $user->id == $id_usuario && $id_sesion === JWTAuthFacade::parseToken()->getClaim('id_sesion')) {
                $usuario = User::find($id_usuario);

                if (!$usuario) {
                    return response()->json(['status' => Responses::STATUS_ERROR, 'response' => Responses::RESPONSE_ERROR_USUARIO_NO_ENCONTRADO], 404);
                }

                // agregar campos a incluir en la respuesta 
                $userData = [
                    'id' => $usuario->id,
                    'primer_nombre' => $usuario->primer_nombre,
                    'primer_apellido' => $usuario->primer_apellido,
                    'correo' => $usuario->correo,
                ];

                return response()->json(['status' => Responses::STATUS_SATISFACTORIO, 'response' => Responses::RESPONSE_SATISFACTORIO, 'data' => $userData], 200);
            } else {
                return response()->json(['status' => Responses::STATUS_ERROR, 'response' => Responses::RESPONSE_ERROR_USUARIO_NO_AUTORIZADO], 401);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => Responses::STATUS_ERROR, 'response' => Responses::RESPONSE_ERROR_TOKEN_INVALIDO], 401);
        }
    }

    public function updateUsuario(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'id' => 'required',
                'id_sesion' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => Responses::STATUS_ERROR, 'response' => Responses::RESPONSE_CAMPOS_OBLIGATORIOS], 400);
            }
            Log::info("TRY");
            // Obtener el usuario autenticado a través del token
            $user = JWTAuthFacade::parseToken()->authenticate();

            #Log::info("USER: $user");

            // Obtener los datos de la solicitud
            $idUsuario = $request->input('id');
            $idSesion = $request->input('id_sesion');

            if ($user && $user->id == $idUsuario && $idSesion === JWTAuthFacade::parseToken()->getClaim('id_sesion')) {
                $usuario = User::find($idUsuario);


                if (!$usuario) {
                    return response()->json(['status' => Responses::STATUS_ERROR, 'response' => Responses::RESPONSE_ERROR_USUARIO_NO_ENCONTRADO], 404);
                }

                // Actualizar los datos del usuario con los campos enviados en la solicitud
                $usuario->fill($request->all());
                $usuario->usuario_modificacion = $user->id;
                $usuario->save();

                // Actualizar el campo 'updated_at'
                $usuario->touch();

                // agregar campos a incluir en la respuesta
                $userData = [
                    'id' => $usuario->id,
                    'primer_nombre' => $usuario->primer_nombre,
                    'primer_apellido' => $usuario->primer_apellido,
                    'correo' => $usuario->correo,
                ];

                return response()->json(['status' => Responses::STATUS_SATISFACTORIO, 'response' => Responses::RESPONSE_SATISFACTORIO, 'data' => $userData], 200);
            } else {
                return response()->json(['status' => Responses::STATUS_ERROR, 'response' => Responses::RESPONSE_ERROR_USUARIO_NO_AUTORIZADO], 401);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => Responses::STATUS_ERROR, 'response' => Responses::RESPONSE_ERROR_TOKEN_INVALIDO], 401);
        }
    }
    
    private function validarDatos(array $datos)
    {
        if (User::where('correo', $datos['correo'])->exists()) {
            return ['status' => Responses::STATUS_ERROR_EMAIL, 'response' => Responses::RESPONSE_ERROR_EMAIL_EXISTE];
        }

        return ['status' => Responses::STATUS_SATISFACTORIO, 'response' => Responses::DATOS_VALIDOS];
    }
}
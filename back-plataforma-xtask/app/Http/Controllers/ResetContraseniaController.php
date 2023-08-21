<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use App\Models\User;
use App\Models\PasswordReset;
use App\Mail\RecuperarContraseniaMail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ResetContraseniaController extends Controller
{
    public function resetContrasenia(Request $request)
    {
        try {
            $idUsuario = $request->input('id_usuario');
            $correo = $request->input('correo');

            // Verificar si el usuario existe en la base de datos
            $usuario = User::find($idUsuario);

            if (!$usuario || $usuario->correo !== $correo) {
                return response()->json(['status' => Responses::STATUS_ERROR_USER, 'response' => Responses::RESPONSE_USER_NO_ENCONTRADO], 404);
            }

            // Generar un código de recuperación y almacenar en la tabla password_resets
            $codigoRecuperacion = Str::random(5);
            $fechaExpiracion = now()->addHours(1); // Caduca en 1 hora

            PasswordReset::updateOrCreate(
                ['id_usuario' => $idUsuario],
                ['codigo_recuperacion' => $codigoRecuperacion, 'fecha_expiracion_codigo' => $fechaExpiracion]
            );

            // Enviar el código de recuperación por correo
            $url = "http://configurarcontrasenia.com/recuperar-contrasenia/$idUsuario/$codigoRecuperacion";
            Mail::to($correo)->send(new RecuperarContraseniaMail($codigoRecuperacion, $url));

            // Responder con los datos del usuario y mensaje de éxito
            $userData = [
                'id' => $usuario->id,
                'primer_nombre' => $usuario->primer_nombre,
                'primer_apellido' => $usuario->primer_apellido,
                'correo' => $usuario->correo,
            ];

            return response()->json(['status' => Responses::STATUS_CODIGO_ENVIADO, 'response' => Responses::RESPONSE_CODIGO_ENVIADO, 'data' => $userData], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => Responses::STATUS_ERROR, 'response' => Responses::RESPONSE_ERROR_PROCESAR], 500);
        }
    }
}


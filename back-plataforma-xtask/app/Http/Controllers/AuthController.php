<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ServiciosInterface\ServicioUsuarioI;
use App\Services\ServiciosInterface\ServicioLoginI;
use Illuminate\Support\Facades\Validator;
use App\Constants\Responses;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    protected $servicioUsuario;
    protected $servicioLogin;

    public function __construct(ServicioUsuarioI $servicioUsuario, ServicioLoginI $servicioLogin)
    {
        $this->servicioUsuario = $servicioUsuario;
        $this->servicioLogin = $servicioLogin;
    }

    public function registrar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'primer_nombre' => 'required',
            'primer_apellido' => 'required',
            'correo' => 'required|email',
            'contrasenia' => 'required',
         ]);

        if ($validator->fails()) {
            return response()->json(['status' =>  Responses::STATUS_ERROR, 'response' => Responses::RESPONSE_ERROR_DATOS_INVALIDOS], 400);
        }
        $resultado = $this->servicioUsuario->registrarUsuario($request->all());
        if ($resultado['status'] === Responses::STATUS_ERROR_EMAIL) {
            return response()->json($resultado, 400);
        }
        return response()->json($resultado, 201);
    }

    
    public function login(Request $request)
    {
        //Validar campos obligatorios
        $validator = Validator::make($request->all(), [
            'correo' => 'required|email',
            'contrasenia' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => Responses::STATUS_ERROR, 'response' => Responses::RESPONSE_ERROR_DATOS_INVALIDOS], 400);
        }

        $userData = $this->servicioLogin->iniciarSesion($request);

        #$userDataJson = json_encode($userData);
        #Log::info("userData:$userDataJson");

        if ($userData['status'] === Responses::STATUS_ERROR) {
            return response()->json(['status' => Responses::STATUS_ERROR, 'response' =>Responses::RESPONSE_ERROR_CREDENCIALES], 401);
        }

        return response()->json(['data' => $userData], 200);
    }
    

    public function logout($idUsuario)
    {
         try {
            $user = JWTAuth::parseToken()->authenticate();

            #$userDataJson = json_encode($userData);
            Log::info("userData:$user->id");
            Log::info("userData:$idUsuario");


            // Validar si el ID proporcionado coincide con el ID del usuario autenticado
            if ($user && $user->id == $idUsuario) {
                JWTAuth::invalidate(); // Invalidar el token actual
                return response()->json(['status' => Responses::STATUS_SATISFACTORIO, 'response' => Responses::RESPONSE_SALIDA_EXITOSA]);
            } else {
                return response()->json(['status' => Responses::STATUS_ERROR, 'response' => Responses::RESPONSE_ERROR_USUARIO_NO_AUTORIZADO], 401);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => Responses::STATUS_ERROR, 'response' => Responses::RESPONSE_ERROR_TOKEN_INVALIDO], 401);
        }
    }

}



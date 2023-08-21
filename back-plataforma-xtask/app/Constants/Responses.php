<?php

namespace App\Constants;

class Responses
{
    const STATUS_ERROR = '0';
    const STATUS_SATISFACTORIO = '1';
    const STATUS_ERROR_EMAIL = '2';
    const STATUS_ERROR_USER = '3';
    const STATUS_CODIGO_ENVIADO = '4';

    const RESPONSE_REGISTRO = 'Registro correcto';
    const DATOS_VALIDOS = 'Datos Válidos';
    const RESPONSE_ERROR_DATOS_INVALIDOS = 'Datos inválidos';
    const RESPONSE_ERROR_EMAIL_EXISTE = 'El correo ya está registrado en la base de datos.';
    const RESPONSE_ERROR_CREDENCIALES = 'Credenciales incorrectas';
    const RESPONSE_SATISFACTORIO = 'Credenciales validas';
    const RESPONSE_ERROR_USUARIO_NO_AUTORIZADO = 'Usuario no autorizado';
    const RESPONSE_SALIDA_EXITOSA = 'Sesion cerrada correctamente';
    const RESPONSE_ERROR_TOKEN_INVALIDO = 'Token invalido';
    const RESPONSE_CAMPOS_OBLIGATORIOS = 'Datos Faltantes';
    const RESPONSE_USER_NO_ENCONTRADO = 'Usuario no encontrado';
    const RESPONSE_CODIGO_ENVIADO = 'Código de recuperación enviado';
    const RESPONSE_ERROR_PROCESAR = 'Error al procesar la solicitud';

}

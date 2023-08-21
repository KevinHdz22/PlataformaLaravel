<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class RecuperarContraseniaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $codigoRecuperacion;
    public $url;

    public function __construct($codigoRecuperacion, $url)
    {
        $this->codigoRecuperacion = $codigoRecuperacion;
        $this->url = $url;
    }

    public function build()
    {
        return $this->view('recuperar_contrasenia');
    }
}

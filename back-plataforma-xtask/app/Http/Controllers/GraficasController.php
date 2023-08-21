<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class GraficasController extends Controller
{
    public function generarDatosGraficas(Request $request)
    {
        // Generar un valor aleatorio para cada categoría
        $gastosMensuales = $this->generarValorAleatorioAlto();
        $tareasPendientes = $this->generarValorAleatorioBajo();
        $clientesAlcanzados = $this->generarValorAleatorioBajo();
        $estimacionIngresos = $this->generarValorAleatorioAlto();
        $avanceProyecto = $this->generarValorAleatorioBajo();

        $data = [
            'gastos_mensuales' => $gastosMensuales,
            'tareas_pendientes' => $tareasPendientes,
            'clientes_alcanzados' => $clientesAlcanzados,
            'estimacion_ingresos' => $estimacionIngresos,
            'avance_proyecto' => $avanceProyecto,
        ];

        return response()->json($data);
    }

    private function generarValorAleatorioBajo()
    {
        return [
            'valor' => rand(1, 100), // Genera un número aleatorio entre 1 y 100
        ];
    }

     private function generarValorAleatorioAlto()
    {
        return [
            'valor' => rand(1000, 100000), // Genera un número aleatorio entre 1000 y 1000000
        ];
    }
}


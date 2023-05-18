<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Administradores;
use App\Asignaciones;
use App\Blog;
use App\Evaluaciones;
use App\Indicadores;
use App\Perfil;
use App\Preguntas;
use App\Respuestas;
use App\Tramites;

class VerTramitesController extends Controller
{
    //
    public function index()
    {
        # code...
        $blog = Blog::all();
        $administradores = Administradores::all();
        $usuarios = Perfil::all();
        $tramites = Tramites::paginate(10);

        return view(
            "paginas.verTramites",
            array(
                "blog" => $blog,
                "administradores" => $administradores,
                'usuarios' => $usuarios,
                'tramites' => $tramites
            )
        );
    }

    /**=============================================
     * VER EVALUACIÓN ASIGNADA
     ==============================================*/
    public function searchEva()
    {
        $dato = $_POST['query'];

        $asignacion = Asignaciones::where('id_asignacion', $dato)->get();
        $asignaciones = Asignaciones::all();
        $blog = Blog::all();
        $administradores = Administradores::all();
        $usuarios = Perfil::all();
        $indicadores = Indicadores::all();
        $evaluaciones = Evaluaciones::all();
        $preguntas = Preguntas::all();
        $respuestas = Respuestas::all();

        if (count($asignacion) != 0) {

            return view(
                'paginas.verEvaluaciones',
                array(
                    'status' => 200,
                    "blog" => $blog,
                    "asignacion" => $asignacion,
                    "administradores" => $administradores,
                    "usuarios" => $usuarios,
                    "asignaciones" => $asignaciones,
                    "evaluaciones" => $evaluaciones,
                    "indicadores" => $indicadores,
                    "preguntas" => $preguntas,
                    "respuestas" => $respuestas
                )
            );
            //return redirect('/administradores') -> with('ok-editar', '');

        } else {

            return view(
                'paginas.verEvaluaciones',
                array(
                    'status' => 404,
                    "blog" => $blog,
                    "administradores" => $administradores
                )
            );

        }

    }

}
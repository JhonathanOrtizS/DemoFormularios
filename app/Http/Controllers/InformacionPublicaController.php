<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Administradores;
use App\Blog;
use App\AsignacionTramite;

class InformacionPublicaController extends Controller
{
    //
    public function index()
    {
        # code...
        $blog = Blog::all();
        $administradores = Administradores::all();
        $asignaciones = AsignacionTramite::paginate(10);

        return view(
            "paginas.infoPublica",
            array(
                "blog" => $blog,
                "administradores" => $administradores,
                'asignaciones' => $asignaciones
            )
        );
    }


    /*===============================
    CREAR UN REGISTRO AL FORMULARIO
    ===============================*/
    public function store(Request $request)
    {
        # code...
        //recolectando datos
        $datos = array(
            'fechaIP' => $request->input('fechaInfoPublica'),
            'solicitanteIP' => $request->input('solicitanteIP'),
            'residenciaIP' => $request->input('residenciaIP'),
            'telefonoIP' => $request->input('telefonoIP'),
            'municipioIP' => $request->input('municipioIP'),
            'cuiIP' => $request->input('cuiIP'),
            'descripcionIP' => $request->input('descripcionIP'),
            'estatusIP' => $request->input('estatusIP')
        );

        /*codigo para crear Codigo Unico para cada registro
        del formulario antes de ser guardado*/
        $codigo = '';
        $longitud = 5;
        $caracteres = '0123456789';
        for ($i = 0; $i < $longitud; $i++) {
            $codigo .= $caracteres[rand(0, strlen($caracteres) - 1)];
        }

        $codigoFormIP = 'FIP' . $codigo;
    }


}
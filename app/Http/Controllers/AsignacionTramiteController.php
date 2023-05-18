<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Administradores;
use App\Blog;
use App\Tramites;

use Illuminate\Support\Facades\DB;

class AsignacionTramiteController extends Controller
{
    //
    public function index()
    {

        //para mostrar datos conjuntos de 2 tablas
        $join = DB::table('asignacion_tramite')
            ->join('users', 'users.id', '=', 'asignacion_tramite.user_id')
            ->join('tramite', 'tramite.id_tramite', '=', 'asignacion_tramite.tramite_id')
            ->select('asignacion_tramite.*', 'users.*', 'tramite.*')
            ->get();

        if (request()->ajax()) {

            return datatables()->of($join)
                ->addColumn('name', function ($data) {

                    $name = $data->name;

                    return $name;

                })
                ->addColumn('titulo_evaluacion', function ($data) {

                    $titulo_evaluacion = $data->titulo_evaluacion;

                    return $titulo_evaluacion;

                })
                ->addColumn('estatus', function ($data) {

                    $estatus = $data->estatus;

                    return $estatus;

                })
                ->addColumn('acciones', function ($data) {

                    $acciones = '<div class="btn-group">
								
								<a href="' . url()->current() . '/' . $data->id_asignacion . '" class="btn btn-warning btn-sm">
									<i class="fas fa-pencil-alt text-white"></i>
								</a>

								<button class="btn btn-danger btn-sm eliminarRegistro" 
									action="' . url()->current() . '/' . $data->id_asignacion . '" 
									method="DELETE" pagina="asignaciones" token="' . csrf_token() . '">
										<i class="fas fa-trash-alt"></i>
								</button>

			  				</div>';

                    return $acciones;

                })
                ->rawColumns(['name', 'titulo_evaluacion', 'evaluador', 'estatus', 'acciones'])
                ->make(true);

        }

        $blog = Blog::all();
        $administradores = Administradores::all();
        $usuarios = Administradores::all();
        $tramites = Tramites::all();

        return view(
            "paginas.asignacion_tramite",
            array(
                "blog" => $blog,
                "administradores" => $administradores,
                'tramites' => $tramites,
                'usuarios' => $usuarios
            )
        );

    }
}
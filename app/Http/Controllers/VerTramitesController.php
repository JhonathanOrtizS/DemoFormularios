<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Administradores;
use App\Blog;
use App\Perfil;
use App\Tramites;
use App\AsignacionTramite;
use App\InformacionPublica;

use Illuminate\Support\Facades\DB;

class VerTramitesController extends Controller
{
    //
    public function index()
    {
        # code...
        $join = DB::table('asignacion_tramite')
            ->join('tramite', 'tramite.id_tramite', '=', 'asignacion_tramite.tramite_id')
            ->select('asignacion_tramite.*', 'tramite.*')
            ->get();

        if (request()->ajax()) {
            # code...
            return datatables()->of($join)
                ->addColumn('nombre_tramite', function ($data) {
                    # code...
                    $nombre_tramite = $data->nombre_tramite;
                    return $nombre_tramite;
                })
                ->addColumn('observaciones', function ($data) {
                    # code...
                    $observaciones = $data->observaciones;
                    return $observaciones;
                })
                ->addColumn('fecha_asignacion', function ($data) {
                    # code...
                    $fecha_asignacion = $data->fecha_asignacion;
                    return $fecha_asignacion;
                })
                ->addColumn('estatus', function ($data) {
                    # code...
                    $estatus = $data->estatus;
                    return $estatus;
                })
                ->addColumn('acciones', function ($data) {

                    $acciones = '<div class="btn-group">
                            
                            <a href="' . url()->current() . '/' . $data->id_ag . '" class="btn btn-warning btn-sm">
                                <i class="fas fa-pencil-alt text-white"></i>
                            </a>

                          </div>';

                    return $acciones;

                })
                ->rawColumns(['nombre_tramite', 'observaciones', 'fecha_asignacion', 'estatus', 'acciones'])
                ->make(true);
        }

        $blog = Blog::all();
        $administradores = Administradores::all();
        $tramites = Tramites::paginate(10);
        $asignaciones = AsignacionTramite::paginate(10);

        return view(
            "paginas.verTramites",
            array(
                "blog" => $blog,
                "administradores" => $administradores,
                'tramites' => $tramites,
                'asignaciones' => $asignaciones
            )
        );
    }

    /*================================
    MOSTRAR UN REGISTRO SELECCIONANDO
    PARA ENVIARLO A LA PAGINA CORRESPONDIENTE DEL
    TRAMITE ASIGNADO
    ================================*/
    public function show($id)
    {
        $asignacion = AsignacionTramite::where('id_ag', $id)->get();
        $blog = Blog::all();
        $administradores = Administradores::all();
        $tramite = Tramites::all();
        $ip = InformacionPublica::all();

        /**
         * Se debe buscar por el codigo del tramite, ya que el id 
         * de cada tramite tiene un valor repetitivo por ejemplo 1,2,3...
         * para ser enviada la informacion al formulario correspondiente
         */

        $id_tramite = $asignacion['tramite_id'];

        if (count($asignacion) != 0) {

            if ($asignacion['tramite_id'] == $tramite['id_tramite']) {

                switch ($tramite['nombre_tramite']) {
                    case 'Información Publica':
                        return view(
                            'paginas.infoPublica',
                            array(
                                'asignacion' => $asignacion,
                                "blog" => $blog,
                                'tramite' => $tramite,
                                "administradores" => $administradores
                            )
                        );
                        break;

                    default:
                        # code...
                        break;
                }


            }
            return view(
                'paginas.verTramites',
                array(
                    'status' => 500,
                    'asignacion' => $asignacion,
                    "blog" => $blog,
                    "administradores" => $administradores
                )
            );
        } else {
            return view(
                'paginas.verTramites',
                array(
                    'status' => 404,
                    "blog" => $blog,
                    "administradores" => $administradores
                )
            );
        }

    }

}
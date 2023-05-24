<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Administradores;
use App\Blog;
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
        $usuarioActual = auth()->user();

        /*$join = DB::table('asignacion_tramite AS at')
            ->join('users', 'users.id', '=', 'at.user_id')
            ->select('at.*', 'users.*')
            ->get(); */

        $join = DB::table('asignacion_tramite AS at')
            ->join('users', 'users.id', '=', 'at.user_id')
            ->select('at.*', 'users.*')
            ->where('users.id', $usuarioActual->id)
            ->get();

        if (request()->ajax()) {
            # code...
            return datatables()->of($join)

                ->addColumn('codigo_tramite', function ($data) {
                    # Codigo del tramite de la asignacion
                    $codigo_tramite = $data->tramite_cod;
                    return $codigo_tramite;
                })
                ->addColumn('observacion', function ($data) {
                    # Observacion del tramite de la asignacion
                    $observacion = $data->observaciones_asignacion;
                    return $observacion;
                })
                ->addColumn('fecha_asignacion', function ($data) {
                    # Fecha de asignacion del tramtie
                    $fecha_asignacion = $data->fecha_asignacion;
                    return $fecha_asignacion;
                })
                ->addColumn('fecha_finalizacion', function ($data) {
                    # Fecha de finalizacion de Asignacion
                    $fecha_finalizacion = $data->fecha_finalizacion;
                    return $fecha_finalizacion;
                })
                ->addColumn('estatus', function ($data) {
                    # Estatus de la Asignacion
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
                ->rawColumns(['codigo_tramite', 'observacion', 'fecha_asignacion', 'fecha_finalizacion', 'estatus', 'acciones'])
                ->make(true);
        }

        $blog = Blog::all();
        $administradores = Administradores::all();
        $tramites = Tramites::paginate(10);
        $asignaciones = AsignacionTramite::paginate(10);
        $usuario = Administradores::all();

        return view(
            "paginas.verTramites",
            array(
                "blog" => $blog,
                "administradores" => $administradores,
                'tramites' => $tramites,
                'asignaciones' => $asignaciones,
                'usuario' => $usuarioActual
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
        $infop = InformacionPublica::all();

        if (count($asignacion) != 0) {
            return view(
                'paginas.infoPublica',
                array(
                    'status' => 200,
                    "blog" => $blog,
                    'asignacion' => $asignacion,
                    "administradores" => $administradores,
                    'infoP' => $infop
                )
            );
        } else {
            return view(
                'paginas.infoPublica',
                array(
                    'status' => 404,
                    "blog" => $blog,
                    "administradores" => $administradores
                )
            );
        }

        /**
         * Se debe buscar por el codigo del tramite, ya que el id 
         * de cada tramite tiene un valor repetitivo por ejemplo 1,2,3...
         * para ser enviada la informacion al formulario correspondiente
         */

        //Extraer el Texto de la cadena
        /*$cadena = $asignacion['tramite_cod'];
        $texto = preg_replace("/[^a-zA-Z]/", "", $cadena);

        if (count($asignacion) != 0) {

            switch ($texto) {
                case 'FIP':
                    return view(
                        'paginas.infoPublica',
                        array(
                            'asignacion' => $asignacion,
                            "blog" => $blog,
                            "administradores" => $administradores,
                            'infoP' => $infop
                        )
                    );
                    break;
                case 'TSD':
                    return view(
                        'paginas.infoPublica',
                        array(
                            'asignacion' => $asignacion,
                            "blog" => $blog,
                            "administradores" => $administradores,
                            'infoP' => $infop
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
                'status' => 404,
                'asignacion' => $asignacion,
                "blog" => $blog,
                "administradores" => $administradores
            )
        );
            */
    }

}
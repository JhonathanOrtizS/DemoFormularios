<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Administradores;
use App\Blog;
use App\Tramites;
use App\AsignacionTramite;

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
                ->addColumn('nombre_tramite', function ($data) {

                    $nombre_tramite = $data->nombre_tramite;

                    return $nombre_tramite;

                })
                ->addColumn('observaciones', function ($data) {

                    $observaciones = $data->observaciones;

                    return $observaciones;

                })
                ->addColumn('fecha_asignacion', function ($data) {

                    $fecha_asignacion = $data->fecha_asignacion;

                    return $fecha_asignacion;

                })
                ->addColumn('estatus', function ($data) {

                    $estatus = $data->estatus;

                    return $estatus;

                })
                ->addColumn('acciones', function ($data) {

                    $acciones = '<div class="btn-group">
								
								<a href="' . url()->current() . '/' . $data->id_ag . '" class="btn btn-warning btn-sm">
									<i class="fas fa-pencil-alt text-white"></i>
								</a>

								<button class="btn btn-danger btn-sm eliminarRegistro" 
									action="' . url()->current() . '/' . $data->id_ag . '" 
									method="DELETE" pagina="asignacion_tramite" token="' . csrf_token() . '">
										<i class="fas fa-trash-alt"></i>
								</button>

			  				</div>';

                    return $acciones;

                })
                ->rawColumns(['name', 'nombre_tramite', 'observaciones', 'fecha_asignacion', 'estatus', 'acciones'])
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


    /**=============================================
     * CREAR REGISTRO DE ASIGNACION
     ==============================================*/
    public function store(Request $request)
    {
        //Recoger datos
        $datos = array(
            "usuario" => $request->input('id_user'),
            "tramite" => $request->input('id_tramite'),
            "estatus" => $request->input('estatus'),
            "observacion" => $request->input('observacion_asignacion')
        );

        //Recoger fecha
        $fechaActual = date('Y-m-d');

        if (!empty($datos)) {

            $validar = \Validator::make($datos, [
                "usuario" => "required|regex:/^\d+$/",
                "tramite" => "required|regex:/^\d+$/",
                "estatus" => 'required|regex:/^[a-z]+(?: [a-z]+)?$/i',
                "observacion" => 'required|regex:/^[\p{L}\p{N}\sáéíóúÁÉÍÓÚñÑ,.\-()]+$/u',
            ]);

            if ($validar->fails()) {

                return redirect("asignacion_tramite")->with("no-validacion", "");
                # code...
            } else {

                $asignacion = new AsignacionTramite();
                $asignacion->user_id = $datos['usuario'];
                $asignacion->tramite_id = $datos['tramite'];
                $asignacion->fecha_asignacion = $fechaActual;
                $asignacion->estatus = $datos['estatus'];
                $asignacion->observaciones_asignacion = $datos['observacion'];
                $asignacion->save();

                return redirect("asignacion_tramite")->with("ok-crear", "");

            }

        } else {
            return redirect("asignacion_tramite")->with("error", "");
        }

    }
}
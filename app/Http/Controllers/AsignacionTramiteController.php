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

        $join = DB::table('asignacion_tramite AS at')
            ->leftJoin('users', 'users.id', '=', 'at.user_id')
            ->where(function ($query) {
                $query->whereNotNull('at.user_id')
                    ->orWhereNull('at.user_id');
            })
            ->select('at.*', 'users.*')
            ->get();

        //para mostrar datos conjuntos de 2 tablas
        if (request()->ajax()) {

            return datatables()->of($join)
                ->addColumn('name', function ($data) {
                    //Colomna para ver el usuario asignado al tramite
                    $name = $data->name;

                    return $name;

                })
                ->addColumn('tramite_cod', function ($data) {
                    //Columna para dar el nombre del Tramite
                    $codigo_tramite = $data->tramite_cod;

                    return $codigo_tramite;

                })
                ->addColumn('fecha_asignacion', function ($data) {
                    //fecha de asignacion del tramite de la tabla de asignacion
                    $fecha_asignacion = $data->fecha_asignacion;

                    return $fecha_asignacion;

                })
                ->addColumn('fecha_finalizacion', function ($data) {
                    //fecha de finalizacion del tramite de la tabla del formulario
                    $fecha_fin = $data->fecha_finalizacion;

                    return $fecha_fin;

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
                ->rawColumns(['name', 'tramite_cod', 'fecha_asignacion', 'fecha_finalizacion', 'estatus', 'acciones'])
                ->make(true);

        }

        $blog = Blog::all();
        $administradores = Administradores::all();
        $usuarios = Administradores::all();
        $tramites = Tramites::all();
        $asignacion = AsignacionTramite::all();

        return view(
            "paginas.asignacion_tramite",
            array(
                "blog" => $blog,
                "administradores" => $administradores,
                'tramites' => $tramites,
                'usuarios' => $usuarios,
                'asignaciones' => $asignacion
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

    /*================================ 
    MOSTRAR UN REGISTRO
    ================================*/
    public function show($id)
    {
        # code...
        $asignacion = AsignacionTramite::where('id_ag', $id)->get();
        $blog = Blog::all();
        $administradores = Administradores::all();
        $tramites = Tramites::all();
        $usuarios = Administradores::all();
        $asignaciones = AsignacionTramite::all();

        if (count($asignacion) != 0) {
            return view(
                'paginas.asignacion_tramite',
                array(
                    'status' => 200,
                    "blog" => $blog,
                    "administradores" => $administradores,
                    'tramites' => $tramites,
                    'usuarios' => $usuarios,
                    'asignado' => $asignacion,
                    'asignaciones' => $asignaciones
                )
            );
        } else {
            return view(
                'paginas.asignacion_tramite',
                array(
                    'status' => 404,
                    "blog" => $blog,
                    "administradores" => $administradores
                )
            );
        }

    }



    /*================================
    EDITAR UN REGISTRO DE PREGUNTAS
    ================================*/
    public function update($id, Request $request)
    {
        $datos = array(
            "indicador" => $request->input("id_indicador"),
            "pregunta" => $request->input("pregunta"),
            "descripcion" => $request->input("descripcion"),
            "respuesta" => $request->input("respuestas")
        );

        $blog = Blog::all();
        $administradores = Administradores::all();
        $usuarios = Administradores::all();
        $tramites = Tramites::all();
        $asignacion = AsignacionTramite::all();

        return view(
            "paginas.asignacion_tramite",
            array(
                "blog" => $blog,
                "administradores" => $administradores,
                'tramites' => $tramites,
                'usuarios' => $usuarios,
                'asignaciones' => $asignacion
            )
        );

    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Blog;
use App\Administradores;
use App\Tramites;

class TramitesController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {

            return datatables()->of(Tramites::all())
                ->addColumn('acciones', function ($data) {

                    $acciones = '<div class="btn-group">
                              
                              <a href="' . url()->current() . '/' . $data->id_tramite . '" class="btn btn-warning btn-sm">
                                  <i class="fas fa-pencil-alt text-white"></i>
                              </a>

                              <button class="btn btn-danger btn-sm eliminarRegistro" 
                                  action="' . url()->current() . '/' . $data->id_tramite . '" 
                                  method="DELETE" pagina="tramites" token="' . csrf_token() . '">
                                      <i class="fas fa-trash-alt"></i>
                              </button>

                            </div>';

                    return $acciones;

                })
                ->rawColumns(['acciones'])
                ->make(true);

        }

        $blog = Blog::all();
        $administradores = Administradores::all();

        return view("paginas.tramites", array("blog" => $blog, "administradores" => $administradores));

        /** 
         * 
         */


        // $blog = Blog::all();
        // $administradores = Administradores::all();
        // $tramites = Tramites::paginate(10);

        // return view(
        //     "paginas.tramites",
        //     array(
        //         "blog" => $blog,
        //         "administradores" => $administradores,
        //         'tramites' => $tramites
        //     )
        // );

    }


    /*================================
    CREAR UN NUEVO REGISTRO
    ================================*/
    public function store(Request $request)
    {

        //declarando expresiones regulares
        $regex = '/^[\p{L}\p{N}\sáéíóúÁÉÍÓÚñÑ]+$/u';
        $regex2 = '/^[\p{L}\p{N}\s,.áéíóúÁÉÍÓÚñÑ]+$/u';

        //recoger los datos
        $datos = array(
            "titulo" => $request->input("titulo_tramite"),
            "descripcion" => $request->input("descripcion_tramite")
        );

        if (!empty($datos)) {

            $validar = \Validator::make($datos, [
                "titulo" => 'required|regex:/^[\p{L}\p{N}\sáéíóúÁÉÍÓÚñÑ]+$/u',
                "descripcion" => 'required|regex:/^[\p{L}\p{N}\s,.áéíóúÁÉÍÓÚñÑ]+$/u'
            ]);

            if ($validar->fails()) {
                //return $datos;
                return redirect("tramites")->with("no-validacion", "");
            } else {

                $tramite = new Tramites();
                $tramite->nombre = $datos['titulo'];
                $tramite->observaciones = $datos['descripcion'];
                $tramite->save();

                return redirect("tramites")->with("ok-crear", "");

            }

        } else {
            return redirect("tramites")->with("error", "");
        }

    }
}
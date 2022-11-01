<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Blog;
use App\Administradores;
use App\Respuestas;

class RespuestasController extends Controller
{
    public function index(){

		//HACER PETICION AJAX de los registros de asministradores
		if (request() -> ajax()) {

			return datatables()->of(Respuestas::all()) 
			//se debe construir una columna para el token de seguridad @csrf 
			//por lo que se pasa un parametro mas en esta funcion
            ->addColumn('p_respuestas', function($data){

				$tags = json_decode($data->p_respuestas, true);

				$palabras = '<h5>';

                foreach ($tags as $key => $value) {
                    $palabras .= '<span class="badge badge-secondary mx-1">'.$value.'</span>';
                }

                 $palabras .= '</h5>';

                return $palabras;
  
			})
			->addColumn('acciones', function ($data){

				$acciones = 
				'<div class="btn-group">

					<a href="'.url()->current().'/'.$data->id_respuesta.'" class="btn btn-warning btn-sm ">
						<i class="fas fa-pencil-alt text-white"></i>
					</a>

					<button type="submit" class="btn btn-danger btn-sm eliminarRegistro" 
						action="'.url()->current().'/'.$data->id_respuesta.'"
                		method="DELETE"  token="'.csrf_token().'" 
						pagina="respuestas" >
                              
                        <i class="fas fa-trash-alt"></i>

                    </button>
				</div>';

				return $acciones;

			})
			-> rawColumns(['p_respuestas','acciones'])
			-> make(true);
		}

		$blog = Blog::all();
		$administradores = Administradores::all();
		return view("paginas.respuestas", array("blog"=>$blog, "administradores"=>$administradores));

	} 


    /*================================
	CREAR UN REGISTRO DE PREGUNTAS
	================================*/
	public function store(Request $request)
	{
		/**
		 * Para crear con el metodo Store, Laravel exige tener una columna creada llamada
		 * created_at con la fecha con que se va a crear el registro
		 */
        $blog = Blog::all();

		// Regocer datos
    	$datos = array( 
			"titulo"=>$request->input("titulo_respuesta"),
            "respuesta"=>$request->input("respuestas"),
			"descripcion"=>$request->input("descripcion")
		);
        //return $datos;
    	// Validar datos
    	if(!empty($datos)){
			
    		$validar = \Validator::make($datos,[
    			"titulo"=> "required|regex:/^[0-9a-zA-Z ]+$/i",
				"respuesta"=> 'required|regex:/^[,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                "descripcion" => 'required|regex:/^[(\\)\\=\\&\\$\\;\\-\\_\\*\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i' ,
    		]); 
			
			//si todo pasa la validacion Guardamos
    		if($validar->fails()){
				
				//validación fallida
    		 	return redirect("respuestas")->with("no-validacion", "");

    		}else{

				//Guardar Datos de Respuestas
                $respuesta = new Respuestas();
                $respuesta->titulo_respuesta = $datos["titulo"];
                $respuesta->p_respuestas = json_encode(explode(",", $datos["respuesta"]));
				$respuesta->descripcion = $datos["descripcion"];

                $respuesta->save(); 
                return redirect("respuestas")->with("ok-crear", "");   

    		}

		} else {
			return redirect("respuestas")->with("error","");
		}

	}


	/*================================
	EDITAR UN REGISTRO DE PREGUNTAS
	================================*/
	public function update($id, Request $request)
	{
		// Regocer datos
    	$datos = array( 
			"titulo"=>$request->input("titulo_respuesta"),
            "respuesta"=>$request->input("respuestas"),
			"descripcion"=>$request->input("descripcion")
		);
        //return $datos;
    	// Validar datos
    	if(!empty($datos)){
			
    		$validar = \Validator::make($datos,[
    			"titulo"=> "required|regex:/^[0-9a-zA-Z ]+$/i",
				"respuesta"=> 'required|regex:/^[,\\"\\[\\]\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                "descripcion" => 'required|regex:/^[(\\)\\=\\&\\$\\;\\-\\_\\*\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i' ,
    		]); 
			
			//si todo pasa la validacion Guardamos
    		if($validar->fails()){
				
				//validación fallida
    		 	return redirect("respuestas")->with("no-validacion", "");

    		}else{

				//Guardar Datos de Respuestas
				$datos2 = array(
					"titulo_respuesta"=>$datos['titulo'],
					"p_respuestas"=>json_encode(explode(",", $datos["respuesta"])),
					"descripcion"=>$datos['descripcion']
				);

				$respuesta = Respuestas::where('id_respuesta', $id)->update($datos2);
                 
                return redirect("respuestas")->with("ok-editar", "");   

    		}

		} else {
			return redirect("respuestas")->with("error","");
		}

	}


	/*================================
	MOSTRAR UN REGISTRO DE PREGUNTAS
	================================*/
	public function show($id)
	{
		$respuesta = Respuestas::where('id_respuesta', $id)->get();
		$blog = Blog::all();
		$administradores = Administradores::all();

		if (count($respuesta) != 0) {
			return view('paginas.respuestas', 
			array(
				'status' => 200,
				'respuesta' => $respuesta,
				"blog" =>$blog, 
				"administradores" => $administradores
			));
		} else {
			return view('paginas.respuestas', 
			array('status' => 404, 
			"blog"=>$blog, 
			"administradores" => $administradores));
		}

	}


	/*================================
	ELIMINAR UN REGISTRO DE PREGUNTAS
	================================*/
	public function destroy($id, Request $request)
	{
		$valida = Respuestas::where('id_respuesta', $id)->get();

		if (!empty($valida)) {
			$respuesta = Respuestas::where('id_respuesta', $valida[0]['id_respuesta'])->delete();
			return 'Ok';
		} else {
			return redirect('/respuestas') -> with('no-borrar', '');# code...
		}
	}

}

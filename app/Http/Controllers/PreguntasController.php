<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Preguntas;
use App\Blog;
use App\Administradores;
use App\Indicadores;
use App\Respuestas;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PreguntasController extends Controller
{
    //MOSTRAR LISTADO DE PREGUNTAS
    public function index(){

    	//para mostrar datos conjuntos de 2 tablas
		$join = DB::table('preguntas')
		->join('indicadores','indicadores.id_indicador','=','preguntas.indicador_id')
		->join('respuestas','respuestas.id_respuesta','=','preguntas.respuesta_id')
		->select('preguntas.*','respuestas.*','indicadores.*')
		->get(); 

    	if(request()->ajax()){ 

			  return datatables()->of($join)
			  ->addColumn('titulo_indicador', function($data){

				$titulo_indicador = $data->titulo_indicador;
  
				return $titulo_indicador;
  
			  })
			  ->addColumn('p_respuestas', function($data){

				$tags = json_decode($data->p_respuestas, true);

				$palabras = '<h5>';

                foreach ($tags as $key => $value) {
                    
                    $palabras .= '<span class="badge badge-secondary mx-1">'.$value.'</span>';
                }

                 $palabras .= '</h5>';

                return $palabras;
  
			  })
			  ->addColumn('acciones', function($data){

			  		$acciones = '<div class="btn-group">
								
								<a href="'.url()->current().'/'.$data->id_pregunta.'" class="btn btn-warning btn-sm">
									<i class="fas fa-pencil-alt text-white"></i>
								</a>

								<button class="btn btn-danger btn-sm eliminarRegistro" 
									action="'.url()->current().'/'.$data->id_pregunta.'" 
									method="DELETE" pagina="preguntas" token="'.csrf_token().'">
										<i class="fas fa-trash-alt"></i>
								</button>

			  				</div>';

			  		return $acciones;

			  })
			  ->rawColumns(['titulo_indicador', 'p_respuestas', 'acciones'])
			  -> make(true);

		}

		$blog = Blog::all();
		$administradores = Administradores::all();
		$indicadores = Indicadores::all();
		$respuestas = Respuestas::all();

		return view("paginas.preguntas", 
		array(
			"blog"=>$blog, 
			"administradores"=>$administradores,
			"indicadores"=>$indicadores,
			"respuestas"=>$respuestas
		));

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

		// Regocer datos
    	$datos = array( 
			"indicador"=>$request->input("id_indicador"),
    		"pregunta"=>$request->input("pregunta"),
			"descripcion"=>$request->input("descripcion"),
			"respuesta"=>$request->input("respuestas")
		); 
        
    	// Validar datos
    	if(!empty($datos)){
			
    		$validar = \Validator::make($datos,[
    			"indicador"=> "required|regex:/^[0-9]+/i",
    			"pregunta"=> "required|regex:/^[\\?\\¿\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i",
				"descripcion" => 'required|regex:/^[(\\)\\=\\&\\$\\;\\-\\_\\*\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
				"respuesta"=> "required|regex:/^[0-9]+/i"
    		]); 
			
			//si todo pasa la validacion Guardamos
    		if($validar->fails()){
				
				//validación fallida
    		 	return redirect("preguntas")->with("no-validacion", "");

    		}else{

				//Guardar Datos de Preguntas
                $pregunta = new Preguntas();
                $pregunta->indicador_id = $datos["indicador"];
                $pregunta->pregunta = $datos["pregunta"];
				$pregunta->descripcion_pregunta = $datos["descripcion"];
				$pregunta->respuesta_id = $datos["respuesta"];

                $pregunta->save(); 

                return redirect("preguntas")->with("ok-crear", "");   

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
		/**
		 * Para crear con el metodo Store, Laravel exige tener una columna creada llamada
		 * created_at con la fecha con que se va a crear el registro
		 */ 

		// Regocer datos
    	$datos = array( 
			"indicador"=>$request->input("id_indicador"),
    		"pregunta"=>$request->input("pregunta"),
			"descripcion"=>$request->input("descripcion"),
			"respuesta"=>$request->input("respuestas")
		);
        
    	// Validar datos
    	if(!empty($datos)){
			
    		$validar = \Validator::make($datos,[
    			"indicador"=> "required|regex:/^[0-9]+/i",
    			"pregunta"=> "required|regex:/^[\\?\\¿\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i",
				"descripcion" => 'required|regex:/^[(\\)\\=\\&\\$\\;\\-\\_\\*\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
				"respuesta"=> "required|regex:/^[0-9]+/i"
    		]); 
			
			//si todo pasa la validacion Guardamos
    		if($validar->fails()){
				
				//validación fallida
    		 	return redirect("preguntas")->with("no-validacion", "");

    		}else{

				$datos2 = array(
					"indicador_id"=>$datos['indicador'],
					"respuesta_id"=>$datos['respuesta'],
					"pregunta"=>$datos['pregunta'],
					"descripcion_pregunta"=>$datos['descripcion']
				);

				//Guardar Datos de Preguntas
				$pregunta = Preguntas::where('id_pregunta', $id)->update($datos2);

                return redirect("preguntas")->with("ok-editar", "");

    		}

		} else {
			return redirect("preguntas")->with("error","");
		}

	}



	/*================================
	MOSTRAR UN REGISTRO DE PREGUNTAS
	================================*/	
	public function show($id)
	{
		$pregunta = Preguntas::where('id_pregunta', $id)->get();
		$blog = Blog::all();
		$administradores = Administradores::all();
		$indicadores = Indicadores::all();
		$respuestas = Respuestas::all();

		if (count($pregunta) != 0) {
			return view('paginas.preguntas', 
			array(
			'status' => 200, 
			'pregunta' => $pregunta, 
			"blog" =>$blog, 
			"administradores" => $administradores,
			'indicadores'=>$indicadores,
			"respuestas"=>$respuestas
			));
		} else {
			return view('paginas.preguntas', 
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
		$validar = Preguntas::where('id_pregunta', $id)->get();

		if (!empty($validar)) {
			
			$pregunta = Preguntas::where('id_pregunta', $validar[0]['id_pregunta'])->delete();
			return 'Ok';
			
		} else {
			return redirect('/preguntas') -> with('no-borrar', '');# code...
		}
		
	}
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Indicadores;
use App\Blog;
use App\Administradores;
use App\Evaluaciones;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class IndicadoresController extends Controller
{
    public function index(){

		//para mostrar datos conjuntos de 2 tablas
		$join = DB::table('evaluaciones')
		->join('indicadores','evaluaciones.id_evaluacion','=','indicadores.evaluacion_id')
		->select('evaluaciones.*','indicadores.*')
		->get(); 

    	if(request()->ajax()){ 

			  return datatables()->of($join)
			  ->addColumn('titulo_evaluacion', function($data){

				$titulo_evaluacion = $data->titulo_evaluacion;
  
				return $titulo_evaluacion;
  
			  })
			  ->addColumn('acciones', function($data){

			  		$acciones = '<div class="btn-group">
								
								<a href="'.url()->current().'/'.$data->id_indicador.'" class="btn btn-warning btn-sm">
									<i class="fas fa-pencil-alt text-white"></i>
								</a>

								<button class="btn btn-danger btn-sm eliminarRegistro" 
									action="'.url()->current().'/'.$data->id_indicador.'" 
									method="DELETE" pagina="indicadores" token="'.csrf_token().'">
										<i class="fas fa-trash-alt"></i>
								</button>

			  				</div>';

			  		return $acciones;

			  })
			  ->rawColumns(['titulo_evaluacion', 'acciones'])
			  -> make(true);

		}

		$blog = Blog::all();
		$administradores = Administradores::all();
		$evaluaciones = Evaluaciones::all();

	return view("paginas.indicadores", array("blog"=>$blog, "administradores"=>$administradores, 'evaluaciones'=>$evaluaciones));

	} 

	

	/*================================
	CREAR UN REGISTRO DE INDICADORES
	================================*/
	public function store(Request $request)
	{
		/**
		 * Para crear con el metodo Store, Laravel exige tener una columna creada llamada
		 * created_at con la fecha con que se va a crear el registro
		 */

		// Regocer datos
    	$datos = array( 
			"evaluacion"=>$request->input("id_evaluacion"),
    		"titulo"=>$request->input("titulo_indicador"),
			"descripcion"=>$request->input("descripcion_indicador")
		);

        
    	// Validar datos
    	if(!empty($datos)){
			
    		$validar = \Validator::make($datos,[
    			"evaluacion"=> "required|regex:/^[0-9]+/i",
    			"titulo"=> "required|regex:/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i",
				"descripcion" => 'required|regex:/^[(\\)\\=\\&\\$\\;\\-\\_\\*\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i'
    		]); 
			
			//si todo pasa la validacion Guardamos
			//!$datos['imagen_temporal'] || 

    		if($validar->fails()){
				//validar datos de entrada

    		 	return redirect("indicadores")->with("no-validacion", "");

    		}else{

				//Guardar Indicador
                $indicador = new Indicadores();
                $indicador->evaluacion_id = $datos["evaluacion"];
                $indicador->titulo_indicador = $datos["titulo"];
				$indicador->descripcion_indicador = $datos["descripcion"];

                $indicador->save(); 

                return redirect("indicadores")->with("ok-crear", "");   

    		}

		} else {
			return redirect("indicadores")->with("error","");
		}

	}


	/*================================
	MOSTRAR UN SOLO REGISTRO DE INDICADORES
	================================*/
	public function show($id)
	 {
		$indicador = Indicadores::where('id_indicador', $id)->get();
		$blog = Blog::all();
		$administradores = Administradores::all();
		$evaluaciones = Evaluaciones::all();
		
		if ( count($indicador) != 0 ) {
			
			return view('paginas.indicadores', 
			array(
			'status' => 200, 
			'indicador' => $indicador, 
			"blog" =>$blog, 
			"administradores" => $administradores,
			'evaluaciones'=>$evaluaciones));
			//return redirect('/administradores') -> with('ok-editar', '');

		} else {
			
			return view('paginas.indicadores', 
			array('status' => 404, 
			"blog"=>$blog, 
			"administradores" => $administradores));

		}
	 }

	/*================================
	ACUALIZAR UN REGISTRO DE INDICADORES
	================================*/
	public function update($id, Request $request)
	{
		// Regocer datos
    	$datos = array( 
			"evaluacion"=>$request->input("id_evaluacion"),
    		"titulo"=>$request->input("titulo_indicador"),
			"descripcion"=>$request->input("descripcion_indicador")
		);

        //return $datos;
    	// Validar datos
    	if(!empty($datos)){

    		$validar = \Validator::make($datos,[
    			"evaluacion"=> "required|regex:/^[0-9]+/i",
    			"titulo"=> "required|regex:/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i",
				"descripcion" => 'required|regex:/^[(\\)\\=\\&\\$\\;\\-\\_\\*\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i'
    		]); 
			
			//si todo pasa la validacion Guardamos
			//!$datos['imagen_temporal'] || 

			
    		if($validar->fails()){
				//validar datos de entrada
				
    		 	return redirect("/indicadores")->with("no-validacion", "");

    		}else{

				$datos2 = array(
					"evaluacion_id"=>$datos['evaluacion'],
					"titulo_indicador"=>$datos['titulo'],
					"descripcion_indicador"=>$datos['descripcion']
				);

				$indicador = Indicadores::where('id_indicador', $id)->update($datos2); 

                return redirect("indicadores")->with("ok-editar", "");   

    		}

		} else {
			return redirect("indicadores")->with("error","");
		}

	}


	/**=========================
	 * ELIMINAR UN REGISTRO
	 *=========================*/
	public function destroy($id, Request $request)
	{
		$validar = Indicadores::where('id_indicador', $id) -> get();
		//echo '<pre>'; print_r($validar); echo '</pre>';
		
		//primero debemos eliminar la foto para no tener archivos basura en el temp
		if (!empty($validar)) {
			
			$indicador = Indicadores::where('id_indicador', $validar[0]['id_indicador']) -> delete();

			//return redirect('/administradores') -> with('ok-eliminado', '');
			//javascript no debuelve una varible de sesion por lo que se manda un solo parametro
			//para devolver el parametro de Ajax
			return "Ok";

		} else {
			
			return redirect('/indicadores') -> with('no-borrar', '');

		}
	}	

}

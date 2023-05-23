<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Evaluaciones;
use App\Blog;
use App\Administradores;

class EvaluacionesController extends Controller
{
	//INDEX EVALUACIONES
	public function index()
	{

		if (request()->ajax()) {

			return datatables()->of(Evaluaciones::all())
				->addColumn('acciones', function ($data) {

					$acciones = '<div class="btn-group">
								
								<a href="' . url()->current() . '/' . $data->id_evaluacion . '" class="btn btn-warning btn-sm">
									<i class="fas fa-pencil-alt text-white"></i>
								</a>

								<button class="btn btn-danger btn-sm eliminarRegistro" 
									action="' . url()->current() . '/' . $data->id_evaluacion . '" 
									method="DELETE" pagina="evaluaciones" token="' . csrf_token() . '">
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

		return view("paginas.evaluaciones", array("blog" => $blog, "administradores" => $administradores));

	}


	/*================================
		  CREAR UN REGISTRO DE EVALUACIONES
		  ================================*/
	public function store(Request $request)
	{
		//recoger los datos
		$datos = array(
			"titulo" => $request->input("titulo_evaluacion"),
			"descripcion" => $request->input("descripcion_evaluacion")
		);

		if (!empty($datos)) {


			$validar = \Validator::make($datos, [
				"titulo" => "required|regex:/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i",
				"descripcion" => 'required|regex:/^[(\\)\\=\\&\\$\\;\\-\\_\\*\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i'
			]);

			if ($validar->fails()) {
				//return $datos;
				return redirect("evaluaciones")->with("no-validacion", "");
			} else {

				$evaluacion = new Evaluaciones();
				$evaluacion->titulo_evaluacion = $datos['titulo'];
				$evaluacion->descripcion_evaluacion = $datos['descripcion'];
				$evaluacion->save();

				return redirect("evaluaciones")->with("ok-crear", "");

			}

		} else {
			return redirect("evaluaciones")->with("error", "");
		}

	}


	/*================================
	   MOSTRAR UN SOLO REGISTRO DE EVALUACIONES
	   ================================*/
	public function show($id)
	{
		$evaluacion = Evaluaciones::where('id_evaluacion', $id)->get();
		$blog = Blog::all();
		$administradores = Administradores::all();

		if (count($evaluacion) != 0) {

			return view(
				'paginas.evaluaciones',
				array(
					'status' => 200,
					'evaluacion' => $evaluacion,
					"blog" => $blog,
					"administradores" => $administradores
				)
			);
			//return redirect('/administradores') -> with('ok-editar', '');

		} else {

			return view(
				'paginas.evaluaciones',
				array(
					'status' => 404,
					"blog" => $blog,
					"administradores" => $administradores
				)
			);

		}
	}


	/*================================
		  EDITAR UN REGISTRO DE EVALUACIONES
		  ================================*/
	public function update($id, Request $request)
	{
		//recoger los datos
		$datos = array(
			"titulo" => $request->input("titulo_evaluacion"),
			"descripcion" => $request->input("descripcion_evaluacion")
		);

		if (!empty($datos)) {


			$validar = \Validator::make($datos, [
				"titulo" => "required|regex:/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i",
				"descripcion" => 'required|regex:/^[(\\)\\=\\&\\$\\;\\-\\_\\*\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i'
			]);

			if ($validar->fails()) {
				//return $datos;
				return redirect("evaluaciones")->with("no-validacion", "");
			} else {

				$datos = array(
					"titulo_evaluacion" => $datos["titulo"],
					"descripcion_evaluacion" => $datos["descripcion"]
				);

				$evaluacion = Evaluaciones::where('id_evaluacion', $id)->update($datos);
				return redirect("evaluaciones")->with("ok-editar", "");

			}

		} else {
			return redirect("evaluaciones")->with("error", "");
		}

	}


	/*=============================================
		  Eliminar un registro
		  =============================================*/
	public function destroy($id, Request $request)
	{

		$validar = Evaluaciones::where("id_evaluacion", $id)->get();
		return $id;
		if (!empty($validar)) {

			return "ok";

			$evaluacion = Evaluaciones::where("id_evaluacion", $validar[0]["id_evaluacion"])->delete();

			//Responder al AJAX de JS


		} else {

			return redirect("evaluaciones")->with("no-borrar", "");

		}

	}

}
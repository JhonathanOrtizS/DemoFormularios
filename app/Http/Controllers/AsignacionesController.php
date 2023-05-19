<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Asignaciones;
use App\Blog;
use App\Administradores;
use App\Evaluaciones;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AsignacionesController extends Controller
{
	//
	public function index()
	{

		//para mostrar datos conjuntos de 2 tablas
		$join = DB::table('asignaciones')
			->join('users', 'users.id', '=', 'asignaciones.user_id')
			->join('evaluaciones', 'evaluaciones.id_evaluacion', '=', 'asignaciones.evaluacion_id')
			->select('asignaciones.*', 'users.*', 'evaluaciones.*')
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
				->rawColumns(['name', 'titulo_evaluacion', 'evaluador', 'acciones'])
				->make(true);

		}

		$blog = Blog::all();
		$administradores = Administradores::all();
		$evaluaciones = Evaluaciones::all();

		return view(
			"paginas.asignaciones",
			array(
				"blog" => $blog,
				"administradores" => $administradores,
				'evaluaciones' => $evaluaciones
			)
		);

	}



	/**=============================================
	 * MOSTRAR UN SOLO REGISTRO
	 * para enviarlo a un modal de edición
	 ==============================================*/

	public function show($id)
	{

		$asignacion = Asignaciones::where('id_asignacion', $id)->get();
		$blog = Blog::all();
		$administradores = Administradores::all();
		$evaluaciones = Evaluaciones::all();

		if (count($asignacion) != 0) {

			return view(
				'paginas.asignaciones',
				array(
					'status' => 200,
					'asignacion' => $asignacion,
					"blog" => $blog,
					"administradores" => $administradores,
					"evaluaciones" => $evaluaciones
				)
			);
			//return redirect('/administradores') -> with('ok-editar', '');

		} else {

			return view(
				'paginas.asignaciones',
				array(
					'status' => 404,
					"blog" => $blog,
					"administradores" => $administradores
				)
			);

		}
	}



	/**=============================================
	   * BUSCAR USUARIO PARA ASIGNAR EVALUACION
	   ==============================================*/
	public function search()
	{
		//$dato = $_GET['query'];
		$dato = $_POST['query'];
		$dato2 = $_POST['evaluador'];

		$admin = Administradores::where('name', $dato)->get();
		$user = Administradores::where('name', $dato2)->get();
		$blog = Blog::all();
		$administradores = Administradores::all();
		$evaluaciones = Evaluaciones::all();

		if (count($admin) != 0) {

			return view(
				'paginas.asignaciones',
				array(
					'status' => 202,
					'admin' => $admin,
					"user" => $user,
					"blog" => $blog,
					"administradores" => $administradores,
					"evaluaciones" => $evaluaciones
				)
			);
			//return redirect('/administradores') -> with('ok-editar', '');

		} else {

			return view(
				'paginas.asignaciones',
				array(
					'status' => 404,
					"blog" => $blog,
					"administradores" => $administradores
				)
			);

		}

	}



	/**=============================================
	   * CREAR REGISTRO DE ASIGNACION
	   ==============================================*/
	public function store(Request $request)
	{
		//Recoger datos
		$datos = array(
			"usuario" => $request->input('id_usuario'),
			"evaluacion" => $request->input('asignar_evaluacion'),
			"observacion" => $request->input('observaciones'),
			"evaluador" => $request->input('id_evaluador')
		);

		if (!empty($datos)) {

			$validar = \Validator::make($datos, [
				"usuario" => "required|regex:/^[0-9]+/",
				"evaluacion" => "required|regex:/^[0-9]+/",
				"observacion" => 'required|regex:/^[(\\)\\=\\&\\$\\;\\-\\_\\*\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
				"evaluador" => "required|regex:/^[0-9]+/"
			]);

			if ($validar->fails()) {

				return redirect("asignaciones")->with("no-validacion", "");
				# code...
			} else {

				$asignacion = new Asignaciones();
				$asignacion->user_id = $datos['usuario'];
				$asignacion->evaluacion_id = $datos['evaluacion'];
				$asignacion->observaciones = $datos['observacion'];
				$asignacion->evaluador = $datos['evaluador'];
				$asignacion->estatus = 0;
				$asignacion->save();

				return redirect("asignaciones")->with("ok-crear", "");

			}

		} else {
			return redirect("asignaciones")->with("error", "");
		}


	}


	/**=============================================
		* ACTUALIZAR REGISTRO DE ASIGNACION
		==============================================*/
	public function update($id, Request $request)
	{

		//Recoleccion de Datos
		$datos = array(
			"evaluacion" => $request->input('asignar_evaluacion'),
			"observaciones" => $request->input('observaciones'),
		);

		if (!empty($datos)) {

			$validar = \Validator::make($datos, [
				"evaluacion" => "required|regex:/^[0-9]+/",
				"observaciones" => 'required|regex:/^[(\\)\\=\\&\\$\\;\\-\\_\\*\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
			]);

			if ($validar->fails()) {
				# code...
				return redirect("evaluaciones")->with("no-validacion", "");
			} else {
				# code...
				$datos2 = array(
					"evaluacion_id" => $datos['evaluacion'],
					"observaciones" => $datos['observaciones']
				);

				//Actualizando datos de asignaciones
				$asignacion = Asignaciones::where('id_asignacion', $id)->update($datos2);

				return redirect("asignaciones")->with("ok-editar", "");

			}

		} else {

		}

	}


	/**=============================================
		* ELIMINAR REGISTRO DE ASIGNACION
		==============================================*/
	public function destroy($id, Request $request)
	{
		$validar = Asignaciones::where('id_asignacion', $id)->get();
		//$validar = Asignaciones::where('id_asignacion', $id)->get($datos2);

		if (!empty($validar)) {

			$asignacion = Asignaciones::where('id_asignacion', $validar[0]['id_asignacion'])->delete();
			return 'Ok';

		} else {
			return redirect('/asignaciones')->with('no-borrar', ''); # code...
		}
	}
}
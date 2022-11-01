<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Administradores;
use App\Blog;
use App\Preguntas;
use Illuminate\Support\Facades\Hash;

class AdministradoresController extends Controller
{ 
    /**
	 * MOSTRAR TODOS LOS REGISTROS DE LA TABLA
	 */
	
	public function index(){

		//HACER PETICION AJAX de los registros de asministradores
		if (request() -> ajax()) {

			return datatables()->of(Administradores::all()) 
			//se debe construir una columna para el token de seguridad @csrf 
			//por lo que se pasa un parametro mas en esta funcion
			->addColumn('acciones', function ($data)
			{
				$acciones = 
				'<div class="btn-group">

					<a href="'.url()->current().'/'.$data->id.'" class="btn btn-warning btn-sm ">
						<i class="fa-solid fa-user-pen"></i>
					</a>

					<button type="submit" class="btn btn-danger btn-sm eliminarRegistro" 
						action="'.url()->current().'/'.$data->id.'"
                		method="DELETE"  token="'.csrf_token().'" 
						pagina="administradores" >
                              
                        <i class="fa-solid fa-circle-xmark"></i>

                    </button>
				</div>';
				return $acciones;
			})
			-> rawColumns(['acciones'])
			-> make(true);
		} 
			
		

		$blog = Blog::all();
		$administradores = Administradores::all();
		return view("paginas.administradores", array("blog"=>$blog, "administradores"=>$administradores));

		/*
		$administradores = Administradores::all();
		$blog = Blog::all();

		return view("paginas.administradores", array("administradores"=>$administradores, "blog"=>$blog));
		*/
	}


	/**=============================================
	 * MOSTRAR UN SOLO REGISTRO
	 * para enviarlo a un modal de edición
	 ==============================================*/
	 public function show($id)
	 {
		
		$admin = Administradores::where('id', $id)->get();
		$blog = Blog::all();
		$administradores = Administradores::all();
		
		if ( count($admin) != 0 ) {
			
			return view('paginas.administradores', 
			array('status' => 200, 
			'admin' => $admin, 
			"blog" =>$blog, 
			"administradores" => $administradores));
			//return redirect('/administradores') -> with('ok-editar', '');

		} else {
			
			return view('paginas.administradores', 
			array('status' => 404, 
			"blog"=>$blog, 
			"administradores" => $administradores));

		}
	 }


	/**==============================
	 * EDITAR UN REGISTRO DE USUARIOS
	 *===============================*/
	public function update($id, Request $request)
	{
		//Recoger Datos
		$datos = array(
			'name' => $request -> input('name'),
			'email' => $request -> input('email'),
			'password_actual' => $request -> input('password_actual'),
			'rol' => $request -> input('rol'),
			'imagen_actual' => $request -> input('imagen_actual')
		);

		//recogemos el password por aparte
		$pass = array('password' => $request -> input('password'));
		$foto = array('foto' => $request -> file('foto'));

		//echo '<pre>'; print_r($datos); echo '</pre>';
		//echo '<pre>'; print_r($foto); echo '</pre>';


		//Ahora debemos validar los datos
		if (!empty($datos)) {

			//se utiliza la funcion de Laravel para validar los datos
			$validar = \Validator::make($datos, [
				'name' => 'required|regex:/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
				'email' => 'required|regex:/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/i'
			]);

			//validando el Pass
			if ($pass['password'] != '') {
				
				$validarPass = \Validator::make($pass, [
					'password' => 'required|regex:/^[0-9a-zA-Z]+$/i'
				]);

				if ($validarPass -> fails()) {

					return redirect('/administradores') -> with('no-validacion', '');

				} else {
					# para guardar una nueva contraseña
					$nuevoPass = Hash::make($pass['password']);

				}

			} else {

				$nuevoPass = $datos['password_actual'];
			}
			

			//validando la Foto
			if ($foto['foto'] != '') {
				
				$validarFoto = \Validator::make($foto, [
					'foto' => 'required|image|mimes:jpg,jpeg,png|max:2000000'
				]);

				if ($validarFoto -> fails()) {
					return redirect('/administradores') -> with('no-validacion-Img', '');
				} 

			}


			if ($validar -> fails()) {
				
				return redirect('/administradores') -> with('no-validacion', '');

			} else {
				
				if ($foto['foto'] != '') {

					//echo 'Viene contenido en la foto';
						//return;

					if (!empty( $datos['imagen_actual'])) {
						
						if ($datos['imagen_actual'] != 'img/admin/user_p.png') {

							unlink($datos['imagen_actual']);

						}
						
					}
					
					$aleatorio = mt_rand(100,999);

					$rutaFoto = "img/admin/".$aleatorio.".".$foto["foto"]->guessExtension();

					move_uploaded_file($foto['foto'], $rutaFoto);

				} else {
					//echo 'NO - Viene contenido en la foto';
						//return;
					$rutaFoto = $datos['imagen_actual'];
				}

				$datos2 = array( 
					'name' => $datos['name'],
					'email' => $datos['email'],
					'password' => $nuevoPass,
					'rol' => $datos['rol'],
					'foto' => $rutaFoto
				);

				//echo '<pre>'; print_r($datos2); echo '</pre>';

				$administradores = Administradores::where('id', $id) -> update($datos2);

				return redirect('/administradores') -> with('ok-editar', '');

			}
			
		} else {
			
			return redirect('/administradores') -> with('error', '');

		}
		
	}

	/**=========================
	 * ELIMINAR UN REGISTRO
	 *=========================*/
	public function destroy($id, Request $request)
	{
		$validar = Administradores::where('id', $id) -> get();
		//echo '<pre>'; print_r($validar); echo '</pre>';
		
		//primero debemos eliminar la foto para no tener archivos basura en el temp
		if (!empty($validar) && $id != 1) {
			
			if (!empty($validar[0]['foto'])) {
				# code...
				unlink($validar[0]['foto']);
			}

			$admin = Administradores::where('id', $validar[0]['id']) -> delete();

			//return redirect('/administradores') -> with('ok-eliminado', '');
			//javascript no debuelve una varible de sesion por lo que se manda un solo parametro
			//para devolver el parametro de Ajax
			return "Ok";

		} else {
			
			return redirect('/administradores') -> with('no-borrar', '');

		}
	}
	
	
	/**=======================
	 * Buscar un Registro
	 *========================*/
	public function search()
	{
		$dato = $_GET['query'];

		$admin = Administradores::where('name', $dato)->get();
		$blog = Blog::all();
		$administradores = Administradores::all();
		
		if ( count($admin) != 0 ) {
			
			return view('paginas.administradores', 
			array('status' => 200, 
			'admin' => $admin, 
			"blog" =>$blog, 
			"administradores" => $administradores));
			//return redirect('/administradores') -> with('ok-editar', '');

		} else {
			
			return view('paginas.administradores', 
			array('status' => 404, 
			"blog"=>$blog, 
			"administradores" => $administradores));

		}
		
	}

}

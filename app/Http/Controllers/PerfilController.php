<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Administradores;
use App\Asignaciones;
use App\Blog;
use App\Perfil;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PerfilController extends Controller
{

    public function index()
    {
        $blog = Blog::all();
        $usuario = Perfil::all();
		$asignaciones = Asignaciones::all();

		return view("paginas.perfil", 
		array(
			"blog"=>$blog, 
			"administradores"=>$usuario, 
			"usuario"=>$usuario,
			"asignaciones"=>$asignaciones
		));
        
    }


    /**=============================================
	 * MOSTRAR UN SOLO REGISTRO
	 * para enviarlo a un modal de edición
	 ==============================================*/
	 public function show($id)
	 {
		
		$admin = Perfil::where('id', $id)->get();
		$blog = Blog::all();
		$administradores = Administradores::all();
		
		if ( count($admin) != 0 ) {
			
			return view('paginas.perfil', 
			array('status' => 200, 
			'admin' => $admin, 
			"blog" =>$blog, 
			"administradores" => $administradores));
			//return redirect('/administradores') -> with('ok-editar', '');

		} else {
			
			return view('paginas.perfil', 
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
			'imagen_actual' => $request -> input('imagen_actual')
		);

		//recogemos el password y la foto por aparte
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

					return redirect('/perfil') -> with('no-validacion', '');

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
					return redirect('/perfil') -> with('no-validacion-Img', '');
				} 

			}

			//Validar para Guardar los datos capturados
			if ($validar -> fails()) {
				
				return redirect('/perfil') -> with('no-validacion', '');

			} else {
				
				if ($foto['foto'] != '') {

					//echo 'Viene contenido en la foto';
						//return;
					//si viene foto se borra el
					if (!empty( $datos['imagen_actual'])) {
						
						if ($datos['imagen_actual'] != 'img/admin/admin.png') {

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
					'foto' => $rutaFoto
				);

				//echo '<pre>'; print_r($datos2); echo '</pre>';

				$usuario = Perfil::where('id', $id) -> update($datos2);

				return redirect('/perfil') -> with('ok-editar', '');

			}
			
		} else {
			
			return redirect('/perfil') -> with('error', '');

		}
		
	}

}

<?php

//preguntamos si viene un archivo de nombre file con un nombre de archivo
//que viene en datos
if(isset($_FILES["file"]["name"])){

	/**
	 * $_FILES["file"]["name"]
	 * son funciones propias para saber si trae un nombre el archivo
	 * 
	 * $_FILES["file"]["tmp_name"]
	 * La ruta temporal donde se carga el archivo se almacena en esta variable.
	 * 
	 * En PHP, cuando se carga un archivo, la variable superglobal $ _FILES se rellena con toda la información sobre el archivo cargado. Se inicializa como un arreglo y puede contener la siguiente información para la carga exitosa de archivos.
	 * tmp_name: La ruta temporal donde se carga el archivo se almacena en esta variable.
	 * name: El nombre real del archivo se almacena en esta variable.
	 * size: Indica el tamaño del archivo cargado en bytes.
	 * type: Contiene el tipo mime del archivo cargado.
	 * error: Si hay un error durante la carga del archivo, esta variable se rellena con el mensaje de error correspondiente. En el caso de que se cargue correctamente el archivo, contiene 0, que puede comparar utilizando la constante UPLOAD_ERR_OK.
	 * 
	 * Después de validar la solicitud POST, verificamos que la carga del archivo se realizó correctamente.
	 * if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK) {
	 * en este caso uploadedFile es el nome del input
	 */

	//preguntamos si vienen errores en el archivo pasa al else de
	//lo contrario realiza el proceso
	if (!$_FILES['file']['error']) {

		$titulo = md5(rand(100, 200));
		$extension = explode('.', $_FILES['file']['name']);
		$archivo = $titulo.'.'.$extension[1];
		$destino = '../img/temp/blog/'.$archivo; 
		$origen = $_FILES["file"]["tmp_name"];
		move_uploaded_file($origen, $destino);
		//se imprime la ruta nueva que se acaba de crear
		//se hace otra variable post para devolver la ruta del archivo temporal
		echo $_POST["ruta"].'/img/temp/blog/'.$archivo;

	}else{

		echo  $mensaje = 'Ooops!  El archivo temporal no se puedo cear:  '.$_FILES['file']['error'];

	}


}
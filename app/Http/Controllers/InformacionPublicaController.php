<?php

namespace App\Http\Controllers;

use App\InformacionPublica;
use Illuminate\Http\Request;

use App\Administradores;
use App\Blog;
use App\AsignacionTramite;

class InformacionPublicaController extends Controller
{
    //
    public function index()
    {
        # code...
        $blog = Blog::all();
        $administradores = Administradores::all();

        return view(
            "paginas.infoPublica",
            array(
                "blog" => $blog,
                "administradores" => $administradores,
            )
        );
    }


    /*===============================
    CREAR UN REGISTRO AL FORMULARIO
    ===============================*/
    public function store(Request $request)
    {
        # code...
        //recolectando datos
        $datos = array(

            'solicitanteIP' => $request->input('solicitanteIP'),
            'residenciaIP' => $request->input('residenciaIP'),
            'telefonoIP' => $request->input('telefonoIP'),
            'municipioIP' => $request->input('municipioIP'),
            'cuiIP' => $request->input('cuiIP'),
            'descripcionIP' => $request->input('descripcionIP'),
            'estatusIP' => $request->input('estatusIP')
        );



        /*codigo para crear Codigo Unico para cada registro
        del formulario antes de ser guardado*/
        $codigo = '';
        $longitud = 5;
        $caracteres = '0123456789';
        for ($i = 0; $i < $longitud; $i++) {
            $codigo .= $caracteres[rand(0, strlen($caracteres) - 1)];
        }
        $codFormIP = 'FIP' . $codigo;
        //===================================

        if (!empty($datos)) {
            # validando fecha
            $fecha = date('Y-m-d');
            # validando fecha

            //Patrones para validar
            $nom = '/^[A-Za-záéíóúÁÉÍÓÚñÑ\s]+$/u';
            $residencia = "/^[0-9A-Za-záéíóúÁÉÍÓÚñÑ\s.,'-]+$/u";
            $telefono = '/^\d{8}$/';
            $muni = '/^[A-Za-záéíóúÁÉÍÓÚñÑ\s]+$/u';
            $cui = '/^(\d{4}\s?\d{5}\s?\d{4})$/';
            $descripcion = '/^[A-Za-záéíóúÁÉÍÓÚñÑ0-9\s.,-]+$/u';
            $estatus = '/^[a-z\s]+$/u';


            //Validando campos con las expresiones regulares
            $validar = \Validator::make($datos, [
                'solicitanteIP' => ['required', 'regex:' . $nom],
                'residenciaIP' => ['required', 'regex:' . $residencia],
                'telefonoIP' => ['required', 'regex:' . $telefono],
                'municipioIP' => ['required', 'regex:' . $muni],
                'cuiIP' => ['required', 'regex:' . $cui],
                'descripcionIP' => ['required', 'regex:' . $descripcion],
                'estatusIP' => ['required', 'regex:' . $estatus]
            ]);


            //Bloque para validar y enviar a la DB
            if ($validar->fails()) {

                # code...
                return redirect("infoPublica")->with("no-validacion", "");
            } else {
                //Registro a la Tabla de Informacion Publica
                $data = new InformacionPublica();
                $data->codigo_tramite = $codFormIP;
                $data->fecha_solicitud = $fecha;
                $data->contacto = $datos['solicitanteIP'];
                $data->direccion = $datos['residenciaIP'];
                $data->telefono = $datos['telefonoIP'];
                $data->municipio = $datos['municipioIP'];
                $data->cui = $datos['cuiIP'];
                $data->detalle_solicitud = $datos['descripcionIP'];
                $data->estatus_ip = $datos['estatusIP'];
                $data->save();

                //Registro a la Tabla de Asignacion de tramite
                $data2 = new AsignacionTramite();
                $data2->titulo_tramite = 'Solicitud Acceso a Información Pública';
                $data2->fecha_asignacion = $fecha;
                $data2->estatus = $datos['estatusIP'];
                $data2->tramite_cod = $codFormIP;
                $data2->save();

                return redirect("verTramites")->with("ok-crear", "");
            }

        } else {
            return redirect("infoPublica")->with("error", "");
        }
    }




}
@foreach ($administradores as $element)
 
  @if (isset($_COOKIE["email_login"]) && $_COOKIE["email_login"] == $element->email)
               
     @if ($element->rol == "usuario")

@extends('plantilla')

@section('content')
    
<div class="content-wrapper" style="min-height: 247px;">

  <section class="content-header">

    <div class="container-fluid">

      <div class="row mb-2">

        <div class="col-sm-6">

          <h1>Información Pública</h1>

        </div>

        <div class="col-sm-6">

          <ol class="breadcrumb float-sm-right">

            <li class="breadcrumb-item"><a href="{{url('/')}}">Inicio</a></li>
            <li class="breadcrumb-item active">Tramites</li>
            <li class="breadcrumb-item active">Información Pública</li>

          </ol>

        </div>

      </div>

    </div><!-- /.container-fluid -->

  </section>

  <!-- Main content -->
  <section class="content">

    <div class="container-fluid">

      <div class="row">

        <div class="col-12">

          @foreach ($blog as $element)
                 
          @endforeach

          <form action="{{url('/')}}/infoPublica" method="post" enctype="multipart/form-data">
            {{--se aplica al formulario enctype para indicarle que se va a trabajar 
              con archivos de tipo file--}}

            @csrf
            {{--Este proceso ayuda a crear un token aleatorio de autenticación
              para poder eliminar, editar, o crear datos en la DB--}}

            <!-- Default box -->
            <div class="card">

              <div class="modal-header bg-dark">

                <h4 class="modal-title">Solicitud Acceso a la Información Pública</h4>

                <button type="submit" class="btn btn-primary float-right bg-white">Guardar cambios</button>

              </div>

              <div class="card-body">
               
                <div class="row">
                  
                  <div class="col-lg-7">
                    
                      <div class="card">

                        <div class="card-body">

                          {{-- Fecha de Solicitud  --}}

                          <div class="input-group mb-3">

                            <div class="input-group-append">

                              <span class="input-group-text">Fecha de Solicitud</span>

                            </div>

                            <input type="date" id="fechaInfoPublica" class="form-control" name="" placeholder="Ingrese el título del tramite" readonly>

                          </div>

                          {{-- Solicitante  --}}

                          <div class="input-group mb-3">
                            
                            <div class="input-group-append">
                              
                              <span class="input-group-text">Solicitante</span>

                            </div>

                            <input type="text" class="form-control" name="solicitanteIP" value="{{-- $element->servidor--}}" required>

                          </div>

                          {{-- Residencia  --}}

                          <div class="input-group mb-3">
                            
                            <div class="input-group-append">
                              
                              <span class="input-group-text">Residencia</span>

                            </div>

                            <input type="text" class="form-control" name="residenciaIP" value="{{-- $element->titulo--}}" required>

                          </div>

                          {{-- Telefono  --}}

                          <div class="input-group mb-3">
                            
                            <div class="input-group-append">
                              
                              <span class="input-group-text">Telefono +502</span>

                            </div>

                            <input type="number" class="form-control" name="telefonoIP" value="{{-- $element->titulo--}}" required>

                          </div>

                          {{-- Municipio  --}}

                          <div class="input-group mb-3">
                            
                            <div class="input-group-append">
                              
                              <span class="input-group-text">Municipio </span>

                            </div>

                            <select class="form-control"  name="municipioIP" required>

                                <option value=""  selected>Seleccione </option>
                                <option value="cubulco">Cubulco</option>
                                <option value="granados">Granados</option>
                                <option value="salama">Salamá</option>
                                <option value="san jeronimo">San Jerónimo</option>

                            </select>

                          </div>

                          {{-- CUI --}}

                          <div class="input-group mb-3">
                            
                            <div class="input-group-append">
                              
                              <span class="input-group-text">CUI</span>

                            </div>

                            <input type="text" class="form-control" name="cuiIP" value="{{-- $element->titulo--}}" required>

                          </div>

                          {{-- Descripción  --}}

                          <div class="input-group mb-3">
                            
                            <div class="input-group-append">
                              
                              <span class="input-group-text">Descripción</span>

                            </div>

                            <textarea class="form-control" rows="5" name="descripcionIP" required>{{--$element->descripcion--}}</textarea>

                          </div>

                          <hr class="pb-2">

                        </div>

                      </div>

                  </div>

                  <div class="col-lg-5">
                    
                    <div class="card">

                      <div class="card-body">
                
                        <div class="row">
                          
                          <div class="col-lg-12">
                              
                            {{-- Codigo Formulario --}}
                            <div class="form-group my-2 text-center">

                              <ol class="breadcrumb float-sm-left" style="background: #FFF; width: 100%;">

                                <li class="breadcrumb-item active">No.</li>
                                <li class="breadcrumb-item active" style="color: #0000FF;">codigo de formulario</li>
                                
                              </ol>
                               

                            </div>
                            
                            {{--Referencia--}}
                            <div class="form-group my-2 text-center">

                              <ol class="breadcrumb float-sm-left" style="background: #FFF; width: 100%;">

                                <li class="breadcrumb-item active">Ref.</li>
                                <li class="breadcrumb-item active" style="color: #0000FF;">codigo de referencia</li>

                              </ol>
                              

                            </div>

                            {{--Estatus--}}
                            <div class="form-group my-2 text-center">

                              <ol class="breadcrumb float-sm-left" style="background: #FFF; width: 100%;">

                                <li class="breadcrumb-item active">Estatus.</li>
                                <li class="breadcrumb-item active">Asignado</li>

                              </ol>
                              

                            </div>

                          </div>

                        </div>
                          
                      </div>


                      {{--CAMBIAR ESTATUS--}}
                      <div class="card-body">
                
                        <div class="row">
                          
                          <div class="col-lg-12">
                              
                            <div class="input-group mb-3">
                              
                              <div class="input-group-append">
                                
                                <span class="input-group-text">Estatus</span>

                              </div>

                              <select class="form-control"  name="estatusIP" required>

                                <option value=""  selected>Seleccione </option>
                                <option value="en espera">En Espera</option>
                                <option value="modificado">Modificado</option>
                                <option value="asignado">Asignado</option>
                                <option value="ejecutando">Ejecutando</option>

                            </select>

                            </div>
                            

                          </div>

                        </div>
                          
                      </div>
          
                    </div>
                    
                  </div>

                </div>

              </div>

              <!-- /.card-body -->
              <div class="card-footer">

                 <button type="submit" class="btn btn-primary float-right bg-dark">Guardar cambios</button>

              </div>
              <!-- /.card-footer-->
            </div>
            <!-- /.card -->

          </form>

        </div>

      </div>

    </div>

  </section>
  <!-- /.content -->
</div>

<script>
  // Obtener el elemento del input por su id
  var fechaInput = document.getElementById("fechaInfoPublica");

  // Obtener la fecha actual
  var fechaActual = new Date();

  // Formatear la fecha para asignarla al valor del input
  var formatoFecha = fechaActual.toISOString().split('T')[0];

  // Asignar la fecha formateada al valor del input
  fechaInput.value = formatoFecha;
</script>

<!-- -->
@if (Session::has("ok-crear"))

    <script>
        notie.alert({ type: 1, text: '¡Tramite creado con Exito!', time: 10 })
  </script>

  @endif

  @if (Session::has("no-validacion"))

  <script>
      notie.alert({ type: 2, text: '¡Hay campos no válidos en el formulario!', time: 10 })
  </script>

  @endif

  @if (Session::has("error"))

    <script>
        notie.alert({ type: 3, text: '¡Error al cargar los datos en el Formulario!', time: 10 })
  </script>

  @endif


<!-- -->




@endsection

{{--CONDICIONES PARA QUE NO IRRUMPAN LOS USUARIOS EN LAS PAGINAS
  DE ADMINISTRADORES--}}

    @else

    <script>window.location="{{url('/perfil')}}"</script>

    @endif

  @endif

@endforeach 

  
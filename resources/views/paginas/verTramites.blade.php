
@extends('plantilla')

@section('content')

<div class="content-wrapper" style="min-height: 247px;">

  <section class="content-header">

    <div class="container-fluid">

      <div class="row mb-2">

        <div class="col-sm-6">

          <h1>Tramites</h1>

        </div>

        <div class="col-sm-6">

          <ol class="breadcrumb float-sm-right">

            <li class="breadcrumb-item"><a href="{{url('/')}}">Inicio</a></li>

            <li class="breadcrumb-item active">Tramites</li>

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

          <!-- Evaluaciones Asignadas -->
          <div class="card">

            <div class="modal-header bg-dark">

              <h3 class="modal-title">Tramites Asignados</h3>

            </div>
            
            
            <!-- /.card-body-->
            <div class="card-body">
              
              {{--  TABLA PARA MOSTRAR TRAMITES ASIGNADOS  --}}

              @foreach($administradores as $key => $element)
                @if (isset($_COOKIE["email_login"]) && $_COOKIE["email_login"] == $element->email)
                  @foreach($asignaciones as $i => $asig)

                    @if ($element->id == $asig['user_id'])
                    {{--  Se deja verifica a que usuario se asigno el tramite para mostrar
                      solo el tramite asignado al usuario que se esta logueando  --}}

                <table class="
                table table-responsive table-striped dt-responsive  dtr-inline
                " width="100%" id="verTramiteAsignado">
                
                  <thead>
  
                    <tr>
                      
                      <th>#</th>
                      <th> Tramite </th>
                      <th> Codigo </th>
                      <th> Observaciones del Tramite</th>
                      <th> Fecha Asignación </th>
                      <th> Fecha Finalización </th>
                      <th> Estatus </th>
                      <th> Acciones </th>
  
                    </tr>              
  
                  </thead>
  
                  <tbody>
                      
  
                  </tbody>
  
                </table>

                      @endif
                      @endforeach
                @endif
                @endforeach
                {{--  TABLA PARA MOSTRAR TRAMITES ASIGNADOS  --}}

              </div>

            </div>
            <!-- /.card-body-->

          </div>
          <!-- Evaluaciones Asignadas -->

        </div>

      </div>

    </div>

  </section>
  <!-- /.content -->
</div>



<!-- -->

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

          <form action="{{url('/')}}/blog/" method="post" enctype="multipart/form-data">
            {{--se aplica al formulario enctype para indicarle que se va a trabajar 
              con archivos de tipo file--}}

            @method('PUT')
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

                            <input type="date" id="fechaInput" class="form-control" name="" placeholder="Ingrese el título del tramite" readonly>

                          </div>

                          {{-- Solicitante  --}}

                          <div class="input-group mb-3">
                            
                            <div class="input-group-append">
                              
                              <span class="input-group-text">Solicitante</span>

                            </div>

                            <input type="text" class="form-control" name="servidor" value="{{-- $element->servidor--}}" required>

                          </div>

                          {{-- Residencia  --}}

                          <div class="input-group mb-3">
                            
                            <div class="input-group-append">
                              
                              <span class="input-group-text">Residencia</span>

                            </div>

                            <input type="text" class="form-control" name="titulo" value="{{-- $element->titulo--}}" required>

                          </div>

                          {{-- Telefono  --}}

                          <div class="input-group mb-3">
                            
                            <div class="input-group-append">
                              
                              <span class="input-group-text">Telefono +502</span>

                            </div>

                            <input type="number" class="form-control" name="titulo" value="{{-- $element->titulo--}}" required>

                          </div>

                          {{-- Municipio  --}}

                          <div class="input-group mb-3">
                            
                            <div class="input-group-append">
                              
                              <span class="input-group-text">Municipio </span>

                            </div>

                            <select class="form-control"  name="estatus" required>

                                <option value=""  selected>Seleccione </option>
                                <option value="en espera">Cubulco</option>
                                <option value="modificado">Granados</option>
                                <option value="asignado">Salamá</option>
                                <option value="ejecutando">San Jerónimo</option>

                            </select>

                          </div>

                          {{-- CUI --}}

                          <div class="input-group mb-3">
                            
                            <div class="input-group-append">
                              
                              <span class="input-group-text">CUI</span>

                            </div>

                            <input type="number" class="form-control" name="titulo" value="{{-- $element->titulo--}}" required>

                          </div>

                          {{-- Descripción  --}}

                          <div class="input-group mb-3">
                            
                            <div class="input-group-append">
                              
                              <span class="input-group-text">Descripción</span>

                            </div>

                            <textarea class="form-control" rows="5" name="descripcion" required>{{--$element->descripcion--}}</textarea>

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

                              <select class="form-control"  name="estatus" required>

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

<!-- -->






  @if (Session::has("no-validacion"))

  <script>
      notie.alert({ type: 2, text: '¡Hay campos no válidos en el formulario!', time: 10 })
  </script>

  @endif

  @endsection

  
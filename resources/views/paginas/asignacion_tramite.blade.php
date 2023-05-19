@foreach ($administradores as $element)

  @if (isset($_COOKIE["email_login"]) && $_COOKIE["email_login"] == $element->email)
               
    @if ($element->rol == "administrador")

@extends('plantilla')

@section('content')

<div class="content-wrapper" style="min-height: 247px;">

  <section class="content-header">

    <div class="container-fluid">

      <div class="row mb-2">

        <div class="col-sm-6">

          <h1>Asignaciones</h1>

        </div>

        <div class="col-sm-6">

          <ol class="breadcrumb float-sm-right">

            <li class="breadcrumb-item"><a href="{{url('/')}}">Inicio</a></li>

            <li class="breadcrumb-item active">Asignaciones</li>

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

          <!-- Default box -->
          <div class="card">

            <div class="modal-header bg-dark">

              <h3 class="modal-title">Asignación de Tramites</h3> 

              <div class="card-tools">

                <button class="btn btn-primary btn-sm bg-white" data-toggle="modal" data-target="#crearAsignacionTramite"> 
                  <i class="fa-solid fa-plus"></i>
                </button>

              </div>
            </div>


            <!-- /.card-body-->
            <div class="card-body">
              
                <table class="
                table table-bordered table-striped dt-responsive dataTable no-footer dtr-inline
                " width="100%" id="tablaAsignacionesTramites">
                
                  <thead>
  
                    <tr>
                      
                      <th>#</th>
                      <th>Usuario</th>
                      <th>Tramite</th>
                      <th>Observaciones</th>
                      <th>Fecha Asig.</th>
                      <th>Estatus</th>
                      <th>Acciones</th>
  
                    </tr>              
  
                  </thead>
  
                  <tbody>
  
                  </tbody>
  
                </table>

              </div>

            </div>
            <!-- /.card-body-->

          </div>
          <!-- /.card -->

      </div>

    </div>

  </section>
  <!-- /.content -->
</div>


<!--=====================================
Crear Asignaciones
======================================-->

<div class="modal" id="crearAsignacionTramite">

    <div class="modal-dialog">

        <div class="modal-content">

            <form action="{{url('/')}}/asignacion_tramite" method="post" enctype="multipart/form-data">

            @csrf
            
            <div class="modal-header bg-info">
                
                <h4 class="modal-title">Crear Asignación de Tramite</h4>

                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>

            <div class="modal-body">
                
                {{-- Título Tramite --}}
                <label>Título del Tramite</label> <br>
                <div class="input-group mb-3">

                <div class="input-group-append input-group-text">
                    <i class="nav-icon fa-solid fa-sheet-plastic"></i>
                </div>

                <select class="form-control"  name="id_tramite" required>

                    <option value=""  selected>Seleccione Tramite</option>

                    @foreach ($tramites as $key => $value)
                    
                        <option value="{{$value->id_tramite}}">{{$value->nombre_tramite}}</option>

                    @endforeach

                    </select>

                </div> 

                {{-- Usuario --}}
                <label>Usuario</label> <br>
                <div class="input-group mb-3">

                    <div class="input-group-append input-group-text">
                        <i class="fa-solid fa-user"></i>
                    </div>

                    <select class="form-control"  name="id_user" required>

                      <option value=""  selected>Seleccione Usuario</option>

                      @foreach ($usuarios as $key => $val)
                    
                        <option value="{{$val->id}}">{{$val->name}}</option>

                      @endforeach

                    </select>

                </div>

                {{-- Estatus del Tramite --}}
                <label>Estatus del Tramite</label> <br>
                <div class="input-group mb-3">

                    <div class="input-group-append input-group-text">
                        <i class="fas fa-list-ul"></i>
                    </div>

                    <select class="form-control"  name="estatus" required>

                        <option value=""  selected>Seleccione Estatus</option>
                        <option value="asignado">Asignado</option>
                        <option value="ejecutando">Ejecutando</option>
                        <option value="en espera">En Espera</option>
                        <option value="modificado">Modificado</option>
                        <option value="abortado">Abortado</option>

                    </select>

                </div>

                {{-- Fecha de Tramite --}}
                <label>Fecha de Asignación </label> <br>
                <div class="input-group mb-3">

                  <div class="input-group-append input-group-text">
                      <i class="fa-solid fa-calendar-days"></i>
                  </div>

                  <input type="date" id="fechaInput" class="form-control" name="" placeholder="Ingrese el título del tramite" readonly>

                </div>

                {{-- Descripción Tramite --}}
                <label>Descripción del Tramite</label> <br>
                <div class="input-group mb-3">
            
                    <div class="input-group-append input-group-text">
                        <i class="fas fa-pencil-alt"></i>
                    </div>

                    <textarea class="form-control" rows="3" name="observacion_asignacion"
                    placeholder="Ingrese la descripción del tramite"
                    cols="20"
                    maxlength="300"></textarea>

                </div> 

            </div>

            <div class="modal-footer d-flex justify-content-between">
                
                <div>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>

                <div>
                <button type="submit" class="btn btn-primary">Guardar</button>
                </div>

            </div>

            </form>

        </div>
    
    </div>

</div>

<script>$("#crearAsignacionTramite").modal()</script>
<script>
    // Obtener el elemento del input por su id
    var fechaInput = document.getElementById("fechaInput");

    // Obtener la fecha actual
    var fechaActual = new Date();

    // Formatear la fecha para asignarla al valor del input
    var formatoFecha = fechaActual.toISOString().split('T')[0];

    // Asignar la fecha formateada al valor del input
    fechaInput.value = formatoFecha;
  </script>


  <!--=====================================
  Editar Asignaciones
  ======================================-->

  @if (isset($status))

    @if ($status == 200)

      @foreach ($tramites as $key => $valueAg)
    
<div class="modal" id="crearAsignacionTramite">

    <div class="modal-dialog">

        <div class="modal-content">

            <form action="{{url('/')}}/tramites/{{$valueT['id_ag']}}" method="post" enctype="multipart/form-data">
                @method('PUT')
                @csrf
            
            <div class="modal-header bg-info">
                
                <h4 class="modal-title">Editar Asignación de Tramite</h4>

                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>

            <div class="modal-body">
                
                {{-- Título Tramite --}}
                <label>Título del Tramite</label> <br>
                <div class="input-group mb-3">

                <div class="input-group-append input-group-text">
                    <i class="nav-icon fa-solid fa-sheet-plastic"></i>
                </div>

                <select class="form-control"  name="id_tramite" required>

                    @foreach ($tramites as $key => $valueT2)

                        @if ($valueT['tramite_id'] == $valueT2['id_tramite'])
                            <option value="$valueT2['id_tramite']" selected>{{$valueT2->nombre_tramite}}</option>
                        @endif
                    
                        <option value="{{$valueT2->id_tramite}}">{{$valueT2->nombre_tramite}}</option>

                    @endforeach

                    </select>

                </div> 

                {{-- Usuario --}}
                <label>Usuario</label> <br>
                <div class="input-group mb-3">

                    <div class="input-group-append input-group-text">
                        <i class="fa-solid fa-user"></i>
                    </div>

                    <select class="form-control"  name="id_user" required>

                    @foreach ($usuarios as $key => $valueUs)

                        @if ($val['evaluacion_id'] == $value4['id_evaluacion'])
                            <option value="$value4['id_evaluacion']" selected>{{$value4->titulo_evaluacion}}</option>
                        @endif
                    
                        <option value="{{$val->id}}">{{$val->name}}</option>

                    @endforeach

                    </select>

                </div>

                {{-- Estatus del Tramite --}}
                <label>Estatus del Tramite</label> <br>
                <div class="input-group mb-3">

                    <div class="input-group-append input-group-text">
                        <i class="fas fa-list-ul"></i>
                    </div>

                    <select class="form-control"  name="estatus" required>

                        <option value=""  selected>Seleccione Estatus</option>
                        <option value="asignado">Asignado</option>
                        <option value="ejecutando">Ejecutando</option>
                        <option value="en espera">En Espera</option>
                        <option value="modificado">Modificado</option>
                        <option value="abortado">Abortado</option>

                    </select>

                </div>

                {{-- Descripción Tramite --}}
                <label>Descripción del Tramite</label> <br>
                <div class="input-group mb-3">
            
                <div class="input-group-append input-group-text">
                    <i class="fas fa-pencil-alt"></i>
                </div>

                <textarea class="form-control" rows="3" name="observacion_tramite"
                placeholder="Ingrese la descripción del tramite"
                cols="20"
                maxlength="300"></textarea>

                </div> 

            </div>

            <div class="modal-footer d-flex justify-content-between">
                
                <div>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>

                <div>
                <button type="submit" class="btn btn-primary">Guardar</button>
                </div>

            </div>

            </form>

        </div>

    </div>

</div>

      @endforeach

      <script>$("#editarAsignaciones").modal()</script>

    @endif

  @endif



  @if (Session::has("ok-crear"))

    <script>
        notie.alert({ type: 1, text: '¡Asginación creada con Exito!', time: 10 })
  </script>

  @endif

  @if (Session::has("no-validacion"))

  <script>
      notie.alert({ type: 2, text: '¡Hay campos no válidos en el formulario!', time: 10 })
  </script>

  @endif

  @if (Session::has("error"))

    <script>
        notie.alert({ type: 3, text: '¡Error en el gestor de Asignaciones!', time: 10 })
  </script>

  @endif

  @if (Session::has("ok-editar"))

    <script>
        notie.alert({ type: 1, text: '¡La Asignación ha sido actualizada correctamente!', time: 10 })
  </script>

  @endif

  @if (Session::has("no-borrar"))

    <script>
        notie.alert({ type: 3, text: '¡Error al eliminar la Asignación!', time: 10 })
  </script>

  @endif

  @endsection

  @else

      <script>window.location="{{url('/perfil')}}"</script>

      @endif

    @endif

  @endforeach 
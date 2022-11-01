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

              <h3 class="modal-title">Asignaciones</h3> 

            </div>


            <!-- /.card-body-->
            <div class="card-body">
              
                <table class="
                table table-bordered table-striped dt-responsive dataTable no-footer dtr-inline
                " width="100%" id="tablaAsignaciones">
                
                  <thead>
  
                    <tr>
                      
                      <th>#</th>
                      <th>Usuario</th>
                      <th>Evaluación</th>
                      <th>Observaciones</th>
                      <th>Fecha Asig.</th>
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


          <div class="col-12">

            <div class="card">

                <form method="post" action="{{ url('/search') }}">
                  @csrf
                
                  <div class="modal-header bg-info">
                    
                    <h4 class="modal-title">Crear Asignación</h4>

                  </div>

                  <div class="modal-body">

                      {{-- Evaluado --}}
                      <label for="query">Ingrese usuario a evaluar.</label>

                      <div class="input-group mb-3">
                        
                          <div class="input-group-append input-group-text">
                            <i class="fa-solid fa-user"></i>
                          </div>

                          <input type="text" class="form-control mw-50" name="query" placeholder="Ingrese el nombre del usuario" required>

                      </div>

                  </div>

                  <div class="modal-body">

                      {{-- Evaluador --}}
                      <label for="query">Ingrese usuario evaluador.</label>

                      <div class="input-group mb-3">
                        
                          <div class="input-group-append input-group-text">
                            <i class="fa-solid fa-user-tie"></i>
                          </div>

                          <input type="text" class="form-control mw-50" name="evaluador" placeholder="Ingrese nombre del evaluador" required>

                      </div>

                  </div>

                  <div class="modal-footer d-flex justify-content-between">
                    
                    <div>
                      <button type="submit" class="btn btn-primary bg-dark">Crear Asignación</button>
                    </div>

                  </div>

                </form>

                <!-- CARD footer -->
              <div class="card-footer">

                  <!-- listado de usuarios -->
                  <div class="">

                      <table class="table table-bordered table-striped dt-responsive" width="100%" id="tablaUsuario">
                        
                        <thead>

                          <tr>
                            
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th width="50px">Foto</th>
                            <th>Rol</th>

                          </tr>              

                        </thead>

                        <tbody>

                        </tbody>

                      </table>

                  </div>
                  <!-- /.card-body-->

              </div>

            </div>

              
          </div>


          </div>

        </div>

      </div>

    </div>

  </section>
  <!-- /.content -->
  


<!--=====================================
Crear Asignaciones
======================================-->
@if (isset($status))

  @if ($status == 202)

    @foreach ($admin as $key => $value)

<div class="modal" id="crearAsignaciones">

  <div class="modal-dialog">

    <div class="modal-content">

      <form action="{{url('/')}}/asignaciones" method="post" enctype="multipart/form-data">

       @csrf
        
        <div class="modal-header bg-info">
          
          <h4 class="modal-title">Crear Asignación</h4>

          <button type="button" class="close" data-dismiss="modal">&times;</button>

        </div>

        <div class="modal-body">
          
           {{-- Asignar Usuario a Evaluar --}}
           <label for="">Usuario a evaluar</label> <br>
          <div class="input-group mb-3">
          
            <div class="input-group-append input-group-text">
                <i class="fa-solid fa-user"></i>
            </div>

            <input type="text" class="form-control" name="id_usuario" placeholder="Asigne usuario a evaluar" value="{{$value->id}}" hidden require> 
            <input type="text" class="form-control" name="name" placeholder="Asigne usuario a evaluar" value="{{$value->name}}" readonly > 

          </div> 

          {{-- Asignar Evaluación --}}
          <label for="">Asignar evaluación</label> <br>
          <div class="input-group mb-3">

            <div class="input-group-append input-group-text">
                <i class="nav-icon fa-solid fa-sheet-plastic"></i>
            </div>

            <!-- <input type="text" class="form-control" name="asignar_evaluacion" placeholder="Asigne Evaluacion" value="{{-- old("evaluacion_id") --}}" required>  -->

            <select class="form-control"  name="asignar_evaluacion" required >

                <option value="" default>Asignar Evaluación</option>

                @foreach ($evaluaciones as $key => $value2)
              
                  <option value="{{ $value2 -> id_evaluacion }}">{{$value2->titulo_evaluacion}}</option>

                @endforeach

            </select>

          </div> 

          {{-- Obsercaciones de la Asignación --}}
          <label for="">Observaciones</label> <br>
          <div class="input-group mb-3">
     
            <div class="input-group-append input-group-text">
              <i class="fas fa-pencil-alt"></i>
            </div>

            <!-- <input type="text" class="form-control" name="descripcion_indicador" placeholder="Ingrese la descripción del indicador" value="{{--old("descripcion_indicador")--}}" maxlength="255" required> -->
            <textarea class="form-control" rows="5" name="observaciones" required value="{{old('observaciones')}}"
            placeholder="Ingrese una observación de la Asignación..."
            maxlength="255"
            ></textarea>

          </div> 


          {{-- Asignar Evaluador --}}
          <label for="query">Usuario evaluador.</label>
          <div class="input-group mb-3">

            <div class="input-group-append input-group-text">
                <i class="fa-solid fa-user-tie"></i>
            </div>

            @foreach ($user as $key => $users)

                <input type="text" class="form-control" name="id_evaluador" value="{{$users->id}}" hidden require readonly>
                <input type="text" class="form-control" name="evaluador" placeholder="Asigne usuario evaluador" value="{{$users->name}}" readonly> 

            @endforeach

          </div>

        </div>


        <div class="card-footer">
          
          <div class="modal-footer d-flex justify-content-between">
            
            <div>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>

            <div>
              <button type="submit" class="btn btn-primary">Guardar</button>
            </div>

          </div>

        </div>
        

      </form>

    </div>
    
  </div>

</div>

    @endforeach

    <script>$("#crearAsignaciones").modal()</script>

  @endif

@endif


<!--=====================================
Editar Asignaciones
======================================-->

@if (isset($status))

  @if ($status == 200)

    @foreach ($asignacion as $key => $value3)
  
    <div class="modal" id="editarAsignaciones">

      <div class="modal-dialog">

        <div class="modal-content">

          <form action="{{url('/')}}/asignaciones/{{$value3['id_asignacion']}}" method="post" enctype="multipart/form-data">
          @method('PUT')
          @csrf
            
            <div class="modal-header bg-info">
              
              <h4 class="modal-title">Editar Asignación</h4>

              <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>

            <div class="modal-body">
              
              {{-- Asignar Usuario a Evaluar --}}
              <label for="">Usuario a evaluar</label> <br>
              <div class="input-group mb-3">
              
                <div class="input-group-append input-group-text">
                    <i class="fa-solid fa-user"></i>
                </div>

                <!-- <input type="text" class="form-control" name="id_usuario" placeholder="Asigne usuario a evaluar" value="{{$value3->user_id}}" hidden readonly> -->
                @foreach ($administradores as $kay => $data)

                  @if ($value3->user_id == $data->id)
                
                    <input type="text" class="form-control" name="name" placeholder="Asigne usuario a evaluar" value="{{$data->name}}" readonly> 

                  @endif

                @endforeach 
                
              </div> 

              {{-- Asignar Evaluación --}}
              <label for="">Asignar evaluación</label> <br>
              <div class="input-group mb-3">

                <div class="input-group-append input-group-text">
                    <i class="nav-icon fa-solid fa-sheet-plastic"></i>
                </div>

                <select class="form-control"  name="asignar_evaluacion" required >

                    @foreach ($evaluaciones as $key => $value4)

                      @if ($value3['evaluacion_id'] == $value4['id_evaluacion'])
                          <option value="$value4['id_evaluacion']" selected>{{$value4->titulo_evaluacion}}</option>
                      @endif
                    
                      <option value="{{ $value4 -> id_evaluacion }}">{{$value4->titulo_evaluacion}}</option>

                    @endforeach

                </select>

              </div> 

              {{-- Obsercaciones de la Asignación --}}
              <label for="">Observaciones</label> <br>
              <div class="input-group mb-3">
        
                <div class="input-group-append input-group-text">
                  <i class="fas fa-pencil-alt"></i>
                </div>

                <!-- <input type="text" class="form-control" name="descripcion_indicador" placeholder="Ingrese la descripción del indicador" value="{{--old("descripcion_indicador")--}}" maxlength="255" required> -->
                <textarea class="form-control" rows="5" name="observaciones" required value=""
                placeholder="Ingrese una observación de la Evaluación"
                maxlength="255"
                >{{$value3['observaciones']}}</textarea>

              </div> 

              {{-- Asignar Evaluador --}}
              <label for="query">Usuario evaluador.</label>
              <div class="input-group mb-3">

                <div class="input-group-append input-group-text">
                    <i class="fa-solid fa-user-tie"></i>
                </div>

                <!-- <input type="text" class="form-control" name="id_usuario" placeholder="Asigne usuario a evaluar" value="{{$value3->evaluador}}" hidden readonly> -->

                @foreach ($administradores as $key => $evaluador)
                
                  @if ($value3['evaluador'] == $evaluador->id)

                  <input type="text" class="form-control" name="evaluador" placeholder="Asigne usuario evaluador" value="{{$evaluador['name']}}" readonly> 

                  @endif

                @endforeach

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
      notie.alert({ type: 1, text: '¡Categoria creada con Exito!', time: 10 })
 </script>

@endif

@if (Session::has("no-validacion"))

<script>
    notie.alert({ type: 2, text: '¡Hay campos no válidos en el formulario!', time: 10 })
</script>

@endif

@if (Session::has("error"))

  <script>
      notie.alert({ type: 3, text: '¡Error en el gestor de Categorias!', time: 10 })
 </script>

@endif

@if (Session::has("ok-editar"))

  <script>
      notie.alert({ type: 1, text: '¡La categoria ha sido actualizada correctamente!', time: 10 })
 </script>

@endif

@if (Session::has("no-borrar"))

  <script>
      notie.alert({ type: 3, text: '¡Error al eliminar la Categoria!', time: 10 })
 </script>

@endif

@endsection
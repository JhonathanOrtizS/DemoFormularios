@extends('plantilla')

@section('content')

<div class="content-wrapper" style="min-height: 247px;">

  <section class="content-header">

    <div class="container-fluid">

      <div class="row mb-2">

        <div class="col-sm-6">

          <h1>Preguntas</h1>

        </div>

        <div class="col-sm-6">

          <ol class="breadcrumb float-sm-right">

            <li class="breadcrumb-item"><a href="{{url('/')}}">Inicio</a></li>

            <li class="breadcrumb-item active">Preguntas</li>

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

              <h3 class="modal-title">Crear Nueva Pregunta</h3>

              <div class="card-tools">

                <button class="btn btn-primary btn-sm bg-white" data-toggle="modal" data-target="#crearPregunta"> 
                  <i class="fa-solid fa-plus"></i>
                </button>

              </div>

            </div>

            <div class="card-body">

              <table class="
                table table-bordered table-striped dt-responsive dataTable no-footer dtr-inline
                " width="100%" id="tablaPreguntas">
                
                  <thead>
  
                    <tr>
                      
                      <th>#</th>
                      <th>Indicador</th>
                      <th>Pregunta</th>
                      <th>Serie de Respuestas</th>
                      <th>Acciones</th>
  
                    </tr>              
  
                  </thead>
  
                  <tbody>
  
                  </tbody>
  
                </table>

            </div>

            <!-- /.card-body -->
            <div class="card-footer">

              Footer

            </div>
            <!-- /.card-footer-->
          </div>
          <!-- /.card -->
        </div>

      </div>

    </div>

  </section>
  <!-- /.content -->
</div>



<!--=====================================
Crear PREGUNTAS
======================================-->
<div class="modal" id="crearPregunta">

  <div class="modal-dialog">

    <div class="modal-content">

      <form action="{{url('/')}}/preguntas" method="post" enctype="multipart/form-data">

       @csrf
        
        <div class="modal-header bg-info">
          
          <h4 class="modal-title">Crear Pregunta</h4>

          <button type="button" class="close " data-dismiss="modal">&times;</button>

        </div>

        <div class="modal-body">

          {{-- SELECCION DE INDICADORES --}}

          <div class="input-group mb-3">

            <div class="input-group-append input-group-text">
              <i class="fas fa-list-ul"></i>
            </div>

            <select class="form-control"  name="id_indicador" required>

              <option value=""  selected>Seleccione Indicador</option>

              @foreach ($indicadores as $key => $value)
              
                <option value="{{$value->id_indicador}}">{{$value->titulo_indicador}}</option>

              @endforeach

            </select>

          </div> 

          <hr class="pb-2">
          
           {{-- Título Pregunta --}}

           <div class="input-group mb-3">

            <div class="input-group-append input-group-text">
              <i class="fa-solid fa-pencil"></i>
            </div>

            <input type="text" class="form-control" name="pregunta" placeholder="Ingrese la pregunta" value="{{old("titulo_pregunta")}}" 
            maxlength="150" required>

          </div> 

          {{-- Descripcion del Indicador --}}

          <div class="input-group mb-3">
     
            <div class="input-group-append input-group-text">
              <i class="fas fa-pencil-alt"></i>
            </div>

            <textarea class="form-control" rows="5" name="descripcion" value="{{old("descripcion")}}"
            placeholder="Ingrese la descripción de la pregunta -'Opcional'-"
            maxlength="255"
            ></textarea>

          </div> 

          {{-- SELECCION DE RESPUESTAS --}}

          <div class="input-group mb-3">

            <div class="input-group-append input-group-text">
              <i class="nav-icon fa-solid fa-check-to-slot"></i>
            </div>

            <select class="form-control"  name="respuestas" required>

              <option value=""  selected>Seleccione Serie de Respuestas</option>

              @foreach ($respuestas as $keyr => $value2)
              
                <option value="{{$value2->id_respuesta}}">{{$value2->titulo_respuesta}}</option>

              @endforeach

            </select>

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


<!--=====================================
EDITAR PREGUNTAS
======================================-->
@if (isset($status))

    @if ($status == 200 )
        
        @foreach ($pregunta as $item => $val)

        <!--=====================================
          Foreach de status
        ======================================-->
            
<div class="modal" id="editarPregunta">

  <div class="modal-dialog">

    <div class="modal-content">

      <form action="{{url('/')}}/preguntas/{{$val->id_pregunta}}" method="post" enctype="multipart/form-data">

        @method('PUT')
        @csrf
        
        <div class="modal-header bg-info">
          
          <h4 class="modal-title">Editar Pregunta</h4>

          <button type="button" class="close " data-dismiss="modal">&times;</button>

        </div>

        <div class="modal-body">

          {{-- SELECCION DE INDICADORES --}}

          <label>Elegir Indicador</label> <br>

          <div class="input-group mb-3">


              <div class="input-group-append input-group-text">
                <i class="fas fa-list-ul"></i>
              </div>
  
              <select class="form-control"  name="id_indicador" required>
  
                <option value="{{$val->indicador_id}}"  selected>{{$value->titulo_indicador}}</option>
  
                @foreach ($indicadores as $key => $value)
                
                  <option value="{{$value->id_indicador}}">{{$value->titulo_indicador}}</option>
  
                @endforeach
  
              </select>

          </div> 

          <hr class="pb-2">
          
           {{-- Título Pregunta --}}
           <label>Pregunta</label> <br>
           <div class="input-group mb-3">

            <div class="input-group-append input-group-text">
              <i class="fa-solid fa-pencil"></i>
            </div>

            <input type="text" class="form-control" name="pregunta" placeholder="Ingrese la pregunta" value="{{$val->pregunta}}" 
            maxlength="150" required>

          </div> 

          {{-- Descripcion del Indicador --}}
          <label>Descripción</label> <br>
          <div class="input-group mb-3">
     
            <div class="input-group-append input-group-text">
              <i class="fas fa-pencil-alt"></i>
            </div>

            <textarea class="form-control" rows="5" name="descripcion"
            placeholder="Ingrese la descripción de la pregunta -'Opcional'-"
            maxlength="255">{{$val->descripcion_pregunta}}</textarea>

          </div> 

          {{-- SELECCION DE RESPUESTAS --}}
          <hr class="pb-2">

          <label>Elegir Serie de Respuestas</label> <br>

          <div class="input-group mb-3">

            <div class="input-group-append input-group-text">
              <i class="nav-icon fa-solid fa-check-to-slot"></i>
            </div>

            <select class="form-control"  name="respuestas" required>

              <option value="{{$val->respuesta_id}}"  selected>{{$value2->titulo_respuesta}}</option>

              @foreach ($respuestas as $keyr => $value2)
              
                <option value="{{$value2->id_respuesta}}">{{$value2->titulo_respuesta}}</option>

              @endforeach

            </select>

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

        <!--=====================================
          Foreach de status
        ======================================-->

        @endforeach

        <script>$("#editarPregunta").modal()</script>

    @endif
    
@endif



@if (Session::has("ok-crear"))

  <script>
      notie.alert({ type: 1, text: 'Pregunta creada con Exito!', time: 10 })
 </script>

@endif

@if (Session::has("no-validacion"))

<script>
    notie.alert({ type: 2, text: '¡Hay campos no válidos en el formulario!', time: 10 })
</script>

@endif

@if (Session::has("error"))

  <script>
      notie.alert({ type: 3, text: '¡Error en el gestor de Preguntas!', time: 10 })
 </script>

@endif

@if (Session::has("ok-editar"))

  <script>
      notie.alert({ type: 1, text: '¡La Pregunta ha sido actualizada correctamente!', time: 10 })
 </script>

@endif

@if (Session::has("no-borrar"))

  <script>
      notie.alert({ type: 3, text: '¡Error al eliminar Pregunta!', time: 10 })
 </script>

@endif

@endsection
@extends('plantilla')

@section('content')

<div class="content-wrapper" style="min-height: 247px;">

  <section class="content-header">

    <div class="container-fluid">

      <div class="row mb-2">

        <div class="col-sm-6">

          <h1>Evaluaciones</h1>

        </div>

        <div class="col-sm-6">

          <ol class="breadcrumb float-sm-right">

            <li class="breadcrumb-item"><a href="{{url('/')}}">Inicio</a></li>

            <li class="breadcrumb-item active">Evaluaciones</li>

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

              <h3 class="modal-title">Crear Nueva Evaluación</h3> 

              <div class="card-tools">

                <button class="btn btn-primary btn-sm bg-white" data-toggle="modal" data-target="#crearEvaluacion"> 
                  <i class="fa-solid fa-plus"></i>
                </button>

              </div>

            </div>

            <div class="card-body">
              {{--
              @foreach ($categorias as $element)
                  {{ $element }}
                @endforeach --}}

                <table class="table table-bordered table-striped dt-responsive dataTable no-footer dtr-inline" 
                width="100%" id="tablaEvaluaciones"> 
                
                  <thead>
  
                    <tr>
                      
                      <th>#</th>
                      <th>Titulo</th>
                      <th>Descripción</th>
                      <th>Acciones</th>
  
                    </tr>              
  
                  </thead>
  
                  <tbody>
  
                  </tbody>
  
                </table>

            </div>
            
          </div>
          <!-- /.card -->
        </div>

      </div>

    </div>

  </section>
  <!-- /.content -->
</div>


<!--=====================================
Crear Evaluación
======================================-->
<div class="modal" id="crearEvaluacion">

  <div class="modal-dialog">

    <div class="modal-content">

      <form action="{{url('/')}}/evaluaciones" method="post" enctype="multipart/form-data">

       @csrf
        
        <div class="modal-header bg-info">
          
          <h4 class="modal-title">Crear Evaluación</h4>

          <button type="button" class="close" data-dismiss="modal">&times;</button>

        </div>

        <div class="modal-body">
          
           {{-- Título Evaluacion --}}

           <div class="input-group mb-3">

            <div class="input-group-append input-group-text">
              <i class="fas fa-list-ul"></i>
            </div>

           <input type="text" class="form-control" name="titulo_evaluacion" placeholder="Ingrese el título de la evaluacion" value="{{old('titulo_evaluacion')}}" required>
            

          </div> 

          {{-- Descripción Evaluacion --}}

          <div class="input-group mb-3">
     
            <div class="input-group-append input-group-text">
              <i class="fas fa-pencil-alt"></i>
            </div>

            <!-- <input type="text" class="form-control" name="descripcion_evaluacion" placeholder="Ingrese la descripción de la evaluación" value="{{--old("descripcion_evaluacion")--}}" maxlength="255" required> -->
            <textarea class="form-control" rows="5" name="descripcion_evaluacion" required value="{{old('descripcion_evaluacion')}}"
            placeholder="Ingrese la descripción de la evaluación"
            maxlength="255"
            ></textarea>
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
Editar Evaluaciones
======================================-->

@if (isset($status))

  @if ($status == 200)

    @foreach ($evaluacion as $key => $value)
  
      <div class="modal" id="editarEvaluacion">

        <div class="modal-dialog">

          <div class="modal-content">

            <form action="{{url('/')}}/evaluaciones/{{$value->id_evaluacion}}" method="post" enctype="multipart/form-data">

              @method('PUT')

              @csrf
              
              <div class="modal-header bg-info">
                
                <h4 class="modal-title">Editar Evaluacion</h4>

                <button type="button" class="close" data-dismiss="modal">&times;</button>

              </div>

              <div class="modal-body">

                
                {{-- Título Evaluacion --}}
                <label>Título de Evaluación</label> <br>
                <div class="input-group mb-3">

                  <div class="input-group-append input-group-text">
                    <i class="fas fa-list-ul"></i>
                  </div>

                  <input type="text" class="form-control" name="titulo_evaluacion" placeholder="Ingrese el título de la evaluacion" value="{{$value->titulo_evaluacion}}">

                </div> 

                {{-- Descripción Evaluacion --}}
                <label>Descripción de la Evaluación</label> <br>
                <div class="input-group mb-3">
           
                  <div class="input-group-append input-group-text">
                    <i class="fas fa-pencil-alt"></i>
                  </div>

                  <textarea class="form-control" rows="3" name="descripcion_evaluacion"
                  placeholder="Ingrese la descripción de la evaluación"
                  cols="20"
                  maxlength="300">{{$value->descripcion_evaluacion}}</textarea>

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

    <script>$("#editarEvaluacion").modal()</script>

  @endif

@endif



@if (Session::has("ok-crear"))

  <script>
      notie.alert({ type: 1, text: '¡Evaluación creada con Exito!', time: 10 })
 </script>

@endif

@if (Session::has("no-validacion"))

<script>
    notie.alert({ type: 2, text: '¡Hay campos no válidos en el formulario!', time: 10 })
</script>

@endif

@if (Session::has("error"))

  <script>
      notie.alert({ type: 3, text: '¡Error en el gestor de Evaluación!', time: 10 })
 </script>

@endif

@if (Session::has("ok-editar"))

  <script>
      notie.alert({ type: 1, text: '¡La Evaluación ha sido actualizada correctamente!', time: 10 })
 </script>

@endif

@if (Session::has("no-borrar"))

  <script>
      notie.alert({ type: 3, text: '¡Error al eliminar la Evaluación!', time: 10 })
 </script>

@endif

@endsection
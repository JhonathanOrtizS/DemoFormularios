@extends('plantilla')

@section('content')

<div class="content-wrapper" style="min-height: 247px;">

  <section class="content-header">

    <div class="container-fluid">

      <div class="row mb-2">

        <div class="col-sm-6">

          <h1>Respuestas</h1>

        </div>

        <div class="col-sm-6">

          <ol class="breadcrumb float-sm-right">

            <li class="breadcrumb-item"><a href="{{url('/')}}">Inicio</a></li>

            <li class="breadcrumb-item active">Respuestas</li>

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

              <h3 class="modal-title">Crear Nueva Serie de Respuestas</h3>

              <div class="card-tools">

                <button class="btn btn-primary btn-sm bg-white" data-toggle="modal" data-target="#crearRespuesta"> 
                  <i class="fa-solid fa-plus"></i>
                </button>

              </div>

            </div>

            <div class="card-body">

              

              <table class="
                table table-bordered table-striped dt-responsive dataTable no-footer dtr-inline
                " width="100%" id="tablaRespuestas">
                
                  <thead>
  
                    <tr>
                      
                      <th>#</th>
                      <th>Titulo</th>
                      <th>Serie de Respuestas</th>
                      <th>Descripción</th>
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
Crear RESPUESTAS
======================================-->
<div class="modal" id="crearRespuesta">

  <div class="modal-dialog">

    <div class="modal-content">

      <form action="{{url('/')}}/respuestas" method="post" enctype="multipart/form-data">

       @csrf
         
        <div class="modal-header bg-info">
          
          <h4 class="modal-title">Crear Serie de Respuestas</h4>

          <button type="button" class="close " data-dismiss="modal">&times;</button>

        </div>

        <div class="modal-body">

          {{-- Título Pregunta --}}

          <div class="input-group mb-3">

            <div class="input-group-append input-group-text">
              <i class="fa-solid fa-pencil"></i>
            </div>

            <input type="text" class="form-control" name="titulo_respuesta" placeholder="Ingrese el titulo de la Respuesta" value="{{old('titulo_respuesta')}}" 
            maxlength="150" required>

          </div> 

          {{-- Descripcion del Indicador --}}

          <div class="input-group mb-3">
     
            <div class="input-group-append input-group-text">
              <i class="fas fa-pencil-alt"></i>
            </div>

            <textarea class="form-control" rows="5" name="descripcion" value="{{old('descripcion')}}"
            placeholder="Ingrese la descripción de la pregunta -'Opcional'-"
            maxlength="255"
            ></textarea>

          </div> 

          {{-- Palabras claves de Respuestas --}}
                  
          <div class="form-group mb-3">
     
            <label>Escribir respuestas <span class="small">(Separadas por comas)</span></label>

            <input type="text" class="form-control" value="ejemplo" name="respuestas" data-role="tagsinput" required>

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
EDITAR RESPUESTAS
======================================-->

@if (isset($status))

  @if ($status == 200)

    @foreach ($respuesta as $key => $val)
        
    <!--=====================================
      Foreach de status
    ======================================-->


<div class="modal" id="editarRespuesta">

  <div class="modal-dialog">

    <div class="modal-content">

      <form action="{{url('/')}}/respuestas/{{$val->id_respuesta}}" method="post" enctype="multipart/form-data">

        @method('PUT')
        @csrf
         
        <div class="modal-header bg-info">
          
          <h4 class="modal-title">Crear Serie de Respuestas</h4>

          <button type="button" class="close " data-dismiss="modal">&times;</button>

        </div>

        <div class="modal-body">

          {{-- Título Pregunta --}}

          <div class="input-group mb-3">

            <div class="input-group-append input-group-text">
              <i class="fa-solid fa-pencil"></i>
            </div>

            <input type="text" class="form-control" name="titulo_respuesta" placeholder="Ingrese el titulo de la Respuesta" value="{{$val->titulo_respuesta}}" 
            maxlength="150" required>

          </div> 

          {{-- Descripcion del Indicador --}}

          <div class="input-group mb-3">
     
            <div class="input-group-append input-group-text">
              <i class="fas fa-pencil-alt"></i>
            </div>

            <textarea class="form-control" rows="5" name="descripcion" value=""
            placeholder="Ingrese la descripción de la pregunta -'Opcional'-"
            maxlength="255"
            >{{$val->descripcion}}</textarea>

          </div> 

          {{-- Palabras claves de Respuestas --}}
                  
          <div class="form-group mb-3">
     
            <label>Escribir respuestas <span class="small">(Separadas por comas)</span></label>

            @php
                $tags = json_decode($val->p_respuestas, true);
                $p_claves = '';
                foreach ($tags as $element) {
                  $p_claves .= $element.',';
                }
            @endphp

            <input type="text" class="form-control" value="{{$p_claves}}" name="respuestas" data-role="tagsinput" required>

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

    <script>$("#editarRespuesta").modal()</script>
      
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
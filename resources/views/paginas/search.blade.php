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
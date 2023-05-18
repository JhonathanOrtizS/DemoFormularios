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

          <!-- Default box -->
          <div class="card">

            <div class="modal-header bg-dark">

              <h3 class="modal-title">Crear Nuevo Tramite</h3> 

              <div class="card-tools">

                <button class="btn btn-primary btn-sm bg-white" data-toggle="modal" data-target="#crearTramite"> 
                  <i class="fa-solid fa-plus"></i>
                </button>

              </div>

            </div>

            <div class="card-body">

                <table class="table table-bordered table-striped dt-responsive dataTable no-footer dtr-inline" 
                width="100%" id="tablaTramties"> 
                
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
Crear Tramites
======================================-->
  
  <div class="modal" id="crearTramite">

    <div class="modal-dialog">

      <div class="modal-content">

        <form action="{{url('/')}}/tramites" method="post" enctype="multipart/form-data">

          @csrf
          
          <div class="modal-header bg-info">
            
            <h4 class="modal-title">Crear Tramite</h4>

            <button type="button" class="close" data-dismiss="modal">&times;</button>

          </div>

          <div class="modal-body">

            
            {{-- Título Tramite --}}
            <label>Título del Tramite</label> <br>
            <div class="input-group mb-3">

              <div class="input-group-append input-group-text">
                <i class="fas fa-list-ul"></i>
              </div>

              <input type="text" class="form-control" name="titulo_tramite" placeholder="Ingrese el título del tramite" value="{{old('nombre_tramite')}}">

            </div> 

            {{-- Descripción Tramite --}}
            <label>Descripción del Tramite</label> <br>
            <div class="input-group mb-3">
        
              <div class="input-group-append input-group-text">
                <i class="fas fa-pencil-alt"></i>
              </div>

              <textarea class="form-control" rows="3" name="descripcion_tramite"
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

  <script>$("#crearTramite").modal()</script>


<!--=====================================
Editar Evaluaciones
======================================-->

@if (isset($status))

  @if ($status == 200)

    @foreach ($tramite as $key => $value)
  
      <div class="modal" id="editarTramite">

        <div class="modal-dialog">

          <div class="modal-content">

            <form action="{{url('/')}}/tramites/{{$value->id_tramite}}" method="post" enctype="multipart/form-data">

              @method('PUT')

              @csrf
              
              <div class="modal-header bg-info">
                
                <h4 class="modal-title">Editar Tramite</h4>

                <button type="button" class="close" data-dismiss="modal">&times;</button>

              </div>

              <div class="modal-body">

                
                {{-- Título Tramite --}}
                <label>Título del Tramite</label> <br>
                <div class="input-group mb-3">

                  <div class="input-group-append input-group-text">
                    <i class="fas fa-list-ul"></i>
                  </div>

                  <input type="text" class="form-control" name="titulo_tramite" placeholder="Ingrese el título de la evaluacion" value="{{$value->titulo_tramite}}">

                </div> 

                {{-- Descripción Tramite --}}
                <label>Descripción del Tramite</label> <br>
                <div class="input-group mb-3">
           
                  <div class="input-group-append input-group-text">
                    <i class="fas fa-pencil-alt"></i>
                  </div>

                  <textarea class="form-control" rows="3" name="descripcion_tramite"
                  placeholder="Ingrese la descripción de la evaluación"
                  cols="20"
                  maxlength="300">{{$value->observaciones}}</textarea>

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

    <script>$("#editarTramite").modal()</script>

  @endif

@endif



@if (Session::has("ok-crear"))

  <script>
      notie.alert({ type: 1, text: '¡Tramite creado con Exito!', time: 10 })
 </script>

@endif

@if (Session::has("no-validacion"))

<script>
    notie.alert({ type: 2, text: '¡Hay contenido no válido en el formulario!', time: 10 })
</script>

@endif

@if (Session::has("error"))

  <script>
      notie.alert({ type: 3, text: '¡Validar datos en el gestor de Tramites!', time: 10 })
 </script>

@endif

@if (Session::has("ok-editar"))

  <script>
      notie.alert({ type: 1, text: '¡El Tramite ha sido actualizado correctamente!', time: 10 })
 </script>

@endif

@if (Session::has("no-borrar"))

  <script>
      notie.alert({ type: 3, text: '¡Error al eliminar la Evaluación!', time: 10 })
 </script>

@endif

@endsection

    @else

      <script>window.location="{{url('/perfil')}}"</script>

    @endif

  @endif

@endforeach 
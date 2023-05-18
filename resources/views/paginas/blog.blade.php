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

          <h1>Blog</h1>

        </div>

        <div class="col-sm-6">

          <ol class="breadcrumb float-sm-right">

            <li class="breadcrumb-item"><a href="{{url('/')}}">Inicio</a></li>

            <li class="breadcrumb-item active">Blog</li>

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

          <form action="{{url('/')}}/blog/{{$element->id}}" method="post" enctype="multipart/form-data">
            {{--se aplica al formulario enctype para indicarle que se va a trabajar 
              con archivos de tipo file--}}

            @method('PUT')

            {{--Este proceso ayuda a crear un token aleatorio de autenticación
              para poder eliminar, editar, o crear datos en la DB--}}
            @csrf

            <!-- Default box -->
            <div class="card">

              <div class="modal-header bg-dark">

                <h4 class="modal-title">Administración del Blog</h4>

                <button type="submit" class="btn btn-primary float-right bg-white">Guardar cambios</button>

              </div>

              <div class="card-body">
               
                <div class="row">
                  
                  <div class="col-lg-7">
                    
                      <div class="card">

                        <div class="card-body">

                          {{-- Dominio  --}}

                          <div class="input-group mb-3">

                            <div class="input-group-append">

                              <span class="input-group-text">Dominio</span>

                            </div>

                            <input type="text" class="form-control" name="dominio" value="{{ $element->dominio}}" required>

                          </div>

                          {{-- Servidor  --}}

                          <div class="input-group mb-3">
                            
                            <div class="input-group-append">
                              
                              <span class="input-group-text">Servidor</span>

                            </div>

                            <input type="text" class="form-control" name="servidor" value="{{ $element->servidor}}" required>

                          </div>

                          {{-- Título  --}}

                          <div class="input-group mb-3">
                            
                            <div class="input-group-append">
                              
                              <span class="input-group-text">Título</span>

                            </div>

                            <input type="text" class="form-control" name="titulo" value="{{ $element->titulo}}" required>

                          </div>

                          {{-- Descripción  --}}

                          <div class="input-group mb-3">
                            
                            <div class="input-group-append">
                              
                              <span class="input-group-text">Descripción</span>

                            </div>

                            <textarea class="form-control" rows="5" name="descripcion" required>{{$element->descripcion}}</textarea>

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
                              
                            {{-- Cambiar Logo --}}

                            <div class="form-group my-2 text-center">
                              
                              <div class="btn btn-default btn-file mb-3">
                                
                                <i class="fas fa-paperclip"></i> Adjuntar Imagen de Logo

                                <input type="file" name="logo">

                                <input type="hidden" name="logo_actual" value="{{$element->logo}}">

                              </div>

                              <br>

                              <img src="{{url('/')}}/{{$element->logo}}" class="img-fluid img-icono py-2 bg-secondary previsualizarImg_logo">

                              <p class="help-block small mt-3">Dimensiones: 700px * 200px | Peso Max. 2MB | Formato: JPG o PNG</p>

                            </div>

                            <hr class="pb-2">

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

@if (Session::has("no-validacion"))

  <script>
    notie.alert({
      type: 2,
      text: '¡Hay campos no válidos en el formulario!',
      time: 7
    })
  </script>

@endif

@if (Session::has("no-validacion-imagen"))

  <script>
    notie.alert({
      type: 2,
      text: '¡Alguna de las imágenes no tiene el formato correcto!',
      time: 7
    })
  </script>

@endif

@if (Session::has("error"))

  <script>
    notie.alert({
      type: 3,
      text: '¡Error en el gestor de blog!',
      time: 7
    })
  </script>

@endif

@if (Session::has("ok-editar"))

  <script>
    notie.alert({
      type: 1,
      text: '¡El blog ha sido actualizado correctamente!',
      time: 7
    })
  </script>

@endif

@endsection

{{--CONDICIONES PARA QUE NO IRRUMPAN LOS USUARIOS EN LAS PAGINAS
  DE ADMINISTRADORES--}}

    @elseif ($element->rol == "editor")

    <script>window.location="{{url('/asignaciones')}}"</script>

    @else

    <script>window.location="{{url('/perfil')}}"</script>

    @endif

  @endif

@endforeach 
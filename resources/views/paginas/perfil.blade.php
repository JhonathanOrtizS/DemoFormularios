@foreach ($administradores as $key => $element)

  @if (isset($_COOKIE["email_login"]) && $_COOKIE["email_login"] == $element->email)
               
    @if ($element->rol == "usuario")

@extends('plantilla')

@section('content')

<div class="content-wrapper" style="min-height: 247px;">

  <section class="content-header">

    <div class="container-fluid">

      <div class="row mb-2">

        <div class="col-sm-6">

          <h1>Perfil</h1>

        </div>

        <div class="col-sm-6">

          <ol class="breadcrumb float-sm-right">

            <li class="breadcrumb-item"><a href="{{url('/')}}">Inicio</a></li>

            <li class="breadcrumb-item active">Perfil </li>

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

                <h4 class="modal-title">Datos Personales </h4>

                <button class="btn btn-primary btn-sm bg-white" data-toggle="modal" data-target="#editarUsuario"> 
                  <i class="fa-solid fa-pen-to-square iconEdit"></i>
                </button>

                <!-- <a href="{{url('/')}}/{{$element->id}}" class="btn btn-warning btn-sm ">
                    Editar
                </a> -->

              </div>

              <div class="card-body">
               
                <div class="row">
                    @foreach ($blog as $key => $data)
                    @endforeach

                    <!-- IMAGEN -->
                    <div class="col-lg-5">
                        
                        <div class="card">

                            <div class="card-body">
                        
                                <div class="row">
                                
                                <div class="col-lg-12">
                                    
                                    {{-- FOTOGRAFIA --}}

                                    <div class="form-group my-2 text-center imgPerfil">
                                    
                                        @if ($element->foto == "")

                                            <img src="{{url('/')}}/img/admin/admin.png" class="img-circle elevation-2" alt="User Image">

                                        @else

                                            <img src="{{url('/')}}/{{$element->foto}}" class="img-circle elevation-2" alt="User Image">

                                        @endif

                                    </div>

                                    <hr class="pb-2">

                                </div>

                                </div>
                                
                            </div>
            
                        </div>
                        
                    </div>
                    <!-- IMAGEN -->
                  
                    <!-- DATOS PERSONALES -->
                    <div class="col-lg-7">
                        
                        <div class="card">

                            <div class="card-body">


                            {{-- NOMBRE  --}}

                            <div class="row mb-3 datosPersonales">

                                <ol class="breadcrumb float-sm-right bg-white">

                                    <li class="breadcrumb-item"><a >Nombre</a></li>

                                    <li class="breadcrumb-item active"> {{ $element->name }} </li>

                                </ol>

                            </div>

                            {{-- EMAIL  --}}

                            <div class="row mb-3 datosPersonales">
                                
                                <ol class="breadcrumb float-sm-right bg-white">

                                    <li class="breadcrumb-item"><a >Email</a></li>

                                    <li class="breadcrumb-item active"> {{ $element->email }} </li>

                                </ol>

                            </div>

                            {{-- ROL  --}}

                            <div class="row mb-3 datosPersonales">
                                
                                <ol class="breadcrumb float-sm-right bg-white">

                                    <li class="breadcrumb-item"><a >Rol</a></li>

                                    <li class="breadcrumb-item active"> {{ $element->rol }} </li>

                                </ol>

                            </div>


                        </div>

                    </div>
                    <!-- DATOS PERSONALES -->

                </div>

              </div>

            </div>
            <!-- /.card -->

        </div>

      </div>

    </div>

  </section>
  <!-- /.content -->


  
  <section class="content">

    <div class="container-fluid">

      <div class="row">

        <div class="col-12">

            <!-- Default box -->
            <div class="card">

              <div class="modal-header bg-info">

                <h4 class="modal-title"> Informe de Evaluaciones </h4>

              </div>

              <div class="card-body">
               
                <div class="row">

                    <?php
                      $arrCont = [];
                      $cont = 0;
                      $cont1 = 0;
                      $cont2 = 0;

                      foreach ($asignaciones as $i => $asig){

                        if ($element['id'] == $asig['evaluador'] && $asig['estatus'] == '0'){
                          //EVALUACIONES PENDIENTES
                          $cont++;
                          //echo '<script> alert("'.$element['id'].'"); </script>';

                        } 
                        
                        if ($element['id'] == $asig['user_id'] && $asig['estatus'] == '1'){
                          //EVALUACIONES REALIZADAS
                          $cont1++;
                        
                        }

                        if ($element['id'] == $asig['evaluador']){
                          //EVALUACIONES ASIGNADAS
                          $cont2++;
                        
                        }
                        

                      }

                      //array_count_values($arrCont);
                      //print_r($arrCont);
                      
                    ?>

                    <!-- EVALUACIONES -->
                    <div class="col-lg-5">
                        
                        <div class="card">
                            
                            <div class="modal-header bg-blue">

                              <h4 class="modal-title titleEvaluacion">Evaluaciones </h4>

                            </div>

                            <div class="modal-body bodyEvaluacion">

                              <div class="row">

                                <div class="col-lg-4">

                                  <div class="">
  
                                    <p>Pendientes</p>
                                    <h3 class="modal-title"> {{$cont}} </h3>
                                    
                                  </div>
  
                                </div>
  
                                <div class="col-lg-4">
  
                                  <div class="">
                                    
                                    <p>Realizadas</p>
                                    <h3 class="modal-title"> {{$cont1}} </h3>
                                    
                                  </div>
  
                                </div>

                                <div class="col-lg-4">
  
                                  <div class="">
                                    
                                    <p>Asignadas</p>
                                    <h3 class="modal-title"> {{$cont2}} </h3>
                                    
                                  </div>
  
                                </div>

                              </div>

                            </div>

                        </div>
                        
                    </div>
                    <!-- EVALUACIONES -->
                    
                  
                    <!-- PROMEDIO -->
                    <div class="col-lg-3">
                        
                        <div class="card">
                            
                            <div class="modal-header bg-green">

                              <h4 class="modal-title titleEvaluacion">Promedio </h4>

                            </div>

                            <div class="modal-body bodyEvaluacion">

                              <div class="col-lg-12">
  
                                <div class="">
                                  
                                  <p>Promedio de Evaluaciones</p>
                                  <h3 class="modal-title"> {{$cont2}} </h3>
                                  
                                </div>

                              </div>

                            </div>

                        </div>
                        
                    </div>
                    <!-- PROMEDIO -->
                    
                    

                </div>

              </div>

            </div>
            <!-- /.card -->

        </div>

      </div>

    </div>

  </section>



</div>


<!--===================================
SECCION PARA MOSTRAR EVALUACIONES
====================================-->



<!--=====================================
MODAL EDITAR USUARIO
======================================-->

<div class="modal" id="editarUsuario">
 
  <div class="modal-dialog">
   
    <div class="modal-content">

      <form method="POST" action="{{url('/')}}/perfil/{{$element['id']}}">
        @method('PUT')
        @csrf
      
        <div class="modal-header bg-info">
          
          <h4 class="modal-title">Editar Usuario</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>

        </div>

        <div class="modal-body">

            {{-- Nombre --}}

            <div class="input-group mb-3">
              
              <div class="input-group-append input-group-text">               
                 <i class="fas fa-user"></i>
              </div>

              <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $element['name'] }}" required autocomplete="name" autofocus placeholder="Nombre">

              @error('name')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror

            </div>

            {{-- Email --}}

            <div class="input-group mb-3">
              
              <div class="input-group-append input-group-text">               
                 <i class="fas fa-envelope"></i>
              </div>

              <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $element['email'] }}" required autocomplete="email" placeholder="Email">

              @error('email')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror

            </div>

            {{-- Password --}}

            <div class="input-group mb-3">
              
              <div class="input-group-append input-group-text">               
                 <i class="fas fa-key"></i>
              </div>

              <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password" placeholder="Contraseña mínimo de 8 caracteres">

              @error('password')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror

            </div>
            <input type="hidden" name="password_actual" value="{{$element['password']}}">

            {{-- Foto --}}
            <hr class="pb-2">

            <div class="form-group my-2 text-center">
            
              <div class="btn btn-default btn-file">
                
                <i class="fas fa-paperclip"></i> Adjuntar Foto

                <input type="file" name="foto">

              </div> 

              <br>

              @if ($element["foto"] == "")

                <img src="{{url('/')}}/img/admin/admin.png" class="previsualizarImg_foto img-fluid py-2 w-25 rounded-circle">
                
              @else 

                <img src="{{url('/')}}/{{$element['foto']}}" class="previsualizarImg_foto img-fluid py-2 w-25 rounded-circle">

              @endif

              <input type="hidden" value="{{$element['foto']}}" name="imagen_actual">

              <p class="help-block small">Dimensiones: 200px * 200px | Peso Max. 2MB | Formato: JPG o PNG</p>

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






<!--===================================
SESSIONES
====================================-->
@if (Session::has("no-validacion"))

  <script>
    notie.alert({
      type: 2,
      text: '¡Hay campos no válidos en el formulario!',
      time: 7
    })
  </script>

@endif

@if (Session::has("no-validacion-Img"))

  <script>
    notie.alert({
      type: 2,
      text: '¡Alguna imágen no tiene el formato correcto!',
      time: 7
    })
  </script>

@endif

@if (Session::has("error"))

  <script>
    notie.alert({
      type: 3,
      text: '¡Error en el gestor de Perfil!',
      time: 7
    })
  </script>

@endif

@if (Session::has("ok-editar"))

  <script>
    notie.alert({
      type: 1,
      text: '¡El Perfil ha sido actualizado correctamente!',
      time: 7
    })
  </script>

@endif

@endsection

{{--CONDICIONES PARA QUE NO IRRUMPAN LOS USUARIOS EN LAS PAGINAS
  DE ADMINISTRADORES--}}

    @else

    <script>window.location="{{url('/perfil')}}"</script>

    @endif

  @endif

@endforeach 
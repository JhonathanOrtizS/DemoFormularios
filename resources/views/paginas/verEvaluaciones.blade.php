
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

          <!-- Evaluaciones Asignadas -->
          <div class="card">

            <div class="modal-header bg-dark">

              <h3 class="modal-title">Evaluaciones Asignadas</h3>

            </div>
            
            
            <!-- /.card-body-->
            <div class="card-body">
              
              {{--  TABLA PARA MOSTRAR EVALUACIONES ASIGNADAS  --}}
                <table class="
                table table-responsive table-striped dt-responsive  dtr-inline
                " width="100%" id="">
                
                  <thead>
  
                    <tr>
                      
                      <th>#</th>
                      <th> Evaluación </th>
                      <th> Observaciones </th>
                      <th> Fecha Asig. </th>
                      <th> Estatus </th>
                      <th> Acciones </th>
  
                    </tr>              
  
                  </thead>
  
                  <tbody>
                      @php
                      $key = 0;
                      @endphp
                      

                        @foreach ($usuarios as $key => $element)

                          @if (isset($_COOKIE["email_login"]) && $_COOKIE["email_login"] == $element->email)

                            @foreach ($asignaciones as $i => $asig)

                              @if ($element->id == $asig['evaluador'])
                              {{--  Se deja como usuario evaluador para mostrar las evaluaciones asignadas
                                    esto determina la evaluación que debe realizar el usuario logueado --}}
                              <tr>

                                <td>{{ $key-1 }}</td>
                                {{--  <td>{{ $asig['evaluacion_id'] }}</td>  --}}

                                  @foreach ($evaluaciones as $k => $eva)
                                    @if ($asig['evaluacion_id'] == $eva['id_evaluacion'])
                                      <td>{{ $eva['titulo_evaluacion'] }}</td>
                                    @endif
                                  @endforeach
                                
                                <td>{{ $asig['observaciones'] }}</td>
                                <td>{{ $asig['fecha_asignacion'] }}</td>

                                  @if ($asig['estatus'] == 0)
                                    <td> Pendiente </td> 
                                    <td>
                                      <form method="post" action="{{ url('/searchEva') }}">
                                      @csrf
                                    
                                          <input hidden type="text" class="form-control" name="query" value="{{ $asig['id_asignacion'] }}" required>

                                          <div>
                                            <button type="submit" class="btn btn-warning btn-sm">
                                              <i class="fas fa-pencil-alt text-white"></i>
                                            </button>
                                          </div>

                                        </div>

                                      </form>
                                    </td>   
                                  @endif
                                  @if ($asig['estatus'] == 1)
                                    <td> Completa </td>
                                    <td>  
                                      <div class="btn-group">
								
                                        <a  class="btn  btn-sm">
                                          <i class="fa-solid fa-check text-success"></i>
                                        </a>

                                        <form action="{{ url('/searchEva') }}" method="post">
                                          @csrf
                                          <input type="text" class="form-control"  value="{{$asig['id_asignacion']}}" name="query" required hidden>
                                          <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa-solid fa-eye"></i>
                                          </button>

                                        </form>

                                      </div>
                                    </td>
                                  </tr>
                                  @endif

                                  @php
                                  $key++;
                                  @endphp
                                  
                              @endif

                            @endforeach    

                          @endif

                        @endforeach
  
                  </tbody>
  
                </table>
                {{--  TABLA PARA MOSTRAR EVALUACIONES ASIGNADAS  --}}

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





  <!--=====================================
  Realizar Evaluaciones
  ======================================-->

  @if (isset($status))

    @if ($status == 200)

      @foreach ($asignacion as $key => $asigna)
    
      <div class="modal fade" id="realizarEvaluacion" tabindex="-1" role="dialog"
      aria-labelledby="realizarEvaluacion" aria-hidden="true">

        <div class="modal-dialog modal-lg " role="document">

          <div class="modal-content">
            
            {{--  FORMULARIO PARA CAPTURAR RESPUESTAS  --}}
            <form action="{{url('/')}}/verEvaluaciones" method="post" enctype="multipart/form-data">
            @csrf

              <input type="text" class="form-control" name="idAsignacion" value="{{$asigna->id_asignacion}}" readonly hidden> 
              <div class="modal-header bg-info">
                
                <h4 class="modal-title">Resolver Evaluación</h4>

                <button type="button" class="close" data-dismiss="modal">&times;</button>

              </div>

              <div class="modal-body">

                <div class="col-8">

                  {{-- Asignar Usuario a Evaluar --}}
                  <label for="">Usuario a evaluar</label> <br>
                  <div class="input-group mb-3">
                  
                    <div class="input-group-append input-group-text">
                        <i class="fa-solid fa-user"></i>
                    </div>

                    @foreach ($administradores as $kay => $data)

                      @if ($asigna->user_id == $data->id)
                    
                        <input type="text" class="form-control" name="idUser" value="{{$data->id}}" readonly hidden>     
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
                    
                    @foreach ($evaluaciones as $i => $eva)
                      @if ($asigna->evaluacion_id == $eva['id_evaluacion'])
                        <input type="text" class="form-control" name="idEvaluacion" value="{{$eva->id_evaluacion}}" readonly hidden required> 
                        <input type="text" class="form-control" name="name" placeholder="Evaluación" value="{{$eva->titulo_evaluacion}}" readonly> 
                      @endif
                    @endforeach
                    
                  </div> 

                  {{-- Obsercaciones de la Asignación --}}
                  <label for="">Observaciones</label> <br>
                  <div class="input-group mb-3">
            
                    <div class="input-group-append input-group-text">
                      <i class="fas fa-pencil-alt"></i>
                    </div>

                    <textarea class="form-control" rows="2" name="observaciones" required readonly
                    placeholder="Ingrese una observación de la Evaluación"
                    maxlength="255"
                    >{{$asigna['observaciones']}}</textarea>

                  </div> 

                  {{-- Asignar Evaluador --}}
                  <label for="query">Usuario evaluador.</label>
                  <div class="input-group mb-3">

                    <div class="input-group-append input-group-text">
                        <i class="fa-solid fa-user-tie"></i>
                    </div>

                    <!-- <input type="text" class="form-control" name="id_usuario" placeholder="Asigne usuario a evaluar" value="{{$asigna->evaluador}}" hidden readonly> -->

                    @foreach ($administradores as $key => $evaluador)
                    
                      @if ($asigna['evaluador'] == $evaluador->id)

                        <input type="text" class="form-control" name="evaluador" placeholder="Asigne usuario evaluador" value="{{$evaluador['name']}}" readonly> 

                      @endif

                    @endforeach

                  </div>

                </div>
                
              </div>


              {{--  EVALUACION  --}}
              <div class="modal-body">

                <div class="col-12">

                  <!-- Evaluaciones Asignadas -->
                  <div class="card">
        
                    <div class="modal-header bg-dark">
  
                      @foreach ($evaluaciones as $i => $eva)
                        @if ($asigna->evaluacion_id == $eva['id_evaluacion'])
                          <h3 class="modal-title">Tipo de Evaluación: <span class="text-blue"> {{$eva->titulo_evaluacion}} </span> </h3>
                        @endif
                      @endforeach
        
                    </div>
                    
                    
                    <!-- /.card-body-->
                    <div class="card-body">
                      
                      {{--  TABLA PARA MOSTRAR EVALUACIONES ASIGNADAS  --}}
                        <table class="
                        table table-responsive table-striped dt-responsive  dtr-inline
                        " width="100%" id="">
                        
                          <thead>
                            <tr>
                              
                              <th># </th>
                              <th> Indicador </th>
                              <th> Pregunta </th>
                              <th> Respuestas </th>
          
                            </tr>              
                          </thead>
          
                          <tbody>
                              
                            @php
                            $cont = 0;
                            @endphp

                              {{--  CICLO PARA VER EVALUACIONES  --}}
                              @foreach ($evaluaciones as $i => $eva)
                                @if ($asigna->evaluacion_id == $eva['id_evaluacion'])

                                  {{--  CICLO PARA VER INDICADORES  --}}
                                  @foreach ($indicadores as $ind => $indicador)
  
                                      @if ($eva->id_evaluacion == $indicador->evaluacion_id)

                                          {{--  CICLO PARA VER PREGUNTAS  --}}
                                          @foreach ($preguntas as $pre => $pregunta)

                                              @if ($pregunta['indicador_id'] == $indicador->id_indicador)

                                                  {{--  CICLO PARA VER RESPUESTAS  --}}
                                                  @foreach ($respuestas as $resp => $respuesta)

                                                      @if ($pregunta->respuesta_id == $respuesta->id_respuesta)


                                                          <tr>
                                                            <td> {{++$cont}} </td>

                                                            <td>
                                                              {{$indicador->titulo_indicador}}
                                                              <input class="form-control" name="resIndicador[]" value="{{$indicador->id_indicador}}" hidden>
                                                            </td>

                                                            <td>
                                                              {{$pregunta->pregunta}}
                                                              <input class="form-control" name="resPregunta[]" value="{{$pregunta->id_pregunta}}" hidden>
                                                            </td>

                                                            <td>
                                                                @php
                                                                  $tags = json_decode($respuesta->p_respuestas, true);

                                                                  $palabras = '<div>';
                                                        
                                                                  foreach ($tags as $key => $value) {
                                                                      $palabras .= '<div class="form-check form-check-inline id="'.$pregunta->id_respuesta.'">
                                                                      <input class="form-check-input" type="checkbox" name="respuesta[]" style="width:25px;height:25px" value="'.$cont.'" id="inlineCheckbox">
                                                                      <label class="form-check-label" for="inlineCheckbox">'.$value.'</label> 
                                                                      </div>';
                                                                  }
                                                                  $palabras .= '</div>';
                                                                  echo $palabras;
                                                                @endphp

                                                            </td>
                                                          </tr>
                                                        
                                                          
                                                      @endif
                                                      
                                                  @endforeach
                                                  {{--  CICLO PARA VER RESPUESTAS  --}}
                                              @endif
                                              
                                          @endforeach
                                          {{--  CICLO PARA VER PREGUNTAS  --}}
                                      @endif

                                  @endforeach
                                  {{--  CICLO PARA VER INDICADORES  --}}
                                @endif

                              @endforeach
                              {{--  CICLO PARA VER EVALUACIONES  --}}
        
                          </tbody>
          
                        </table>
                        {{--  TABLA PARA MOSTRAR EVALUACIONES ASIGNADAS  --}}
        
                      </div>
        
                    </div>
                    <!-- /.card-body-->
        
                  </div>
                  <!-- Evaluaciones Asignadas -->
        
                </div>

              </div>
              {{--  EVALUACION  --}}


              {{--  BOTONES  --}}
              <div class="modal-footer d-flex justify-content-between bg-white">
                
                <div>
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>

                <div>
                  <button type="submit" class="btn btn-primary">Guardar</button>
                </div>

              </div>
              {{--  BOTONES  --}}

            </form>
            {{--  FORMULARIO PARA CAPTURAR RESPUESTAS  --}}

          </div>
          
        </div>

      </div>

      @endforeach

      <script>$("#realizarEvaluacion").modal()</script>

    @endif

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
        notie.alert({ type: 1, text: '¡La Evaluación ha sido terminada correctamente!', time: 10 })
  </script>

  @endif

  @if (Session::has("no-borrar"))

    <script>
        notie.alert({ type: 3, text: '¡Error al eliminar la Categoria!', time: 10 })
  </script>

  @endif

  @endsection

  
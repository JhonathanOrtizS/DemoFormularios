@extends('plantilla')

@section('content')

<div class="content-wrapper" style="min-height: 247px;">

  <section class="content-header">

    <div class="container-fluid">

      <div class="row mb-2">

        <div class="col-sm-6">

          <h1>Indicadores</h1>

        </div>

        <div class="col-sm-6">

          <ol class="breadcrumb float-sm-right">

            <li class="breadcrumb-item"><a href="{{url('/')}}">Inicio</a></li>

            <li class="breadcrumb-item active">Indicadores</li>

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

              <h3 class="modal-title">Crear Nuevo Indicador</h3> 

              <div class="modal-tools">

                <button class="btn btn-primary btn-sm bg-white" data-toggle="modal" data-target="#crearIndicador"> 
                  <i class="fa-solid fa-plus"></i>
                </button>

              </div>

            </div>

            <div class="card-body">
              {{--
              @foreach ($categorias as $element)
                  {{ $element }}
                @endforeach --}}

                <table class="
                table table-bordered table-striped dt-responsive dataTable no-footer dtr-inline
                " width="100%" id="tablaIndicadores">
                
                  <thead>
  
                    <tr>
                      
                      <th>#</th>
                      <th>Evaluación</th>
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
Crear Indicadores
======================================-->
<div class="modal" id="crearIndicador">

  <div class="modal-dialog">

    <div class="modal-content">

      <form action="{{url('/')}}/indicadores" method="post" enctype="multipart/form-data">

       @csrf
        
        <div class="modal-header bg-info">
          
          <h4 class="modal-title">Crear Indicador</h4>

          <button type="button" class="close " data-dismiss="modal">&times;</button>

        </div>

        <div class="modal-body">

          {{-- SELECCION DE EVALUACION --}}

          <div class="input-group mb-3">

            <div class="input-group-append input-group-text">
              <i class="fas fa-list-ul"></i>
            </div>

            <select class="form-control"  name="id_evaluacion" required>

              <option value=""  selected>Seleccione Evaluación</option>

              @foreach ($evaluaciones as $key => $value2)
              
                <option value="{{$value2->id_evaluacion}}">{{$value2->titulo_evaluacion}}</option>

              @endforeach

            </select>

          </div> 

          <hr class="pb-2">
          
           {{-- Título Indicador --}}

           <div class="input-group mb-3">

            <div class="input-group-append input-group-text">
              <i class="fas fa-list-ul"></i>
            </div>

            <input type="text" class="form-control" name="titulo_indicador" placeholder="Ingrese el título del indicador" value="{{old("titulo_indicador")}}" required> 

          </div> 

          {{-- Descripcion del Indicador --}}

          <div class="input-group mb-3">
     
            <div class="input-group-append input-group-text">
              <i class="fas fa-pencil-alt"></i>
            </div>

            <!-- <input type="text" class="form-control" name="descripcion_indicador" placeholder="Ingrese la descripción del indicador" value="{{--old("descripcion_indicador")--}}" maxlength="255" required> -->
            <textarea class="form-control" rows="5" name="descripcion_indicador" required value="{{old("descripcion_indicador")}}"
            placeholder="Ingrese la descripción del indicador"
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
Editar Indicadores
======================================-->

@if (isset($status))

  @if ($status == 200)

    @foreach ($indicador as $key => $value)
  
      <div class="modal" id="editarIndicador">

        <div class="modal-dialog">

          <div class="modal-content">

            <form action="{{url('/')}}/indicadores/{{$value->id_indicador}}" method="post" enctype="multipart/form-data">

              @method('PUT')

              @csrf
              
              <div class="modal-header bg-info">
                
                <h4 class="modal-title">Editar Indicador</h4>

                <button type="button" class="close dark" data-dismiss="modal">&times;</button>

              </div>

              <div class="modal-body">

                {{-- SELECCION DE EVALUACION --}}
                <label>Elegir Evaluación</label> <br>
                <div class="input-group mb-3">

                  <div class="input-group-append input-group-text">
                    <i class="fas fa-list-ul"></i>
                  </div>

                  <select class="form-control"  name="id_evaluacion" required>

                    @foreach ($evaluaciones as $key => $value2)

                      @if ($value2->id_evaluacion == $value->evaluacion_id)
                        <option value="{{$value2->id_evaluacion}}" selected>{{$value2->titulo_evaluacion}}</option>
                      @endif

                      <option value="{{$value2->id_evaluacion}}" >{{$value2->titulo_evaluacion}}</option>

                    @endforeach

                  </select>

                </div> 

                <hr class="pb-2">
                
                
                {{-- Título Indicador --}}
                <label>Título del Indicador</label> <br>
                <div class="input-group mb-3">

                  <div class="input-group-append input-group-text">
                    <i class="fas fa-list-ul"></i>
                  </div>

                  <input type="text" class="form-control" name="titulo_indicador" placeholder="Ingrese el título del indicador" value="{{$value->titulo_indicador}}" required>

                </div> 

                {{-- Descripción Indicador --}}
                <label>Descripción del Indicador</label> <br>
                <div class="input-group mb-3">
           
                  <div class="input-group-append input-group-text">
                    <i class="fas fa-pencil-alt"></i>
                  </div>

                  <textarea class="form-control" rows="5" name="descripcion_indicador" required>{{$value->descripcion_indicador}}</textarea>

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

    <script>$("#editarIndicador").modal()</script>

  @endif

@endif



@if (Session::has("ok-crear"))

  <script>
      notie.alert({ type: 1, text: '¡Indicador creado con Exito!', time: 10 })
 </script>

@endif

@if (Session::has("no-validacion"))

<script>
    notie.alert({ type: 2, text: '¡Hay campos no válidos en el formulario!', time: 10 })
</script>

@endif

@if (Session::has("error"))

  <script>
      notie.alert({ type: 3, text: '¡Error en el gestor de Indicadores!', time: 10 })
 </script>

@endif

@if (Session::has("ok-editar"))

  <script>
      notie.alert({ type: 1, text: '¡El Indicador ha sido actualizado correctamente!', time: 10 })
 </script>

@endif

@if (Session::has("no-borrar"))

  <script>
      notie.alert({ type: 3, text: '¡Error al eliminar el Indicador!', time: 10 })
 </script>

@endif

@endsection
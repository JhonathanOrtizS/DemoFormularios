
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

          <!-- Evaluaciones Asignadas -->
          <div class="card">

            <div class="modal-header bg-dark">

              <h3 class="modal-title">Tramites Asignados</h3>

            </div>
            
            
            <!-- /.card-body-->
            <div class="card-body">
              
              {{--  TABLA PARA MOSTRAR TRAMITES ASIGNADOS  --}}

              @foreach($administradores as $key => $element)
                @if (isset($_COOKIE["email_login"]) && $_COOKIE["email_login"] == $element->email)
                  @foreach($asignaciones as $i => $asig)

                    @if ($element->id == $asig['user_id'])
                    {{--  Se deja verifica a que usuario se asigno el tramite para mostrar
                      solo el tramite asignado al usuario que se esta logueando  --}}

                <table class="
                table table-responsive table-striped dt-responsive  dtr-inline
                " width="100%" id="verTramiteAsignado">
                
                  <thead>
  
                    <tr>
                      
                      <th>#</th>
                      <th> Tramite </th>
                      <th> Contacto </th>
                      <th> Observaciones del Tramite</th>
                      <th> Fecha Asignación </th>
                      <th> Estatus </th>
                      <th> Acciones </th>
  
                    </tr>              
  
                  </thead>
  
                  <tbody>
                      
  
                  </tbody>
  
                </table>

                      @endif
                      @endforeach
                @endif
                @endforeach
                {{--  TABLA PARA MOSTRAR TRAMITES ASIGNADOS  --}}

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


  @if (Session::has("no-validacion"))

  <script>
      notie.alert({ type: 2, text: '¡Hay campos no válidos en el formulario!', time: 10 })
  </script>

  @endif

  @endsection

  
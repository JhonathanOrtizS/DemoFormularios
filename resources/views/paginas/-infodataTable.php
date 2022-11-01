<!-- 
    aca este es el codigo para mostrar la información en la tabla DataTable
    pero da problema al dejarlo comentado por el decorador de codigo laravel
    aunque quede comnetado, sigue funcionando los comandos,
    se tiene que removerlo para que trabaje la petición ajax
    de donde se imprime los datos que vienen del servidor
-->

<table class="table table-bordered table-striped dt-responsive" width='100%'
              id="tablaAdmin">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th width="50px">Foto</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                  </tr>
                </thead>

                <tbody>
                  
                  
                    @foreach ($administradores as $key => $ele)
                    <tr>

                      <td>{{$key+1}}</td>
                      <td>{{$ele['name']}}</td>
                      <td>{{$ele['email']}}</td>

                      @php
                          if ($ele['foto'] == "") {
                            
                            echo '
                            <td> 
                              <img src="'.url('/').'/img/admin/user_p.png" alt="" class="img-fluid rounded-circule">
                            </td>
                            ';
                          } else {
                            
                            echo '
                            <td> 
                              <img src="'.url('/') .'/'. $ele['foto'] .'" alt="" class="img-fluid rounded-circule">
                            </td>
                            ';
                          }
                      @endphp
                          
                      <td>{{$ele['rol']}}</td>
                      <td>
                        <div class="btn-group">

                          <a href="{{url('/')}}/administradores/{{$ele['id']}}" class="btn btn-warning btn-sm">
                            <i class="fa-solid fa-user-pen"></i>
                          </a>

                          <button type="submit" class="btn btn-warning btn-sm eliminarRegistro" action="{{url('/')}}/administradores/{{$ele['id']}}"
                          method="DELETE"  token="" pagina="administradores">
                          @csrf
                              
                            <i class="fa-solid fa-circle-xmark"></i>

                          </button>

                          {{--
                          <form action="{{url('/')}}/administradores/{{$ele['id']}}" method="POST">
                            @method('DELETE')
                            @csrf
                          
                              tambien se puede 
                              <input type="hidden" name="_method" value="DELETE">
                              
                              

                            <button type="submit" class="btn btn-danger btn-sm" >
                              
                              <i class="fa-solid fa-circle-xmark"></i>

                            </button>

                          </form>
                          --}}
                   {{--       
                        </div>
                      </td>

                    </tr>
                    @endforeach 

                </tbody>

              </table>
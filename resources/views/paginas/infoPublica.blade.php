@foreach ($administradores as $element)
 
  @if (isset($_COOKIE["email_login"]) && $_COOKIE["email_login"] == $element->email)
               
     @if ($element->rol == "usuario")


@extend s('plantilla')
    


@section('content')
 
    

<!-- -->

<!--- CONTENIDO DEL FORMULARIO -->

<!-- -->


@if (Session::has("no-validacion"))

  <script>

    notie.alert({
      type: 2,
       text: '¡Hay campos no válid
    o
s en el formulario!',
      time: 7
    })
   </script>
    


@endif
 
    

@if (Session::has("no-validacion-imagen"))

   <script>
    

    notie.alert({
      type: 2,
       text: '¡Alguna de las i
    m
ágenes no tiene el formato correcto!',
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
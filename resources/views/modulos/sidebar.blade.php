
<aside class="main-sidebar sidebar-dark-primary elevation-4" style="overflow-x:hidden">
    
    <!-- Brand Logo -->
    <a href="{{url('/')}}" class="brand-link">
      <img src="{{url('/')}}/{{$blog[1]['logo']}}" alt="AdminLTE Logo" class="brand-image elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">EVA-180</span>
      @php
          //print_r($blog[1]['logo']);
      @endphp
    </a>

    <!-- Sidebar -->
    <div class="sidebar os-host os-theme-light os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-scrollbar-horizontal-hidden os-host-transition"><div class="os-resize-observer-host"><div class="os-resize-observer observed" style="left: 0px; right: auto;"></div></div><div class="os-size-auto-observer" style="height: calc(100% + 1px); float: left;"><div class="os-resize-observer observed"></div></div><div class="os-content-glue" style="margin: 0px -8px; width: 249px; height: 296px;"></div><div class="os-padding"><div class="os-viewport os-viewport-native-scrollbars-invisible" style="overflow-y: scroll;"><div class="os-content" style="padding: 0px 8px; height: 100%; width: 100%;">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">

          @foreach ($administradores as $element)

            @if ($_COOKIE["email_login"] == $element->email)
              
              @if ($element->foto == "")

                 <img src="{{url('/')}}/img/admin/admin.png" class="img-circle elevation-2 img-fluid" alt="User Image">

              @else

                <img src="{{url('/')}}/{{$element->foto}}" class="img-circle elevation-2 img-fluid" alt="User Image">

              @endif


            @endif
           
         @endforeach 
          
          
        </div>

        
        <div class="info">
          <a href="#" class="d-block">

            @foreach ($administradores as $element)

                @if ($_COOKIE["email_login"] == $element->email)
                  {{$element->name}}

                @endif
              
            @endforeach 
            
          </a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">

        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
         
          @foreach ($administradores as $element)

                @if ($_COOKIE["email_login"] == $element->email)
                  
                  @if ($element->rol == 'administrador')

                      <!--=====================================
                      Botón Blog
                      ======================================-->

                      <li class="nav-item">
                        <a href="{{ url('/') }}" class="nav-link">
                          <i class="nav-icon fas fa-home"></i>
                          <p>Blog</p>
                        </a>
                      </li>

                      <!--=====================================
                      Botón Administradores
                      ======================================-->

                      <li class="nav-item">
                        <a href="{{ url('/administradores') }}" class="nav-link">
                          <i class="nav-icon fas fa-users-cog"></i>
                          <p>Administradores</p>
                        </a>
                      </li>

                      <!--=====================================
                      Botón Asignaciones
                      ======================================-->

                      <li class="nav-item">
                        <a href="{{ url('/asignacion_tramite') }}" class="nav-link">
                          <i class="nav-icon fa-solid fa-pen-to-square"></i>
                          <p>Asignaciones Tramites</p>
                        </a>
                      </li>
                      
                      <!--=====================================
                      Botón Tramites
                      ======================================-->

                      <li class="nav-item">
                        <a href="{{ url('/tramites') }}" class="nav-link">
                          <i class="nav-icon fa-solid fa-sheet-plastic"></i>
                          <p>Tramites</p>
                        </a>
                      </li>
                  
                  @else

                      <!--=====================================
                      Perfil
                      ======================================-->

                      <li class="nav-item">
                        <a href="{{ url('/perfil') }}" class="nav-link">
                          <i class="nav-icon fa-solid fa-user"></i>
                          <p>Perfil</p>
                        </a>
                      </li>

                      <!--=====================================
                      Botón Tramites
                      ======================================-->

                      <li class="nav-item">
                        <a href="{{ url('/verTramites') }}" class="nav-link">
                          <i class="nav-icon fa-solid fa-sheet-plastic"></i>
                          <p>Tramites</p>
                        </a>
                      </li>

                  @endif

                @endif
              
            @endforeach 


          <!--=====================================
          BOTÓN SITIO WEB

          <li class="nav-item">
          
            <a href="{{ substr(url('/'),0,-11) }}" class="nav-link" target="_blank">
              
              <i class="nav-icon fas fa-globe"></i>
              
              <p>Ver sitio</p>

            </a>

          </li>
          ======================================-->

          

        </ul>

      </nav>
      <!-- /.sidebar-menu -->
    </div></div></div><div class="os-scrollbar os-scrollbar-horizontal os-scrollbar-unusable os-scrollbar-auto-hidden"><div class="os-scrollbar-track"><div class="os-scrollbar-handle" style="width: 100%; transform: translate(0px, 0px);"></div></div></div><div class="os-scrollbar os-scrollbar-vertical os-scrollbar-auto-hidden"><div class="os-scrollbar-track"><div class="os-scrollbar-handle" style="height: 21.4131%; transform: translate(0px, 0px);"></div></div></div><div class="os-scrollbar-corner"></div></div>
    <!-- /.sidebar -->
  </aside>
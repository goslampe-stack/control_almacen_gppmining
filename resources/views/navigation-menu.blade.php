<nav class="main-header navbar navbar-expand-md navbar-light">
    <!-- navbar-dark navbar-gray-dark -->
    <div class="container-fluid">
        <a href="{{ route('dashboard') }}" class="navbar-brand pt-2">
            <img src="{{ asset('dist/img/goslam_viajes.jpg') }}" alt="Apolo Logo" title="Principal" class="brand-image img-circle elevation-3" style="opacity: .8">
        </a>


        <!--   <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button> -->



        <div class="collapse navbar-collapse order-3 justify-content-center pt-2" id="navbarCollapse">
            <ul class="apl-navbar-nav">
                <!--  <li class="apl-nav-item">
                    <a href="{{route('dashboard')}}" class="apl-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" title="Administrar empresas"><i class="fas fa-home fa-lg"></i> </i></a>
                </li> -->
                <!--  <li class="apl-nav-item">
                    <a href="{{ route('setting') }}" class="apl-nav-link {{ request()->routeIs('setting') ? 'active' : '' }}" "><i class="fas fa-cog fa-lg"></i></a>

                </li> -->
                <!--   <li class="nav-item">
                    @if (request()->routeIs('tiendas')||
                    request()->routeIs('tipo-unidad')||
                    request()->routeIs('tipo-unidad')||
                    request()->routeIs('personal')||
                    request()->routeIs('proveedor')||
                    request()->routeIs('usuario')||
                    request()->routeIs('orden-compra')||
                    request()->routeIs('ingreso')||
                    request()->routeIs('transporte')||
                    request()->routeIs('salida')||
                    request()->routeIs('articulo')||
                    request()->routeIs('kardex')||
                    request()->routeIs('inventario-inicial')||
                    request()->routeIs('verDetalleKardex')||
                    request()->routeIs('informacion')||
                    request()->routeIs('tienda-editar')||
                    request()->routeIs('usuario')||
                    request()->routeIs('role')||
                    request()->routeIs('permisionEdit')||
                    request()->routeIs('empresa')||

                    request()->routeIs('ventasDetalles'))

                    <a href="{{ route('informacion') }}" class="apl-nav-link active"><i class="fas fa-sitemap fa-lg"></i></a>
                    @else
                    <a href="{{ route('dashboard') }}" class="apl-nav-link "><i class="fas fa-sitemap fa-lg"></i></a>
                    @endif
                </li> -->

                <!-- <li class="nav-item">
                    <a href="#" class="apl-nav-link {{ request()->routeIs('estadisticas') ? 'active' : '' }}"><i class="fas fa-chart-line fa-lg"></i></a>
                </li>
                <li class="nav-item">
                    <a href="#" class="apl-nav-link {{ request()->routeIs('other') ? 'active' : '' }}"><i class="fas fa-users fa-lg"></i></a>
                </li> -->
            </ul>
        </div>
        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
            <!--   <li class="nav-item">
                <a class="nav-link d-md-none" href="#" data-widget="pushmenu" role="button">
                    <i class="fas fa-bars"></i>
                </a>
            </li> -->
            <li class="nav-item dropdown">
                <a class="nav-link circle " data-toggle="dropdown" href="#">
                    <i class="fas fa-user fa-lg item-circle" style="color:aliceblue"></i>

                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-header">{{ __('Administrar cuenta') }}
                        <p>{{\App\Models\Util::getUsuarioNombre()}}</p>
                    </span>
                    <div class="dropdown-divider"></div>

                    
                    <a href="{{ route('profile.show') }}" class="dropdown-item {{ request()->routeIs('profile.show') ? 'active' : '' }}">
                        <i class="fas fa-user mr-2  {{ request()->routeIs('profile.show') ? 'text-white' : 'text-blue' }}"></i> Perfil
                    </a>
             
                     <!--  @if(\App\Models\Util::esUsuario())

                   <!-- <a href="{{  route('facturacion')  }}" class="dropdown-item {{ request()->routeIs('facturacion') ? 'active' : '' }}">
                       <!-- <i class="fas fa-shipping-fast mr-2 {{ request()->routeIs('facturacion') ? 'text-white' : 'text-blue' }}"></i>Facturaci&oacute;n
                    </a>-->

                    @endif

                    <div class="dropdown-divider"></div>



                    <a href="{{  route('dashboard')  }}" class="dropdown-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-home mr-2 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-blue' }}"></i>Empresas
                    </a>

              



                    @if(\App\Models\Util::tienePermiso(\App\Models\Util::$OPCION_UNIDAD_MEDIDAD))
                    <a href="{{  route('tipo-unidad')  }}" class="dropdown-item {{ request()->routeIs('tipo-unidad') ? 'active' : '' }}">
                        <i class="fas fa-ruler mr-2 {{ request()->routeIs('tipo-unidad') ? 'text-white' : 'text-blue' }}"></i> Unidad de medida
                    </a>
                    @endif

                    @if(\App\Models\Util::tienePermiso(\App\Models\Util::$OPCION_ARTICULO))
                    <a href="{{  route('articulo') }}" class="dropdown-item {{ request()->routeIs('articulo') ? 'active' : '' }}">
                        <i class="fas fa-box mr-2 {{ request()->routeIs('articulo') ? 'text-white' : 'text-blue' }}"></i> Art&iacute;culo
                    </a>
                    @endif



                    @if(\App\Models\Util::tienePermiso(\App\Models\Util::$OPCION_TRANSPORTE))


                    <a href="{{ route('transporte')  }}" class="dropdown-item {{ request()->routeIs('transporte') ? 'active' : '' }}">
                        <i class="fas fa-truck mr-2 {{ request()->routeIs('transporte') ? 'text-white' : 'text-blue' }}"></i> Transporte
                    </a>
                    @endif


                    @if(\App\Models\Util::tienePermiso(\App\Models\Util::$OPCION_PROVEEDOR))
                    <a href="{{  route('proveedor')  }}" class="dropdown-item {{ request()->routeIs('proveedor') ? 'active' : '' }}">
                        <i class="fas fa-user-tie mr-2 {{ request()->routeIs('proveedor') ? 'text-white' : 'text-blue' }}"></i> Proveedor
                    </a>
                    @endif




                    @if(\App\Models\Util::tienePermiso(\App\Models\Util::$OPCION_USUARIOS))

                    <a href="{{  route('usuario')  }}" class="dropdown-item {{ request()->routeIs('usuario') ? 'active' : '' }}">
                        <i class="fas fa-user mr-2 {{ request()->routeIs('usuario') ? 'text-white' : 'text-blue' }}"></i> Usuarios
                    </a>


                    @endif
                    @if(\App\Models\Util::tienePermiso(\App\Models\Util::$OPCION_PERMISO_USUARIO))


                <!--     <a href="{{  route('permiso-usuario')  }}" class="dropdown-item {{ request()->routeIs('permiso-usuario') ? 'active' : '' }}">
                        <i class="fas fa-user mr-2 {{ request()->routeIs('permiso-usuario') ? 'text-white' : 'text-blue' }}"></i> Permiso Usuario
                    </a>
 -->
                    @endif

                    <!--   <a href="{{  route('role')  }}" class="dropdown-item">
                        <i class="fas fa-user mr-2"></i> Roles
                    </a>
 -->





                    @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('api-tokens.index') }}" class="dropdown-item">
                        <i class="fas fa-users mr-2"></i> {{ __('API Tokens') }}
                    </a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="dropdown-item">
                            <i class="fas fa-reply mr-2 text-blue"></i> {{ __('Cerrar sesión') }}
                        </a>
                    </form>
                </div>
            </li>
        </ul>

    </div>
</nav>
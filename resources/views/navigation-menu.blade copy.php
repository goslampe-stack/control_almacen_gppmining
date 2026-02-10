<nav class="main-header navbar navbar-expand-md navbar-light">
    <!-- navbar-dark navbar-gray-dark -->
    <div class="container-fluid">
        <a href="{{ route('dashboard') }}" class="navbar-brand pt-2">
            <img src="{{ asset('dist/img/GMaranonLogo.png') }}" alt="Apolo Logo" class="brand-image img-circle elevation-3" style="opacity: .8">


        </a>


        <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        @php
        $user = Auth::user();
        $module = $user->roles[0]->modules->sortBy('module_rank')->where('view_sidebar','=',1);

        @endphp


        <div class="collapse navbar-collapse order-3 justify-content-center pt-2" id="navbarCollapse">
            <ul class="apl-navbar-nav">
                <li class="apl-nav-item">
                    <a href="{{route('dashboard')}}" class="apl-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" title="Administrar empresas"><i class="fas fa-home fa-lg"></i> </i></a>
                </li>
               <!--  <li class="apl-nav-item">
                    <a href="{{ route('setting') }}" class="apl-nav-link {{ request()->routeIs('setting') ? 'active' : '' }}" "><i class="fas fa-cog fa-lg"></i></a>

                </li> -->
                <li class="nav-item">
                    @if (request()->routeIs('tiendas')||
                    request()->routeIs('tipo-unidad')||
                    request()->routeIs('tipo-unidad')||
                    request()->routeIs('personal')||
                    request()->routeIs('proveedor')||
                    request()->routeIs('requerimiento-personal')||
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
                </li>

                <!-- <li class="nav-item">
                    <a href="#" class="apl-nav-link {{ request()->routeIs('estadisticas') ? 'active' : '' }}"><i class="fas fa-chart-line fa-lg"></i></a>
                </li>
                <li class="nav-item">
                    <a href="#" class="apl-nav-link {{ request()->routeIs('other') ? 'active' : '' }}"><i class="fas fa-users fa-lg"></i></a>
                </li> -->
            </ul>
        </div>

        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
            <li class="nav-item">
                <a class="nav-link d-md-none" href="#" data-widget="pushmenu" role="button">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-user"></i>
                    <span class="badge text-info navbar-badge"><i class="fas fa-info-circle"></i></span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-header">{{ __('Manage Account') }}</span>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('profile.show') }}" class="dropdown-item">
                        <i class="fas fa-user mr-2"></i> {{ __('Perfil') }}
                    </a>

                    @foreach($module as $m)

                    @if($m->opcion=='otros' && $m->identity=='empresa')
                    <a href="{{ route($m->module_url) }}" class="dropdown-item">
                        <i class="fas fa-user mr-2"></i> {{$m->name}}
                    </a>

                    @endif

                    @if($m->opcion=='entrada' && $m->identity=='tipo-unidad')
                    <a href="{{ route($m->module_url) }}" class="dropdown-item">
                        <i class="fas fa-user mr-2"></i> {{$m->name}}
                    </a>

                    @endif

                    @if($m->opcion=='entrada' && $m->identity=='articulo')
                    <a href="{{ route($m->module_url) }}" class="dropdown-item">
                        <i class="fas fa-user mr-2"></i> {{$m->name}}
                    </a>

                    @endif

                    @if($m->opcion=='otros' && $m->identity=='transporte')
                    <a href="{{ route($m->module_url) }}" class="dropdown-item">
                        <i class="fas fa-user mr-2"></i> {{$m->name}}
                    </a>
                    @endif

                    @if($m->opcion=='otros' && $m->identity=='proveedor')
                    <a href="{{ route($m->module_url) }}" class="dropdown-item">
                        <i class="fas fa-user mr-2"></i> {{$m->name}}
                    </a>
                    @endif
                    @if($m->opcion=='otros' && $m->identity=='user')
                    <a href="{{ route($m->module_url) }}" class="dropdown-item">
                        <i class="fas fa-user mr-2"></i> {{$m->name}}
                    </a>
                    @endif
                    @if($m->opcion=='otros' && $m->identity=='role')
                    <a href="{{ route($m->module_url) }}" class="dropdown-item">
                        <i class="fas fa-user mr-2"></i> {{$m->name}}
                    </a>
                    @endif


                    @endforeach




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
                            <i class="fas fa-reply mr-2"></i> {{ __('Cerrar sesión') }}
                        </a>
                    </form>
                </div>
            </li>
        </ul>
    </div>
</nav>


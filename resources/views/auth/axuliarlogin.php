<x-guest-layout>
  <div class="form-shape-wrapper">
    <div class="form-shape">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 3000 185.4">
        <path fill="red" d="M3000,0v185.4H0V0c496.4,115.6,996.4,173.4,1500,173.4S2503.6,115.6,3000,0z"></path>
      </svg>
    </div>
  </div>

  <div class="form-wrapper">
    <div class="container">
      <div class="card">
        <div class="row no-gutters">
          <div class="col d-none d-lg-flex" style="background: url(plugins/latform/dist/images/cover1.jpg)">
            <div class="logo">
              <a href="{{ route('login') }}"><img src="{{ asset('plugins/latform/dist/images/logo.png') }}" alt="logo"></a>
            </div>

            <div>
              <h3 class="font-weight-bold">Goslam Viajes</h3>
              <p class="lead my-5">Nuestro sistema de logística avanzado ofrece gestión de inventarios, orden de requerimientos, orden de compras, ingresos de productos, devoluciones de productos, salidas y kardex, diseñado para mejorar la eficiencia y cumplimiento en la industria minera. ¡Transforma tu operación minera con nuestra tecnología innovadora!.</p>

             <!--  <a href="https://www.facebook.com/goslamviajes" target="_blank">
                <i class="mdi mdi-facebook"></i> Facebook
              </a>
              <a href="https://www.instagram.com/goslamviajes/" target="_blank">
                <i class="mdi mdi-instagram"></i> Instagram
              </a>
              <a href="https://www.youtube.com/@goslamviajes2151/featured" target="_blank">
                <i class="mdi mdi-youtube"></i> Youtube
              </a> -->
              <a href="https://wa.me/51920438989" target="_blank">
                <i class="mdi mdi-whatsapp"></i> WhatsApp
              </a>


            </div>

            <ul class="list-inline">
           
              <li class="list-inline-item">
              <!--   <a href="#" target="blank">Términos y condiciones</a> -->
              </li>
            </ul>
          </div>

          <div class="col">
            <div class="row">
              <div class="col-md-10 offset-md-1">
                <div class="logo d-block d-lg-none text-center text-lg-left">
                  <a href="{{ route('login') }}"><img src="{{ asset('plugins/latform/dist/images/logo.png') }}" alt="logo"></a>
                </div>

                <div class="my-5 text-center text-lg-left">
                  <h3 class="font-weight-bold">Iniciar sesión</h3>
                  <p class="text-muted">Inicia sesión en Goslam para continuar</p>
                </div>

                <form action="{{ route('login') }}" method="POST" id="formulario">
                  @csrf
                  <div class="form-group">
                    <div class="form-icon-wrapper">
                      <input type="email" class="form-control" name="email" id="email" :value="old('email')" placeholder="Correo electrónico" autofocus required>
                      <i class="form-icon-left mdi mdi-email"></i>
                    </div>
                    @error('email')<span class="text-danger small"><em>{{ $message }}</em></span>@enderror
                  </div>

                  <div class="form-group">
                    <div class="form-icon-wrapper">
                      <input type="password" class="form-control" name="password" id="password" placeholder="Contraseña" required autocomplete="current-password">
                      <i class="form-icon-left mdi mdi-lock"></i>
                      <a href="#" class="form-icon-right password-show-hide" title="Hide or show password">
                        <i class="mdi mdi-eye"></i>
                      </a>
                    </div>
                    @error('password')<span class="text-danger small"><em>{{ $message }}</em></span>@enderror
                  </div>

                  <p class="text-center mb-4">
                  <!--   @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">¿Has olvidado tu contraseña?</a>
                    @endif -->
                  </p>
                  <button type="submit" id="login" name="login" class="btn btn-primary btn-block mb-4 text-white">Iniciar Sesi&oacute;n</button>
                </form>

              <!--   <div class="text-divider">o</div>

                <div class="social-links justify-content-center">
                  <a href="{{ route('register') }}" class="btn btn-success 2btn-lg text-white">Crea una cuenta nueva</a>
                </div> -->

                <!-- <p class="text-center d-block d-lg-none mt-5 mt-lg-0">
                  ¿Aún no tienes una cuenta?
                  <a href="{{ route('register') }}">Crea una cuenta nueva</a>.
                </p> -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-guest-layout>
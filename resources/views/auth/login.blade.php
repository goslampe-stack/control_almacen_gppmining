<x-guest-layout>
  <div id="particles-js"></div>

  <style type="text/css">
    .apl-form-control {
      background: url(https://res.cloudinary.com/velasquez-paz/image/upload/v1618333387/l7oqsb2ucmvcimhrvy6n.png);
      background-color: inherit;
      color: #fff;
      padding: 1.5rem 1rem 1.5rem 1rem;
      border-radius: 1rem 0rem 0rem 1rem;
      border-right: inherit;
      border-color: #385c7f;
    }

    .apl-icon-control {
      background: url(https://res.cloudinary.com/velasquez-paz/image/upload/v1618333387/l7oqsb2ucmvcimhrvy6n.png);
      background-color: inherit;
      padding: 0rem 1rem 0rem 1rem;
      border-radius: 0rem 1rem 1rem 0rem;
      border-left: inherit;
      border-color: #385c7f;
    }

    .apl-form-control::placeholder {
      font-style: oblique;
    }

    .apl-btn-control {
      padding: .5rem;
      border-radius: .6rem .6rem .6rem .6rem;
    }
  </style>
  <!-- 4e7193-->

  <div class="content-wrapper" style="background-color: inherit;">
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="row justify-content-center">
              <div class="col-xs-12 col-sm-8 col-md-8 col-lg-7">
                <div style="margin-top: 20%;"></div>

                <div class="card">
                  <div class="row no-gutters">
                    <div class="col d-none d-lg-flex" style="background: url(plugins/latform/dist/images/cover1.jpg)">
                      <div class="logo">
                        <a href="{{ route('login') }}"><img src="{{ asset('plugins/latform/dist/images/logo.png') }}" alt="logo"></a>
                      </div>

                      <div>
                        <h3 class="font-weight-bold">GPP Mining Log&iacute;stico</h3>
                        <p class="lead my-5" style="text-align: justify;">Nuestra plataforma logística centraliza y optimiza los procesos de solicitudes internas, adquisiciones, cotizaciones, órdenes de compra, control de ingresos y despachos de productos, devoluciones y gestión de inventarios (kardex). Desarrollada para elevar la eficiencia operativa y el cumplimiento normativo en empresas del sector minero, impulsa tus operaciones mediante tecnología moderna e innovadora..</p>

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
                              @if (Route::has('password.request'))
                              <a href="https://wa.me/51920438989">¿Has olvidado tu contraseña?</a>
                              @endif
                            </p>
                            <button type="submit" id="login" name="login" class="btn btn-primary btn-block mb-4 text-white">Iniciar Sesi&oacute;n</button>
                          </form>

                          <div class="text-divider">O</div>

                          <div class="social-links justify-content-center">
                            <a href="https://wa.me/51920438989" class="btn btn-success 2btn-lg btn-block text-white">Crea una cuenta nueva</a>
                          </div>

                          <p class="text-center d-block d-lg-none mt-5 mt-lg-0">
                            ¿Aún no tienes una cuenta?
                            <a href="https://wa.me/51920438989">Crea una cuenta nueva</a>.
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</x-guest-layout>
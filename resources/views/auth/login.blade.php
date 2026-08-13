@extends('layouts.login_new')
@section('content')
    <link rel="stylesheet" href="{{asset('main/css/pages/page-auth.css')}}">
    <style>
        .invalid-feedback {
            display: block;
        }
    </style>
    <div class="position-relative">
        <div class="authentication-wrapper authentication-basic container-p-y p-4">
            <div class="authentication-inner py-4">
                <!-- Login -->
                <div class="card p-2">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center mt-5">
                        <a href="/" class="app-brand-link gap-2">
                            <span class="app-brand-logo demo">
                                <span style="color: #666cff">
                                        <img width="100" height="100" src="{{asset('icon1.jpeg')}}" alt="logo">
                                </span>
                            </span>
                        </a>
                    </div>

                    <div class="card-body mt-2">
                        <div class="row text-center">
                            <h3>{{config('app.nama_instansi')}}</h3>
                        </div>
                        <div class="row">
                            <div class="col-8">
                                <h4 class="mb-2">Selamat Datang</h4>
                                <p class="mb-4">Silahkan login terlebih dahulu</p>
                            </div>
                            <div class="col text-end">
                                <div class="dropdown-style-switcher dropdown me-1 me-xl-0">
                                    <a class="nav-link btn btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow"
                                       href="javascript:void(0);" data-bs-toggle="dropdown">
                                        <i class='ri-22px'></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-styles">
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0);" data-theme="light">
                                                <span class="align-middle"><i class='ri-sun-line ri-22px me-3'></i>Terang</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0);" data-theme="dark">
                                                <span class="align-middle"><i
                                                        class="ri-moon-clear-line ri-22px me-3"></i>Gelap</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0);" data-theme="system">
                                                <span class="align-middle"><i class="ri-computer-line ri-22px me-3"></i>Sistem</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <form id="formAuthentication" class="mb-3" action="{{route('login')}}" method="POST">
                            @csrf
                            <div class="form-floating form-floating-outline mb-3">
                                <input type="text" placeholder="Masukkan Usermane Anda" id="username"
                                       name="username" autocomplete="off"
                                       data-kt-translate="sign-in-input-email"
                                       class="form-control @error('username') is-invalid @enderror"
                                       autofocus
                                       required value="{{old('username')}}"/>
                                @error('username')
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                                <label for="username">Username</label>
                            </div>
                            <div class="mb-3">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input type="password" placeholder="Masukkan Password Anda" name="password"
                                               id="password"
                                               autocomplete="off"
                                               class="form-control @error('password') is-invalid @enderror" required/>
                                        <label for="password">Password</label>
                                    </div>
                                    <span class="input-group-text cursor-pointer showPassword"
                                          data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss-="click"
                                          data-bs-placement="bottom"
                                          title="Lihat Password">
                                            <i class="ri ri-eye-off-line"></i>
                                    </span>
                                    @error('password')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 text-center">
                                <label class="form-label captcha" for="captcha">
                                        <span>
                                            <img alt="captcha" class="img-fluid" src="{!! captcha_src('default') !!}">
                                        </span>
                                </label>
                            </div>
                            <div class="mb-3 text-center">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" id="captcha"
                                               class="form-control @error('captcha')is-invalid @enderror"
                                               autocomplete="off" name="captcha" required
                                               placeholder="Silahkan isikan tulisan pada gambar diatas">
                                        <label for="captcha">Captcha</label>
                                    </div>
                                    <span class="input-group-text rounded-end cursor-pointer"
                                          data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss-="click"
                                          data-bs-placement="bottom" id="reload-captcha"
                                          title="Ganti Captcha">
                                            <i class="ri ri-refresh-line"></i>
                                        </span>
                                    @error('captcha')
                                    <div class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 d-flex justify-content-end">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember-me"/>
                                    <label class="form-check-label" for="remember-me"> ingat saya </label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let captchaTimeoutId;

        function captchaTimeout() {
            if (captchaTimeoutId) {
                clearTimeout(captchaTimeoutId);
            }
            captchaTimeoutId = setTimeout(() => {
                const captcha = $('#captcha');
                captcha.addClass('is-invalid');
                captcha.siblings('.invalid-feedback').html('<strong>Captcha sudah tidak berlaku, silahkan <a href="#captcha" class="text-danger-emphasis ganti-captcha"> ganti!</a</strong>');
            }, 60000);
        }

        document.addEventListener("DOMContentLoaded", function () {
            $('#reload-captcha').click(function () {
                loadingAlert();
                $.ajax({
                    type: 'GET',
                    url: 'reload-captcha',
                    success: function (data) {
                        $(".captcha span").html(`<img class="img-fluid" src="${data.captcha}">`);
                        $('#captcha').removeClass('is-invalid');
                        captchaTimeout();

                        setTimeout(() => {
                            Swal.close();
                        }, 500)
                    }
                });

            });

            $('#formAuthentication').on('submit', function () {
                loadingAlert('');
            });

            $('.showPassword').click(function () {
                const passInput = $('#password');
                const type = passInput.attr('type');
                const icon = $(this).children();
                const thisText = $(this);
                if (type === 'password') {
                    thisText.attr('title', 'Sembunyikan Password')
                    thisText.attr('data-bs-original-title', 'Sembunyikan Password')
                    passInput.attr('type', 'text')
                    icon.removeClass('ri ri-eye-off-line')
                    icon.addClass('ri ri-eye-line')
                } else {
                    thisText.attr('title', 'Lihat Password')
                    thisText.attr('data-bs-original-title', 'Lihat Password')
                    passInput.attr('type', 'password')
                    icon.removeClass('ri ri-eye-line')
                    icon.addClass('ri ri-eye-off-line')
                }
            })
        })

    </script>
@endsection

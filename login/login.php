<!doctype html>

<html
    lang="en"
    class="light-style layout-wide customizer-hide"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="assets/"
    data-template="vertical-menu-template"
    data-style="light">

<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Lightdata | Login</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="assets/vendor/fonts/remixicon/remixicon.css" />
    <link rel="stylesheet" href="assets/vendor/fonts/flag-icons.css" />

    <!-- Menu waves for no-customizer fix -->
    <link rel="stylesheet" href="assets/vendor/libs/node-waves/node-waves.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="assets/vendor/libs/typeahead-js/typeahead.css" />
    <!-- Vendor -->
    <link rel="stylesheet" href="assets/vendor/libs/@form-validation/form-validation.css" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="assets/vendor/css/pages/page-auth.css" />
    <link rel="stylesheet" href="assets/vendor/libs/sweetalert2/sweetalert2.css" />

    <!-- Helpers -->
    <script src="assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="assets/vendor/js/template-customizer.js"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="assets/js/config.js"></script>
</head>

<body>
    <?php include("assets/css/styleGlobal.php"); ?>
    <!-- Content -->


    <div class="authentication-wrapper authentication-cover">
        <!-- Logo -->
        <a href="javascript:void(0)" class="auth-cover-brand d-flex align-items-center gap-4" style="cursor: default;">
            <span class="app-brand-logo">
                <span style="color: var(--bs-primary)">
                    <svg width="51" height="50" viewBox="0 0 51 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M25.1012 0L50.2024 25L25.1012 50L0 25L25.1012 0ZM3.91031 25L25.1012 46.1055L46.2921 25L25.1012 3.89455L3.91031 25Z" fill="var(--bs-primary)" />
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M25.2638 17L33.4066 24.7825L31.6445 26.6118L25.2638 20.5134L18.8832 26.6118L17.1211 24.7825L25.2638 17Z" fill="var(--bs-primary)" />
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M25.2638 23.6055L33.4066 31.388L31.6445 33.2172L25.2638 27.1189L18.8832 33.2172L17.1211 31.388L25.2638 23.6055Z" fill="var(--bs-primary)" />
                    </svg>
                </span>
            </span>
            <span class="app-brand-text demo text-heading fw-semibold">Lightdata | Fulfillment</span>
        </a>
        <!-- /Logo -->
        <div class="authentication-inner row m-0">
            <!-- /Left Section -->
            <div class="d-none d-lg-flex col-lg-7 col-xl-8 align-items-center justify-content-center p-12 pb-2">
                <img
                    src="assets/img/illustrations/fondoLogoFF.png"
                    class="auth-cover-illustration w-50"
                    alt="auth-illustration"
                    data-app-light-img="illustrations/fondoLogoFF.png"
                    data-app-dark-img="illustrations/fondoLogoFF.png" />
                <img
                    src="assets/img/illustrations/auth-cover-login-mask-light.png"
                    class="authentication-image"
                    alt="mask"
                    data-app-light-img="illustrations/auth-cover-login-mask-light.png"
                    data-app-dark-img="illustrations/auth-cover-login-mask-dark.png" />
            </div>
            <!-- /Left Section -->

            <!-- Login -->
            <div
                class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg position-relative py-sm-12 px-12 py-6">
                <div class="w-px-400 mx-auto pt-5 pt-lg-0">
                    <h4 class="mb-1">¡Bienvenido/a a Lightdata FF! 👋</h4>
                    <p class="mb-5">Complete los campos para ingresar al sistema</p>

                    <div class="mb-5">
                        <div class="mb-5">
                            <div class="form-password-toggle">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input
                                            type="text"
                                            id="codEmpresa_login"
                                            class="form-control campos_login"
                                            name="empresa"
                                            placeholder="Ingrese su empresa" />
                                        <label for="codEmpresa_login">Empresa</label>
                                    </div>
                                    <span class="input-group-text cursor-pointer"><i id="elimEmpresa_login" onclick="appLogin.cambiarEmpresa()" class="ri-close-line"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-floating form-floating-outline mb-5">
                            <input
                                type="text"
                                class="form-control campos_login"
                                id="username_login"
                                name="email-username"
                                placeholder="Ingrese su usuario"
                                autofocus />
                            <label for="username_login">Usuario</label>
                        </div>
                        <div class="mb-5">
                            <div class="form-password-toggle">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input
                                            type="password"
                                            id="password_login"
                                            class="form-control campos_login"
                                            name="password"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                            aria-describedby="password" />
                                        <label for="password_login">Contraseña</label>
                                    </div>
                                    <span id="ojito_login" onclick="appLogin.verContraseña()" class="input-group-text cursor-pointer"><i class="ri-eye-off-line"></i></span>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="mb-5 d-flex justify-content-between mt-5"> -->
                        <!-- <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" id="remember-me" />
                                <label class="form-check-label" for="remember-me"> Recuerdame </label>
                            </div> -->
                        <!-- <a href="auth-forgot-password-cover.html" class="float-end mb-1 mt-2">
                                <span>Olvidaste la contraseña?</span>
                            </a> -->
                        <!-- </div> -->
                        <button id="btnIngresar_login" class="btn btn-primary d-grid w-100" onclick='appLogin.login();'>Ingresar</button>
                        <button id="btnLoading_login" class="btn btn-primary w-100 ocultar" type="button" disabled>
                            <span class="spinner-border me-1" role="status" aria-hidden="true"></span>
                            Cargando...
                        </button>

                        <span id="completarCampos_login" class="badge bg-label-danger w-100 mt-5 ocultar">Debes completar todos los campos</span>
                    </div>

                </div>
            </div>
            <!-- /Login -->
        </div>
    </div>

    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="assets/vendor/libs/jquery/jquery.js"></script>
    <script src="assets/vendor/libs/popper/popper.js"></script>
    <script src="assets/vendor/js/bootstrap.js"></script>
    <script src="assets/vendor/libs/node-waves/node-waves.js"></script>
    <script src="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="assets/vendor/libs/hammer/hammer.js"></script>
    <script src="assets/vendor/libs/i18n/i18n.js"></script>
    <script src="assets/vendor/libs/typeahead-js/typeahead.js"></script>
    <script src="assets/vendor/js/menu.js"></script>

    <!-- endbuild -->
    <script src="assets/vendor/libs/sweetalert2/sweetalert2.js"></script>

    <!-- Vendors JS -->
    <script src="assets/vendor/libs/@form-validation/popular.js"></script>
    <script src="assets/vendor/libs/@form-validation/bootstrap5.js"></script>
    <script src="assets/vendor/libs/@form-validation/auto-focus.js"></script>

    <?php include("sistema/customLib/sweetalert.php"); ?>

    <!-- Main JS -->
    <!--<script src="assets/js/main.js"></script>-->

    <script>
        const appLogin = (function() {
            public = {};

            public.Inicializar = function() {
                localStorage.removeItem("horaInicioSesion");
                localStorage.removeItem("didUser");
                localStorage.removeItem("authToken");
                const idEmpresa = localStorage.getItem("idEmpresa");

                if (idEmpresa) {
                    const codEmpresa = localStorage.getItem("codEmpresa");
                    // const imgBase64 = localStorage.getItem("logoEmpresa");

                    if (codEmpresa) {
                        $("#codEmpresa_login").val(codEmpresa);
                        $("#codEmpresa_login").attr("readonly", true);
                    }

                    // if (imgBase64) {
                    //     const imgElement = document.getElementById("logoEmpresa");
                    //     if (imgElement) imgElement.src = imgBase64;
                    // }
                } else {
                    $("#elimEmpresa_login").css("display", "none");
                }
            };

            public.reset = function() {
                $(".campos_login").val("");
                localStorage.removeItem("didUser");
                localStorage.removeItem("usernameUser");
                localStorage.removeItem("perfilUser");
                localStorage.removeItem("idEmpresa");
                localStorage.removeItem("codEmpresa");
                // localStorage.removeItem("logoEmpresa");
            };

            public.login = function() {
                $("#btnIngresar_login").addClass("ocultar");
                $("#btnLoading_login").removeClass("ocultar");
                $(".campos_login").removeClass("is-invalid");

                const codEmpresa = $("#codEmpresa_login").val();
                const username = $("#username_login").val();
                const password = $("#password_login").val();

                if (!codEmpresa || !username || !password) {
                    $(".campos_login").addClass("is-invalid");
                    $("#completarCampos_login").removeClass("ocultar")
                    $("#btnIngresar_login").removeClass("ocultar");
                    $("#btnLoading_login").addClass("ocultar");
                    return;
                } else {
                    $("#completarCampos_login").addClass("ocultar")
                }

                const parametros = {
                    codEmpresa,
                    username,
                    password
                };

                $.ajax({
                    url: "login/processLogin.php",
                    type: "POST",
                    dataType: "json",
                    data: parametros,
                    success: function(response) {
                        if (response.success) {
                            const data = response.data
                            localStorage.setItem("didUser", data.user.did);
                            localStorage.setItem("usernameUser", data.user.username);
                            localStorage.setItem("perfilUser", data.user.perfil);
                            localStorage.setItem("idEmpresa", data.company.did);
                            localStorage.setItem("nombreEmpresa", data.company.nombre);
                            localStorage.setItem("codEmpresa", data.company.codigo);
                            localStorage.setItem("logoEmpresa", data.company.imagen);
                            localStorage.setItem("modoTrabajoEmpresa", data.company.modo_trabajo);
                            localStorage.setItem("authToken", data.user.token);
                            location.reload();
                        } else {
                            $(".campos_login").addClass("is-invalid");
                            globalSweetalert.error({
                                titulo: response.message
                            });
                        }
                        $("#btnIngresar_login").removeClass("ocultar");
                        $("#btnLoading_login").addClass("ocultar");
                    },
                    error: function() {
                        globalSweetalert.error();
                        $("#btnIngresar_login").removeClass("ocultar");
                        $("#btnLoading_login").addClass("ocultar");
                    }
                });
            };

            public.cambiarEmpresa = function() {
                $("#codEmpresa_login").val("");
                $("#codEmpresa_login").attr("readonly", false);
                $("#elimEmpresa_login").css("display", "none");

                localStorage.removeItem("idEmpresa");
                localStorage.removeItem("codEmpresa");
                // localStorage.removeItem("logoEmpresa");
            };

            public.verContraseña = function() {
                const passwordInput = document.getElementById("password_login");
                const icon = document.querySelector("#ojito_login i");

                if (passwordInput.type == "password") {
                    passwordInput.type = "text";
                    icon.classList.replace("ri-eye-off-line", "ri-eye-line");
                } else {
                    passwordInput.type = "password";
                    icon.classList.replace("ri-eye-line", "ri-eye-off-line");
                }
            };

            $(".campos_login").on("input", function() {
                $(this).removeClass("is-invalid");
            });

            $(".campos_login").on("keydown", function(e) {
                if (e.key === "Enter") {
                    e.preventDefault();
                    appLogin.login();
                }
            });

            return public;
        }());

        appLogin.Inicializar();
    </script>


    <!-- NO BORRAR, DEJAR SIMEPRE AL FINAL -->
    <?php include("router.php"); ?>
</body>

</html>
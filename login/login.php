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

    <title>Fulfillment | Login</title>

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
                    <svg width="225" height="42" viewBox="0 0 225 42" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M19.612 1.3379C20.3867 0.591176 21.6133 0.591176 22.388 1.3379L40.5666 18.8604C41.3593 19.6245 41.3854 20.8856 40.6249 21.6818L38.8434 23.5471C38.078 24.3484 36.8069 24.3747 36.0091 23.6056L22.388 10.4761C21.6133 9.72942 20.3867 9.72942 19.612 10.4761L5.99091 23.6056C5.19307 24.3747 3.92201 24.3484 3.15662 23.5471L1.37507 21.6818C0.614624 20.8856 0.640687 19.6245 1.43338 18.8604L19.612 1.3379Z" fill="var(--bs-heading-color)" />
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M19.612 18.3379C20.3867 17.5912 21.6133 17.5912 22.388 18.3379L40.5666 35.8604C41.3593 36.6245 41.3854 37.8856 40.6249 38.6818L38.8434 40.5471C38.078 41.3484 36.8069 41.3747 36.0091 40.6056L22.388 27.4761C21.6133 26.7294 20.3867 26.7294 19.612 27.4761L5.99091 40.6056C5.19307 41.3747 3.92201 41.3484 3.15662 40.5471L1.37507 38.6818C0.614624 37.8856 0.640687 36.6245 1.43338 35.8604L19.612 18.3379Z" fill="var(--bs-heading-color)" />
                        <path d="M214.599 34.3834V21.2904H209.569V17H224.955V21.2904H219.925V34.3834H214.599Z" fill="var(--bs-heading-color)" />
                        <path d="M191.681 34.3834V17H195.577L203.639 26.7396H202.875V17H207.831V34.3834H203.935L195.897 24.6438H196.661V34.3834H191.681Z" fill="var(--bs-heading-color)" />
                        <path d="M176.68 34.3834V17H189.575V21.0438H181.759V23.5342H188.984V27.578H181.759V30.3396H189.575V34.3834H176.68Z" fill="var(--bs-heading-color)" />
                        <path d="M154.769 34.3834V17H159.405L164.681 28.8108H163.843L169.12 17H173.755V34.3834H168.947V24.989H170.131L165.692 34.3834H162.758L158.32 24.989H159.577V34.3834H154.769Z" fill="var(--bs-heading-color)" />
                        <path d="M140.199 34.3834V17H145.525V29.9944H152.577V34.3834H140.199Z" fill="var(--bs-heading-color)" />
                        <path d="M125.704 34.3834V17H131.03V29.9944H138.082V34.3834H125.704Z" fill="var(--bs-heading-color)" />
                        <path d="M117.517 34.3834V17H122.843V34.3834H117.517Z" fill="var(--bs-heading-color)" />
                        <path d="M102.972 34.3834V17H115.597V21.0438H108.298V23.7561H115.005V27.7999H108.298V34.3834H102.972Z" fill="var(--bs-heading-color)" />
                        <path d="M88.4771 34.3834V17H93.803V29.9944H100.855V34.3834H88.4771Z" fill="var(--bs-heading-color)" />
                        <path d="M77.7802 34.6793C75.1008 34.6793 73.0871 34.0299 71.7392 32.7313C70.3913 31.4163 69.7173 29.4437 69.7173 26.8136V17H75.0433V26.8876C75.0433 27.9889 75.257 28.8273 75.6843 29.4026C76.1282 29.9779 76.8268 30.2656 77.7802 30.2656C78.7336 30.2656 79.424 29.9779 79.8514 29.4026C80.2953 28.8273 80.5172 27.9889 80.5172 26.8876V17H85.7445V26.8136C85.7445 29.4437 85.087 31.4163 83.7719 32.7313C82.4733 34.0299 80.4761 34.6793 77.7802 34.6793Z" fill="var(--bs-heading-color)" />
                        <path d="M55.2476 34.3834V17H67.8721V21.0438H60.5735V23.7561H67.2803V27.7999H60.5735V34.3834H55.2476Z" fill="var(--bs-heading-color)" />
                    </svg>

                </span>
            </span>
            <!-- <span class="app-brand-text demo text-heading fw-semibold">Lightdata | Fulfillment</span> -->
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
                <div class="w-px-450 mx-auto pt-5 pt-lg-0">
                    <h4 class="fw-bold mb-1">Bienvenido/a a Fullfilment <small>by Lightdata</small> 👋</h4>
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
                                            placeholder="Ingrese su codigo de empresa" />
                                        <label for="codEmpresa_login">Codigo de empresa</label>
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
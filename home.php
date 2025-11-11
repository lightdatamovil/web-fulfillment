<?php

if (!isset($_SESSION["logueado"])) {
    header("Location: https://ff.lightdata.app/index.php");
    exit();
}

?>

<!doctype html>
<html
    lang="en"
    class="light-style layout-navbar-fixed layout-menu-fixed layout-compact"
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

    <title>Lightdata</title>

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
    <link rel="stylesheet" href="assets/vendor/libs/apex-charts/apex-charts.css" />
    <link rel="stylesheet" href="assets/vendor/libs/swiper/swiper.css" />
    <link rel="stylesheet" href="assets/vendor/libs/dropzone/dropzone.css" />
    <link rel="stylesheet" href="assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css" />
    <link rel="stylesheet" href="assets/vendor/libs/animate-css/animate.css" />
    <link rel="stylesheet" href="assets/vendor/libs/bs-stepper/bs-stepper.css" />
    <link rel="stylesheet" href="assets/vendor/libs/@form-validation/form-validation.css" />
    <link rel="stylesheet" href="assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
    <link rel="stylesheet" href="assets/vendor/libs/flatpickr/flatpickr.css" />
    <link rel="stylesheet" href="assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css" />
    <link rel="stylesheet" href="assets/vendor/libs/bootstrap-maxlength/bootstrap-maxlength.css" />
    <link rel="stylesheet" href="assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css" />
    <link rel="stylesheet" href="assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css" />
    <link rel="stylesheet" href="assets/vendor/libs/jquery-timepicker/jquery-timepicker.css" />
    <link rel="stylesheet" href="assets/vendor/libs/pickr/pickr-themes.css" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="assets/vendor/css/pages/cards-statistics.css" />
    <link rel="stylesheet" href="assets/vendor/css/pages/cards-analytics.css" />
    <link rel="stylesheet" href="assets/vendor/css/pages/page-profile.css" />

    <!-- SWEET ALERT -->
    <link rel="stylesheet" href="assets/vendor/libs/sweetalert2/sweetalert2.css" />

    <!-- SELECT2 -->
    <link rel="stylesheet" href="assets/vendor/libs/select2/select2.css " />

    <!-- SELECT BOOTSTRAP -->
    <link rel="stylesheet" href="assets/vendor/libs/bootstrap-select/bootstrap-select.css" />

    <link rel="stylesheet" href="librerias/photoswipe/photoswipe.css">
    <script src="librerias/sheetjs/sheetjs.js"></script>
    <script src="librerias/lodash/lodash.js"></script>
    <script src="librerias/qrcode/qrcode.js"></script>

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

    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="/" class="app-brand-link">
                        <span class="app-brand-logo">
                            <span style="color: var(--bs-primary)">
                                <svg width="31" height="30" viewBox="0 0 51 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M25.1012 0L50.2024 25L25.1012 50L0 25L25.1012 0ZM3.91031 25L25.1012 46.1055L46.2921 25L25.1012 3.89455L3.91031 25Z" fill="var(--bs-primary)" />
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M25.2638 17L33.4066 24.7825L31.6445 26.6118L25.2638 20.5134L18.8832 26.6118L17.1211 24.7825L25.2638 17Z" fill="var(--bs-primary)" />
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M25.2638 23.6055L33.4066 31.388L31.6445 33.2172L25.2638 27.1189L18.8832 33.2172L17.1211 31.388L25.2638 23.6055Z" fill="var(--bs-primary)" />
                                </svg>
                            </span>
                        </span>
                        <span class="app-brand-text demo menu-text fw-semibold ms-2">Lightdata</span>
                    </a>

                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M8.47365 11.7183C8.11707 12.0749 8.11707 12.6531 8.47365 13.0097L12.071 16.607C12.4615 16.9975 12.4615 17.6305 12.071 18.021C11.6805 18.4115 11.0475 18.4115 10.657 18.021L5.83009 13.1941C5.37164 12.7356 5.37164 11.9924 5.83009 11.5339L10.657 6.707C11.0475 6.31653 11.6805 6.31653 12.071 6.707C12.4615 7.09747 12.4615 7.73053 12.071 8.121L8.47365 11.7183Z"
                                fill-opacity="0.9" />
                            <path
                                d="M14.3584 11.8336C14.0654 12.1266 14.0654 12.6014 14.3584 12.8944L18.071 16.607C18.4615 16.9975 18.4615 17.6305 18.071 18.021C17.6805 18.4115 17.0475 18.4115 16.657 18.021L11.6819 13.0459C11.3053 12.6693 11.3053 12.0587 11.6819 11.6821L16.657 6.707C17.0475 6.31653 17.6805 6.31653 18.071 6.707C18.4615 7.09747 18.4615 7.73053 18.071 8.121L14.3584 11.8336Z"
                                fill-opacity="0.4" />
                        </svg>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>

                <?php include("sistema/layout/sidebar.php"); ?>

            </aside>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                <nav
                    class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                    id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
                            <i class="ri-menu-fill ri-22px"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <!-- Search -->
                        <div class="navbar-nav align-items-center">
                            <div class="nav-item navbar-search-wrapper mb-0">
                                <a class="nav-item nav-link search-toggler fw-normal px-0" href="javascript:void(0);">
                                    <i class="ri-search-line ri-22px scaleX-n1-rtl me-3"></i>
                                    <span class="d-none d-md-inline-block text-muted">Buscar modulo</span>
                                </a>
                            </div>
                        </div>
                        <!-- /Search -->

                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <!-- Language -->
                            <!-- <li class="nav-item dropdown-language dropdown">
                                <a
                                    class="nav-link btn btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow"
                                    href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    <i class="ri-translate-2 ri-22px"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);" data-language="en" data-text-direction="ltr">
                                            <span class="align-middle">English</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);" data-language="fr" data-text-direction="ltr">
                                            <span class="align-middle">French</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);" data-language="ar" data-text-direction="rtl">
                                            <span class="align-middle">Arabic</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);" data-language="de" data-text-direction="ltr">
                                            <span class="align-middle">German</span>
                                        </a>
                                    </li>
                                </ul>
                            </li> -->
                            <!--/ Language -->

                            <!-- Style Switcher -->
                            <li class="nav-item dropdown-style-switcher dropdown me-1 me-xl-0">
                                <a
                                    class="nav-link btn btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow"
                                    href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    <i class="ri-22px"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-styles">
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);" data-theme="light">
                                            <span class="align-middle"><i class="ri-sun-line ri-22px me-3"></i>Claro</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);" data-theme="dark">
                                            <span class="align-middle"><i class="ri-moon-clear-line ri-22px me-3"></i>Oscuro</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);" data-theme="system">
                                            <span class="align-middle"><i class="ri-computer-line ri-22px me-3"></i>Sistema</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <!-- / Style Switcher-->

                            <!-- Quick links  -->
                            <?php //include("sistema/layout/atajos.php"); 
                            ?>
                            <!-- Quick links -->

                            <!-- Notification -->
                            <!-- < ?php include("sistema/layout/notificaciones.php"); ?> -->
                            <!--/ Notification -->

                            <!-- User -->
                            <?php include("sistema/layout/navUser.php"); ?>
                            <!--/ User -->
                        </ul>
                    </div>

                    <!-- Search Small Screens -->
                    <div class="navbar-search-wrapper search-input-wrapper d-none">
                        <input
                            type="text"
                            class="form-control search-input container-xxl border-0"
                            placeholder="Buscar..."
                            aria-label="Buscar..." />
                        <i class="ri-close-fill search-toggler cursor-pointer"></i>
                    </div>
                </nav>

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    <div id="containerAPP" class="container-xxl flex-grow-1 container-p-y">
                        <?php include("modulos/include.php"); ?>
                        <?php include("sistema/include.php"); ?>

                        <div class="winapp w-100 h-100" id="ContainerHomeNovedades">
                            <div class="w-100 h-100 position-relative d-flex d-md-block justify-content-center align-items-center">
                                <div class="containerTituloHome position-relative p-10">
                                    <h1 class="text-center tituloHome">FULFILLMENT</h1>
                                    <h5 class="text-center subtituloHome">BIENVENIDOS</h5>
                                </div>
                                <img src="assets/img/illustrations/fondoHome.png" class="position-absolute bottom-0 start-0 d-none d-md-block imagenHome" style="height: 53%;" alt="">

                            </div>
                        </div>

                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme">
                        <div class="container-xxl">
                            <div
                                class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
                                <div class="text-body mb-2 mb-md-0">
                                    ©
                                    <script>
                                        document.write(new Date().getFullYear());
                                    </script>
                                    , hecho con <span class="text-danger"><i class="tf-icons ri-heart-fill"></i></span> por
                                    <a href="https://lightdata.app" target="_blank" class="footer-link">Lightdata</a>
                                </div>
                                <div class="d-none d-lg-inline-block">

                                    <!-- <a
                                        href="https://lightdata.app/documentation/"
                                        target="_blank"
                                        class="footer-link me-4">Documentation</a> -->

                                    <a href="https://wa.me/5491139438298" target="_blank" class="footer-link d-none d-sm-inline-block">Soporte</a>
                                </div>
                            </div>
                        </div>
                    </footer>
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->

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

    <!-- Vendors JS -->
    <script src="assets/vendor/libs/apex-charts/apexcharts.js"></script>
    <script src="assets/vendor/libs/swiper/swiper.js"></script>
    <script src="assets/vendor/libs/block-ui/block-ui.js"></script>
    <script src="assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
    <script src="assets/vendor/libs/select2/select2.js"></script>
    <script src="assets/vendor/libs/bootstrap-select/bootstrap-select.js"></script>
    <script src="assets/vendor/libs/dropzone/dropzone.js"></script>
    <script src="assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="assets/vendor/libs/bs-stepper/bs-stepper.js"></script>
    <script src="assets/vendor/libs/@form-validation/popular.js"></script>
    <script src="assets/vendor/libs/@form-validation/bootstrap5.js"></script>
    <script src="assets/vendor/libs/@form-validation/auto-focus.js"></script>
    <script src="assets/vendor/libs/moment/moment.js"></script>
    <script src="assets/vendor/libs/flatpickr/flatpickr.js"></script>
    <script src="assets/vendor/libs/jquery-sticky/jquery-sticky.js"></script>
    <script src="assets/vendor/libs/cleavejs/cleave.js"></script>
    <script src="assets/vendor/libs/cleavejs/cleave-phone.js"></script>
    <script src="assets/vendor/libs/bloodhound/bloodhound.js"></script>
    <script src="assets/vendor/libs/autosize/autosize.js"></script>
    <script src="assets/vendor/libs/bootstrap-maxlength/bootstrap-maxlength.js"></script>
    <script src="assets/vendor/libs/jquery-repeater/jquery-repeater.js"></script>
    <script src="assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
    <script src="assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js"></script>
    <script src="assets/vendor/libs/jquery-timepicker/jquery-timepicker.js"></script>
    <script src="assets/vendor/libs/pickr/pickr.js"></script>

    <!-- Main JS -->
    <script src="assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="assets/js/dashboards-analytics.js"></script>
    <script src="assets/js/extended-ui-sweetalert2.js"></script>
    <script src="assets/js/ui-popover.js"></script>
    <script src="assets/js/forms-file-upload.js"></script>
    <script src="assets/js/pages-profile-user.js"></script>
    <script src="assets/js/form-wizard-numbered.js"></script>
    <script src="assets/js/form-wizard-validation.js"></script>
    <script src="assets/js/form-layouts.js"></script>
    <script src="assets/js/forms-selects.js"></script>
    <script src="assets/js/forms-typeahead.js"></script>
    <script src="assets/js/forms-extras.js"></script>
    <script src="assets/js/forms-pickers.js"></script>

    <!-- LIBRERIA DE PANTALLA COMPLETA Y ZOOM DE IMAGENES -->
    <script src="/librerias/photoswipe/photoswipe.umd.min.js"></script>
    <script src="/librerias/photoswipe/photoswipe-lightbox.umd.min.js"></script>
    <!-- / LIBRERIA DE PANTALLA COMPLETA Y ZOOM DE IMAGENES -->

    <!-- APP SISTEMA -->
    <?php include("sistema/sistema.php"); ?>

    <!-- CUSTOM LIBS (Funciones globales y librerias propias) -->
    <?php include("sistema/customLib/paginado.php"); ?>
    <?php include("sistema/customLib/loading.php"); ?>
    <?php include("sistema/customLib/sweetalert.php"); ?>
    <?php include("sistema/customLib/validacionesForm.php"); ?>
    <?php include("sistema/customLib/logoTiendas.php"); ?>
    <?php include("sistema/customLib/activarAcciones.php"); ?>
    <?php include("sistema/customLib/funcionesJs.php"); ?>
    <?php include("sistema/customLib/llenarSelect.php"); ?>
    <?php include("sistema/customLib/inputImg.php"); ?>
    <?php include("sistema/customLib/excelJs.php"); ?>
    <?php include("sistema/customLib/sinInformacion.php"); ?>
    <?php include("sistema/customLib/ordenTablas.php"); ?>
    <?php include("sistema/customLib/requestApi.php"); ?>
    <?php include("sistema/customLib/previewImagenes.php"); ?>
    <?php include("sistema/customLib/estadosGlobales.php"); ?>

    <!-- NO BORRAR, DEJAR SIMEPRE AL FINAL -->
    <?php include("router.php"); ?>

</body>

</html>
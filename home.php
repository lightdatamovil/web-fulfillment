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

    <title>Fulfillment</title>

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
                                <svg width="25" viewBox="0 0 42 42" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M19.612 1.3379C20.3867 0.591176 21.6133 0.591176 22.388 1.3379L40.5666 18.8604C41.3593 19.6245 41.3854 20.8856 40.6249 21.6818L38.8434 23.5471C38.078 24.3484 36.8069 24.3747 36.0091 23.6056L22.388 10.4761C21.6133 9.72942 20.3867 9.72942 19.612 10.4761L5.99091 23.6056C5.19307 24.3747 3.92201 24.3484 3.15662 23.5471L1.37507 21.6818C0.614624 20.8856 0.640687 19.6245 1.43338 18.8604L19.612 1.3379Z" fill="var(--bs-primary)" />
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M19.612 18.3379C20.3867 17.5912 21.6133 17.5912 22.388 18.3379L40.5666 35.8604C41.3593 36.6245 41.3854 37.8856 40.6249 38.6818L38.8434 40.5471C38.078 41.3484 36.8069 41.3747 36.0091 40.6056L22.388 27.4761C21.6133 26.7294 20.3867 26.7294 19.612 27.4761L5.99091 40.6056C5.19307 41.3747 3.92201 41.3484 3.15662 40.5471L1.37507 38.6818C0.614624 37.8856 0.640687 36.6245 1.43338 35.8604L19.612 18.3379Z" fill="var(--bs-primary)" />
                                </svg>

                            </span>
                        </span>
                        <span class="app-brand-text demo menu-text fw-semibold ms-2">
                            <svg width="130" viewBox="0 0 170 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M159.352 17.3834V4.29036H154.322V0H169.708V4.29036H164.678V17.3834H159.352Z" fill="var(--bs-heading-color)" />
                                <path d="M136.433 17.3834V0H140.329L148.392 9.73962H147.628V0H152.584V17.3834H148.688L140.649 7.64375H141.414V17.3834H136.433Z" fill="var(--bs-heading-color)" />
                                <path d="M121.432 17.3834V0H134.328V4.04379H126.512V6.53417H133.736V10.578H126.512V13.3396H134.328V17.3834H121.432Z" fill="var(--bs-heading-color)" />
                                <path d="M99.5215 17.3834V0H104.157L109.434 11.8108H108.595L113.872 0H118.508V17.3834H113.699V7.98895H114.883L110.445 17.3834H107.51L103.072 7.98895H104.33V17.3834H99.5215Z" fill="var(--bs-heading-color)" />
                                <path d="M84.9517 17.3834V0H90.2776V12.9944H97.3296V17.3834H84.9517Z" fill="var(--bs-heading-color)" />
                                <path d="M70.4565 17.3834V0H75.7825V12.9944H82.8345V17.3834H70.4565Z" fill="var(--bs-heading-color)" />
                                <path d="M62.2695 17.3834V0H67.5955V17.3834H62.2695Z" fill="var(--bs-heading-color)" />
                                <path d="M47.7246 17.3834V0H60.3491V4.04379H53.0506V6.75609H59.7574V10.7999H53.0506V17.3834H47.7246Z" fill="var(--bs-heading-color)" />
                                <path d="M33.2295 17.3834V0H38.5555V12.9944H45.6074V17.3834H33.2295Z" fill="var(--bs-heading-color)" />
                                <path d="M22.5327 17.6793C19.8532 17.6793 17.8396 17.0299 16.4916 15.7313C15.1437 14.4163 14.4697 12.4437 14.4697 9.81359V0H19.7957V9.88756C19.7957 10.9889 20.0094 11.8273 20.4368 12.4026C20.8806 12.9779 21.5792 13.2656 22.5327 13.2656C23.4861 13.2656 24.1765 12.9779 24.6039 12.4026C25.0477 11.8273 25.2696 10.9889 25.2696 9.88756V0H30.4969V9.81359C30.4969 12.4437 29.8394 14.4163 28.5244 15.7313C27.2258 17.0299 25.2285 17.6793 22.5327 17.6793Z" fill="var(--bs-heading-color)" />
                                <path d="M0 17.3834V0H12.6245V4.04379H5.32597V6.75609H12.0327V10.7999H5.32597V17.3834H0Z" fill="var(--bs-heading-color)" />
                            </svg>
                        </span>
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

                        <div class="winapp w-100 h-100">
                            <div class="w-100 h-100 position-relative d-flex d-md-block justify-content-center align-items-center">
                                <div class="containerTituloHome position-relative p-10">
                                    <div class="d-flex justify-content-center">
                                        <div class="d-flex flex-column align-items-end">
                                            <svg class="tituloHome" width="600" viewBox="0 0 225 42" fill="none" xmlns="http://www.w3.org/2000/svg">
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
                                            <h5 class="text-center subtituloHome">BIENVENIDOS</h5>
                                        </div>
                                    </div>
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
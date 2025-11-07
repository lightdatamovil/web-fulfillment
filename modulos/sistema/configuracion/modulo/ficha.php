<div class="winapp" id='modulo_configuracion' style="display:none;">

    <div class="card mb-6">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <i class="ri-settings-3-line ri-30px me-2"></i>
                <h3 class="mb-0">Configuración</h3>
            </div>
        </div>
    </div>

    <div class="col-12 mb-6">
        <div class="row">

            <div class="col-12 col-md-12 col-lg-6">
                <div class="card">
                    <div class="row p-5">
                        <div class="col-md-4">
                            <div class="w-100 ratio ratio-1x1">
                                <img class="card-img h-100 w-100" id="logoEmpresa_configuracion" style="object-fit: cover;" src="" onerror="this.onerror=null; this.src='../../assets/img/extras/imagenDefault.jpg';" alt="">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body p-0">
                                <h4 class="card-title fw-bold m-0" id="nombreFantasia_configuracion"></h4>
                                <p class="card-text" id="razonSocial_configuracion"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-12 col-lg-6">
                <div class="card">
                    <div class="row p-5">
                        <div class="col-md-4">
                            <div class="bg-white p-3 rounded ratio ratio-1x1">
                                <div id="qrcode_configuracion" class="d-flex align-items-center justify-content-center"></div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body p-0">
                                <h4 class="card-title fw-bold m-0">QR</h4>
                                <p class="card-text">Con este QR podrán ingresar desde la app</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
            <h4 class="card-header fw-bold pb-0">Seleccióne el modo de trabajo </h4>
            <div class="card-body">
                <p class="card-text">Podras seleccionar si quieres trabajar con OTs o solo PVs</p>
                <div class="row">

                    <div class="col-md mb-md-0 mb-5">
                        <div class="form-check custom-option custom-option-basic checked">
                            <label class="form-check-label custom-option-content" for="opcionPV_configuracion">
                                <input name="modoDeTrabajo_configuracion" class="form-check-input" type="radio" value="0" id="opcionPV_configuracion" checked style="top: 3px;" onchange="appModuloConfiguracion.cambiarModoDeTrabajo(this)">
                                <span class="custom-option-header justify-content-start align-items-baseline gap-2 pb-0">
                                    <span class="h5 fw-bold mb-0">PVs</span>
                                    <small class="text-muted">(Pedidos de ventas)</small>
                                </span>
                                <span class="custom-option-body">
                                    <p class="m-0">Podrá comenzar el armado de PVs de forma directa sin tener que agruparlos</p>
                                </span>
                            </label>
                        </div>
                    </div>


                    <div class="col-md">
                        <div class="form-check custom-option custom-option-basic">
                            <label class="form-check-label custom-option-content" for="opcionOT_configuracion">
                                <input name="modoDeTrabajo_configuracion" class="form-check-input" type="radio" value="1" id="opcionOT_configuracion" style="top: 3px;" onchange="appModuloConfiguracion.cambiarModoDeTrabajo(this)">
                                <span class="custom-option-header justify-content-start align-items-baseline gap-2 pb-0">
                                    <span class="h5 fw-bold mb-0">OTs</span>
                                    <small class="text-muted">(Ordenes de trabajo)</small>
                                </span>
                                <span class="custom-option-body">
                                    <p class="m-0">Deberá agrupar los Pedidos de venta en una OT para iniciar armado</p>
                                </span>
                            </label>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

</div>
<div class="winapp" id='modulo_pedidoDeVentas' style="display:none;">

    <div class="card mb-6">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <i class="ri-shopping-cart-line ri-30px me-2"></i>
                <h3 class="mb-0">Listado de armado de pedido de ventas</h3>
            </div>
        </div>
    </div>

    <div class="card">

        <div class="card-header border-bottom">

            <div class="row gy-5 gx-3 mb-5">

                <div class="col-12 col-md-6 col-lg-3">
                    <div class="input-group input-daterange">
                        <input type="date" class="form-control campos_pedidoDeVentas" id="filtroFechaDesde_pedidoDeVentas" />
                        <span class="input-group-text cursor-pointer" id="tipoFecha_pedidoDeVentas" onclick="appModuloPedidoDeVentas.cambiarTipoFecha()"><i class="ri-arrow-right-s-line"></i></span>
                        <input type="date" class="form-control campos_pedidoDeVentas" id="filtroFechaHasta_pedidoDeVentas" />
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-3">
                    <div class="form-floating form-floating-outline">
                        <input type="text" class="form-control campos_pedidoDeVentas inputs_pedidoDeVentas" id="filtroIdVenta_pedidoDeVentas" placeholder="ID Venta" />
                        <label for="filtroIdVenta_pedidoDeVentas">Buscar por ID venta</label>
                    </div>
                </div>


                <div class="col-12 col-md-6 col-lg-3">
                    <div class="form-floating form-floating-outline">
                        <select id="filtroArmador_pedidoDeVentas" multiple class="form-select campos_pedidoDeVentas select2_pedidoDeVentas"></select>
                        <label for="filtroArmador_pedidoDeVentas">Armador</label>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-3">
                    <div class="form-floating form-floating-outline">
                        <select id="filtroAlertada_pedidoDeVentas" class="form-select campos_pedidoDeVentas">
                            <option value="" selected>Todas</option>
                            <option value="0">No</option>
                            <option value="1">Si</option>
                        </select>
                        <label for="filtroAlertada_pedidoDeVentas">Aletada</label>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-floating form-floating-outline">
                        <select id="filtroClientes_pedidoDeVentas" multiple class="form-select campos_pedidoDeVentas select2_pedidoDeVentas"></select>
                        <label for="filtroClientes_pedidoDeVentas">Clientes</label>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-floating form-floating-outline">
                        <select id="filtroOrigen_pedidoDeVentas" multiple class="form-select campos_pedidoDeVentas select2_pedidoDeVentas"></select>
                        <label for="filtroOrigen_pedidoDeVentas">Origen</label>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-floating form-floating-outline">
                        <select id="filtroEstado_pedidoDeVentas" multiple class="form-select campos_pedidoDeVentas select2_pedidoDeVentas"></select>
                        <label for="filtroEstado_pedidoDeVentas">Estado</label>
                    </div>
                </div>

            </div>

            <div class="row g-3 mb-3">
                <!-- <div class="col-12 col-md-6 col-lg-3">
                    <button class="btn btn-label-success w-100" onclick="appModalPedidoDeVentas.open()"><span class="tf-icons ri-box-3-fill ri-19px me-2"></span>Nuevo</button>
                </div> -->
                <div class="col-12 col-md-6 col-lg-3">
                    <button class="btn btn-warning w-100" onclick="appModuloPedidoDeVentas.limpiarCampos()">Limpiar filtros</button>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <button class="btn btn-primary w-100" onclick="appModuloPedidoDeVentas.getListado({type: 1})">Filtrar</button>
                </div>
            </div>

        </div>

        <div class="table-responsive text-nowrap table-container">
            <table class="table table-hover">
                <thead id="theadListado_pedidoDeVentas" class="table-thead">
                    <tr>
                        <th data-order="did_cliente">Cliente</th>
                        <th data-order="fecha">Fecha</th>
                        <th data-order="id_venta">ID Venta</th>
                        <th data-order="estado">Estado</th>
                        <th data-order="origen">Origen</th>
                        <th data-order="asignado">Asgnado a</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tbodyListado_pedidoDeVentas"></tbody>
            </table>
        </div>

        <div class="card-footer" id="footer_pedidoDeVentas"></div>

    </div>
</div>
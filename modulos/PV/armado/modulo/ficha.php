<div class="winapp" id='container_pedidoDeVenta' style="display:none;">

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

            <div class="row g-3 align-items-center justify-content-between">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-floating form-floating-outline">
                        <select id="filtroClientes_pedidoDeVenta" class="form-select"></select>
                        <label for="filtroClientes_pedidoDeVenta">Cliente</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <button class="btn btn-label-warning w-100"><span class=" tf-icons ri-alarm-warning-fill ri-19px me-2"></span>Procesar pedidos alertadas</button>
                </div>
            </div>

        </div>

        <div class="table-responsive text-nowrap table-container">
            <table class="table table-hover">
                <thead class="table-thead">
                    <tr>
                        <th>Cliente</th>
                        <th>Pedidos pendientes</th>
                        <th>Pedidos alertadas</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody id="tbodyListado_pedidoDeVenta"></tbody>
            </table>
        </div>

        <div class="card-footer" id="footer_pedidoDeVenta"></div>

    </div>
</div>
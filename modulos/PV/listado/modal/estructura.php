<script>
    const appModalPedidoDeVentas = (function() {
        let donde = 0;
        let g_data;
        let g_productos;
        const rutaAPI = "ordenes-trabajo"

        const public = {};

        public.open = async function({
            mode = 0,
            did_cliente = 0
        } = {}) {
            donde = mode
            clienteSeleccionado = appSistema.clientes.find(c => c.did == did_cliente)

            await resetModal()
            $("#titulo_mPedidoDeVentas").text(clienteSeleccionado?.nombre_fantasia || "Cliente desconocido");
            $("#subtitulo_mPedidoDeVentas").html(`Listado de pedidos <b>${donde == 0 ? "pendientes" : "alertados"}</b>`);

            await get({
                did_cliente
            })
        }

        function get({
            did_cliente = 0
        } = {}) {
            const parametros = {
                alertada: donde
            };

            const queryString = $.param(parametros);

            globalRequest.get(`/${rutaAPI}/${did_cliente}?${queryString}`, {
                onSuccess: function(result) {
                    g_data = result.data;
                    renderPedidos()
                    $("#modal_mPedidoDeVentas").modal("show")

                    globalActivarAcciones.tooltips({
                        idContainer: "modal_mPedidoDeVentas"
                    })
                }
            });
        }

        function resetModal() {
            globalActivarAcciones.activarPrimerTab({
                tabList: "tabs_mPedidoDeVentas"
            })
        };

        function renderPedidos() {
            $("#listaPedidos_mPedidoDeVentas").empty();

            if (g_data.length === 0) {
                $("#listaPedidos_mPedidoDeVentas").html(`<div class="d-flex justify-content-center"><span class="badge rounded-pill bg-label-primary px-6">Sin pedidos</span></div>`);
                return;
            }

            let buffer = ""

            g_data.forEach((item, idx) => {
                let pedido = item?.pedidos[0]
                let operador = appSistema.usuarios.find(o => o.did == item.asignado)
                let dids_productos = []

                buffer += `<tr data-bs-toggle="collapse" data-bs-target="#linea${idx}_mPedidoDeVentas" class="accordion-toggle">`

                buffer += `<td>${item.fecha_inicio ? globalFuncionesJs.formatearFecha({fecha: item.fecha_inicio, para: "frontend"}).slice(0, 10) : '---'}</td>`
                buffer += `<td>${pedido?.id_venta || "---"}</td>`
                buffer += `<td>${pedido?.estado || "---"}</td>`
                buffer += `<td>${pedido?.flex || "---"}</td>`
                buffer += `<td>${operador?.nombre || "---"}</td>`
                buffer += `<td></td>`

                buffer += `</tr>`

                buffer += `<tr class="border-0">`

                buffer += `<td colspan="6" class="p-0 border-0">`

                buffer += `<div id="linea${idx}_mPedidoDeVentas" class="accordion-collapse collapse px-6 pb-9">`
                buffer += `<div class="row border border-primary border-top-0">`
                buffer += `<div class="col-12 p-4">`
                buffer += `<div class="row">`

                buffer += `<div class="col-4">`
                buffer += `<button type="button" class="btn btn-label-warning btn-fab demo waves-effect w-100">`
                buffer += `<span class="tf-icons ri-delete-back-2-line ri-19px me-2"></span>Desestimar pedido`
                buffer += `</button>`
                buffer += `</div>`

                buffer += `<div class="col-4">`
                buffer += `<button type="button" class="btn btn-label-dark btn-fab demo waves-effect w-100">`
                buffer += `<span class="tf-icons ri-printer-line ri-19px me-2"></span>Imprimir`
                buffer += `</button>`
                buffer += `</div>`

                buffer += `<div class="col-4">`
                buffer += `<button type="button" class="btn btn-label-success btn-fab demo waves-effect w-100">`
                buffer += `<span class="tf-icons ri-check-double-line ri-19px me-2"></span>Marcar como armado`
                buffer += `</button>`
                buffer += `</div>`

                buffer += `</div>`

                buffer += `</div>`

                buffer += `<div class="col-12">`
                buffer += `<div class="row">`

                buffer += `<div class="col-12">`
                buffer += `<div class="table-responsive">`
                buffer += `<table class="table table-bordered">`
                buffer += `<thead class="table-thead">`
                buffer += `<tr>`
                buffer += `<th colspan="4" class="text-center py-3">Productos</th>`
                buffer += `</tr>`

                buffer += `<tr>`
                buffer += `<th class="py-3">Producto</th>`
                buffer += `<th class="py-3">SKU</th>`
                buffer += `<th class="py-3">Combinacion</th>`
                buffer += `<th class="py-3">Cantidad</th>`
                buffer += `</tr>`

                buffer += `</thead>`
                buffer += `<tbody>`

                if (pedido.productos.length > 0) {
                    pedido.productos.forEach((producto) => {
                        buffer += `<tr>`
                        buffer += `<td>${producto.descripcion || "Sin informacion"}</td>`
                        buffer += `<td>${producto.sku || "Sin informacion"}</td>`
                        const varianteDescripcionParse = producto.variation_attributes ? JSON.parse(producto.variation_attributes) : []
                        const varianteDescripcion = varianteDescripcionParse.map((item) => `${item.name}${item.value_name ? `: ${item.value_name}` : "" }`)
                        buffer += `<td>${varianteDescripcion.join(" | ") || "Default"}</td>`
                        buffer += `<td class="text-center">${producto.cantidad || "1"}</td>`
                        buffer += `</tr>`

                        if (producto.did_producto) dids_productos.push(producto.did_producto)

                    })
                } else {
                    buffer += `<tr>`
                    buffer += `<td class="text-center" colspan="4">Sin productos</td>`
                    buffer += `</tr>`
                }

                buffer += `</tbody>`
                buffer += `</table>`
                buffer += `</div>`
                buffer += `</div>`

                buffer += `<div class="col-12">`
                buffer += `<div class="table-responsive">`
                buffer += `<table class="table table-bordered">`
                buffer += `<thead class="table-thead">`
                buffer += `<tr>`
                buffer += `<th colspan="2" class="text-center py-3">Insumos</th>`
                buffer += `</tr>`
                buffer += `<tr>`
                buffer += `<th class="py-3">Insumo</th>`
                buffer += `<th class="py-3">Cantidad</th>`
                buffer += `</tr>`
                buffer += `</thead>`
                buffer += `<tbody>`
                buffer += `<tr>`
                buffer += `<td>Insumo</td>`
                buffer += `<td>Cantidad</td>`
                buffer += `</tr>`
                buffer += `</tbody>`
                buffer += `</table>`
                buffer += `</div>`
                buffer += `</div>`

                buffer += `</div>`
                buffer += `</div>`

                buffer += `</div>`
                buffer += `</div>`
                buffer += `</td>`
                buffer += `</tr>`
            })

            $("#listaPedidos_mPedidoDeVentas").html(buffer);
        }

        return public;
    })();
</script>
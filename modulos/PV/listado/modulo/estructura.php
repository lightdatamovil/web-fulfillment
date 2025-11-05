<script>
    const appModuloPedidoDeVentas = (function() {
        let g_data;
        let g_meta;
        let order = "";
        let direction = "";
        let openModulo = 0
        const rutaAPI = "ordenes-trabajo"

        const public = {};

        public.paginaActual = 1;
        public.limitePorPagina = 10;

        public.open = async function() {
            $(".winapp").hide();
            $("#modulo_pedidoDeVenta").show();

            await globalLlenarSelect.clientes({
                id: "filtroClientes_pedidoDeVenta",
                multiple: true
            })

            await globalActivarAcciones.select2({
                className: "select2_pedidoDeVenta"
            })

            await appModuloPedidoDeVentas.getListado();

            await globalOrdenTablas.activar({
                idThead: "theadListado_pedidoDeVenta",
                callback: appModuloPedidoDeVentas.getListado,
                defaultOrder: "ordenes_total",
                defaultDir: "desc"
            })
        };

        public.limpiarCampos = function() {
            $(".campos_pedidoDeVenta").val("")
        };

        function renderListado() {
            $("#tbodyListado_pedidoDeVenta").empty()
            let buffer = ""

            if (!g_data || g_data.length < 1) {
                globalSinInformacion.tablasVacias({
                    idTbody: "tbodyListado_pedidoDeVenta",
                    open: openModulo
                })
                return
            };

            g_data.forEach(orden => {
                cliente = appSistema.clientes.find((cliente) => cliente.did == orden.did_cliente);

                btnPendientes = `<button type="button" ${orden.ordenes_pendientes > 0 ? `onclick="appModalPedidoDeVentas.open({mode: 0, did_cliente: ${orden.did_cliente}})"`: ""} class="btn rounded-pill btn-label-info waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="top" title="${orden.ordenes_pendientes > 0 ? "Ver": "Sin"} pedidos pendientes" style="${orden.ordenes_pendientes > 0 ? "" : "cursor: auto;"}"><i class="tf-icons ri-timer-line ri-16px me-2"></i>${orden.ordenes_pendientes || 0}</button>`
                btnAlertados = `<button type="button" ${orden.ordenes_alertadas > 0 ? `onclick="appModalPedidoDeVentas.open({mode: 1, did_cliente: ${orden.did_cliente}})"`: ""} class="btn rounded-pill btn-label-warning waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="top" title="${orden.ordenes_alertadas > 0 ? "Ver": "Sin"} pedidos alertadas" style="${orden.ordenes_alertadas > 0 ? "" : "cursor: auto;"}"><i class="tf-icons ri-alarm-warning-line ri-16px me-2"></i>${orden.ordenes_alertadas || 0}</button>`

                buffer += `<tr>`
                buffer += `<td class="${cliente ? "" : "fw-bold"}">${cliente ? cliente["nombre_fantasia"] : 'Cliente eliminado'}</td>`
                buffer += `<td class="text-center">${btnPendientes}</td>`
                buffer += `<td class="text-center">${btnAlertados}</td>`
                buffer += `<td class="text-center">${orden.ordenes_total || '0'}</td>`
                buffer += `</tr>`
            });

            $("#tbodyListado_pedidoDeVenta").html(buffer)
            $("#totalRegistros_pedidoDeVenta").text(g_meta.totalItems)
            $("#totalPaginas_pedidoDeVenta").text(g_meta.totalPages)
            globalActivarAcciones.tooltips({
                idContainer: "modulo_pedidoDeVenta"
            })

        }

        public.getListado = function({
            type = 0,
            orderBy = "",
            orderDir = ""
        } = {}) {
            openModulo = type;
            order = orderBy || order;
            direction = orderDir || direction;

            const parametros = {
                page: type === 1 ? 1 : public.paginaActual,
                page_size: public.limitePorPagina,
                sort_by: order,
                sort_dir: direction,
                did_cliente: $("#filtroClientes_pedidoDeVenta").val().join(",")
            };

            const queryString = $.param(parametros);

            globalRequest.get(`/${rutaAPI}?${queryString}`, {
                onSuccess: function(result) {
                    g_data = result.data;
                    g_meta = result.meta;
                    public.paginaActual = parseInt(g_meta.page);
                    renderListado();
                    globalPaginado.generar({
                        idBase: "_pedidoDeVenta",
                        meta: g_meta,
                        estructura: appModuloPedidoDeVentas
                    });
                },
            });
        };

        return public;
    })();
</script>
<script>
    const appModuloPedidoDeVentas = (function() {
        let g_data;
        let g_meta;
        let order = "";
        let direction = "";
        let openModulo = 0;
        let rangoFecha = true;

        const rutaAPI = "ordenes-trabajo"

        const public = {};

        public.paginaActual = 1;
        public.limitePorPagina = 10;

        public.open = async function() {
            $(".winapp").hide();
            $("#modulo_pedidoDeVentas").show();

            await globalLlenarSelect.clientes({
                id: "filtroClientes_pedidoDeVentas",
                multiple: true
            })

            await globalLlenarSelect.armadores({
                id: "filtroArmador_pedidoDeVentas",
                multiple: true
            })

            await globalLlenarSelect.estadosOT({
                id: "filtroEstado_pedidoDeVentas",
                multiple: true
            })

            await globalLlenarSelect.tiendas({
                id: "filtroOrigen_pedidoDeVentas",
                multiple: true
            })

            await globalActivarAcciones.select2({
                className: "select2_pedidoDeVentas"
            })

            await formatearRangoFecha()

            await appModuloPedidoDeVentas.getListado();

            await globalActivarAcciones.filtrarConEnter({
                className: "inputs_pedidoDeVentas",
                callback: appModuloPedidoDeVentas.getListado
            })

            await globalOrdenTablas.activar({
                idThead: "theadListado_pedidoDeVentas",
                callback: appModuloPedidoDeVentas.getListado,
                defaultOrder: "fecha",
                defaultDir: "desc"
            })
        };

        public.limpiarCampos = function() {
            $(".campos_pedidoDeVentas").val("")
            $(".select2_pedidoDeVentas").trigger("change")
            appModuloPedidoDeVentas.cambiarTipoFecha(true)
            formatearRangoFecha()
        };

        function formatearRangoFecha() {
            const fechaDesde = globalFuncionesJs.formatearFecha({
                fecha: "hoy",
                para: "date",
                menos: 7
            })

            const fechaHasta = globalFuncionesJs.formatearFecha({
                fecha: "hoy",
                para: "date"
            })

            $('#filtroFechaDesde_pedidoDeVentas').val(fechaDesde);
            $('#filtroFechaHasta_pedidoDeVentas').val(fechaHasta);
        }

        public.cambiarTipoFecha = function(rango) {
            if (rango) {
                rangoFecha = rango
            } else {
                rangoFecha = !rangoFecha
            }

            if (rangoFecha) {
                $("#filtroFechaHasta_pedidoDeVentas").removeClass("ocultar")
                $("#tipoFecha_pedidoDeVentas").removeClass("rounded-end")
            } else {
                $("#filtroFechaHasta_pedidoDeVentas").addClass("ocultar")
                $("#tipoFecha_pedidoDeVentas").addClass("rounded-end")
            }
        };

        function renderListado() {
            $("#tbodyListado_pedidoDeVentas").empty()
            let buffer = ""

            if (!g_data || g_data.length < 1) {
                globalSinInformacion.tablasVacias({
                    idTbody: "tbodyListado_pedidoDeVentas",
                    open: openModulo
                })
                return
            };

            g_data.forEach(pedido => {
                const venta = pedido.pedidos[0]

                let cliente = "<b>Cliente no registrado</b>"
                if (venta.did_cliente) {
                    cliente = appSistema.clientes.find(c => c.did == venta.did_cliente)?.nombre_fantasia || "<b>Cliente eliminado</b>";
                }

                estado = appSistema.estadosOT.find(e => e.did == pedido.estado) || {};
                htmlEstado = `<span class="badge rounded-pill bg-label-${estado.color || "secondary"}">${estado.nombre || "Desconocido"}</span>`

                let armador = "<b>Usuario no registrado</b>"
                if (pedido.asignado) {
                    armador = appSistema.usuarios.find(c => c.did == pedido.asignado)?.nombre || "<b>Usuario eliminado</b>";
                }

                buffer += `<tr class="${pedido.alertada == 1 ? "bg-label-warning" : ""}">`
                buffer += `<td>${cliente || '---'}</td>`
                buffer += `<td>${pedido.fecha_inicio ? globalFuncionesJs.formatearFecha({fecha: pedido.fecha_inicio, para: "frontend"}).slice(0, 10) : '---'}</td>`
                buffer += `<td>${venta.id_venta || '---'}</td>`
                buffer += `<td>${htmlEstado}</td>`
                buffer += `<td>${appSistema.ecommerce[venta.flex] || '---'}</td>`
                buffer += `<td>${armador || '---'}</td>`

                buffer += `<td>`
                buffer += `<button type="button" class="btn btn-icon rounded-pill btn-text-primary" onclick="appModalPedidoDeVentas.open({did: '${pedido.did}'})" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver">`
                buffer += `<i class="tf-icons ri-eye-line ri-22px"></i>`
                buffer += `</button>`
                buffer += `<button type="button" class="btn btn-icon rounded-pill btn-text-primary" onclick="appModalPedidoDeVentas.eliminar('${pedido.did}')" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar">`
                buffer += `<i class="tf-icons ri-delete-bin-6-line ri-22px"></i>`
                buffer += `</button>`
                buffer += `</td>`

                buffer += `</tr>`
            });

            $("#tbodyListado_pedidoDeVentas").html(buffer)
            $("#totalRegistros_pedidoDeVentas").text(g_meta.totalItems)
            $("#totalPaginas_pedidoDeVentas").text(g_meta.totalPages)
            globalActivarAcciones.tooltips({
                idContainer: "modulo_pedidoDeVentas"
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
                fecha_from: $("#filtroFechaDesde_pedidoDeVentas").val(),
                fecha_to: rangoFecha ? $("#filtroFechaHasta_pedidoDeVentas").val() : $("#filtroFechaDesde_pedidoDeVentas").val(),
                id_venta: $("#filtroIdVenta_pedidoDeVentas").val().trim(),
                asignado: $("#filtroArmador_pedidoDeVentas").val().join(","),
                did_cliente: $("#filtroClientes_pedidoDeVentas").val().join(","),
                origen: $("#filtroOrigen_pedidoDeVentas").val().join(","),
                estado: $("#filtroEstado_pedidoDeVentas").val().join(","),
                alertada: $("#filtroAlertada_pedidoDeVentas").val(),
            };

            const queryString = $.param(parametros);

            globalRequest.get(`/${rutaAPI}?${queryString}`, {
                onSuccess: function(result) {
                    g_data = result.data;
                    g_meta = result.meta;
                    public.paginaActual = parseInt(g_meta.page);
                    renderListado();
                    globalPaginado.generar({
                        idBase: "_pedidoDeVentas",
                        meta: g_meta,
                        estructura: appModuloPedidoDeVentas
                    });
                },
            });
        };

        return public;
    })();
</script>
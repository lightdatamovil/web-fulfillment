<script>
    const appModalPedidoDeVentas = (function() {
        let g_did = 0
        let g_data = {};
        let g_productos = [];
        let g_insumos = [];
        let g_didsProductos = [];
        let g_didsInsumos = [];
        let logosTiendas = {}

        const rutaAPI = "ordenes-trabajo"

        const public = {};

        public.open = async function({
            did = 0
        } = {}) {
            await resetModal()
            g_did = did
            logosTiendas = globalLogoTiendas.obtener()


            await get()
        }

        function resetModal() {
            g_did = 0
            g_data = {};
            g_productos = [];
            g_insumos = [];
            g_didsProductos = [];
            g_didsInsumos = [];

            globalActivarAcciones.activarPrimerTab({
                tabList: "tabs_mPedidoDeVentas"
            })
        };

        function get() {
            globalRequest.get(`/${rutaAPI}/${g_did}`, {
                onSuccess: async function(result) {
                    g_data = result.data;

                    $("#fecha_mPedidoDeVentas").html(g_data.fecha_inicio ? globalFuncionesJs.formatearFecha({
                        fecha: g_data.fecha_inicio,
                        para: "frontend"
                    }).slice(0, 10) : 'Sin informacion')
                    $("#cliente_mPedidoDeVentas").html(appSistema.clientes?.find(c => c.did == g_data.pedidos[0].did_cliente)?.nombre_fantasia || "Cliente desconocido")
                    const usuarioAsignado = appSistema.usuarios.find(u => u.did == g_data.asignado)
                    $("#asignado_mPedidoDeVentas").html(usuarioAsignado ? `${usuarioAsignado.nombre} ${usuarioAsignado.apellido}` : "Desconocido")
                    $("#estado_mPedidoDeVentas").html(appSistema.estadosOT?.find(e => e.did == g_data.estado)?.nombre || "Desconocido")
                    $("#alertada_mPedidoDeVentas").html(g_data.alertada == 1 ? "Si" : "No")
                    $("#idVenta_mPedidoDeVentas").html(g_data.pedidos[0].id_venta)
                    $("#tienda_mPedidoDeVentas").html(g_data.pedidos[0].flex != 0 ? logosTiendas[g_data.pedidos[0].flex] : `<span class="fs-6 fw-bold">DIRECTO</span>`)

                    g_productos = await g_data.pedidos.map(p => p.productos).flat()
                    await renderProductos()
                    await renderInsumos()
                    $("#modal_mPedidoDeVentas").modal("show")

                    globalActivarAcciones.tooltips({
                        idContainer: "modal_mPedidoDeVentas"
                    })
                }
            });
        }

        function renderProductos() {
            $("#tbodyListaProductos_pedidoDeVentas").empty()

            if (g_productos.length < 1) {
                $("#tbodyListaProductos_pedidoDeVentas").html(`<tr><td colspan="4"><div class="d-flex justify-content-center"><span class="badge rounded-pill bg-label-primary px-6">Sin productos</span></div></td></tr>`)
                return
            }

            let buffer = ""

            g_productos.forEach(producto => {
                buffer += `<tr>`
                buffer += `<td>${producto.seller_sku  || "Sin sku"}</td>`
                buffer += `<td class="text-wrap">${producto.descripcion || "Desconocido"}</td>`
                const varianteDescripcionParse = producto.variation_attributes ? JSON.parse(producto.variation_attributes) : []
                const varianteDescripcion = varianteDescripcionParse.map((item) => `${item.name}${item.value_name ? `: ${item.value_name}` : "" }`)
                buffer += `<td>${varianteDescripcion.join(" | ") || "Default"}</td>`
                buffer += `<td>${producto.cantidad || "1"}</td>`
                buffer += `</tr>`

                if (producto.did_producto) g_didsProductos.push(producto.did_producto)
            });

            $("#tbodyListaProductos_pedidoDeVentas").html(buffer)

            g_didsInsumos = appSistema.productos.filter(p => g_didsProductos.includes(p.did)).map(p => p.insumos).flat();
        }

        function agruparInsumos() {
            const agrupados = Object.values(
                g_didsInsumos.reduce((acc, item) => {
                    if (!acc[item.did_insumo]) {
                        acc[item.did_insumo] = {
                            ...item
                        };
                    } else {
                        acc[item.did_insumo].cantidad += item.cantidad;
                    }
                    return acc;
                }, {})
            );

            g_insumos = agrupados.map(item => {
                const info = appSistema.insumos.find(i => i.did === item.did_insumo);
                return {
                    did_insumo: item.did_insumo,
                    nombre: info ? info.nombre : "Desconocido",
                    cantidad: item.cantidad || "0"
                };
            });

        }


        function renderInsumos() {
            agruparInsumos()
            $("#tbodyListaInsumos_pedidoDeVentas").empty()

            if (g_insumos.length < 1) {
                $("#tbodyListaInsumos_pedidoDeVentas").html(`<tr><td colspan="2"><div class="d-flex justify-content-center"><span class="badge rounded-pill bg-label-primary px-6">Sin insumos</span></div></td></tr>`)
                return
            }

            let buffer = ""

            g_insumos.forEach(insumos => {
                buffer += `<tr>`
                buffer += `<td>${insumos.nombre  || "Desconocido"}</td>`
                buffer += `<td class="text-center">${insumos.cantidad || "1"}</td>`
                buffer += `</tr>`
            });

            $("#tbodyListaInsumos_pedidoDeVentas").html(buffer)
        }

        return public;
    })();
</script>
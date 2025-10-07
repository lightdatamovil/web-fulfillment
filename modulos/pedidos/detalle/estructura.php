<script>
    const appPedido = (function() {
        let g_did = 0;
        let g_data;
        let logosTiendas = {}

        const public = {};

        public.open = function(did) {
            globalLoading.open()
            resetModal();
            g_did = did
            logosTiendas = globalLogoTiendas.obtener()
            getPedido()
        }

        function getPedido() {
            parametros = {
                idEmpresa: appSistema.idEmpresa,
                did: g_did
            };

            $.ajax({
                url: `${appSistema.urlServer}/pedido/getPedidoById`,
                type: "POST",
                data: parametros,
                headers: {
                    Authorization: `Bearer ${appSistema.tkn}`
                },
                success: function(result) {
                    if (result.estado && result.data) {
                        g_data = result.data;
                        render();
                        globalLoading.close()
                        $("#modalPedido").modal("show")
                    }
                },
                error: function(xhr) {
                    console.log("Error", xhr.responseText);
                    globalLoading.close()
                    globalSweetalert.error()
                }
            });
        }

        function render() {
            const htmlStatus = `<span class="badge rounded-pill bg-label-${appSistema.dbEstadosPedidos[g_data.status].color} me-2">${appSistema.dbEstadosPedidos[g_data.status].traduccion}</span>`

            $("#tienda_mPedidos").html(logosTiendas[g_data.flex] ? logosTiendas[g_data.flex] : "")
            $("#cliente_mPedidos").html(g_data.cliente || "")
            $("#numero_mPedidos").html(g_data.number || "Sin numero");
            $("#comprador_mPedidos").html(g_data.nombreComprador || "Sin comprador");
            $("#fecha_mPedidos").html(g_data.fecha_venta ? globalFuncionesJs.formatearFecha(g_data.fecha_venta) : "Sin fecha");
            $("#status_mPedidos").html(htmlStatus)

            if (g_data.items.length == 0) {
                $("#items_mPedidos").html('<p class="text-muted text-center">Sin items aún.</p>');
            } else {
                buffer = `<table class="table table-bordered">`
                buffer += `<thead>`
                buffer += `<tr>`
                buffer += `<th>ID</th>`
                buffer += `<th>Descripcion</th>`
                buffer += `<th>Cantidad</th>`
                buffer += `</tr>`
                buffer += `</thead>`

                buffer += `<tbody>`

                g_data.items.forEach((i, idx) => {
                    buffer += `<tr>`
                    buffer += `<td>${i.user_product_id}</td>`
                    buffer += `<td>${i.descripcion}</td>`
                    buffer += `<td>${i.cantidad}</td>`
                    buffer += `</tr>`
                });

                buffer += `</tbody>`
                buffer += `</table>`

                $("#items_mPedidos").html(buffer);
            }
        }

        function resetModal() {
            $("#tienda_mPedidos").empty();
            $("#cliente_mPedidos").empty();
            $("#numero_mPedidos").empty();
            $("#comprador_mPedidos").empty();
            $("#fecha_mPedidos").empty();
            $("#status_mPedidos").empty()
            $("#items_mPedidos").empty()
        };

        public.eliminar = function(did) {
            const datos = {
                idEmpresa: appSistema.idEmpresa,
                did
            }

            globalSweetalert.confirmar("¿Estas seguro de eliminar este pedido?", "var(--bs-danger)").then(function(confirmado) {
                if (confirmado) {
                    globalLoading.open()
                    $.ajax({
                        url: `${appSistema.urlServer}/pedido/deletePedido`,
                        data: datos,
                        type: "POST",
                        contentType: "application/json",
                        headers: {
                            Authorization: `Bearer ${appSistema.tkn}`
                        },
                        data: JSON.stringify(datos),
                        success: function(result) {
                            globalLoading.close()
                            globalSweetalert.exito("Eliminado con exito!")
                            appPedidosListado.getListado();
                        },
                        error: function(xhr) {
                            console.log("Error al guardar", xhr.responseText);
                            globalLoading.close()
                            globalSweetalert.error()
                        }
                    });

                }
            })
        };

        return public;
    })();
</script>
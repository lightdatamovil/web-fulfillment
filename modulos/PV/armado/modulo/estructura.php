<script>
    const appModuloPedidoDeVenta = (function() {
        let g_data = {
            "estado": true,
            "data": [{
                "cliente": 1,
                "pendientes": 10,
                "alertados": 15,
            }]
        }
        const public = {};
        let openModulo = 0

        public.open = function() {
            $(".winapp").hide();
            $("#container_pedidoDeVenta").show();
            globalLlenarSelect.clientes({
                id: "filtroClientes_pedidoDeVenta"
            })
            appModuloPedidoDeVenta.getListado();
        };

        public.limpiarCampos = function() {
            $("#filtroClientes_pedidoDeVenta").val("");
        };

        function renderListado() {
            $("#tbodyListado_pedidoDeVenta").empty()
            buffer = ""

            if (!g_data.data || g_data.data.length < 1) {
                globalSinInformacion.tablasVacias("tbodyListado_pedidoDeVenta", openModulo, "OTs")
                return
            };

            g_data.data.forEach(orden => {
                cliente = appSistema.clientes.find((cliente) => cliente.did == orden.cliente);

                btnPendientes = `<button type="button" class="btn rounded-pill btn-primary waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="top" title="${orden.pendientes > 0 ? "Ver ordenes pendientes": "Sin ordenes"}"><i class="tf-icons ri-timer-line ri-16px me-2"></i>${orden.pendientes || 0}</button>`
                btnAlertados = `<button type="button" class="btn rounded-pill btn-warning waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="top" title="${orden.alertados > 0 ? "Ver ordenes alertadas": "Sin ordenes"}"><i class="tf-icons ri-alarm-warning-line ri-16px me-2"></i>${orden.alertados || 0}</button>`

                buffer += `<tr>`
                buffer += `<td>${cliente ? cliente["nombre_fantasia"] : '---'}</td>`
                buffer += `<td>${btnPendientes}</td>`
                buffer += `<td>${btnAlertados}</td>`
                buffer += `<td>${orden.alertados + orden.pendientes || '0'}</td>`
                buffer += `</tr>`
            });

            $("#tbodyListado_pedidoDeVenta").html(buffer)
            globalActivarAcciones.tooltips("ContainerOTListado")
        }

        public.getListado = function(type) {
            openModulo = type
            tienda = $("#filtroClientes_pedidoDeVenta").val();

            const parametros = {
                "idEmpresa": appSistema.idEmpresa,
                "tienda": tienda,
            };

            // globalLoading.open()
            // $.ajax({
            //     url: `${appSistema.urlServer}/armado/getArmados`,
            //     type: "POST",
            //     data: JSON.stringify(parametros),
            //     contentType: "application/json",
            //     headers: {
            //         "Authorization": `Bearer ${appSistema.tkn}`
            //     },
            //     success: function(result) {
            //         g_data = result
            //         if (g_data.estado && g_data.data) {
            renderListado();
            // }
            // globalLoading.close()

            //     },
            //     error: function() {
            //         globalLoading.close()
            //         globalSweetalert.error()
            //     },
            //     complete: function() {
            //         globalLoading.close()
            //     }
            // });
        };

        return public;
    })();
</script>
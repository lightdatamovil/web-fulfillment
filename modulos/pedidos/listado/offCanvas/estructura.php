<script>
    const appOffCanvasPedidos = (function() {
        let g_did = 0
        let g_idVenta = ""
        const rutaAPI = "ordenes-trabajo"

        const public = {}

        public.open = async function({
            did,
            idVenta
        }) {
            await reset()
            g_did = did
            g_idVenta = idVenta

            $("#idVenta_oPedidos").html(g_idVenta || "Sin información")

            await globalActivarAcciones.toggleOffcanvas({
                id: "offCanvas_oPedidos"
            })

            await globalLlenarSelect.armadores({
                id: "armadores_oPedidos",
            })

            await globalActivarAcciones.select2({
                className: "select2_oPedidos"
            })
        }

        function reset() {
            globalValidar.deshabilitarTiempoReal({
                className: "camposObliFeedback_oPedidos"
            })

            $(".campos_oPedidos").val("")
            $("#armadores_oPedidos").change()
            g_did = 0
            g_idVenta = ""
        }

        function validacionFeedback() {
            return globalValidar.obligatorios({
                className: "camposObliFeedback_oPedidos"
            })
        }

        public.trabajarPedido = function() {
            const datos = {
                "did_pedidos": [g_did],
                "did_usuario": $("#armadores_oPedidos").val()
            };

            globalValidar.habilitarTiempoReal({
                className: "camposObliFeedback_oPedidos",
                callback: validacionFeedback
            })

            if (validacionFeedback()) {
                globalSweetalert.alert({
                    titulo: "Verifique los campos"
                })
                return
            }

            globalSweetalert.confirmar({
                    titulo: `¿Estas seguro de trabajar este pedido?`
                })
                .then(function(confirmado) {
                    if (confirmado) {
                        globalRequest.post(`/${rutaAPI}`, datos, {
                            onSuccess: function(result) {
                                $("#modal_mPedidos").modal("hide")
                                globalActivarAcciones.toggleOffcanvas({
                                    id: "offCanvas_oPedidos"
                                })
                                globalSweetalert.exito({
                                    titulo: `Pedido trabajado con exito!`
                                })
                                appModuloPedidos.getListado();
                            }
                        });
                    }
                });
        };

        return public
    })()
</script>
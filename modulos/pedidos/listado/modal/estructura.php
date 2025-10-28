<script>
    const appModalPedidos = (function() {
        let g_did = 0;
        let g_data;
        let g_productos;
        let donde = 0;
        const rutaAPI = "pedidos"

        const public = {};

        public.open = async function({
            mode = 0,
            did = 0
        } = {}) {
            await resetModal()
            g_did = did;
            donde = mode

            await globalLlenarSelect.clientes({
                id: "cliente_mPedidos",
            })

            await globalLlenarSelect.productos({
                id: "producto_productos_mPedidos"
            })

            if (mode == 0) {
                // NUEVO PEDIDO
                $("#titulo_mPedidos").text("Nuevo pedido");
                $("#subtitulo_mPedidos").text("Creacion de pedido nuevo, completar formulario.");
                $('.campos_mPedidos').prop('disabled', false);
                $("#checkHabilitado_mPedidos").prop("checked", true);
                $("#tienda_mPedidos").prop('disabled', true);
                $("#btnEditar_mPedidos").addClass("ocultar");
                $("#btnGuardar_mPedidos, .ocultarDesdeVer_mPedidos").removeClass("ocultar");
                renderProductos()
                $("#modal_mPedidos").modal("show")
            } else if (mode == 1) {
                // MODIFICAR PEDIDO
                await globalLoading.open()
                $("#titulo_mPedidos").text("Modificar pedido");
                $("#subtitulo_mPedidos").html("Recordá presionar <b>Guardar</b> antes de salir, así conservás todos los cambios ");
                $('.campos_mPedidos').prop('disabled', false);
                $("#btnGuardar_mPedidos").addClass("ocultar");
                $("#btnEditar_mPedidos, .ocultarDesdeVer_mPedidos").removeClass("ocultar");
                await get()
            } else {
                // VER PEDIDO
                await globalLoading.open()
                $("#titulo_mPedidos").text("Ver pedido");
                $("#subtitulo_mPedidos").text("Visualizacion de pedido, no se puede modificar.");
                $('.campos_mPedidos').prop('disabled', true);
                $("#btnGuardar_mPedidos, #btnEditar_mPedidos, .ocultarDesdeVer_mPedidos").addClass("ocultar");
                await get()
            }

            await globalActivarAcciones.select2({
                className: "select2_mPedidos"
            })
        }

        function get() {
            globalRequest.get(`/${rutaAPI}/${g_did}`, {
                onSuccess: function(result) {
                    g_data = result.data;
                    $("#cliente_mPedidos").val(g_data.did_cliente).change();
                    $("#tienda_mPedidos").val(g_data.did_cuenta).change();
                    $("#idVenta_mPedidos").val(g_data.id_venta);
                    $("#comprador_mPedidos").val(g_data.comprador);
                    $("#total_mPedidos").val(g_data.total);
                    $("#observacion_mPedidos").val(g_data.observacion);
                    $("#calle_mPedidos").val(g_data.direccion.calle);
                    $("#numero_mPedidos").val(g_data.direccion.numero);
                    $("#cp_mPedidos").val(g_data.direccion.cp);
                    $("#localidad_mPedidos").val(g_data.direccion.localidad);
                    $("#provincia_mPedidos").val(g_data.direccion.provincia);
                    $("#latitud_mPedidos").val(g_data.direccion.latitud);
                    $("#longitud_mPedidos").val(g_data.direccion.longitud);
                    $("#referencia_mPedidos").val(g_data.direccion.referencia);

                    g_productos = g_data.productos || []
                    renderProductos();

                    if (donde == 2) {
                        $('.campos_mPedidos').prop('disabled', true);
                        $(".ocultarDesdeVer_mPedidos").addClass("ocultar")
                    } else {
                        $('.campos_mPedidos').prop('disabled', false);
                        $(".ocultarDesdeVer_mPedidos").removeClass("ocultar")
                    }
                    $("#modal_mPedidos").modal("show")
                }
            });
        }

        function resetModal() {
            globalActivarAcciones.activarPrimerTab({
                tabList: "tabs_mPedidos"
            })

            $(".campos_mPedidos").val("")
            $(".select2_mPedidos").trigger("change")
            g_productos = [];

            globalValidar.limpiarTodas()
            globalValidar.deshabilitarTiempoReal({
                className: "camposObli_mPedidos"
            })
        };

        public.changeCliente = function() {
            let clienteSeleccionado = $("#cliente_mPedidos").val()
            let buffer = ""

            if (!clienteSeleccionado) {
                buffer += `<option value="">Selecciona un cliente para acceder</option>`

                $("#tienda_mPedidos").html(buffer);
                $("#tienda_mPedidos").prop('disabled', true);
            } else {
                let cliente = appSistema.clientes.find((item) => item.did == clienteSeleccionado)

                buffer += `<option value="">Selecciona una tienda</option>`

                cliente.cuentas.forEach(cuenta => {
                    buffer += `<option value="${cuenta.did}">${cuenta.titulo} - ${appSistema.ecommerce[cuenta.flex]}</option>`
                });

                $("#tienda_mPedidos").html(buffer);
                $("#tienda_mPedidos").prop('disabled', false);
            }
        }

        function renderProductos() {
            globalActivarAcciones.formRepeater({
                id: "formProductos_mPedidos",
                data: g_productos
            })
        };

        function validacion() {
            return globalValidar.obligatorios({
                className: "camposObli_mPedidos"
            })
        }

        public.guardar = function() {
            const datos = {
                did_cliente: $("#cliente_mPedidos").val() || null,
                did_cuenta: $("#tienda_mPedidos").val() || null,
                id_venta: $("#idVenta_mPedidos").val().trim() || "",
                comprador: $("#comprador_mPedidos").val().trim() || "",
                total: $("#total_mPedidos").val().trim() || "",
                observacion: $("#observacion_mPedidos").val().trim() || "",
                direccion: {
                    calle: $("#calle_mPedidos").val().trim() || "",
                    numero: $("#numero_mPedidos").val().trim() || "",
                    cp: $("#cp_mPedidos").val().trim() || "",
                    localidad: $("#localidad_mPedidos").val().trim() || "",
                    provincia: $("#provincia_mPedidos").val().trim() || "",
                    latitud: $("#latitud_mPedidos").val().trim() || "",
                    longitud: $("#longitud_mPedidos").val().trim() || "",
                    referencia: $("#referencia_mPedidos").val().trim() || "",
                },
                productos: globalActivarAcciones.obtenerDataFormRepeater({
                    id: "formProductos_mPedidos"
                }),
            };

            globalValidar.formRepeater({
                id: "formProductos_mPedidos"
            })

            globalValidar.habilitarTiempoReal({
                className: "camposObli_mPedidos",
                callback: validacion
            });

            if (validacion()) {
                globalSweetalert.alert({
                    titulo: "Verifique los campos"
                });
                return;
            }

            if (datos.productos.length === 0) {
                globalSweetalert.alert({
                    titulo: "Debe agregar al menos un producto"
                });
                return;
            }

            globalSweetalert.confirmar({
                    titulo: "¿Estas seguro de guardar esta pedido?"
                })
                .then(function(confirmado) {
                    if (confirmado) {
                        globalRequest.post(`/${rutaAPI}`, datos, {
                            onSuccess: function(result) {
                                $("#modal_mPedidos").modal("hide");
                                globalSweetalert.exito();
                                appModuloPedidos.getListado();
                            }
                        });
                    }
                });
        };

        public.editar = function() {
            const datosNuevos = {
                did_cliente: $("#cliente_mPedidos").val() || null,
                did_cuenta: $("#tienda_mPedidos").val() || null,
                id_venta: $("#idVenta_mPedidos").val().trim() || "",
                comprador: $("#comprador_mPedidos").val().trim() || "",
                total: $("#total_mPedidos").val().trim() || "",
                observacion: $("#observacion_mPedidos").val().trim() || "",
                direccion: {
                    calle: $("#calle_mPedidos").val().trim() || "",
                    numero: $("#numero_mPedidos").val().trim() || "",
                    cp: $("#cp_mPedidos").val().trim() || "",
                    localidad: $("#localidad_mPedidos").val().trim() || "",
                    provincia: $("#provincia_mPedidos").val().trim() || "",
                    latitud: $("#latitud_mPedidos").val().trim() || "",
                    longitud: $("#longitud_mPedidos").val().trim() || "",
                    referencia: $("#referencia_mPedidos").val().trim() || "",
                },
                productos: globalActivarAcciones.obtenerDataFormRepeater({
                    id: "formProductos_mPedidos"
                }),
            };

            globalValidar.formRepeater({
                id: "formProductos_mPedidos"
            })

            globalValidar.habilitarTiempoReal({
                className: "camposObli_mPedidos",
                callback: validacion
            });

            if (validacion()) {
                globalSweetalert.alert({
                    titulo: "Verifique los campos"
                });
                return;
            }

            const datosModificados = globalValidar.obtenerCambios({
                dataNueva: datosNuevos,
                dataOriginal: g_data
            });

            if (Object.keys(datosModificados).length === 0) {
                globalSweetalert.alert({
                    titulo: "No se realizaron cambios"
                });
                return;
            }

            datosNuevos.productos = globalValidar.obtenerCambiosEnArray({
                dataNueva: datosNuevos.productos,
                dataOriginal: g_productos
            })

            globalSweetalert.confirmar({
                    titulo: "¿Estas seguro de modificar esta pedido?"
                })
                .then(function(confirmado) {
                    if (confirmado) {
                        globalRequest.put(`/${rutaAPI}/${g_did}`, datosNuevos, {
                            onSuccess: function(result) {
                                $("#modal_mPedidos").modal("hide");
                                globalSweetalert.exito();
                                appModuloPedidos.getListado();
                            }
                        });
                    }
                });
        };

        public.eliminar = function(did) {
            globalSweetalert.confirmar({
                titulo: "¿Estas seguro de eliminar esta pedido?",
                color: "var(--bs-danger)"
            }).then(function(confirmado) {
                if (confirmado) {
                    globalRequest.delete(`/${rutaAPI}/${did}`, {
                        onSuccess: function(result) {
                            globalSweetalert.exito({
                                titulo: "Eliminado con éxito!"
                            });
                            appModuloPedidos.getListado();
                        }
                    });
                }
            });
        };

        return public;
    })();
</script>
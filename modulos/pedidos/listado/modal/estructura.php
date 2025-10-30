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
                    $("#fechaVenta_mPedidos").val(globalFuncionesJs.formatearFecha({
                        fecha: g_data.fecha_venta,
                        para: "date"
                    }))
                    $("#cliente_mPedidos").val(g_data.did_cliente);
                    $("#idVenta_mPedidos").val(g_data.id_venta);
                    $("#total_mPedidos").val(g_data.total);
                    $("#deadline_mPedidos").val(globalFuncionesJs.formatearFecha({
                        fecha: g_data.deadline,
                        para: "date"
                    }))
                    $("#observacion_mPedidos").val(g_data.observacion);

                    $("#comprador_nombre_mPedidos").val(g_data.comprador.nombre);
                    $("#comprador_telefono_mPedidos").val(g_data.comprador.telefono);
                    $("#comprador_email_mPedidos").val(g_data.comprador.email);

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

                    $(".producto_productos_mPedidos").each(function() {
                        $(this).trigger("change");
                        const valor = $(this).val()
                        const producto = g_productos.find(p => p.did_producto == valor);

                        if (producto) {
                            const selectVariante = $(this).closest('[data-repeater-item]').find('.variantes_productos_mPedidos');
                            const variante = producto.did_producto_variante_valor || "default"
                            selectVariante.val(variante).trigger("change");
                        }
                    });

                    if (donde == 2) {
                        $('.campos_mPedidos, .variantes_productos_mPedidos').prop('disabled', true);
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


            const fechaActual = globalFuncionesJs.formatearFecha({
                para: "date"
            })
            $("#fechaVenta_mPedidos").val(fechaActual);
            $("#deadline_mPedidos").val(fechaActual);

            g_productos = [];

            globalValidar.limpiarTodas()
            globalValidar.deshabilitarTiempoReal({
                className: "camposObli_mPedidos"
            })
        };

        function renderProductos() {
            globalActivarAcciones.formRepeater({
                id: "formProductos_mPedidos",
                data: g_productos
            })
        };

        public.renderVariantes = function(select) {
            const $item = $(select).closest("[data-repeater-item]");
            const productoSeleccionado = $(select).val();
            const $selectVariante = $item.find("select[name$='[did_producto_variante_valor]']"); // ← clave

            if (productoSeleccionado) {
                let variantes = obtenerVariantes(productoSeleccionado);

                let buffer = ""

                buffer += `<option value="">Seleccionar variante</option>`
                variantes.forEach(v => buffer += `<option value="${v.did_producto_variante_valor}">${v.nombre_producto_variante_valor}</option>`);
                $selectVariante.prop("disabled", false).html(buffer);
            } else {
                $selectVariante.prop("disabled", true).html('<option value="">Selecciona el producto para ver</option>');
            }
        };


        function obtenerVariantes(didProducto) {
            const producto = appSistema.productos.find(p => p.did == didProducto);
            if (!producto) return [{
                did_producto_variante_valor: "default",
                nombre_producto_variante_valor: "Default"
            }]

            const {
                did_curva,
                valores
            } = producto;
            if (!did_curva || !valores?.length) return [{
                did_producto_variante_valor: "default",
                nombre_producto_variante_valor: "Default"
            }];

            const curva = appSistema.curvas.find(c => c.did == did_curva);
            if (!curva) return [{
                did_producto_variante_valor: "default",
                nombre_producto_variante_valor: "Default"
            }]

            const resultado = valores.map(grupo => {
                const partes = grupo.valores.map(valorDid => {

                    for (const categoria of curva.categorias) {
                        const did_variante = categoria.did_variante
                        const nombreVariante = appSistema.variantes.find(v => v.did == did_variante)?.nombre || "Variante desconocida";
                        const valorEncontrado = categoria.valores.find(v => v.did == valorDid);
                        if (valorEncontrado) {
                            return `${nombreVariante} ${categoria.nombre.toLowerCase()}: ${valorEncontrado.nombre}`;
                        }
                    }
                    return null;
                }).filter(Boolean);

                return {
                    did_producto_variante_valor: grupo.did_productos_variantes_valores,
                    nombre_producto_variante_valor: partes.join(" | ")
                };
            });

            return resultado;
        }

        function validacion() {
            return globalValidar.obligatorios({
                className: "camposObli_mPedidos"
            })
        }

        public.guardar = function() {
            const datos = {
                fecha_venta: globalFuncionesJs.formatearFecha({
                    fecha: $("#fechaVenta_mPedidos").val(),
                    para: "api"
                }),
                did_cliente: $("#cliente_mPedidos").val() || null,
                id_venta: $("#idVenta_mPedidos").val().trim() || "",
                total: $("#total_mPedidos").val().trim() || "",
                deadline: globalFuncionesJs.formatearFecha({
                    fecha: $("#deadline_mPedidos").val(),
                    para: "api"
                }),
                observacion: $("#observacion_mPedidos").val().trim() || "",
                comprador: {
                    nombre: $("#comprador_nombre_mPedidos").val().trim() || "",
                    telefono: $("#comprador_telefono_mPedidos").val().trim() || "",
                    email: $("#comprador_email_mPedidos").val().trim() || ""
                },
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
                })
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

            datos.productos = datos.productos.map((item) => {
                return {
                    ...item,
                    did_producto_variante_valor: item.did_producto_variante_valor === "default" ? null : item.did_producto_variante_valor
                }
            })

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
                fecha_venta: globalFuncionesJs.formatearFecha({
                    fecha: $("#fechaVenta_mPedidos").val(),
                    para: "api"
                }),
                did_cliente: $("#cliente_mPedidos").val() || null,
                id_venta: $("#idVenta_mPedidos").val().trim() || "",
                total: $("#total_mPedidos").val().trim() || "",
                deadline: globalFuncionesJs.formatearFecha({
                    fecha: $("#deadline_mPedidos").val(),
                    para: "api"
                }),
                observacion: $("#observacion_mPedidos").val().trim() || "",
                comprador: {
                    nombre: $("#comprador_nombre_mPedidos").val().trim() || "",
                    telefono: $("#comprador_telefono_mPedidos").val().trim() || "",
                    email: $("#comprador_email_mPedidos").val().trim() || ""
                },
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
                })
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
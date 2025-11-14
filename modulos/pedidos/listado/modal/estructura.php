<script>
    const appModalPedidos = (function() {
        let g_did = 0;
        let g_data;
        let g_productos;
        let donde = 0;
        let logosTiendas = {}
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

            logosTiendas = globalLogoTiendas.obtener()


            if (mode == 0) {
                // NUEVO PEDIDO
                $("#titulo_mPedidos").text("Nuevo pedido");
                $("#subtitulo_mPedidos").text("Creacion de pedido nuevo, completar formulario.");
                $('.campos_mPedidos').prop('disabled', false);
                $("#checkHabilitado_mPedidos").prop("checked", true);
                $("#tienda_mPedidos").prop('disabled', true);
                $("#btnEditar_mPedidos, #listaProductos_mPedidos, #tienda_mPedidos, #btnTrabajar_mPedidos, #containerOperadores_mPedidos").addClass("ocultar");
                $("#btnGuardar_mPedidos, .ocultarDesdeVer_mPedidos").removeClass("ocultar");
                renderProductosRepeater()
                $("#modal_mPedidos").modal("show")
            } else if (mode == 1) {
                // MODIFICAR PEDIDO
                await globalLoading.open()
                $("#titulo_mPedidos").text("Modificar pedido");
                $("#subtitulo_mPedidos").html("Recordá presionar <b>Guardar</b> antes de salir, así conservás todos los cambios ");
                $('.campos_mPedidos').prop('disabled', false);
                $("#btnGuardar_mPedidos").addClass("ocultar");
                $("#btnEditar_mPedidos, .ocultarDesdeVer_mPedidos, #tienda_mPedidos, #btnTrabajar_mPedidos, #containerOperadores_mPedidos").removeClass("ocultar");
                await get()
            } else {
                // VER PEDIDO
                await globalLoading.open()
                $("#titulo_mPedidos").text("Ver pedido");
                $("#subtitulo_mPedidos").text("Visualizacion de pedido, no se puede modificar.");
                $('.campos_mPedidos').prop('disabled', true);
                $("#listaProductos_mPedidos, #tienda_mPedidos, #btnTrabajar_mPedidos, #containerOperadores_mPedidos").removeClass("ocultar");
                $(".ocultarDesdeVer_mPedidos").addClass("ocultar");
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
                    $("#cliente_mPedidos").val(g_data.did_cliente).change();
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

                    let usuarioAsignado = appSistema.usuarios.find(u => u.did == g_data.asignado)
                    $("#armador_mPedidoDeVentas").text(usuarioAsignado ? `${usuarioAsignado.nombre} ${usuarioAsignado.apellido}` : "No asignado");
                    // $("#logistica_mPedidoDeVentas").text(appSistema.logisticas.find(l => l.did == g_data.asignado)?.nombre);

                    $("#calle_mPedidos").val(g_data.direccion.calle);
                    $("#numero_mPedidos").val(g_data.direccion.numero);
                    $("#cp_mPedidos").val(g_data.direccion.cp);
                    $("#localidad_mPedidos").val(g_data.direccion.localidad);
                    $("#provincia_mPedidos").val(g_data.direccion.provincia);
                    $("#latitud_mPedidos").val(g_data.direccion.latitud);
                    $("#longitud_mPedidos").val(g_data.direccion.longitud);
                    $("#referencia_mPedidos").val(g_data.direccion.referencia);

                    $("#tienda_mPedidos").html(g_data.flex != 0 ? logosTiendas[g_data.flex] : `<span class="fs-6 fw-bold">DIRECTO</span>`)

                    let bufferBtnTrabajar = ""
                    bufferBtnTrabajar += `<button type="button" style="${g_data.trabajado == 1 ? "cursor:auto;" : "" }" class="btn btn-icon rounded-pill btn-label-${g_data.trabajado == 1 ? "success" : "warning"}" ${g_data.trabajado == 1 ? "" : `onclick="appOffCanvasPedidos.open({did: '${g_data.did}', idVenta: '${g_data.id_venta}'})"`} data-bs-toggle="tooltip" data-bs-placement="top" title="${g_data.trabajado == 1 ? "Pedido trabajado" : "Trabajar pedido"}">`
                    bufferBtnTrabajar += `<i class="tf-icons ri-${g_data.trabajado == 1 ? "check" : "inbox-archive"}-fill ri-22px"></i>`
                    bufferBtnTrabajar += `</button>`
                    $("#btnTrabajar_mPedidos").html(bufferBtnTrabajar)

                    g_productos = g_data.productos || []
                    renderProductosListado()
                    // renderProductosRepeater();

                    // $(".producto_productos_mPedidos").each(function() {
                    //     $(this).trigger("change");
                    //     const valor = $(this).val()
                    //     const producto = g_productos.find(p => p.did_producto == valor);

                    //     if (producto) {
                    //         const selectVariante = $(this).closest('[data-repeater-item]').find('.variantes_productos_mPedidos');
                    //         const variante = producto.did_producto_variante_valor || "default"
                    //         selectVariante.val(variante).trigger("change");
                    //     }
                    // });

                    if (donde == 2) {
                        $('.campos_mPedidos, .variantes_productos_mPedidos').prop('disabled', true);
                        $(".ocultarDesdeVer_mPedidos").addClass("ocultar")
                    } else {
                        $('.campos_mPedidos').prop('disabled', false);
                        $(".ocultarDesdeVer_mPedidos").removeClass("ocultar")
                    }
                    $("#modal_mPedidos").modal("show")

                    globalActivarAcciones.tooltips({
                        idContainer: "modal_mPedidos"
                    })
                }
            });
        }

        function resetModal() {
            globalActivarAcciones.activarPrimerTab({
                tabList: "tabs_mPedidos"
            })

            $(".campos_mPedidos").val("")
            $(".select2_mPedidos").trigger("change")
            $("#armador_mPedidoDeVentas").text("No asignado");
            $("#logistica_mPedidoDeVentas").text("No sincronizado");

            const fechaActual = globalFuncionesJs.formatearFecha({
                fecha: "hoy",
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

        function renderProductosRepeater() {
            globalActivarAcciones.formRepeater({
                id: "formProductos_mPedidos",
                data: g_productos
            })
        };

        function renderProductosListado() {
            $("#listaProductos_mPedidos").empty();

            if (g_productos.length === 0) {
                $("#listaProductos_mPedidos").html(`<div class="d-flex justify-content-center"><span class="badge rounded-pill bg-label-primary px-6">Sin productos</span></div>`);
                return;
            }

            let buffer = "";
            buffer += `<div class="table-responsive text-nowrap table-container" style="height: 450px;">`
            buffer += `<table class="table table-hover">`
            buffer += `<thead id="theadListaProductos_mPedidos" class="table-thead z-1">`

            buffer += `<tr>`
            buffer += `<th class="py-3">SKU</th>`
            buffer += `<th class="py-3">Producto</th>`
            buffer += `<th class="py-3">Combinacion</th>`
            buffer += `<th class="py-3 text-center">Cantidad</th>`
            buffer += `</tr>`

            buffer += `</thead>`
            buffer += `<tbody id="tbodyListaProductos_mPedidos">`

            g_productos.forEach((producto, idx) => {
                buffer += `<tr>`
                buffer += `<td>${producto.sku || "Sin SKU"}</td>`
                buffer += `<td>${producto.descripcion || "Sin informacion"}</td>`
                const varianteDescripcionParse = producto.variante_descripcion ? JSON.parse(producto.variante_descripcion) : []
                const varianteDescripcion = varianteDescripcionParse.map((item) => `${item.name}${item.value_name ? `: ${item.value_name}` : "" }`)
                buffer += `<td>${varianteDescripcion.join(" | ") || "Default"}</td>`
                buffer += `<td class="text-center">${producto.cantidad || "1"}</td>`
                buffer += `</tr>`
            })

            buffer += `</tbody>`
            buffer += `</table>`
            buffer += `</div>`


            $("#listaProductos_mPedidos").html(buffer);
        }

        public.renderVariantes = function(select) {
            const $item = $(select).closest("[data-repeater-item]");
            const productoSeleccionado = $(select).val();
            const $selectVariante = $item.find("select[name$='[did_producto_variante_valor]']");
            const $inputSku = $item.find("input[name$='[sku]']");

            if (productoSeleccionado) {
                const skuProducto = appSistema.productos.find(p => p.did == productoSeleccionado).sku || ""
                $inputSku.val(skuProducto)

                let variantes = obtenerVariantes({
                    didProducto: productoSeleccionado
                });

                let buffer = ""

                buffer += `<option value="">Seleccionar variante</option>`
                variantes.forEach(v => buffer += `<option value="${v.did_producto_variante_valor}">${v.variante_descripcion}</option>`);
                $selectVariante.prop("disabled", false).html(buffer);
            } else {
                $selectVariante.prop("disabled", true).html('<option value="">Selecciona el producto para ver</option>');
                $inputSku.val("")
            }
        };

        function obtenerVariantes({
            type = 0,
            didProducto,
            didProductoVarianteValor
        }) {
            const producto = appSistema.productos.find(p => p.did == didProducto);
            const defaultVariante = {
                name: "Default",
                id: "",
                value_id: "",
                value_name: "",
            };

            const retornoDefault = (titulo = "Sin información") => {
                if (type == 0) {
                    return [{
                        did_producto_variante_valor: "default",
                        variante_descripcion: "Default"
                    }];
                }
                return {
                    titulo,
                    variante_descripcion: JSON.stringify([defaultVariante])
                };
            };

            if (!producto) return retornoDefault();

            const {
                titulo,
                did_curva,
                valores
            } = producto;
            if (!did_curva || !valores?.length) return retornoDefault(titulo);

            const curva = appSistema.curvas.find(c => c.did == did_curva);
            if (!curva) return retornoDefault(titulo);

            if (type == 0) {
                return valores.map(grupo => {
                    const partes = grupo.valores.map(valorDid => {
                        for (const categoria of curva.categorias) {
                            const variante = appSistema.variantes.find(v => v.did == categoria.did_variante);
                            const valorEncontrado = categoria.valores.find(v => v.did == valorDid);
                            if (valorEncontrado) {
                                return `${variante?.nombre || "Variante desconocida"} ${categoria.nombre.toLowerCase()}: ${valorEncontrado.nombre}`;
                            }
                        }
                        return null;
                    }).filter(Boolean);

                    return {
                        did_producto_variante_valor: grupo.did_productos_variantes_valores,
                        variante_descripcion: partes.join(" | ")
                    };
                });
            }

            const combinacion = valores.find(v => v.did_productos_variantes_valores == didProductoVarianteValor);
            if (!combinacion) return retornoDefault(titulo);

            const partes = combinacion.valores.map(valorDid => {
                for (const categoria of curva.categorias) {
                    const variante = appSistema.variantes.find(v => v.did == categoria.did_variante);
                    const valorEncontrado = categoria.valores.find(v => v.did == valorDid);
                    if (valorEncontrado) {
                        return {
                            name: variante?.nombre || "",
                            id: "",
                            value_id: valorDid || "",
                            value_name: valorEncontrado.nombre || "",
                        };
                    }
                }
                return {
                    name: "Sin información",
                    id: "",
                    value_id: "",
                    value_name: "Sin información",
                };
            }).filter(Boolean);

            return {
                titulo: titulo || "",
                variante_descripcion: JSON.stringify(partes)
            };
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
                const data = obtenerVariantes({
                    type: 1,
                    didProducto: item.did_producto,
                    didProductoVarianteValor: item.did_producto_variante_valor
                }) || {}

                return {
                    ...item,
                    did_producto_variante_valor: item.did_producto_variante_valor === "default" ? null : item.did_producto_variante_valor,
                    descripcion: data.titulo || "",
                    variante_descripcion: data.variante_descripcion || ""
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
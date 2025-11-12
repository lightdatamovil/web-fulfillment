<script>
    const appModalProductos = (function() {
        let g_did = 0;
        let g_data;
        let donde = 0;
        let g_combos = [];
        let g_ecommerce = [];
        let g_insumos = []
        let curvaSeleccionada = {}
        let logosTiendas = {}
        let primerLLenadoEan = true

        const rutaAPI = "productos"

        const public = {};

        public.open = async function({
            mode = 0,
            did = 0
        } = {}) {
            await resetModal()
            g_did = did;
            donde = mode

            await globalLlenarSelect.curvas({
                id: "curvas_mProductos",
                multiple: true
            })
            $("#curvas_mProductos").prepend('<option value="" selected>Sin curva</option>');

            await globalLlenarSelect.insumos({
                id: "insumo_insumos_mProductos"
            })

            await globalLlenarSelect.productos({
                id: "producto_combos_mProductos"
            })

            await globalLlenarSelect.clientes({
                id: "cliente_mProductos"
            })

            await globalLlenarSelect.identificadoresEspeciales({
                id: "identificadoreEspeciales_mProductos",
                multiple: true
            })

            await globalLlenarSelect.insumos({
                id: "nombre_insumo_mProductos"
            })

            logosTiendas = await globalLogoTiendas.obtener()

            if (mode == 0) {
                // NUEVO PRODUCTO
                $("#titulo_mProductos").text("Nuevo producto");
                $("#subtitulo_mProductos").text("Creacion de producto nuevo, completar formulario.");
                $('.campos_mProductos, .deshabilitarDesdeModificar_mProductos').prop('disabled', false);
                $("#btnEditar_mProductos").addClass("ocultar");
                $("#btnGuardar_mProductos, .ocultarDesdeVer_mProductos, .ocultarDesdeModificar_mCurvas").removeClass("ocultar");
                await renderCombos()
                await renderInsumos()
                $("#modal_mProductos").modal("show")
                await globalImageCarousel.init({
                    id: "imagen_mProductos",
                    type: "subir",
                    multiple: false
                });
            } else if (mode == 1) {
                // MODIFICAR PRODUCTO
                await globalLoading.open()
                $("#titulo_mProductos").text("Modificar producto");
                $("#subtitulo_mProductos").text("Modificacion de producto existente, completar formulario.");
                $('.campos_mProductos').prop('disabled', false);
                $("#btnGuardar_mProductos, .ocultarDesdeModificar_mCurvas").addClass("ocultar");
                $("#btnEditar_mProductos, .ocultarDesdeVer_mProductos").removeClass("ocultar");
                await get()
            } else {
                // VER PRODUCTO
                await globalLoading.open()
                $("#titulo_mProductos").text("Ver producto");
                $("#subtitulo_mProductos").text("Visualizacion de producto, no se puede modificar.");
                $('.campos_mProductos').prop('disabled', true);
                $("#btnGuardar_mProductos, #btnEditar_mProductos, .ocultarDesdeVer_mProductos").addClass("ocultar");
                await get()
            }

            await globalActivarAcciones.mostrarOcultarTab({
                tab: "tabCombos_mProductos",
                opcion: 0
            })

            await globalActivarAcciones.select2({
                className: "select2_mProductos"
            })
        }

        function get() {
            globalRequest.get(`/${rutaAPI}/${g_did}`, {
                onSuccess: function(result) {
                    g_data = result.data;
                    $("#cliente_mProductos").val(g_data.did_cliente).change();
                    $("#nombre_mProductos").val(g_data.titulo);
                    $("#sku_mProductos").val(g_data.sku);
                    $("#ean_mProductos").val(g_data.ean);
                    $("#posicion_mProductos").val(g_data.posicion);
                    $("#esCombo_mProductos").val(g_data.es_combo).change();
                    $("#alto_mProductos").val(g_data.alto);
                    $("#ancho_mProductos").val(g_data.ancho);
                    $("#profundo_mProductos").val(g_data.profundo);
                    $("#cm3_mProductos").val(g_data.cm3);
                    $("#habilitado_mProductos").val(g_data.habilitado);
                    $("#identificadoreEspeciales_mProductos").val(g_data.dids_ie).change()
                    $("#descripcion_mProductos").val(g_data.descripcion);
                    $("#curvas_mProductos").val(g_data.did_curva).change();

                    globalImageCarousel.init({
                        id: "imagen_mProductos",
                        type: donde == 1 ? "subir" : "ver",
                        arrUrls: g_data.files,
                        multiple: false
                    });

                    g_ecommerce = g_data.combinaciones || []
                    appModalProductos.renderEcommerce()

                    g_combos = g_data.productos_hijos || [];
                    renderCombos();
                    g_insumos = g_data.insumos || []
                    renderInsumos()

                    if (donde == 1) {
                        $(".ocultarDesdeModificar_mProductos").addClass("ocultar")
                        $(".deshabilitarDesdeModificar_mProductos").prop('disabled', true)
                    } else if (donde == 2) {
                        $('.campos_mProductos').prop('disabled', true);
                        $(".ocultarDesdeVer_mProductos").addClass("ocultar")
                    } else {
                        $(".ocultarDesdeVer_mProductos .ocultarDesdeModificar_mProductos").removeClass("ocultar")
                        $(".deshabilitarDesdeModificar_mProductos").prop('disabled', false)
                    }

                    $("#modal_mProductos").modal("show")
                }
            });
        }

        function resetModal() {
            globalActivarAcciones.activarPrimerTab({
                tabList: "tabs_mProductos"
            })

            $(".campos_mProductos").val("")
            $("#contenedorEcommerce_mProductos").empty();
            $('#curvas_mProductos, #identificadoreEspeciales_mProductos').val(null).trigger('change');
            $("#esCombo_mProductos").val("0");
            $("#habilitado_mProductos").val("1");

            g_data = {}
            g_combos = [];
            g_ecommerce = [];
            g_insumos = [];

            appModalProductos.mostrarCombos()

            globalValidar.limpiarTodas()
            globalValidar.deshabilitarTiempoReal({
                className: "camposObli_mProductos"
            })
        };

        function renderCombos() {
            globalActivarAcciones.formRepeater({
                id: "formCombos_mProductos",
                data: g_combos
            })
        };

        function renderInsumos() {
            globalActivarAcciones.formRepeater({
                id: "formInsumos_mProductos",
                data: g_insumos
            })
        };

        public.generarCurva = function() {
            const valor = $('#curvas_mProductos').val()

            if (!valor) {
                curvaSeleccionada = {}
                g_ecommerce = []
                $("#listaValores_mProductos").html(`<div class="d-flex justify-content-center"><span class="badge rounded-pill bg-label-primary px-6">Puedes elegir una curva, caso contrario debes seleccionar la opcion "Sin curva"</span></div>`);
                appModalProductos.renderEcommerce()
                return;
            }

            curvaSeleccionada = appSistema.curvas.find(item => item.did == valor)
            const valoresSeleccionados = curvaSeleccionada.categorias.map(cat => cat.valores);
            const columnasObtenidas = obtenerColumnasCurvas(valoresSeleccionados)

            renderTablaDeValoresCurvas(columnasObtenidas)
            primerLLenadoEan = true
        }

        function obtenerColumnasCurvas(arrays) {
            return arrays.reduce((acumulado, actual) => {
                const combinaciones = [];
                acumulado.forEach(a => {
                    actual.forEach(b => {
                        combinaciones.push([...a, b]);
                    });
                });
                return combinaciones;
            }, [
                []
            ]);
        }

        function renderTablaDeValoresCurvas(columnasCurva) {
            $("#listaValores_mProductos").empty();

            if (columnasCurva.length === 0) {
                $("#listaValores_mProductos").html(`<div class="d-flex justify-content-center"><span class="badge rounded-pill bg-label-primary px-6">Puedes elegir una curva, caso contrario debes seleccionar la opcion "Sin curva"</span></div>`);
                return;
            }

            let buffer = "";
            buffer += `<div class="table-responsive text-nowrap table-container" style="height: 450px;">`
            buffer += `<table class="table table-hover">`
            buffer += `<thead id="theadListado_mProductos" class="table-thead z-1">`

            buffer += `<tr class="text-center">`
            curvaSeleccionada.categorias.forEach((categoria, idx) => {
                buffer += `<th class="py-3"><span class="text-primary">${appSistema.variantes.find(item => item.did == categoria.did_variante).nombre}</span><br/>${categoria.nombre}</th>`
            });
            buffer += `</tr>`

            buffer += `</thead>`
            buffer += `<tbody id="tbodyListado_mProductos">`

            columnasCurva.forEach((columnas, idx) => {
                buffer += `<tr class="text-center">`
                columnas.forEach((item) => {
                    buffer += `<td data-did="${item.did}">${item.nombre}</td>`
                })
                buffer += `</tr>`
            })

            buffer += `</tbody>`
            buffer += `</table>`
            buffer += `</div>`


            $("#listaValores_mProductos").html(buffer);
            g_ecommerce = columnasCurva.map(columna => {
                return {
                    valores: columna.map(valor => {
                        return valor.did
                    })
                }
            })

            appModalProductos.renderEcommerce()
        }

        public.renderEcommerce = function() {
            primerLLenadoEan = true
            let valueCliente = $("#cliente_mProductos").val();

            if (valueCliente == "") {
                $("#contenedorEcommerce_mProductos").empty('');
                return;
            }

            let cliente = appSistema.clientes.find(c => c.did == valueCliente);
            let cuentas = cliente?.cuentas || [];

            if (cuentas.length < 1) return

            if (g_ecommerce.length < 1) {
                g_ecommerce = [{
                    valores: []
                }];
            }

            let buffer = '';


            buffer += `<table class="table table-bordered">`
            buffer += `<thead class="table-thead z-3"><tr>`
            buffer += `<th class="py-2" style="vertical-align: middle;">Combinacion</th>`
            buffer += `<th class="py-2" style="vertical-align: middle;">EAN</th>`
            // buffer += `<th class="py-2" style="vertical-align: middle;">Sincronizar stock<br/>entre tiendas</th>`

            cuentas.forEach(cuenta => {
                buffer += `<th class="py-2" style="vertical-align: middle;">`
                buffer += `<did class="d-flex align-items-center gap-3">`
                buffer += `<div class="containerSvg" style="width: 50px; height: auto;">${logosTiendas[cuenta.flex] || "Tienda:"}</div>`
                buffer += `<p class="m-0" data-didCuenta="${cuenta.did}">${cuenta.titulo || "Sin informacion"}</p>`
                buffer += `</did>`
                buffer += `</th>`
            })

            buffer += `</tr></thead>`
            buffer += `<tbody>`

            let primerEan = true
            g_ecommerce.forEach((item, idx) => {
                let combinacion = ""
                let masDeUno = false

                if (item.valores.length > 0) {
                    item.valores.forEach((valor) => {
                        let categoria = curvaSeleccionada?.categorias?.find(cat => cat.valores.some(v => v.did == valor));
                        let variante = categoria ? appSistema.variantes.find(item => item.did == categoria.did_variante) : null;
                        let valorSeleccionado = categoria ? categoria.valores.find(v => v.did == valor) : null;

                        const nombreVariante = variante?.nombre || "Desconocido";
                        const nombreValor = valorSeleccionado?.nombre || "Desconocido";

                        combinacion += `<div>${nombreVariante}: <span class="text-primary fw-bold">${nombreValor}</span></div>`;
                        masDeUno = true;
                    });

                } else {
                    combinacion = `Default`
                }

                buffer += `<tr class="lineasEcommerce_mProductos" data-valores='${JSON.stringify(item.valores)}' data-did="${item.did ? item.did : ""}" data-index="${idx}">`
                buffer += `<td>${combinacion}</td>`

                buffer += `<td>`
                buffer += `<div class="col-12">`
                buffer += `<div class="form-floating form-floating-outline">`
                buffer += `<input type="text" style="min-width: 200px;" class="form-control campos_mProductos eansProducto_mProductos" id="eanTablaEccomerce_${idx}_mProductos" ${primerEan && donde == 0 ? `onblur="appModalProductos.llenarAllEan()"`: ""} placeholder="EAN" value="${item.ean || ""}"/>`
                buffer += `<label for="">EAN</label>`
                buffer += `</div>`
                buffer += `</div>`
                buffer += `</td>`
                primerEan = false

                // buffer += `<td>`
                // buffer += `<div class="form-check m-0 p-0 d-flex align-items-center flex-column gap-1">`
                // buffer += `<input class="form-check-input m-0 campos_mProductos" type="checkbox" id="syncTablaEccomerce_${idx}_mProductos" ${item.sync ? "checked": "" }/>`
                // buffer += `</div>`
                // buffer += `</td>`

                cuentas.forEach(cuenta => {
                    let dataCuenta = item.tiendas?.find(i => i.didCuenta == cuenta.did) || {}

                    buffer += `<td data-did="${dataCuenta.did || ""}" data-did-cuenta="${cuenta.did}">`
                    buffer += `<div class="col-12">`
                    buffer += `<div class="form-floating form-floating-outline">`
                    buffer += `<input type="text" style="min-width: 200px;" class="form-control campos_mProductos" placeholder="SKU" id="skuTablaEccomerce_${idx}_mProductos" value="${dataCuenta.sku || ""}"/>`
                    buffer += `<label for="">SKU</label>`
                    buffer += `</div>`
                    buffer += `</div>`
                    buffer += `</td>`

                })

                buffer += `</tr>`

            })

            buffer += `</tbody></table>`



            $("#contenedorEcommerce_mProductos").html(buffer);
        }

        function obtenerDatosEcommerce() {
            const datos = [];

            $(".lineasEcommerce_mProductos").each(function() {
                const $linea = $(this);
                const did_variante_valores = Number($linea.attr("data-did")) || null;
                const valores = JSON.parse($linea.attr("data-valores")) || [];
                const index = $linea.attr("data-index");
                const ean = $linea.find(`#eanTablaEccomerce_${index}_mProductos`).val() || "";
                const sync = $linea.find(`#syncTablaEccomerce_${index}_mProductos`).is(":checked") ? 1 : 0;

                const tiendas = [];

                $linea.find("td").slice(2).each(function() {
                    const $td = $(this);
                    const did = Number($td.attr("data-did")) || null;
                    const didCuenta = Number($td.attr("data-did-cuenta")) || null;
                    const sku = $td.find(`#skuTablaEccomerce_${index}_mProductos`).val() || "";

                    tiendas.push({
                        did,
                        didCuenta,
                        sku,
                    });
                });

                tiendas.sort((a, b) => (a.did || 0) - (b.did || 0));

                datos.push({
                    did: did_variante_valores,
                    valores,
                    ean,
                    sync,
                    tiendas
                });
            });

            return datos;
        };

        public.mostrarCombos = function() {
            let select = $("#esCombo_mProductos").val();

            if (select == 1) {
                $("#curvas_mProductos").val("").change()
                globalActivarAcciones.mostrarOcultarTab({
                    tab: "tabCurvas_mProductos",
                    opcion: 0
                })
                globalActivarAcciones.mostrarOcultarTab({
                    tab: "tabCombos_mProductos",
                    opcion: 1
                })
            } else {
                globalActivarAcciones.mostrarOcultarTab({
                    tab: "tabCombos_mProductos",
                    opcion: 0
                })
                globalActivarAcciones.mostrarOcultarTab({
                    tab: "tabCurvas_mProductos",
                    opcion: 1
                })
            }
        }

        public.calcularCm3 = function() {
            const alto = $("#alto_mProductos").val().trim();
            const ancho = $("#ancho_mProductos").val().trim();
            const profundo = $("#profundo_mProductos").val().trim();

            if (alto && ancho && profundo) {
                const cm3 = (alto * ancho * profundo).toFixed(2);
                $("#cm3_mProductos").val(cm3);
            } else {
                $("#cm3_mProductos").val("");
            }
        };

        public.llenarAllEan = function() {
            if (!primerLLenadoEan) return
            let ean = $("#eanTablaEccomerce_0_mProductos").val().trim();
            if (ean == "") return;

            $(".eansProducto_mProductos").each(function() {
                if ($(this).val().trim() != "") return;
                $(this).val(ean);
            });
            primerLLenadoEan = false
        };

        public.changeInsumo = function(select) {
            const didSeleccionado = select.value;
            const insumo = appSistema.insumos.find(i => i.did == didSeleccionado);
            const $item = $(select).closest("[data-repeater-item]");
            const inputCantidad = $item.find("input[name$='[cantidad]']");
            const mensajeCantidad = $item.find(".mesajeCantida_mProductos");

            if (insumo) {
                if (insumo.unidad == 0) {
                    $(inputCantidad).val('1');
                    $(inputCantidad).addClass('ocultar');
                    $(mensajeCantidad).removeClass('ocultar');
                } else {
                    $(inputCantidad).val('');
                    $(inputCantidad).removeClass('ocultar');
                    $(mensajeCantidad).addClass('ocultar');
                }
            } else {
                // Caso sin insumo seleccionado
                $(inputCantidad).val('');
                $(inputCantidad).removeClass('ocultar');
                $(mensajeCantidad).addClass('ocultar');
            }
        };

        function validacion() {
            return globalValidar.obligatorios({
                className: "camposObli_mProductos"
            })
        }

        public.guardar = function() {
            const datos = {
                did_cliente: $("#cliente_mProductos").val() || null,
                titulo: $("#nombre_mProductos").val().trim() || "",
                sku: $("#sku_mProductos").val().trim() || "",
                ean: $("#ean_mProductos").val().trim() || "",
                alto: $("#alto_mProductos").val().trim() || "",
                ancho: $("#ancho_mProductos").val().trim() || "",
                profundo: $("#profundo_mProductos").val().trim() || "",
                cm3: $("#cm3_mProductos").val().trim() || "",
                es_combo: $("#esCombo_mProductos").val() || 0,
                habilitado: $("#habilitado_mProductos").val() || 0,
                files: globalImageCarousel.getImages({
                    id: "imagen_mProductos"
                }),
                descripcion: $("#descripcion_mProductos").val().trim() || "",
                posicion: $("#posicion_mProductos").val().trim() || "",
                did_curva: $("#curvas_mProductos").val() || null,
                dids_ie: ($("#identificadoreEspeciales_mProductos").val() || []).map(Number),
                combinaciones: obtenerDatosEcommerce(),
                productos_hijos: globalActivarAcciones.obtenerDataFormRepeater({
                    id: "formCombos_mProductos"
                }),
                insumos: globalActivarAcciones.obtenerDataFormRepeater({
                    id: "formInsumos_mProductos"
                }),
            };

            globalValidar.formRepeater({
                id: "formInsumos_mProductos"
            })

            globalValidar.formRepeater({
                id: "formCombos_mProductos"
            })

            globalValidar.habilitarTiempoReal({
                className: "camposObli_mProductos",
                callback: validacion
            })

            if (validacion()) {
                globalSweetalert.alert({
                    titulo: "Verifique los campos"
                })
                return
            }

            if (datos.es_combo == 0) {
                datos.productos_hijos = []
            } else {
                if (datos.productos_hijos.length < 1) {
                    globalSweetalert.alertVolver({
                        titulo: "Si es combo, debe agregar al menos un producto",
                        subtitulo: 'En la pestaña "Combos"'
                    });
                    return;
                }
            }

            globalSweetalert.confirmar({
                    titulo: "¿Estas seguro de guardar este producto?"
                })
                .then(function(confirmado) {
                    if (confirmado) {
                        globalRequest.post(`/${rutaAPI}`, datos, {
                            onSuccess: function(result) {
                                $("#modal_mProductos").modal("hide");
                                globalSweetalert.exito();
                                appModuloProductos.getListado();
                            }
                        });
                    }
                });
        };

        public.editar = function() {
            const datosNuevos = {
                did_cliente: $("#cliente_mProductos").val() || null,
                titulo: $("#nombre_mProductos").val().trim() || "",
                sku: $("#sku_mProductos").val().trim() || "",
                ean: $("#ean_mProductos").val().trim() || "",
                alto: $("#alto_mProductos").val().trim() || "",
                ancho: $("#ancho_mProductos").val().trim() || "",
                profundo: $("#profundo_mProductos").val().trim() || "",
                cm3: $("#cm3_mProductos").val().trim() || "",
                es_combo: $("#esCombo_mProductos").val() || 0,
                habilitado: $("#habilitado_mProductos").val() || 0,
                files: globalImageCarousel.getImages({
                    id: "imagen_mProductos"
                }),
                descripcion: $("#descripcion_mProductos").val().trim() || "",
                posicion: $("#posicion_mProductos").val().trim() || "",
                did_curva: $("#curvas_mProductos").val() || null,
                dids_ie: ($("#identificadoreEspeciales_mProductos").val() || []).map(Number),
                combinaciones: obtenerDatosEcommerce(),
                productos_hijos: globalActivarAcciones.obtenerDataFormRepeater({
                    id: "formCombos_mProductos"
                }),
                insumos: globalActivarAcciones.obtenerDataFormRepeater({
                    id: "formInsumos_mProductos"
                }),
            };

            globalValidar.formRepeater({
                id: "formInsumos_mProductos"
            })

            globalValidar.formRepeater({
                id: "formCombos_mProductos"
            })


            globalValidar.habilitarTiempoReal({
                className: "camposObli_mProductos",
                callback: validacion
            })

            if (validacion()) {
                globalSweetalert.alert({
                    titulo: "Verifique los campos"
                })
                return
            }

            if (datosNuevos.es_combo == 0) {
                datosNuevos.productos_hijos = []
            } else {
                if (datosNuevos.productos_hijos.length < 1) {
                    globalSweetalert.alertVolver({
                        titulo: "Si es combo, debe agregar al menos un producto",
                        subtitulo: 'En la pestaña "Combos"'
                    });
                    return;
                }
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

            if (!datosModificados.files) {
                datosNuevos.files = null
            }

            datosNuevos.combinaciones = globalValidar.obtenerCambiosEnArray({
                dataNueva: datosNuevos.combinaciones,
                dataOriginal: g_ecommerce
            })

            datosNuevos.productos_hijos = globalValidar.obtenerCambiosEnArray({
                dataNueva: datosNuevos.productos_hijos,
                dataOriginal: g_combos
            })

            datosNuevos.insumos = globalValidar.obtenerCambiosEnArray({
                dataNueva: datosNuevos.insumos,
                dataOriginal: g_insumos
            })

            globalSweetalert.confirmar({
                    titulo: "¿Estas seguro de modificar este producto?"
                })
                .then(function(confirmado) {
                    if (confirmado) {
                        globalRequest.put(`/${rutaAPI}/${g_did}`, datosNuevos, {
                            onSuccess: function(result) {
                                $("#modal_mProductos").modal("hide");
                                globalSweetalert.exito();
                                appModuloProductos.getListado();
                            }
                        });
                    }
                });
        };

        public.eliminar = function(did) {
            globalSweetalert.confirmar({
                titulo: "¿Estas seguro de eliminar este producto?",
                color: "var(--bs-danger)"
            }).then(function(confirmado) {
                if (confirmado) {
                    globalRequest.delete(`/${rutaAPI}/${did}`, {
                        onSuccess: function(result) {
                            globalSweetalert.exito({
                                titulo: "Eliminado con éxito!"
                            });
                            appModuloProductos.getListado();
                        }
                    });
                }
            });
        };

        return public;
    }());
</script>
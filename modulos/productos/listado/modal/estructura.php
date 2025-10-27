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
        let eanIguales = true

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

            await globalLlenarSelect.insumos({
                id: "nombre_insumo_mProductos"
            })

            logosTiendas = await globalLogoTiendas.obtener()

            if (mode == 0) {
                // NUEVO PRODUCTO
                $("#titulo_mProductos").text("Nuevo producto");
                $("#subtitulo_mProductos").text("Creacion de producto nuevo, completar formulario.");
                $('.campos_mProductos').prop('disabled', false);
                $("#btnEditar_mProductos").addClass("ocultar");
                $("#btnGuardar_mProductos, .ocultarDesdeVer_mProductos").removeClass("ocultar");
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
                $("#btnGuardar_mProductos").addClass("ocultar");
                $("#btnEditar_mProductos, .ocultarDesdeVer_mProductos").removeClass("ocultar");
                await get()
                await globalImageCarousel.init({
                    id: "imagen_mProductos",
                    type: "subir",
                    multiple: false
                });
            } else {
                // VER PRODUCTO
                await globalLoading.open()
                $("#titulo_mProductos").text("Ver producto");
                $("#subtitulo_mProductos").text("Visualizacion de producto, no se puede modificar.");
                $('.campos_mProductos').prop('disabled', true);
                $("#btnGuardar_mProductos, #btnEditar_mProductos, .ocultarDesdeVer_mProductos").addClass("ocultar");
                await globalImageCarousel.init({
                    id: "imagen_mProductos",
                    type: "ver",
                    multiple: false
                });
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
                    $("#descripcion_mProductos").val(g_data.descripcion);
                    $("#curvas_mProductos").val(g_data.did_curva).change();

                    if (g_data.imagen) {
                        globalImageCarousel.loadImages({
                            id: "imagen_mProductos",
                            arrUrls: [g_data.imagen]
                        })
                    }

                    g_ecommerce = g_data.ecommerce || []
                    appModalProductos.renderEcommerce()

                    g_combos = g_data.combos || [];
                    renderCombos();
                    g_insumos = g_data.insumos || []
                    renderInsumos()

                    if (donde == 2) {
                        $('.campos_mProductos').prop('disabled', true);
                        $(".ocultarDesdeVer_mProductos").addClass("ocultar")
                    } else {
                        $('.campos_mProductos').prop('disabled', false);
                        $(".ocultarDesdeVer_mProductos").removeClass("ocultar")
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
            $('#curvas_mProductos').val(null).trigger('change');
            $("#esCombo_mProductos").val("0");
            $("#habilitado_mProductos").val("1");

            g_data = {}
            g_combos = [];
            g_ecommerce = [];
            g_insumos = [];

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
                    variantes_valores: columna.map(valor => {
                        return valor.did
                    })
                }
            })

            appModalProductos.renderEcommerce()
        }

        public.renderEcommerce = function() {
            let valueCliente = $("#cliente_mProductos").val();

            if (valueCliente == "") {
                $("#contenedorEcommerce_mProductos").empty('');
                return;
            }

            let cliente = appSistema.clientes.find(c => c.did == valueCliente);
            let cuentas = cliente?.cuentas || [];

            if (g_ecommerce.length < 1) {
                g_ecommerce = [{
                    variantes_valores: []
                }];
            }

            let buffer = '';

            g_ecommerce.forEach((item, idx) => {
                let titulo = ""
                let masDeUno = false

                if (item.variantes_valores.length > 0) {
                    item.variantes_valores.forEach((valor) => {
                        let categoria = curvaSeleccionada.categorias.find(cat => cat.valores.some(v => v.did == valor));
                        let variante = appSistema.variantes.find(item => item.did == categoria.did_variante)
                        let valorSeleccionado = categoria.valores.find(v => v.did == valor);

                        titulo += `<div class="text-center ${masDeUno ? "border-start border-primary ps-3" : ""}">${variante.nombre}<br/>${categoria.nombre}: <span class="text-primary">${valorSeleccionado.nombre}</span></div>`
                        masDeUno = true
                    })

                } else {
                    titulo = `Default`
                }

                buffer += `<table class="table table-bordered tablasEcommerce_mProductos" data-valores='${JSON.stringify(item.variantes_valores)}' data-did="${item.did ? item.did : ""}" data-index="${idx}">`
                buffer += `<thead><tr>`
                buffer += `<th colspan="5" class="p-3"><div class="d-flex gap-3 align-items-center justify-content-center">${titulo}</div></th>`
                buffer += `</tr></thead><tbody>`

                let contadorTipos = {};

                let primerEan = true
                cuentas.forEach(cuenta => {
                    let dataCuenta = item.grupos?.find(i => i.didCuenta == cuenta.did) || {}

                    buffer += `<tr>`

                    buffer += `<td>`
                    buffer += `<div class="d-flex align-items-center flex-column gap-1">`
                    buffer += `<div class="containerSvg" style="width: 50px; height: auto;">${logosTiendas[cuenta.flex]}</div>`
                    buffer += `<p class="m-0 text-center" id="cuentaTablaEccomerce_${idx}_mProductos" data-didCuenta="${cuenta.did}" >${cuenta.titulo || cuenta.did}</p>`
                    buffer += `</div>`
                    buffer += `</td>`

                    buffer += `<td>`
                    buffer += `<div class="form-check m-0 p-0 d-flex align-items-center flex-column gap-1">`
                    buffer += `<input class="form-check-input m-0 campos_mProductos" type="checkbox" id="syncTablaEccomerce_${idx}_mProductos" ${dataCuenta.sync ? "checked": "" }/>`
                    buffer += `<p class="m-0 text-center" style="font-size: 12px; white-space: nowrap;">Sincronizar stock<br/>entre tiendas</p>`
                    buffer += `</div>`
                    buffer += `</td>`

                    buffer += `<td>`
                    buffer += `<div class="col-12">`
                    buffer += `<div class="form-floating form-floating-outline">`
                    buffer += `<input type="text" class="form-control campos_mProductos" placeholder="SKU" id="skuTablaEccomerce_${idx}_mProductos" value="${dataCuenta.sku || ""}"/>`
                    buffer += `<label for="">SKU</label>`
                    buffer += `</div>`
                    buffer += `</div>`
                    buffer += `</td>`

                    buffer += `<td>`
                    buffer += `<div class="col-12">`
                    buffer += `<div class="form-floating form-floating-outline">`

                    if (donde == 0) {
                        buffer += `<input type="text" class="form-control campos_mProductos eansProducto_mProductos" id="eanTablaEccomerce_${idx}_mProductos" ${primerEan ? `onchange="appModalProductos.llenarAllEan()"`: ""} placeholder="EAN" value="${dataCuenta.ean || ""}"/>`
                    } else {
                        buffer += `<input type="text" class="form-control campos_mProductos" id="eanTablaEccomerce_${idx}_mProductos" placeholder="EAN" value="${dataCuenta.ean || ""}"/>`
                    }
                    buffer += `<label for="">EAN</label>`
                    buffer += `</div>`
                    buffer += `</div>`
                    buffer += `</td>`
                    primerEan = false

                    buffer += `<td>`
                    buffer += `<div class="col-12">`
                    buffer += `<div class="form-floating form-floating-outline">`
                    buffer += `<input type="text" class="form-control campos_mProductos" placeholder="URL" id="urlTablaEccomerce_${idx}_mProductos" value="${dataCuenta.url || ""}"/>`
                    buffer += `<label for="">URL</label>`
                    buffer += `</div>`
                    buffer += `</div>`
                    buffer += `</td>`

                    buffer += `</tr>`

                });

                buffer += `</tbody></table>`
            })

            $("#contenedorEcommerce_mProductos").html(buffer);
        }


        function obtenerDatosEcommerce() {
            const datos = [];

            $(".tablasEcommerce_mProductos").each(function() {
                const $tabla = $(this);
                const variantes_valores = JSON.parse($tabla.attr("data-valores"));
                const index = $tabla.attr("data-index");

                const grupos = [];

                $tabla.find("tbody tr").each(function() {
                    const $fila = $(this);

                    const did = $fila.find(`[id^="cuentaTablaEccomerce_${index}_mProductos"]`).data("did") || "";
                    const didCuenta = $fila.find(`[id^="cuentaTablaEccomerce_${index}_mProductos"]`).data("didcuenta") || null;
                    const sku = $fila.find(`#skuTablaEccomerce_${index}_mProductos`).val() || "";
                    const ean = $fila.find(`#eanTablaEccomerce_${index}_mProductos`).val() || "";
                    const url = $fila.find(`#urlTablaEccomerce_${index}_mProductos`).val() || "";
                    const sync = $fila.find(`#syncTablaEccomerce_${index}_mProductos`).is(":checked") ? 1 : 0;

                    grupos.push({
                        did,
                        didCuenta,
                        sku,
                        ean,
                        url,
                        sync
                    });
                });

                datos.push({
                    variantes_valores,
                    grupos
                });
            });

            return datos;
        };

        public.mostrarCombos = function() {
            let select = $("#esCombo_mProductos").val();

            if (select == 1) {
                globalActivarAcciones.mostrarOcultarTab({
                    tab: "tabCombos_mProductos",
                    opcion: 1
                })
            } else {
                globalActivarAcciones.mostrarOcultarTab({
                    tab: "tabCombos_mProductos",
                    opcion: 0
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
            if (!eanIguales) return;
            let ean = $("#eanTablaEccomerce_0_mProductos").val().trim();
            if (ean == "") return;

            $(".eansProducto_mProductos").each(function() {
                if ($(this).val().trim() != "") return;
                $(this).val(ean);
            });
            eanIguales = false;
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
                imagen: globalImageCarousel.getImages({
                    id: "imagen_mProductos"
                }),
                descripcion: $("#descripcion_mProductos").val().trim() || "",
                posicion: $("#posicion_mProductos").val().trim() || 0,
                did_curva: $("#curvas_mProductos").val() || null,
                ecommerce: obtenerDatosEcommerce(),
                combos: globalActivarAcciones.obtenerDataFormRepeater({
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
                datos.combos = []
            } else {
                if (datos.combos.length < 1) {
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
                imagen: globalImageCarousel.getImages({
                    id: "imagen_mProductos"
                }),
                descripcion: $("#descripcion_mProductos").val().trim() || "",
                posicion: $("#posicion_mProductos").val().trim() || 0,
                did_curva: $("#curvas_mProductos").val() || null,
                ecommerce: obtenerDatosEcommerce(),
                combos: globalActivarAcciones.obtenerDataFormRepeater({
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
                datosNuevos.combos = []
            } else {
                if (datosNuevos.combos.length < 1) {
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

            datosNuevos.ecommerce = globalValidar.obtenerCambiosEnArray({
                dataNueva: datosNuevos.ecommerce,
                dataOriginal: g_ecommerce
            })

            datosNuevos.combos = globalValidar.obtenerCambiosEnArray({
                dataNueva: datosNuevos.combos,
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
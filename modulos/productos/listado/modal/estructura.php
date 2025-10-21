<script>
    const appModalProductos = (function() {
        let g_did = 0;
        let g_data;
        let donde = 0;
        let g_combos = [];
        let g_ecommerce = [];
        let g_ecommerce_bd = []
        let g_insumos = []
        let curvasSeleccionadas = []
        let logosTiendas = {}
        let g_columnas_curvas = []
        let eanIguales = true
        let g_curvas = {
            did: 0,
            data: []
        };

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

            await globalLlenarSelect.clientes({
                id: "cliente_mProductos"
            })
            await globalLlenarSelect.insumos({
                id: "nombre_insumo_mProductos"
            })
            await globalLlenarSelect.productos({
                id: "producto_combo_mProductos"
            })

            logosTiendas = await globalLogoTiendas.obtener()

            if (mode == 0) {
                // NUEVO PRODUCTO
                $("#titulo_mProductos").text("Nuevo producto");
                $("#subtitulo_mProductos").text("Creacion de producto nuevo, completar formulario.");
                $('.campos_mProductos').prop('disabled', false);
                $("#btnGuardar_mProductos, .forms_mProductos").removeClass("ocultar");
                globalInputImg.crear("imagen_mProductos")
                $("#modal_mProductos").modal("show")
            } else if (mode == 1) {
                // MODIFICAR PRODUCTO
                globalLoading.open()
                $("#titulo_mProductos").text("Modificar producto");
                $("#subtitulo_mProductos").text("Modificacion de producto existente, completar formulario.");
                $('.campos_mProductos').prop('disabled', false);
                $("#btnGuardar_mProductos, .forms_mProductos").removeClass("ocultar");
                get()
            } else {
                // VER PRODUCTO
                globalLoading.open()
                $("#titulo_mProductos").text("Ver producto");
                $("#subtitulo_mProductos").text("Visualizacion de producto, no se puede modificar.");
                $('.campos_mProductos').prop('disabled', true);
                $("#btnGuardar_mProductos, .forms_mProductos").addClass("ocultar");
                get()
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
                    $("#cliente_mProductos").val(g_data.cliente);
                    $("#nombre_mProductos").val(g_data.titulo);
                    // $("#sku_mProductos").val(g_data.sku);
                    // $("#ean_mProductos").val(g_data.ean);
                    globalInputImg.crear("imagen_mProductos", g_data.imagen)
                    $("#posicion_mProductos").val(g_data.posicion);
                    $("#alto_mProductos").val(g_data.alto);
                    $("#ancho_mProductos").val(g_data.ancho);
                    $("#profundo_mProductos").val(g_data.profundo);
                    $("#cm3_mProductos").val(g_data.cm3);
                    $("#esCombo_mProductos").val(g_data.esCombo).change();
                    $("#estado_mProductos").val(g_data.estado);
                    $("#descripcion_mProductos").val(g_data.descripcion);
                    g_ecommerce = g_data.ecommerce || []
                    g_ecommerce_bd = g_data.ecommerce || []
                    appModalProductos.renderEcommerce()
                    g_combos = g_data.combos || [];
                    renderCombos();
                    g_curvas = g_data.curvas.length > 0 ? g_data.curvas[0] : {
                        did: 0,
                        data: []
                    };
                    curvasSeleccionadas = g_data?.curvas[0]?.data?.length > 0 ? Object.keys(g_data.curvas[0].data[0]) : [];
                    appModalProductos.seleccionarCurvas(1)
                    renderCurvas();
                    g_insumos = g_data.insumos || []
                    globalLoading.close()
                    $("#modal_mProductos").modal("show")
                }
            });
        }

        public.mostrarCombos = function(select) {
            if (select.value == 1) {
                globalActivarAcciones.mostrarOcultarTab({
                    id: "tabCombos_mProductos",
                    opcion: 1
                })
            } else {
                globalActivarAcciones.mostrarOcultarTab({
                    id: "tabCombos_mProductos",
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

        function resetModal() {
            globalActivarAcciones.activarPrimerTab({
                tabList: "tabs_mProductos"
            })

            $(".campos_mProductos").val("")
            $(".contenedoresExtras_mProductos").html("");
            $(".btnAgregar_mProductos").prop("disabled", true);
            $('#curvas_mProductos').val(null).trigger('change');

            $("#esCombo_mProductos").val("0");
            $("#estado_mProductos").val("1");
            $("#cantidad_combo_mProductos").val("1");
            $("#cantidad_insumo_mProductos").val("0");

            g_data = {}
            g_combos = [];
            g_curvas = {
                did: 0,
                data: []
            };
            g_ecommerce = [];
            g_insumos = [];

            globalValidar.limpiarTodas()
            globalValidar.deshabilitarTiempoReal({
                className: "camposObli_mProductos"
            })
        };

        function validacion() {
            return globalValidar.obligatorios({
                className: "camposObli_mProductos"
            })
        }

        public.guardar = function() {
            const datos = {
                cliente: $("#cliente_mProductos").val(),
                titulo: $("#nombre_mProductos").val(),
                // sku: $("#sku_mProductos").val().trim(),
                // ean: $("#ean_mProductos").val().trim(),
                alto: $("#alto_mProductos").val().trim(),
                ancho: $("#ancho_mProductos").val().trim(),
                profundo: $("#profundo_mProductos").val().trim(),
                cm3: $("#cm3_mProductos").val().trim(),
                esCombo: $("#esCombo_mProductos").val(),
                habilitado: $("#estado_mProductos").val(),
                // imagen: globalInputImg.obtener("imagen_mProductos"),
                descripcion: $("#descripcion_mProductos").val().trim(),
                posicion: $("#posicion_mProductos").val().trim(),
                combos: g_combos,
                curvas: g_curvas,
                ecommerce: appModalProductos.obtenerDatosEcommerce(),
                insumos: g_insumos
            };

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

            globalSweetalert.confirmar({
                    titulo: "¿Estas seguro de guardar este producto?"
                })
                .then(function(confirmado) {
                    if (confirmado) {
                        globalRequest.post(`/${rutaAPI}`, datos, {
                            onSuccess: function(result) {
                                $("#modal_mProductos").modal("hide");
                                globalSweetalert.exito();
                                appModulosProductos.getListado();
                            }
                        });
                    }
                });
        };

        public.habilitarBtnAgregarValor = function() {
            let permitir = true

            $(".selectValores_mProductos").each(function() {
                if ($(this).val() == "") permitir = false
            });

            if (!permitir) {
                $("#btnAgregarValores_mProductos").prop("disabled", true)
            } else {
                $("#btnAgregarValores_mProductos").prop("disabled", false)
            }
        };

        public.generarCurva = async function() {
            curvaSeleccionada = $('#curvas_mProductos').val()

            if (!curvaSeleccionada) {
                $("#listaValores_mProductos").html(`<div class="d-flex justify-content-center"><span class="badge rounded-pill bg-label-primary px-6">Puedes elegir una curva, caso contrario debes seleccionar la opcion "Sin curva"</span></div>`);
                return;
            }

            console.log("curvaSeleccionada", curvaSeleccionada);

            let curva = await appSistema.curvas.find((item) => {
                item.did == curvaSeleccionada
                return item
            })

            console.log("curva", curva);

            let valoresSeleccionados = await curva.categorias.map(cat => cat.valores);

            g_columnas_curvas = await obtenerColumnas(valoresSeleccionados)
            await renderTablaDeValores()
        }

        function obtenerColumnas(arrays) {
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

        function renderTablaDeValores() {
            $("#listaValores_mProductos").empty();

            if (g_columnas_curvas.length === 0) {
                $("#listaValores_mProductos").html(`<div class="d-flex justify-content-center"><span class="badge rounded-pill bg-label-primary px-6">Puedes elegir una curva, caso contrario debes seleccionar la opcion "Sin curva"</span></div>`);
                return;
            }

            let buffer = "";
            buffer += `<div class="table-responsive text-nowrap table-container" style="height: 450px;">`
            buffer += `<table class="table table-hover">`
            buffer += `<thead id="theadListado_mProductos" class="table-thead z-1">`

            buffer += `<tr class="text-center">`
            // categoriasSeleccionadas.forEach((categoria, idx) => {
            //     buffer += `<th class="py-3"><span class="text-primary">${categoria.nombreVariante}</span><br/>${categoria.nombreCategoria}</th>`
            // })
            buffer += `</tr>`

            buffer += `</thead>`
            buffer += `<tbody id="tbodyListado_mProductos">`

            g_columnas_curvas.forEach((columnas, idx) => {
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
        }

        public.renderEcommerce = function() {
            valueCliente = $("#cliente_mProductos").val();

            if (valueCliente == "") {
                $("#contenedorEcommerce_mProductos").html('');
                return;
            }

            cliente = appSistema.clientes.find(c => c.did == valueCliente);
            cuentas = cliente?.cuentas || [];

            let buffer = '';

            g_curvas.data.forEach(curva => {
                let titulo = ""
                let masDeUno = false
                for (key in curva) {
                    let valor = curva[key];
                    let codigo = appSistema.curvas.find(v => v.did == key).codigo;
                    let valorCodigo = appSistema.curvas.find(v => v.did == key).valores.find(v => v.did == valor).codigo;

                    if (masDeUno) {
                        titulo += ` | `
                    }
                    masDeUno = true
                    titulo += `${codigo}: <span class="badge rounded-pill bg-label-warning">${valorCodigo}</span>`
                }

                buffer += `<table class="table table-bordered">`
                buffer += `<thead><tr>`
                buffer += `<th colspan="5">${titulo}</th>`
                buffer += `</tr></thead><tbody>`

                let contadorTipos = {};


                let primerEan = true
                cuentas.forEach(cuenta => {
                    tipo = cuenta.flex
                    existe = g_ecommerce_bd.find(e => globalFuncionesJs.compararDosObjetos(e.curva, curva) && e.flex == tipo);

                    if (!contadorTipos[tipo]) {
                        contadorTipos[tipo] = 1;
                    } else {
                        contadorTipos[tipo]++;
                    }

                    buffer += `<tr>`

                    buffer += `<td class="text-center">`
                    buffer += `<div class="containerSvg" style="width: 50px; height: auto;">${logosTiendas[tipo]}</div>`
                    buffer += `<p class="text-muted" style="margin: 3px 0 0 0;">${cuenta.titulo || cuenta.did}</p>`
                    buffer += `</td>`

                    buffer += `<td>`
                    buffer += `<div class="form-check mt-4">`
                    buffer += `<input class="form-check-input" type="checkbox" ${existe ? existe.actualizar == 1 ? "checked": "" : "" }/>`
                    buffer += `<label class="form-check-label">Sincronizar stock entre tiendas</label>`
                    buffer += `</div>`
                    buffer += `</td>`

                    buffer += `<td>`
                    buffer += `<div class="col-12">`
                    buffer += `<div class="form-floating form-floating-outline">`
                    buffer += `<input type="text" class="form-control" placeholder="SKU" value="${existe ? existe.sku : ""}"/>`
                    buffer += `<label for="">SKU</label>`
                    buffer += `</div>`
                    buffer += `</div>`
                    buffer += `</td>`

                    buffer += `<td>`
                    buffer += `<div class="col-12">`
                    buffer += `<div class="form-floating form-floating-outline">`

                    if (donde == 0) {
                        buffer += `<input type="text" class="form-control eansProducto_mProductos" ${primerEan ? `id="primerEan_mProductos" onchange="appModalProductos.llenarAllEan()"`: ""} placeholder="EAN" value="${existe ? existe.ean : ""}"/>`
                    } else {
                        buffer += `<input type="text" class="form-control" placeholder="EAN" value="${existe ? existe.ean : ""}"/>`
                    }
                    buffer += `<label for="">EAN</label>`
                    buffer += `</div>`
                    buffer += `</div>`
                    buffer += `</td>`
                    primerEan = false

                    buffer += `<td>`
                    buffer += `<div class="col-12">`
                    buffer += `<div class="form-floating form-floating-outline">`
                    buffer += `<input type="text" class="form-control" placeholder="URL" value="${existe ? existe.url : ""}"/>`
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

        public.llenarAllEan = function() {
            if (!eanIguales) return;
            let ean = $("#primerEan_mProductos").val().trim();
            if (ean == "") return;

            $(".eansProducto_mProductos").each(function() {
                if ($(this).val().trim() != "") return;
                $(this).val(ean);
            });
            eanIguales = false;
        };

        public.obtenerDatosEcommerce = function() {
            let datos = [];

            let indexCurva = 0;

            g_curvas.data.forEach(curva => {
                let cliente = appSistema.clientes.find(c => c.did == $("#cliente_mProductos").val());
                let cuentas = cliente.cuentas || [];
                existe = g_ecommerce_bd.find(e => globalFuncionesJs.compararDosObjetos(e.curva, curva));

                let filas = $(`#contenedorEcommerce_mProductos table`).eq(indexCurva).find("tbody tr");
                filas.each((i, fila) => {
                    let inputs = $(fila).find("input");

                    let sku = $(inputs[1]).val();
                    let ean = $(inputs[2]).val();
                    let url = $(inputs[3]).val();
                    let actualizar = $(inputs[0]).is(":checked") ? 1 : 0;

                    datos.push({
                        did: existe ? existe.did : 0,
                        curva: curva,
                        flex: cuentas[i].flex,
                        didCuenta: cuentas[i].did,
                        sku: sku,
                        ean: ean,
                        url: url,
                        actualizar: actualizar
                    });
                });

                indexCurva++;
            });

            return datos;
        };

        public.habilitarBtnAgregarCombos = function() {
            producto = $("#producto_combo_mProductos").val() || ""
            cantidad = $("#cantidad_combo_mProductos").val() * 1;

            if (producto != "" && cantidad > 0) {
                $("#btnAgregarCombos_mProductos").prop("disabled", false)
            } else {
                $("#btnAgregarCombos_mProductos").prop("disabled", true)
            }
        }

        public.agregarCombos = function() {
            producto = $("#producto_combo_mProductos").val();
            cantidad = $("#cantidad_combo_mProductos").val();

            existe = g_combos.find(v => v.did === producto);

            if (existe) {
                existe.cantidad = cantidad;
            } else {
                g_combos.push({
                    did: producto,
                    cantidad,
                });
            }

            $("#producto_combo_mProductos").val('');
            $("#cantidad_combo_mProductos").val('1');

            $("#btnAgregarCombos_mProductos").prop("disabled", true)
            renderCombos();
        };

        function renderCombos() {
            if (g_combos.length === 0) {
                $("#contenedorCombos_mProductos").html('<p class="text-muted text-center">Sin combos aún.</p>');
                return;
            }

            buffer = `<table class="table table-bordered">`
            buffer += `<thead>`
            buffer += `<tr>`
            buffer += `<th>Producto</th>`
            buffer += `<th>Cantidad</th>`
            if (donde != 2) {
                buffer += `<th>Eliminar</th>`
            }
            buffer += `</tr>`
            buffer += `</thead>`

            buffer += `<tbody>`

            g_combos.forEach((c, idx) => {
                titulo = appSistema.productos.find(p => p.did == c.did)?.titulo || "Sin titulo";

                buffer += `<tr>`
                buffer += `<td>${titulo}</td>`
                buffer += `<td>${c.cantidad}</td>`
                if (donde != 2) {
                    buffer += `<td><button type="button" class="btn btn-icon rounded-pill btn-text-danger" onclick="appModalProductos.eliminarCombo(${idx})" title="Eliminar"><i class="tf-icons ri-delete-bin-6-line ri-22px"></i></button></td>`
                }
                buffer += `</tr>`
            });

            buffer += `</tbody>`
            buffer += `</table>`

            $("#contenedorCombos_mProductos").html(buffer);
        };

        public.eliminarCombo = function(index) {
            g_combos.splice(index, 1);
            renderCombos();
        };

        public.habilitarBtnAgregarInsumo = function() {
            insumo = $("#nombre_insumo_mProductos").val() || ""
            cantidad = $("#cantidad_insumo_mProductos").val() * 1;

            if (insumo != "" && cantidad > 0) {
                $("#btnAgregarInsumos_mProductos").prop("disabled", false)
            } else {
                $("#btnAgregarInsumos_mProductos").prop("disabled", true)
            }
        }

        public.agregarInsumo = function() {
            insumo = $("#nombre_insumo_mProductos").val();
            cantidad = $("#cantidad_insumo_mProductos").val();
            habilitado = $("#checkInsumoHabilitado_mUsuarios").is(":checked") ? 1 : 0;

            existe = g_insumos.find(i => i.did === insumo);

            if (existe) {
                existe.cantidad = cantidad;
                existe.habilitado = habilitado;
            } else {
                g_insumos.push({
                    did: insumo,
                    cantidad,
                    habilitado
                });
            }

            $("#nombre_insumo_mProductos").val('');
            $("#cantidad_insumo_mProductos").val('0');
            $("#checkInsumoHabilitado_mUsuarios").prop("checked", false);

            $("#btnAgregarInsumos_mProductos").prop("disabled", true)
            renderInsumos();
        };

        function renderInsumos() {
            if (g_insumos.length === 0) {
                $("#contenedorInsumos_mProductos").html('<p class="text-muted text-center">Sin insumos aún.</p>');
                return;
            }

            buffer = `<table class="table table-bordered">`
            buffer += `<thead>`
            buffer += `<tr>`
            buffer += `<th>Insumo</th>`
            buffer += `<th>Cantidad</th>`
            buffer += `<th>Estado</th>`
            if (donde != 2) {
                buffer += `<th>Eliminar</th>`
            }
            buffer += `</tr>`
            buffer += `</thead>`

            buffer += `<tbody>`

            g_insumos.forEach((c, idx) => {
                let nombre = appSistema.insumos.find(i => i.did == c.did).nombre
                buffer += `<tr>`
                buffer += `<td>${nombre}</td>`
                buffer += `<td>${c.cantidad}</td>`
                buffer += `<td><span class="badge rounded-pill bg-label-${c.habilitado == 1 ? "success" : "danger"}">${c.habilitado == 1 ? "Habilitado" : "Deshabilitado"}</span></td>`

                if (donde != 2) {
                    buffer += `<td><button type="button" class="btn btn-icon rounded-pill btn-text-danger" onclick="appModalProductos.eliminarInsumo(${idx})" title="Eliminar"><i class="tf-icons ri-delete-bin-6-line ri-22px"></i></button></td>`
                }
                buffer += `</tr>`
            });

            buffer += `</tbody>`
            buffer += `</table>`

            $("#contenedorInsumos_mProductos").html(buffer);
        };

        public.eliminarInsumo = function(index) {
            g_insumos.splice(index, 1);
            renderInsumos();
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
                            appModulosProductos.getListado();
                        }
                    });
                }
            });
        };

        return public;
    }());
</script>
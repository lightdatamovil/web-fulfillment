<script>
    const appProducto = (function() {
        let g_did = 0;
        let g_data;
        let donde = 0;
        let g_combos = [];
        let g_ecommerce = [];
        let g_ecommerce_bd = []
        let g_insumos = []
        let variantesSeleccionadas = []
        let logosTiendas = {}
        let eanIguales = true
        let g_variantes = {
            did: 0,
            data: []
        };

        public = {};

        public.open = function(type, did) {
            resetModal()
            g_did = did;
            donde = type
            globalLlenarSelect.variantes("variantes_mProductos", true)
            globalLlenarSelect.clientes("cliente_mProductos")
            globalLlenarSelect.insumos("nombre_insumo_mProductos")
            globalLlenarSelect.productos("producto_combo_mProductos")

            logosTiendas = globalLogoTiendas.obtener()

            globalActivarAcciones.mostrarOcultarTab("tabCombos_mProductos", 0)
            if (type == 0) {
                // NUEVO PRODUCTO
                $("#titulo_mProductos").text("Nuevo producto");
                $("#subtitulo_mProductos").text("Creacion de producto nuevo, completar formulario.");
                $('.campos_mProductos').prop('disabled', false);
                $("#btnGuardar_mProductos, .forms_mProductos").removeClass("ocultar");
                globalInputImg.crear("imagen_mProductos")
                $("#modalProducto").modal("show")
            } else if (type == 1) {
                // MODIFICAR PRODUCTO
                globalLoading.open()
                $("#titulo_mProductos").text("Modificar producto");
                $("#subtitulo_mProductos").text("Modificacion de producto existente, completar formulario.");
                $('.campos_mProductos').prop('disabled', false);
                $("#btnGuardar_mProductos, .forms_mProductos").removeClass("ocultar");
                getProducto()
            } else {
                // VER PRODUCTO
                globalLoading.open()
                $("#titulo_mProductos").text("Ver producto");
                $("#subtitulo_mProductos").text("Visualizacion de producto, no se puede modificar.");
                $('.campos_mProductos').prop('disabled', true);
                $("#btnGuardar_mProductos, .forms_mProductos").addClass("ocultar");
                getProducto()
            }
        }

        function getProducto() {
            parametros = {
                idEmpresa: appSistema.idEmpresa,
                did: g_did
            };

            $.ajax({
                url: `${appSistema.urlServer}/producto/getProductoById`,
                type: "POST",
                data: parametros,
                headers: {
                    Authorization: `Bearer ${appSistema.tkn}`
                },
                success: function(result) {
                    if (result.estado && result.data) {
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
                        appProducto.renderEcommerce()
                        g_combos = g_data.combos || [];
                        renderCombos();
                        g_variantes = g_data.variantes.length > 0 ? g_data.variantes[0] : {
                            did: 0,
                            data: []
                        };
                        variantesSeleccionadas = g_data?.variantes[0]?.data?.length > 0 ? Object.keys(g_data.variantes[0].data[0]) : [];
                        appProducto.seleccionarVariantes(1)
                        renderVariantes();
                        g_insumos = g_data.insumos || []
                        renderInsumos()
                        globalLoading.close()
                        $("#modalProducto").modal("show")
                    }
                },
                error: function(xhr) {
                    console.log("Error", xhr.responseText);
                    globalLoading.close()
                    globalSweetalert.error()
                }
            });
        }

        public.mostrarCombos = function(select) {
            if (select.value == 1) {
                globalActivarAcciones.mostrarOcultarTab("tabCombos_mProductos", 1)
            } else {
                globalActivarAcciones.mostrarOcultarTab("tabCombos_mProductos", 0)
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
            globalActivarAcciones.activarPrimerTab("tabs_mProductos")

            $(".campos_mProductos").val("")
            $(".contenedoresExtras_mProductos").html("");
            $(".btnAgregar_mProductos").prop("disabled", true);
            $('#variantes_mProductos').val(null).trigger('change');

            $("#esCombo_mProductos").val("0");
            $("#estado_mProductos").val("1");
            $("#cantidad_combo_mProductos").val("1");
            $("#cantidad_insumo_mProductos").val("0");

            g_data = {}
            g_combos = [];
            g_variantes = {
                did: 0,
                data: []
            };
            g_ecommerce = [];
            g_insumos = [];

            globalValidar.limpiarTodas()
            globalValidar.deshabilitarTiempoReal("camposObli_mProductos")
        };

        function validacion() {
            return globalValidar.obligatorios("camposObli_mProductos")
        }

        public.guardar = function() {
            const cliente = $("#cliente_mProductos").val();
            const titulo = $("#nombre_mProductos").val();
            // const sku = $("#sku_mProductos").val().trim();
            // const ean = $("#ean_mProductos").val().trim();
            const posicion = $("#posicion_mProductos").val().trim();
            const alto = $("#alto_mProductos").val().trim();
            const ancho = $("#ancho_mProductos").val().trim();
            const profundo = $("#profundo_mProductos").val().trim();
            const cm3 = $("#cm3_mProductos").val().trim();
            const esCombo = $("#esCombo_mProductos").val();
            const habilitado = $("#estado_mProductos").val();
            // const imagen = globalInputImg.obtener("imagen_mProductos");
            const descripcion = $("#descripcion_mProductos").val().trim();
            base64 = globalInputImg.obtener("imagen_mProductos")
            console.log("base64", base64);

            const datos = {
                idEmpresa: appSistema.idEmpresa,
                did: g_did || 0,
                cliente,
                titulo,
                // sku,
                // ean,
                alto,
                ancho,
                profundo,
                cm3,
                esCombo,
                habilitado,
                // imagen,
                descripcion,
                posicion,
                combos: g_combos,
                variantes: g_variantes,
                ecommerce: appProducto.obtenerDatosEcommerce(),
                insumos: g_insumos
            };

            globalValidar.habilitarTiempoReal("camposObli_mProductos", validacion)

            if (validacion()) {
                globalSweetalert.alert("Verifique los campos")
                return
            }

            globalSweetalert.confirmar("¿Estas seguro de guardar este producto?").then(function(confirmado) {
                if (confirmado) {
                    globalLoading.open()
                    $.ajax({
                        url: `${appSistema.urlServer}/producto/postProducto`,
                        type: "POST",
                        contentType: "application/json",
                        data: JSON.stringify(datos),
                        headers: {
                            Authorization: `Bearer ${appSistema.tkn}`
                        },
                        success: function(result) {
                            if (result.estado) {
                                globalLoading.close()
                                $("#modalProducto").modal("hide")
                                globalSweetalert.exito()
                                appSistema.cargarProductos()
                                appProductosListado.getListado();
                            } else {
                                globalLoading.close()
                                globalSweetalert.alert(result.message)
                            }
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

        public.habilitarBtnAgregarVariante = function() {
            seleccion = $("#variantes_mProductos").val()

            if (seleccion.length < 1) {
                $("#btnAgregarVariante_mProductos").prop("disabled", true)
            } else {
                $("#btnAgregarVariante_mProductos").prop("disabled", false)
            }
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

        public.seleccionarVariantes = function(type) {
            if (type == 0) {
                $("#contenedorSelectValores_mProductos, #contenedorListaVariantes_mProductos").html("")
                g_variantes.data = []
                variantesSeleccionadas = $("#variantes_mProductos").val()
            } else {
                $('#variantes_mProductos').val(variantesSeleccionadas).trigger('change');
                $("#btnAgregarVariante_mProductos").prop("disabled", true)
            }

            if (variantesSeleccionadas.length == 0) return;

            buffer = ""

            columnas = "9"
            columnas2 = "3"
            if (variantesSeleccionadas.length == 2) {
                columnas = "4"
                columnas2 = "4"
            } else if (variantesSeleccionadas.length > 2) {
                columnas = "3"
                columnas2 = "3"
            }

            for (seleccionada of variantesSeleccionadas) {

                varianteSeleccionada = appSistema.variantes.find((variante) => variante.did == seleccionada)

                buffer += `<div class="col-12 col-md-${columnas}">`
                buffer += `<div class="form-floating form-floating-outline">`
                buffer += `<select class="form-select selectValores_mProductos" data-didVariante="${varianteSeleccionada["did"]}" onchange="appProducto.habilitarBtnAgregarValor()">`
                buffer += `<option value="" selected>Selecciona</option>`
                for (valores of varianteSeleccionada["valores"]) {
                    buffer += `<option value="${valores["did"]}">${valores["nombre"] || "Sin nombre"}</option>`
                }
                buffer += `</select>`
                buffer += `<label>${varianteSeleccionada.codigo}</label>`
                buffer += `</div>`
                buffer += `</div>`
            }

            buffer += `<div class="col-12 col-md-${columnas2}">`
            buffer += `<button class="btn btn-label-success w-100" id="btnAgregarValores_mProductos" disabled onclick="appProducto.agregarVariante()">Agregar</button>`
            buffer += `</div>`

            $("#contenedorSelectValores_mProductos").html(buffer)
        }

        public.agregarVariante = function() {
            newData = {}

            $(".selectValores_mProductos").each(function() {
                newData[$(this).data("didvariante")] = $(this).val()
            });

            existe = g_variantes.data.some((item) => globalFuncionesJs.compararDosObjetos(item, newData));

            if (existe) {
                globalSweetalert.alert("Ya existe esta variante")
                return
            }

            g_variantes.data.push(newData)

            $(".selectValores_mProductos").each(function() {
                $(this).val("")
            });

            $("#btnAgregarValores_mProductos").prop("disabled", true)
            renderVariantes();
        };

        function renderVariantes() {
            if (g_variantes.data.length == 0) {
                $("#contenedorListaVariantes_mProductos").html('<p class="text-muted text-center">Sin variantes aún.</p>');
                return;
            }

            buffer = `<table class="table table-bordered">`
            buffer += `<thead><tr>`

            for (let seleccionada of variantesSeleccionadas) {
                let varianteSeleccionada = appSistema.variantes.find(v => v.did == seleccionada)
                buffer += `<th>${varianteSeleccionada.codigo}</th>`
            }

            if (donde != 2) {
                buffer += `<th>Eliminar</th>`
            }

            buffer += `</tr></thead><tbody>`

            g_variantes.data.forEach((item, idx) => {
                buffer += `<tr>`

                for (let seleccionada of variantesSeleccionadas) {
                    const variante = appSistema.variantes.find(v => v.did == seleccionada)

                    const valorDid = item[seleccionada]
                    const valor = variante.valores.find(val => val.did == valorDid)
                    const nombre = valor?.nombre || "Sin nombre"

                    buffer += `<td>${nombre}</td>`
                }

                if (donde != 2) {
                    buffer += `<td><button type="button" class="btn btn-icon rounded-pill btn-text-danger" onclick="appProducto.eliminarVariante(${idx})" title="Eliminar"><i class="tf-icons ri-delete-bin-6-line ri-22px"></i></button></td>`
                }

                buffer += `</tr>`
            })

            buffer += `</tbody></table>`

            $("#contenedorListaVariantes_mProductos").html(buffer)
            eanIguales = true
            appProducto.renderEcommerce()
        }

        public.eliminarVariante = function(index) {
            g_variantes.data.splice(index, 1);
            renderVariantes();
        };

        public.renderEcommerce = function() {
            valueCliente = $("#cliente_mProductos").val();

            if (valueCliente == "") {
                $("#contenedorEcommerce_mProductos").html('');
                return;
            }

            cliente = appSistema.clientes.find(c => c.did == valueCliente);
            cuentas = cliente?.cuentas || [];

            let buffer = '';

            g_variantes.data.forEach(variante => {
                let titulo = ""
                let masDeUno = false
                for (key in variante) {
                    let valor = variante[key];
                    let codigo = appSistema.variantes.find(v => v.did == key).codigo;
                    let valorCodigo = appSistema.variantes.find(v => v.did == key).valores.find(v => v.did == valor).codigo;

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
                    existe = g_ecommerce_bd.find(e => globalFuncionesJs.compararDosObjetos(e.variante, variante) && e.flex == tipo);

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
                        buffer += `<input type="text" class="form-control eansProducto_mProductos" ${primerEan ? `id="primerEan_mProductos" onchange="appProducto.llenarAllEan()"`: ""} placeholder="EAN" value="${existe ? existe.ean : ""}"/>`
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

            let indexVariante = 0;

            g_variantes.data.forEach(variante => {
                let cliente = appSistema.clientes.find(c => c.did == $("#cliente_mProductos").val());
                let cuentas = cliente.cuentas || [];
                existe = g_ecommerce_bd.find(e => globalFuncionesJs.compararDosObjetos(e.variante, variante));

                let filas = $(`#contenedorEcommerce_mProductos table`).eq(indexVariante).find("tbody tr");
                filas.each((i, fila) => {
                    let inputs = $(fila).find("input");

                    let sku = $(inputs[1]).val();
                    let ean = $(inputs[2]).val();
                    let url = $(inputs[3]).val();
                    let actualizar = $(inputs[0]).is(":checked") ? 1 : 0;

                    datos.push({
                        did: existe ? existe.did : 0,
                        variante: variante,
                        flex: cuentas[i].flex,
                        didCuenta: cuentas[i].did,
                        sku: sku,
                        ean: ean,
                        url: url,
                        actualizar: actualizar
                    });
                });

                indexVariante++;
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
                    buffer += `<td><button type="button" class="btn btn-icon rounded-pill btn-text-danger" onclick="appProducto.eliminarCombo(${idx})" title="Eliminar"><i class="tf-icons ri-delete-bin-6-line ri-22px"></i></button></td>`
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
                    buffer += `<td><button type="button" class="btn btn-icon rounded-pill btn-text-danger" onclick="appProducto.eliminarInsumo(${idx})" title="Eliminar"><i class="tf-icons ri-delete-bin-6-line ri-22px"></i></button></td>`
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
            const datos = {
                idEmpresa: appSistema.idEmpresa,
                did
            }

            globalSweetalert.confirmar("¿Estas seguro de eliminar esta producto?", "var(--bs-danger)").then(function(confirmado) {
                if (confirmado) {
                    globalLoading.open()
                    $.ajax({
                        url: `${appSistema.urlServer}/producto/deleteProducto`,
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
                            appSistema.cargarProductos()
                            appProductosListado.getListado();
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
    }());
</script>
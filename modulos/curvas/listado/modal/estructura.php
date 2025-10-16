<script>
    const appModalCurvas = (function() {
        let g_did = 0;
        let g_data;
        let donde = 0;
        let categoriasSeleccionadas = [];
        let g_columnas = []
        let g_columnasHead = []
        const rutaAPI = "curvas"

        const public = {};

        public.open = async function({
            mode = 0,
            did = 0
        } = {}) {
            await resetModal();
            g_did = did;
            donde = mode

            await globalLlenarSelect.variantes({
                id: "variantes_mCurvas",
                multiple: true
            })

            await globalActivarAcciones.select2({
                className: "select2_mCurvas"
            })

            if (mode == 0) {
                // NUEVA CURVA
                $("#titulo_mCurvas").text("Nueva curva");
                $("#subtitulo_mCurvas").text("Creacion de curva nuevo, completar formulario.");
                $('.campos_mCurvas').prop('disabled', false);
                $("#btnGuardar_mCurvas, .ocultarDesdeVer").removeClass("ocultar");
                $("#btnEditar_mCurvas").addClass("ocultar")
                $("#modal_mCurvas").modal("show")
            } else if (mode == 1) {
                // MODIFICAR CURVA
                await globalLoading.open()
                $("#titulo_mCurvas").text("Modificar curva");
                $("#subtitulo_mCurvas").text("Modificacion de curva existente, completar formulario.");
                $('.campos_mCurvas').prop('disabled', false);
                $("#btnEditar_mCurvas, .ocultarDesdeVer").removeClass("ocultar");
                $("#btnGuardar_mCurvas").addClass("ocultar")
                await get()
            } else {
                // VER CURVA
                await globalLoading.open()
                $("#titulo_mCurvas").text("Ver curva");
                $("#subtitulo_mCurvas").text("Visualizacion de curva, no se puede modificar.");
                $('.campos_mCurvas').prop('disabled', true);
                $("#btnGuardar_mCurvas, #btnEditar_mCurvas, .ocultarDesdeVer").addClass("ocultar");
                await get()
            }
        }

        function get() {
            globalRequest.get(`/${rutaAPI}/${g_did}`, {
                onSuccess: function(result) {
                    g_data = result.data;
                    $("#codigo_mCurvas").val(g_data.codigo);
                    $("#nombre_mCurvas").val(g_data.nombre);
                    $("#descripcion_mCurvas").val(g_data.descripcion);
                    $("#checkHabilitado_mCurvas").prop("checked", g_data.habilitado == 1);
                    g_categorias = structuredClone(g_data.categorias)

                    if (donde == 2) {
                        $('.campos_mCurvas').prop('disabled', true);
                        $(".ocultarDesdeVer").addClass("ocultar")
                    } else {
                        $(".ocultarDesdeVer").removeClass("ocultar")
                    }

                    $("#modal_mCurvas").modal("show")
                }
            });
        }

        function resetModal() {
            globalActivarAcciones.activarPrimerTab({
                tabList: "tabs_mCurvas"
            })

            $(".campos_mCurvas").val("")
            $("#checkHabilitado_mCurvas").prop("checked", true);
            $("#btnGenerarCurva_mCurvas").prop("disabled", true)
            $("#listaValores_mCurvas").html('');
            $("#variantes_mCurvas").val(null).trigger("change");

            g_data = []
            g_categorias = []

            globalValidar.limpiarTodas()
            globalValidar.deshabilitarTiempoReal({
                className: "camposObli_mCurvas"
            })
        };

        public.agregarVariante = function() {
            let variantes = $("#variantes_mCurvas").val()

            buffer = ""

            if (variantes.length > 0) {
                buffer += `<h5>Seleccionar categorias</h5>`
                buffer += `<div class="row g-5">`

                variantes.forEach((varianteSeleccionada) => {
                    let variante = appSistema.variantes.find((item) => item.did == varianteSeleccionada)

                    buffer += `<div class="col-12 col-md-${variantes.length > 1 ? "6" : "12"}">`
                    buffer += `<div class="form-floating form-floating-outline">`
                    buffer += `<select class="form-select selectCategorias_mProductos" data-variante="${variante.did}" onchange="appModalCurvas.habilitarBtnGenerarCurva()">`
                    buffer += `<option value="" selected>Seleccionar</option>`
                    for (categorias of variante["categorias"]) {
                        buffer += `<option value="${categorias["did"]}">${categorias["nombre"] || "Sin nombre"}</option>`
                    }
                    buffer += `</select>`
                    buffer += `<label>${variante.codigo}</label>`
                    buffer += `</div>`
                    buffer += `</div>`

                })
                buffer += `</div>`
            }

            $("#containerCategorias_mCurvas").html(buffer)
            $("#btnGenerarCurva_mCurvas").prop("disabled", true);
        }

        function obtenerCategoriasSeleccionadas() {
            categoriasSeleccionadas = []

            $(".selectCategorias_mProductos").each(function() {
                const variante = $(this).data("variante");
                const categoria = $(this).val();
                const nombreCategoria = $(this).find("option:selected").text();
                const dataVariante = appSistema.variantes.find((item) => item.did == variante)

                if (categoria) {
                    categoriasSeleccionadas.push({
                        variante,
                        categoria,
                        nombreCategoria,
                        nombreVariante: dataVariante.nombre || ""

                    });
                }
            });
        };

        public.habilitarBtnGenerarCurva = function() {
            const todosValidos = $('.selectCategorias_mProductos').toArray().every(
                categoria => $(categoria).val()?.trim() !== ""
            );

            $("#btnGenerarCurva_mCurvas").prop("disabled", !todosValidos);
        };

        public.generarCurva = async function() {
            await obtenerCategoriasSeleccionadas()

            let valoresSeleccionados = await categoriasSeleccionadas.map((item) => {
                let variante = appSistema.variantes.find((v) => v.did == item.variante)
                let categoria = variante.categorias.find((c) => c.did == item.categoria)
                return categoria.valores
            })

            g_columnas = await obtenerColumnas(valoresSeleccionados)

            await renderTablaDeValores()
        }

        function obtenerColumnas(arrays) {
            return arrays.reduce((acumulado, actual) => {
                const combinaciones = [];
                acumulado.forEach(a => {
                    actual.forEach(b => {
                        combinaciones.push({
                            variante: [...a.variante, b],
                            habilitado: 1
                        });
                    });
                });
                return combinaciones;
            }, [{
                variante: []
            }]);
        }


        function renderTablaDeValores() {
            $("#listaVariantes_mCurvas").empty();

            if (g_columnas.length === 0) {
                $("#listaVariantes_mCurvas").html(`<div class="d-flex justify-content-center"><span class="badge rounded-pill bg-label-warning px-6">Sin variantes aún, agrega al menos una.</span></div>`);
                return;
            }

            let buffer = "";
            buffer += `<div class="table-responsive text-nowrap table-container" style="height: 450px;">`
            buffer += `<table class="table table-hover">`
            buffer += `<thead id="theadListado_mCurvas" class="table-thead z-1">`

            buffer += `<tr class="text-center">`
            buffer += `<th class="py-3"></th>`
            categoriasSeleccionadas.forEach((categoria, idx) => {
                buffer += `<th class="py-3"><span class="text-primary">${categoria.nombreVariante}</span><br/>${categoria.nombreCategoria}</th>`
            })
            buffer += `</tr>`

            buffer += `</thead>`
            buffer += `<tbody id="tbodyListado_mCurvas">`

            g_columnas.forEach((columnas, idx) => {
                buffer += `<tr class="text-center">`
                buffer += `<td>`

                buffer += `<div class="form-check">`
                buffer += `<input class="form-check-input campos_mCurvas" type="checkbox" value="" id="columnaHabilitado_${idx}_mCurvas" ${columnas.habilitado == 1 ? "checked": ""} />`
                buffer += `</div>`

                buffer += `</td>`
                columnas.variante.forEach((item) => {
                    buffer += `<td data-did="${item.did}">${item.nombre}</td>`
                })


                buffer += `</tr>`
            })

            buffer += `</tbody>`
            buffer += `</table>`
            buffer += `</div>`


            $("#listaVariantes_mCurvas").html(buffer);
        }

        function validacion() {
            return globalValidar.obligatorios({
                className: "camposObli_mCurvas"
            })
        }

        public.guardar = function() {
            const datos = {
                codigo: $("#codigo_mCurvas").val().trim() || null,
                nombre: $("#nombre_mCurvas").val().trim() || null,
                habilitado: $("#checkHabilitado_mCurvas").is(":checked") ? 1 : 0,
                categorias: g_categorias || [],
                orden: 1
            };

            datos.categorias = datos.categorias.map((categoria, idx) => ({
                ...categoria,
                valores: globalActivarAcciones.obtenerDataFormRepeater({
                    id: `formValores_${idx}_mCurvas`
                })
            }));

            globalValidar.habilitarTiempoReal({
                className: "camposObli_mCurvas",
                callback: validacion
            });

            if (validacion()) {
                globalSweetalert.alert({
                    titulo: "Verifique los campos"
                });
                return;
            }

            if (datos.categorias.length < 1) {
                globalSweetalert.alert({
                    titulo: "La curva debe tener al menos una categoria"
                });
                return;
            }

            if (!datos.categorias || datos.categorias.some(cat => !cat.valores || cat.valores.length === 0)) {
                globalSweetalert.alert({
                    titulo: "Las categorías deben tener al menos un valor"
                });
                return;
            }

            globalSweetalert.confirmar({
                    titulo: "¿Estas seguro de guardar esta curva?"
                })
                .then(function(confirmado) {
                    if (confirmado) {
                        globalRequest.post(`/${rutaAPI}`, datos, {
                            onSuccess: function(result) {
                                $("#modal_mCurvas").modal("hide")
                                globalSweetalert.exito()
                                appModuloCurvas.getListado();
                            }
                        });
                    }
                });
        };

        public.editar = function() {
            const datosNuevos = {
                codigo: $("#codigo_mCurvas").val().trim() || null,
                nombre: $("#nombre_mCurvas").val().trim() || null,
                habilitado: $("#checkHabilitado_mCurvas").is(":checked") ? 1 : 0,
                orden: 1
            };

            datosNuevos.categorias = g_categorias.map((categoria, idx) => {
                return ({
                    ...categoria,
                    valores: globalActivarAcciones.obtenerDataFormRepeater({
                        id: `formValores_${idx}_mCurvas`
                    })
                })
            })

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

            globalValidar.habilitarTiempoReal({
                className: "camposObli_mCurvas",
                callback: validacion
            });

            if (validacion()) {
                globalSweetalert.alert({
                    titulo: "Verifique los campos"
                });
                return;
            }

            if (!datosNuevos.categorias || datosNuevos.categorias.length < 1) {
                globalSweetalert.alert({
                    titulo: "La curva debe tener al menos una categoría"
                });
                return;
            }

            if (datosNuevos.categorias.some(cat => !cat.valores || cat.valores.length === 0)) {
                globalSweetalert.alert({
                    titulo: "Las categorías deben tener al menos un valor"
                });
                return;
            }

            let categoriasUpdateadas = {}
            if (datosModificados.categorias && datosModificados.categorias.length > 0) {
                categoriasUpdateadas = globalValidar.obtenerCambiosEnArray({
                    dataNueva: datosModificados.categorias,
                    dataOriginal: g_data.categorias
                })
            }

            if (categoriasUpdateadas.update && categoriasUpdateadas.update.length > 0) {
                categoriasUpdateadas.update = categoriasUpdateadas.update.map((categoria) => {

                    let valoresUpdateados = {}
                    let original = g_data.categorias.find(item => item.did == categoria.did)

                    let valoresModificados = globalValidar.obtenerCambios({
                        dataNueva: categoria.valores,
                        dataOriginal: original.valores
                    });

                    valoresModificados = Object.values(valoresModificados)

                    if (valoresModificados && valoresModificados.length > 0) {
                        valoresUpdateados = globalValidar.obtenerCambiosEnArray({
                            dataNueva: valoresModificados,
                            dataOriginal: original.valores
                        })
                    }

                    return {
                        ...categoria,
                        valores: valoresUpdateados
                    }
                })
            }

            datosNuevos.categorias = categoriasUpdateadas

            globalSweetalert.confirmar({
                    titulo: "¿Estas seguro de modificar esta curva?"
                })
                .then(function(confirmado) {
                    if (confirmado) {
                        globalRequest.put(`/${rutaAPI}/${g_did}`, datosNuevos, {
                            onSuccess: function(result) {
                                $("#modal_mCurvas").modal("hide");
                                globalSweetalert.exito();
                                appModuloCurvas.getListado();
                            }
                        });
                    }
                });
        };

        public.eliminar = function(did) {
            globalSweetalert.confirmar({
                titulo: "¿Estas seguro de eliminar este curva?",
                color: "var(--bs-danger)"
            }).then(function(confirmado) {
                if (confirmado) {
                    globalRequest.delete(`/${rutaAPI}/${did}`, {
                        onSuccess: function(result) {
                            globalSweetalert.exito({
                                titulo: "Eliminado con éxito!"
                            });
                            appModuloCurvas.getListado();
                        }
                    });
                }
            });
        };

        return public;
    })();
</script>
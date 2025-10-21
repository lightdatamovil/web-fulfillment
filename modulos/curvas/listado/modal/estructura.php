<script>
    const appModalCurvas = (function() {
        let g_did = 0;
        let g_data;
        let donde = 0;
        let categoriasSeleccionadas = [];
        let g_columnas = []
        let g_columnasFiltradas = []
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
                $("#btnGuardar_mCurvas, .ocultarDesdeVer_mCurvas").removeClass("ocultar");
                $("#btnEditar_mCurvas").addClass("ocultar")
                $("#modal_mCurvas").modal("show")
            } else if (mode == 1) {
                // MODIFICAR CURVA
                await globalLoading.open()
                $("#titulo_mCurvas").text("Modificar curva");
                $("#subtitulo_mCurvas").text("Modificacion de curva existente, completar formulario.");
                $('.campos_mCurvas').prop('disabled', false);
                $("#btnEditar_mCurvas, .ocultarDesdeVer_mCurvas").removeClass("ocultar");
                $("#btnGuardar_mCurvas").addClass("ocultar")
                await get()
            } else {
                // VER CURVA
                await globalLoading.open()
                $("#titulo_mCurvas").text("Ver curva");
                $("#subtitulo_mCurvas").text("Visualizacion de curva, no se puede modificar.");
                $('.campos_mCurvas').prop('disabled', true);
                $("#btnGuardar_mCurvas, #btnEditar_mCurvas, .ocultarDesdeVer_mCurvas").addClass("ocultar");
                await get()
            }
        }

        function resetModal() {
            globalActivarAcciones.activarPrimerTab({
                tabList: "tabs_mCurvas"
            })

            $(".campos_mCurvas").val("")
            $("#searchValor_mCurvas").val("")
            $("#checkHabilitado_mCurvas").prop("checked", true);
            $("#btnGenerarCurva_mCurvas").prop("disabled", true)
            $("#variantes_mCurvas").val(null).trigger("change");
            $("#listaValores_mCurvas").html(`<div class="d-flex justify-content-center"><span class="badge rounded-pill bg-label-warning px-6">Sin variantes aún, agrega al menos una.</span></div>`);

            g_data = []
            g_categorias = []

            globalValidar.limpiarTodas()
            globalValidar.deshabilitarTiempoReal({
                className: "camposObli_mCurvas"
            })
        };

        function get() {
            globalRequest.get(`/${rutaAPI}/${g_did}`, {
                onSuccess: async function(result) {
                    g_data = result.data;
                    g_categorias = result.data.categorias || []
                    $("#codigo_mCurvas").val(g_data.codigo);
                    $("#nombre_mCurvas").val(g_data.nombre);
                    $("#checkHabilitado_mCurvas").prop("checked", g_data.habilitado == 1);
                    $("#variantes_mCurvas").val(g_categorias.map((item) => item.did_variante)).change()
                    await appModalCurvas.agregarVariante()
                    await seleccionarCategorias()
                    await appModalCurvas.generarCurva()

                    if (donde == 2) {
                        $('.campos_mCurvas').prop('disabled', true);
                        $(".ocultarDesdeVer_mCurvas").addClass("ocultar")
                    } else {
                        $(".ocultarDesdeVer_mCurvas").removeClass("ocultar")
                    }

                    $("#modal_mCurvas").modal("show")
                }
            });
        }

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
                    buffer += `<select class="form-select campos_mCurvas selectCategorias_mProductos" id="selectCategoria_${variante.did}_mProductos" data-variante="${variante.did}" onchange="appModalCurvas.habilitarBtnGenerarCurva()">`
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

        function seleccionarCategorias() {
            $(".selectCategorias_mProductos").each(function() {
                const variante = $(this).data("variante");
                const seleccionarCategoria = g_categorias.find((item) => item.did_variante == variante)
                const categoria = $(this).val(seleccionarCategoria.did_categoria);
            });
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

            console.log(valoresSeleccionados);

            g_columnas = await obtenerColumnas(valoresSeleccionados)
            g_columnasFiltradas = [...g_columnas]

            await renderTablaDeValores()
            $("#btnGenerarCurva_mCurvas").prop("disabled", true);

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
            $("#listaValores_mCurvas").empty();

            if (g_columnas.length === 0) {
                $("#listaValores_mCurvas").html(`<div class="d-flex justify-content-center"><span class="badge rounded-pill bg-label-warning px-6">Sin variantes aún, agrega al menos una.</span></div>`);
                return;
            }

            if (g_columnasFiltradas.length === 0) {
                $("#listaValores_mCurvas").html(`<div class="d-flex justify-content-center"><span class="badge rounded-pill bg-label-warning px-6">No hay coincidencias con tu busqueda</span></div>`);
                return;
            }

            let buffer = "";
            buffer += `<div class="table-responsive text-nowrap table-container" style="height: 450px;">`
            buffer += `<table class="table table-hover">`
            buffer += `<thead id="theadListado_mCurvas" class="table-thead z-1">`

            buffer += `<tr class="text-center">`
            categoriasSeleccionadas.forEach((categoria, idx) => {
                buffer += `<th class="py-3"><span class="text-primary">${categoria.nombreVariante}</span><br/>${categoria.nombreCategoria}</th>`
            })
            buffer += `</tr>`

            buffer += `</thead>`
            buffer += `<tbody id="tbodyListado_mCurvas">`

            g_columnasFiltradas.forEach((columnas, idx) => {
                buffer += `<tr class="text-center">`
                columnas.forEach((item) => {
                    buffer += `<td data-did="${item.did}">${item.nombre}</td>`
                })
                buffer += `</tr>`
            })

            buffer += `</tbody>`
            buffer += `</table>`
            buffer += `</div>`


            $("#listaValores_mCurvas").html(buffer);
        }

        public.searchValor = function() {
            let search = $("#searchValor_mCurvas").val().toLowerCase();

            if (search === "") {
                g_columnasFiltradas = [...g_columnas];
            } else {
                g_columnasFiltradas = g_columnas.filter((item) =>
                    item.find((valor) => valor.nombre.toLowerCase().includes(search))
                );
            }

            renderTablaDeValores();
        };

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
                categorias: categoriasSeleccionadas.map((item) => Number(item.categoria)),
            };

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
                globalSweetalert.alertVolver({
                    titulo: "La curva debe tener al menos una categoria",
                    subtitulo: 'Se tomaran las categorias seleccionadas cuando le de a "Generar curva"'
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
                categorias: categoriasSeleccionadas.map((item) => ({
                    did_variante: Number(item.variante),
                    did_categoria: Number(item.categoria)
                })),
            };

            const datosModificados = globalValidar.obtenerCambios({
                dataNueva: datosNuevos,
                dataOriginal: g_data
            });

            if (Object.keys(datosModificados).length === 0) {
                globalSweetalert.alertVolver({
                    titulo: "No se realizaron cambios",
                    subtitulo: 'Si modificó las categorias el cambio se tomara cuando le de a "Generar curva"'
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

            if (datosNuevos.categorias.length < 1) {
                globalSweetalert.alertVolver({
                    titulo: "La curva debe tener al menos una categoria",
                    subtitulo: 'Se tomaran las categorias seleccionadas cuando le de a "Generar curva"'
                });
                return;
            }

            let categoriasUpdateadas = globalValidar.obtenerCambiosEnArray({
                dataNueva: datosNuevos.categorias.map((item) => item.did_categoria),
                dataOriginal: g_data.categorias.map((item) => item.did_categoria)
            })

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
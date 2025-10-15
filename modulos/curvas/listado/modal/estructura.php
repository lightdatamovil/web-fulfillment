<script>
    const appModalCurvas = (function() {
        let g_did = 0;
        let g_data;
        let donde = 0;
        let g_categorias = [];

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
                renderCategorias();
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
                    renderCategorias();

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
                    buffer += `<select class="form-select selectCategorias_mProductos" data-didVariante="${variante.did}" onchange="appModalCurvas.habilitarBtnGenerarCurva()">`
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

        public.habilitarBtnGenerarCurva = function() {
            const todosValidos = $('.selectCategorias_mProductos').toArray().every(
                categoria => $(categoria).val()?.trim() !== ""
            );

            $("#btnGenerarCurva_mCurvas").prop("disabled", !todosValidos);
        };

        public.generarCurva = function() {

        }

















        public.agregarCategoria = function() {
            const nombre = $("#categoria_mCurvas").val().trim();

            verificarTabla = g_categorias.some(v => v.nombre.toLowerCase() === nombre.toLowerCase());

            if (verificarTabla) {
                globalSweetalert.alert({
                    titulo: "Ya existe esa categoria"
                })
                return;
            }

            g_categorias = g_categorias.map((categoria, idx) => ({
                ...categoria,
                valores: globalActivarAcciones.obtenerDataFormRepeater({
                    id: `formValores_${idx}_mCurvas`
                })
            }));


            g_categorias.push({
                did: "",
                nombre,
                valores: []
            });

            $("#categoria_mCurvas").val('');
            $("#btnGenerarCurva_mCurvas").prop("disabled", true)


            renderCategorias();
        };

        public.eliminarValor = function(index) {
            globalSweetalert.confirmar({
                titulo: "¿Estas seguro de eliminar esta categoria?",
                color: "var(--bs-danger)"
            }).then(function(confirmado) {
                if (confirmado) {

                    g_categorias = g_categorias.map((categoria, idx) => ({
                        ...categoria,
                        valores: globalActivarAcciones.obtenerDataFormRepeater({
                            id: `formValores_${idx}_mCurvas`
                        })
                    }));

                    g_categorias.splice(index, 1);
                    renderCategorias();
                }
            })
        };

        public.cambiarNombreCategoria = function(index) {
            g_categorias[index].nombre = $(`#nombreCategoria_${index}_mCurvas`).val();
        };

        function renderCategorias() {
            if (g_categorias.length === 0) {
                $("#listaCategorias_mCurvas").html(`<div class="d-flex justify-content-center"><span class="badge rounded-pill bg-label-warning px-6">Sin categorias aún, agrega al menos una.</span></div>`);
                return;
            }

            let buffer = "";

            g_categorias.forEach((categoria, idx) => {
                buffer += `<div class="col-12 px-3 mb-5 border rounded position-relative">`
                buffer += `<div class="row p-3">`

                buffer += `<div class="col-10 col-md-10 col-lg-6" style="height: 48px;">`
                buffer += `<div class="d-flex align-items-center h-100 fw-bold">Categoria: <input type="text" id="nombreCategoria_${idx}_mCurvas" data-did="${categoria.did}" onkeyup="appModalCurvas.cambiarNombreCategoria(${idx})" class="form-control form-control-sm ms-3 campos_mCurvas camposObli_mCurvas" placeholder="Categoria" value="${categoria.nombre}" /></div>`
                buffer += `</div>`

                buffer += `<div class="col-12 d-none d-lg-block mb-4 mt-2" style="height: 35px;">`
                buffer += `<div class="row bg-body rounded-3 h-100">`

                buffer += `<div class="col-4 h-100">`
                buffer += `<div class="d-flex align-items-center h-100 ps-1">Codigo</div>`
                buffer += `</div>`

                buffer += `<div class="col-7 h-100">`
                buffer += `<div class="d-flex align-items-center h-100">Nombre</div>`
                buffer += `</div>`

                buffer += `<div class="col-1 h-100 p-0">`
                buffer += `<div class="d-flex align-items-center h-100"></div>`
                buffer += `</div>`

                buffer += `</div>`
                buffer += `</div>`

                buffer += `<div class="col-12">`
                buffer += `<form class="form-repeater forms_mCurvas" id="formValores_${idx}_mCurvas">`
                buffer += `<div data-repeater-list="${idx}">`
                buffer += `<div class="mb-3" data-repeater-item>`
                buffer += `<div class="row g-3">`
                buffer += `<input type="hidden" name="did" id="did_valores_${idx}_mCurvas" />`

                buffer += `<div class="col-12 col-md-6 col-lg-4">`
                buffer += `<input type="text" name="codigo" id="codigo_valores_${idx}_mCurvas" class="form-control form-control-sm campos_mCurvas camposObli_mCurvas" placeholder="Codigo" />`
                buffer += `</div>`

                buffer += `<div class="col-12 col-md-6 col-lg-7">`
                buffer += `<input type="text" name="nombre" id="nombre_valores_${idx}_mCurvas" class="form-control form-control-sm campos_mCurvas camposObli_mCurvas" placeholder="Nombre" />`
                buffer += `</div>`

                buffer += `<div class="col-12 col-md-6 col-lg-1">`
                buffer += `<div class="d-flex align-items-center justify-content-center h-100 ocultarDesdeVer">`
                buffer += `<button type="button" class="btn brn-sm btn-icon rounded-pill btn-text-danger" data-repeater-delete data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar valor"><i class="tf-icons ri-delete-bin-6-line ri-22px"></i></button>`
                buffer += `</div>`
                buffer += `</div>`
                buffer += `</div>`
                buffer += `</div>`
                buffer += `</div>`
                buffer += `<div class="mb-0 position-absolute ocultarDesdeVer" style="top: 1rem; right: 1rem;">`
                buffer += `<button type="button" class="btn btn-icon btn-sm btn-label-danger me-2" onclick="appModalCurvas.eliminarValor(${idx})" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar categoria">`
                buffer += `<span class="tf-icons ri-delete-bin-6-line ri-20px"></span>`
                buffer += `</button>`
                buffer += `<button type="button" class="btn btn-icon btn-sm btn-label-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Agregar valor" data-repeater-create>`
                buffer += `<span class="tf-icons ri-add-line ri-20px"></span>`
                buffer += `</button>`
                buffer += `</div>`
                buffer += `</form>`
                buffer += `</div>`

                buffer += `</div>`
                buffer += `</div>`
            })

            $("#listaCategorias_mCurvas").html(buffer);

            g_categorias.forEach((categoria, idx) => {
                globalActivarAcciones.formRepeater({
                    id: `formValores_${idx}_mCurvas`,
                    data: categoria.valores || []
                });
            })

            globalActivarAcciones.tooltips({
                idContainer: "modal_mCurvas"
            })
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
<script>
    const appModalVariantes = (function() {
        let g_did = 0;
        let g_data;
        let donde = 0;
        let g_categorias = [];

        const rutaAPI = "variantes"

        const public = {};

        public.open = async function({
            mode = 0,
            did = 0
        } = {}) {
            await resetModal();
            g_did = did;
            donde = mode

            if (mode == 0) {
                // NUEVA VARIANTE
                $("#titulo_mVariantes").text("Nueva variante");
                $("#subtitulo_mVariantes").text("Creacion de variante nuevo, completar formulario.");
                $('.campos_mVariantes').prop('disabled', false);
                $("#btnGuardar_mVariantes, .ocultarDesdeVer").removeClass("ocultar");
                $("#btnEditar_mVariantes").addClass("ocultar")
                renderCategorias();
                $("#modal_mVariantes").modal("show")
            } else if (mode == 1) {
                // MODIFICAR VARIANTE
                await globalLoading.open()
                $("#titulo_mVariantes").text("Modificar variante");
                $("#subtitulo_mVariantes").text("Modificacion de variante existente, completar formulario.");
                $('.campos_mVariantes').prop('disabled', false);
                $("#btnEditar_mVariantes, .ocultarDesdeVer").removeClass("ocultar");
                $("#btnGuardar_mVariantes").addClass("ocultar")
                await get()
            } else {
                // VER VARIANTE
                await globalLoading.open()
                $("#titulo_mVariantes").text("Ver variante");
                $("#subtitulo_mVariantes").text("Visualizacion de variante, no se puede modificar.");
                $('.campos_mVariantes').prop('disabled', true);
                $("#btnGuardar_mVariantes, #btnEditar_mVariantes, .ocultarDesdeVer").addClass("ocultar");
                await get()
            }
        }

        function get() {
            globalRequest.get(`/${rutaAPI}/${g_did}`, {
                onSuccess: function(result) {
                    g_data = result.data;
                    $("#codigo_mVariantes").val(g_data.codigo);
                    $("#nombre_mVariantes").val(g_data.nombre);
                    $("#descripcion_mVariantes").val(g_data.descripcion);
                    $("#checkHabilitado_mVariantes").prop("checked", g_data.habilitado == 1);
                    g_categorias = structuredClone(g_data.categorias)
                    renderCategorias();

                    if (donde == 2) {
                        $('.campos_mVariantes').prop('disabled', true);
                        $(".ocultarDesdeVer").addClass("ocultar")
                    } else {
                        $(".ocultarDesdeVer").removeClass("ocultar")
                    }

                    $("#modal_mVariantes").modal("show")
                }
            });
        }

        function resetModal() {
            globalActivarAcciones.activarPrimerTab({
                tabList: "tabs_mVariantes"
            })

            $(".campos_mVariantes").val("")
            $("#checkHabilitado_mVariantes").prop("checked", true);
            $("#btnAgregarCategoria_mVariantes").prop("disabled", true)
            $("#listaValores_mVariantes").html('');
            g_data = []
            g_categorias = []

            globalValidar.limpiarTodas()
            globalValidar.deshabilitarTiempoReal({
                className: "camposObli_mVariantes"
            })
        };

        public.habilitarBtnAgregar = function() {
            const categoria = $("#categoria_mVariantes").val().trim();
            $("#btnAgregarCategoria_mVariantes").prop("disabled", !categoria);
        }

        public.agregarCategoria = function() {
            const nombre = $("#categoria_mVariantes").val().trim();

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
                    id: `formValores_${idx}_mVariantes`
                })
            }));


            g_categorias.push({
                did: "",
                nombre,
                valores: []
            });

            $("#categoria_mVariantes").val('');
            $("#btnAgregarCategoria_mVariantes").prop("disabled", true)


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
                            id: `formValores_${idx}_mVariantes`
                        })
                    }));

                    g_categorias.splice(index, 1);
                    renderCategorias();
                }
            })
        };

        public.cambiarNombreCategoria = function(index) {
            g_categorias[index].nombre = $(`#nombreCategoria_${index}_mVariantes`).val();
        };

        function renderCategorias() {
            if (g_categorias.length === 0) {
                $("#listaCategorias_mVariantes").html(`<div class="d-flex justify-content-center"><span class="badge rounded-pill bg-label-warning px-6">Sin categorias aún, agrega al menos una.</span></div>`);
                return;
            }

            let buffer = "";

            g_categorias.forEach((categoria, idx) => {
                buffer += `<div class="col-12 px-3 mb-5 border rounded position-relative">`
                buffer += `<div class="row p-3">`

                buffer += `<div class="col-10 col-md-10 col-lg-6" style="height: 48px;">`
                buffer += `<div class="d-flex align-items-center h-100 fw-bold">Categoria: <input type="text" id="nombreCategoria_${idx}_mVariantes" data-did="${categoria.did}" onkeyup="appModalVariantes.cambiarNombreCategoria(${idx})" class="form-control form-control-sm ms-3 campos_mVariantes camposObli_mVariantes" placeholder="Categoria" value="${categoria.nombre}" /></div>`
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
                buffer += `<form class="form-repeater forms_mVariantes" id="formValores_${idx}_mVariantes">`
                buffer += `<div data-repeater-list="${idx}">`
                buffer += `<div class="mb-3" data-repeater-item>`
                buffer += `<div class="row g-3">`
                buffer += `<input type="hidden" name="did" id="did_valores_${idx}_mVariantes" />`

                buffer += `<div class="col-12 col-md-6 col-lg-4">`
                buffer += `<input type="text" name="codigo" id="codigo_valores_${idx}_mVariantes" class="form-control form-control-sm campos_mVariantes camposObli_mVariantes" placeholder="Codigo" />`
                buffer += `</div>`

                buffer += `<div class="col-12 col-md-6 col-lg-7">`
                buffer += `<input type="text" name="nombre" id="nombre_valores_${idx}_mVariantes" class="form-control form-control-sm campos_mVariantes camposObli_mVariantes" placeholder="Nombre" />`
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
                buffer += `<button type="button" class="btn btn-icon btn-sm btn-label-danger me-2" onclick="appModalVariantes.eliminarValor(${idx})" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar categoria">`
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

            $("#listaCategorias_mVariantes").html(buffer);

            g_categorias.forEach((categoria, idx) => {
                globalActivarAcciones.formRepeater({
                    id: `formValores_${idx}_mVariantes`,
                    data: categoria.valores || []
                });
            })

            globalActivarAcciones.tooltips({
                idContainer: "modal_mVariantes"
            })
        }

        function validacion() {
            return globalValidar.obligatorios({
                className: "camposObli_mVariantes"
            })
        }

        public.guardar = function() {
            const datos = {
                codigo: $("#codigo_mVariantes").val().trim() || null,
                nombre: $("#nombre_mVariantes").val().trim() || null,
                habilitado: $("#checkHabilitado_mVariantes").is(":checked") ? 1 : 0,
                categorias: g_categorias || [],
                orden: 1
            };

            datos.categorias = datos.categorias.map((categoria, idx) => ({
                ...categoria,
                valores: globalActivarAcciones.obtenerDataFormRepeater({
                    id: `formValores_${idx}_mVariantes`
                })
            }));

            globalValidar.habilitarTiempoReal({
                className: "camposObli_mVariantes",
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
                    titulo: "La variante debe tener al menos una categoria"
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
                    titulo: "¿Estas seguro de guardar esta variante?"
                })
                .then(function(confirmado) {
                    if (confirmado) {
                        globalRequest.post(`/${rutaAPI}`, datos, {
                            onSuccess: function(result) {
                                $("#modal_mVariantes").modal("hide")
                                globalSweetalert.exito()
                                appModuloVariantes.getListado();
                            }
                        });
                    }
                });
        };

        public.editar = async function() {
            // 1️⃣ Armo el objeto base
            const datosNuevos = {
                codigo: $("#codigo_mVariantes").val().trim() || null,
                nombre: $("#nombre_mVariantes").val().trim() || null,
                habilitado: $("#checkHabilitado_mVariantes").is(":checked") ? 1 : 0,
                orden: 1
            };

            console.log("g_categorias 1", g_categorias);
            console.log("datosNuevos 1", datosNuevos);

            // 2️⃣ Agrego categorías con sus valores (detectando cambios internos)
            datosNuevos.categorias = g_categorias.map((categoria, idx) => {
                const valoresNuevos = globalActivarAcciones.obtenerDataFormRepeater({
                    id: `formValores_${idx}_mVariantes`
                });

                const categoriaOriginal = g_data.categorias?.find(cat => cat.did === categoria.did);
                let valoresFinales = valoresNuevos;

                // Si existe en los datos originales, detecto cambios en los valores
                if (categoriaOriginal) {
                    const cambiosValores = globalValidar.obtenerCambiosEnArray({
                        dataNueva: valoresNuevos,
                        dataOriginal: categoriaOriginal.valores
                    });

                    // Solo reemplazo si hubo cambios en los valores
                    if (cambiosValores?.length > 0) {
                        valoresFinales = valoresNuevos;
                    }
                }

                return {
                    ...categoria,
                    valores: valoresFinales
                };
            });

            console.log("datosNuevos 2", datosNuevos);

            // 3️⃣ Detecto cambios generales
            const datosModificados = globalValidar.obtenerCambios({
                dataNueva: datosNuevos,
                dataOriginal: g_data
            });

            console.log("datosModificados", datosModificados);

            // 4️⃣ Si no hubo cambios, aviso
            if (Object.keys(datosModificados).length === 0) {
                globalSweetalert.alert({
                    titulo: "No se realizaron cambios"
                });
                return;
            }

            // 5️⃣ Valido campos en tiempo real
            globalValidar.habilitarTiempoReal({
                className: "camposObli_mVariantes",
                callback: validacion
            });

            if (validacion()) {
                globalSweetalert.alert({
                    titulo: "Verifique los campos"
                });
                return;
            }

            // 6️⃣ Valido que haya categorías y valores
            if (!datosNuevos.categorias || datosNuevos.categorias.length < 1) {
                globalSweetalert.alert({
                    titulo: "La variante debe tener al menos una categoría"
                });
                return;
            }

            if (datosNuevos.categorias.some(cat => !cat.valores || cat.valores.length === 0)) {
                globalSweetalert.alert({
                    titulo: "Las categorías deben tener al menos un valor"
                });
                return;
            }

            // 7️⃣ Confirmación antes de enviar
            const confirmado = await globalSweetalert.confirmar({
                titulo: "¿Estás seguro de modificar esta variante?"
            });

            if (!confirmado) return;

            // 8️⃣ Envío al backend
            globalRequest.put(`/${rutaAPI}/${g_did}`, datosNuevos, {
                onSuccess: function(result) {
                    $("#modal_mVariantes").modal("hide");
                    globalSweetalert.exito();
                    appModuloVariantes.getListado();
                }
            });
        };


        public.eliminar = function(did) {
            globalSweetalert.confirmar({
                titulo: "¿Estas seguro de eliminar este variante?",
                color: "var(--bs-danger)"
            }).then(function(confirmado) {
                if (confirmado) {
                    globalRequest.delete(`/${rutaAPI}/${did}`, {
                        onSuccess: function(result) {
                            globalSweetalert.exito({
                                titulo: "Eliminado con éxito!"
                            });
                            appModuloVariantes.getListado();
                        }
                    });
                }
            });
        };

        return public;
    })();
</script>
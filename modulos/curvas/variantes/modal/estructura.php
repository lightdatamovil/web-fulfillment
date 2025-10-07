<script>
    const appModalVariantes = (function() {
        let g_did = 0;
        let g_data;
        let donde = 0;
        let g_valores = [];
        const rutaAPI = "variantes"

        const public = {};

        public.open = async function({
            mode = 0,
            did = 0
        } = {}) {
            await resetModal();
            g_did = did;
            donde = mode
            g_valores = [];

            if (mode == 0) {
                // NUEVA VARIANTE
                $("#titulo_mVariantes").text("Nueva variante");
                $("#subtitulo_mVariantes").text("Creacion de variante nuevo, completar formulario.");
                $('.campos_mVariantes').prop('disabled', false);
                $("#btnGuardar_mVariantes, #formValores_mVariantes").removeClass("ocultar");
                $("#btnEditar_mVariantes").addClass("ocultar")
                $("#modal_mVariantes").modal("show")
            } else if (mode == 1) {
                // MODIFICAR VARIANTE
                await globalLoading.open()
                $("#titulo_mVariantes").text("Modificar variante");
                $("#subtitulo_mVariantes").text("Modificacion de variante existente, completar formulario.");
                $('.campos_mVariantes').prop('disabled', false);
                $("#btnEditar_mVariantes, #formValores_mVariantes").removeClass("ocultar");
                $("#btnGuardar_mVariantes").addClass("ocultar")
                await get()
            } else {
                // VER VARIANTE
                await globalLoading.open()
                $("#titulo_mVariantes").text("Ver variante");
                $("#subtitulo_mVariantes").text("Visualizacion de variante, no se puede modificar.");
                $('.campos_mVariantes').prop('disabled', true);
                $("#btnGuardar_mVariantes, #btnEditar_mVariantes, #formValores_mVariantes").addClass("ocultar");
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
                    g_valores = g_data.valores || [];
                    renderValores();
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
            $("#btnAgregarValor_mVariantes").prop("disabled", true)
            $("#listaValores_mVariantes").html('');
            g_valores = [];

            globalValidar.limpiarTodas()
            globalValidar.deshabilitarTiempoReal({
                className: "camposObli_mVariantes"
            })
        };

        public.habilitarBtnAgregar = function() {
            const codigo = $("#codigo_valores_mVariantes").val().trim();
            const valor = $("#valor_valores_mVariantes").val().trim();
            $("#btnAgregarValor_mVariantes").prop("disabled", !(codigo && valor));
        }

        public.agregarValor = function() {
            const codigo = $("#codigo_valores_mVariantes").val().trim();
            const valor = $("#valor_valores_mVariantes").val().trim();

            verificarTabla = g_valores.some(v => v.codigo.toLowerCase() === codigo.toLowerCase() || v.valor.toLowerCase() === valor.toLowerCase());

            if (verificarTabla) {
                globalSweetalert.alert({
                    titulo: "Ya existe ese código o valor."
                })
                return;
            }

            g_valores.push({
                codigo,
                valor,
                did: 0
            });

            $("#codigo_valores_mVariantes, #valor_valores_mVariantes").val('');
            $("#btnAgregarValor_mVariantes").prop("disabled", true)
            renderValores();
        };

        public.eliminarValor = function(index) {
            g_valores.splice(index, 1);
            renderValores();
        };

        function renderValores() {
            if (g_valores.length === 0) {
                $("#listaValores_mVariantes").html('<p class="text-muted text-center">Sin valores aún.</p>');
                return;
            }

            let buffer = ""
            buffer += `<table class="table table-bordered">`
            buffer += `<thead>`
            buffer += `<tr>`
            buffer += `<th>Código</th>`
            buffer += `<th>Valor</th>`
            if (donde != 2) {
                buffer += `<th>Eliminar</th>`
            }
            buffer += `</tr>`
            buffer += `</thead>`

            buffer += `<tbody>`

            g_valores.forEach((v, idx) => {
                buffer += `<tr>`
                buffer += `<td>${v.codigo}</td>`
                buffer += `<td>${v.valor}</td>`
                if (donde != 2) {
                    buffer += `<td><button type="button" class="btn btn-icon rounded-pill btn-text-danger" onclick="appModalVariantes.eliminarValor(${idx})" title="Eliminar"><i class="tf-icons ri-delete-bin-6-line ri-22px"></i></button></td>`
                }
                buffer += `</tr>`
            });

            buffer += `</tbody>`
            buffer += `</table>`

            $("#listaValores_mVariantes").html(buffer);
        };

        function validacion() {
            return globalValidar.obligatorios({
                className: "camposObli_mVariantes"
            })
        }

        public.guardar = function() {
            const datos = {
                codigo: $("#codigo_mVariantes").val().trim() || null,
                nombre: $("#nombre_mVariantes").val().trim() || null,
                descripcion: $("#descripcion_mVariantes").val().trim() || null,
                habilitado: $("#checkHabilitado_mVariantes").is(":checked") ? 1 : 0,
                atributoValores: g_valores || [],
                orden: 1
            };

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

        public.editar = function() {
            const datosNuevos = {
                codigo: $("#codigo_mVariantes").val().trim() || null,
                nombre: $("#nombre_mVariantes").val().trim() || null,
                descripcion: $("#descripcion_mVariantes").val().trim() || null,
                habilitado: $("#checkHabilitado_mVariantes").is(":checked") ? 1 : 0,
                atributoValores: g_valores || [],
                orden: 1
            };

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

            globalSweetalert.confirmar({
                    titulo: "¿Estas seguro de modificar esta variante?"
                })
                .then(function(confirmado) {
                    if (confirmado) {
                        globalRequest.put(`/${rutaAPI}/${g_did}`, datosModificados, {
                            onSuccess: function(result) {
                                $("#modal_mVariantes").modal("hide")
                                globalSweetalert.exito()
                                appModuloVariantes.getListado();
                            }
                        });
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
<script>
    const appModalCurvas = (function() {
        let g_did = 0;
        let g_data;
        let donde = 0;
        const rutaAPI = "curvas"

        const public = {};

        public.open = async function({
            mode = 0,
            did = 0
        } = {}) {
            await resetModal()
            g_did = did;
            donde = mode

            await globalLlenarSelect.clientes({
                id: "clientes_mCurvas",
                multiple: true
            })

            await globalActivarAcciones.select2({
                className: "select2_mCurvas"
            })

            if (mode == 0) {
                // NUEVO CURVA
                $("#titulo_mCurvas").text("Nuevo curva");
                $("#subtitulo_mCurvas").text("Creacion de curva nuevo, completar formulario.");
                $('.campos_mCurvas').prop('disabled', false);
                $("#btnEditar_mCurvas").addClass("ocultar");
                $("#btnGuardar_mCurvas").removeClass("ocultar");
                $("#modal_mCurvas").modal("show")
            } else if (mode == 1) {
                // MODIFICAR CURVA
                await globalLoading.open()
                $("#titulo_mCurvas").text("Modificar curva");
                $("#subtitulo_mCurvas").text("Modificacion de curva existente, completar formulario.");
                $('.campos_mCurvas').prop('disabled', false);
                $("#btnGuardar_mCurvas").addClass("ocultar");
                $("#btnEditar_mCurvas").removeClass("ocultar");
                await get()
            } else {
                // VER CURVA
                await globalLoading.open()
                $("#titulo_mCurvas").text("Ver curva");
                $("#subtitulo_mCurvas").text("Visualizacion de curva, no se puede modificar.");
                $('.campos_mCurvas').prop('disabled', true);
                $("#btnGuardar_mCurvas, #btnEditar_mCurvas").addClass("ocultar");
                await get()
            }
        }

        function get() {
            globalRequest.get(`/${rutaAPI}/${g_did}`, {
                onSuccess: function(result) {
                    g_data = result.data;
                    $("#codigo_mCurvas").val(g_data.codigo);
                    $("#nombre_mCurvas").val(g_data.nombre);
                    $("#checkHabilitado_mCurvas").prop("checked", g_data.habilitado == 1);
                    $("#checkUnidad_mCurvas").prop("checked", g_data.unidad == 1);
                    $("#clientes_mCurvas").val(g_data.clientes_dids).trigger("change");
                    $("#modal_mCurvas").modal("show")
                }
            });
        }

        function resetModal() {
            globalActivarAcciones.activarPrimerTab({
                tabList: "tabs_mCurvas"
            })

            $(".campos_mCurvas").val("")
            $("#checkHabilitado_mCurvas, #checkUnidad_mCurvas").prop("checked", false);
            $("#clientes_mCurvas").val(null).trigger("change");

            globalValidar.limpiarTodas()
            globalValidar.deshabilitarTiempoReal({
                className: "camposObli_mCurvas"
            })
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
                unidad: $("#checkUnidad_mCurvas").is(":checked") ? 1 : 0,
                clientes_dids: $("#clientes_mCurvas").val().map(Number) || []
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

            globalSweetalert.confirmar({
                    titulo: "¿Estas seguro de guardar este curva?"
                })
                .then(function(confirmado) {
                    if (confirmado) {
                        globalRequest.post(`/${rutaAPI}`, datos, {
                            onSuccess: function(result) {
                                $("#modal_mCurvas").modal("hide");
                                globalSweetalert.exito();
                                appModuloCurvas.getListado();
                            }
                        });
                    }
                });
        };

        public.editar = function() {
            console.log("ENTREEEEE");

            const datosNuevos = {
                codigo: $("#codigo_mCurvas").val().trim() || null,
                nombre: $("#nombre_mCurvas").val().trim() || null,
                habilitado: $("#checkHabilitado_mCurvas").is(":checked") ? 1 : 0,
                unidad: $("#checkUnidad_mCurvas").is(":checked") ? 1 : 0,
                clientes_dids: $("#clientes_mCurvas").val().map(Number) || []
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

            console.log(datosNuevos, g_data);

            const datosModificados = globalValidar.obtenerCambiosParaPUT({
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
                    titulo: "¿Estas seguro de modificar este curva?"
                })
                .then(function(confirmado) {
                    if (confirmado) {
                        globalRequest.put(`/${rutaAPI}/${g_did}`, datosModificados, {
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
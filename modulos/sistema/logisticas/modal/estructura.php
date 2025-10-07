<script>
    const appModalLogisticas = (function() {
        let g_did = 0;
        let g_data;
        let donde = 0;
        const rutaAPI = "logisticas"

        const public = {};

        public.open = async function({
            mode = 0,
            did = 0
        } = {}) {
            await resetModal()
            g_did = did;
            donde = mode

            await globalActivarAcciones.select2({
                className: "select2_mLogisticas"
            })

            if (mode == 0) {
                // NUEVO LOGISTICA
                $("#titulo_mLogisticas").text("Nuevo logistica");
                $("#subtitulo_mLogisticas").text("Creacion de logistica nuevo, completar formulario.");
                $('.campos_mLogisticas').prop('disabled', false);
                $("#checkHabilitado_mLogisticas").prop("checked", true);
                $("#codLightdata_mLogisticas").prop('disabled', true).removeClass("camposObli_mLogisticas");
                $("#btnEditar_mLogisticas").addClass("ocultar");
                $("#btnGuardar_mLogisticas").removeClass("ocultar");
                $("#modal_mLogisticas").modal("show")
            } else if (mode == 1) {
                // MODIFICAR LOGISTICA
                await globalLoading.open()
                $("#titulo_mLogisticas").text("Modificar logistica");
                $("#subtitulo_mLogisticas").text("Modificacion de logistica existente, completar formulario.");
                $('.campos_mLogisticas').prop('disabled', false);
                $("#btnGuardar_mLogisticas").addClass("ocultar");
                $("#btnEditar_mLogisticas").removeClass("ocultar");
                await get()
            } else {
                // VER LOGISTICA
                await globalLoading.open()
                $("#titulo_mLogisticas").text("Ver logistica");
                $("#subtitulo_mLogisticas").text("Visualizacion de logistica, no se puede modificar.");
                $('.campos_mLogisticas').prop('disabled', true);
                $("#btnGuardar_mLogisticas, #btnEditar_mLogisticas").addClass("ocultar");
                await get()
            }
        }

        function get() {
            globalRequest.get(`/${rutaAPI}/${g_did}`, {
                onSuccess: function(result) {
                    g_data = result.data;
                    $("#codigo_mLogisticas").val(g_data.codigo);
                    $("#nombre_mLogisticas").val(g_data.nombre);
                    $("#checkHabilitado_mLogisticas").prop("checked", g_data.habilitado == 1);
                    $("#checkEsLightdata_mLogisticas").prop("checked", g_data.esLightdata == 1);
                    if (g_data.esLightdata == 1) {
                        $("#codLightdata_mLogisticas").val(g_data.codLightdata).prop('disabled', false);
                    }
                    $("#modal_mLogisticas").modal("show")
                }
            });
        }

        function resetModal() {
            globalActivarAcciones.activarPrimerTab({
                tabList: "tabs_mLogisticas"
            })

            $(".campos_mLogisticas").val("")
            $("#checkHabilitado_mLogisticas, #checkEsLightdata_mLogisticas").prop("checked", false);

            globalValidar.limpiarTodas()
            globalValidar.deshabilitarTiempoReal({
                className: "camposObli_mLogisticas"
            })
        };

        public.onChangeEsLightdata = function(e) {
            const isChecked = $(e).is(":checked");

            $("#codLightdata_mLogisticas").prop("disabled", !isChecked);
            globalValidar.limpiarUna({
                id: "codLightdata_mLogisticas"
            })


            if (isChecked) {
                $("#codLightdata_mLogisticas").addClass("camposObli_mLogisticas");
            } else {
                $("#codLightdata_mLogisticas").removeClass("camposObli_mLogisticas")
            }
        }


        function validacion() {
            return globalValidar.obligatorios({
                className: "camposObli_mLogisticas"
            })
        }

        public.guardar = function() {
            const datos = {
                codigo: $("#codigo_mLogisticas").val().trim() || null,
                nombre: $("#nombre_mLogisticas").val().trim() || null,
                habilitado: $("#checkHabilitado_mLogisticas").is(":checked") ? 1 : 0,
                logisticaLD: $("#checkEsLightdata_mLogisticas").is(":checked") ? 1 : 0
            };


            if (datos.logisticaLD == 1) {
                datos.codigoLD = $("#codLightdata_mLogisticas").val()
            }

            globalValidar.habilitarTiempoReal({
                className: "camposObli_mLogisticas",
                callback: validacion
            });

            if (validacion()) {
                globalSweetalert.alert({
                    titulo: "Verifique los campos"
                });
                return;
            }

            globalSweetalert.confirmar({
                    titulo: "¿Estas seguro de guardar esta logistica?"
                })
                .then(function(confirmado) {
                    if (confirmado) {
                        globalRequest.post(`/${rutaAPI}`, datos, {
                            onSuccess: function(result) {
                                $("#modal_mLogisticas").modal("hide");
                                globalSweetalert.exito();
                                appModuloLogisticas.getListado();
                            }
                        });
                    }
                });
        };

        public.editar = function() {
            const datosNuevos = {
                codigo: $("#codigo_mLogisticas").val().trim() || null,
                nombre: $("#nombre_mLogisticas").val().trim() || null,
                habilitado: $("#checkHabilitado_mLogisticas").is(":checked") ? 1 : 0,
                esLightdata: $("#checkEsLightdata_mLogisticas").is(":checked") ? 1 : 0
            };

            if (datosNuevos.esLightdata == 1) {
                datosNuevos.codLightdata = $("#codLightdata_mLogisticas").val()
            }

            globalValidar.habilitarTiempoReal({
                className: "camposObli_mLogisticas",
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
                    titulo: "¿Estas seguro de modificar esta logistica?"
                })
                .then(function(confirmado) {
                    if (confirmado) {
                        globalRequest.put(`/${rutaAPI}/${g_did}`, datosModificados, {
                            onSuccess: function(result) {
                                $("#modal_mLogisticas").modal("hide");
                                globalSweetalert.exito();
                                appModuloLogisticas.getListado();
                            }
                        });
                    }
                });
        };

        public.eliminar = function(did) {
            globalSweetalert.confirmar({
                titulo: "¿Estas seguro de eliminar esta logistica?",
                color: "var(--bs-danger)"
            }).then(function(confirmado) {
                if (confirmado) {
                    globalRequest.delete(`/${rutaAPI}/${did}`, {
                        onSuccess: function(result) {
                            globalSweetalert.exito({
                                titulo: "Eliminado con éxito!"
                            });
                            appModuloLogisticas.getListado();
                        }
                    });
                }
            });
        };

        return public;
    })();
</script>
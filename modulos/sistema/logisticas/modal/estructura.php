<script>
    const appModalLogisticas = (function() {
        let g_did = 0;
        let g_data;
        let g_direcciones;
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

            console.log("donde", donde);


            if (mode == 0) {
                // NUEVO LOGISTICA
                $("#titulo_mLogisticas").text("Nueva logistica");
                $("#subtitulo_mLogisticas").text("Creacion de logistica nueva, completar formulario.");
                $('.campos_mLogisticas').prop('disabled', false);
                $("#checkHabilitado_mLogisticas").prop("checked", true);
                $("#codLightdata_mLogisticas").prop('disabled', true).removeClass("camposObli_mLogisticas");
                $("#btnEditar_mLogisticas").addClass("ocultar");
                $("#btnGuardar_mLogisticas, .ocultarDesdeVer_mLogisticas").removeClass("ocultar");
                renderDirecciones()
                $("#modal_mLogisticas").modal("show")
            } else if (mode == 1) {
                // MODIFICAR LOGISTICA
                await globalLoading.open()
                $("#titulo_mLogisticas").text("Modificar logistica");
                $("#subtitulo_mLogisticas").html("Recordá presionar <b>Guardar</b> antes de salir, así conservás todos los cambios ");
                $('.campos_mLogisticas').prop('disabled', false);
                $("#btnGuardar_mLogisticas").addClass("ocultar");
                $("#btnEditar_mLogisticas, .ocultarDesdeVer_mLogisticas").removeClass("ocultar");
                await get()
            } else {
                // VER LOGISTICA
                await globalLoading.open()
                $("#titulo_mLogisticas").text("Ver logistica");
                $("#subtitulo_mLogisticas").text("Visualizacion de logistica, no se puede modificar.");
                $('.campos_mLogisticas').prop('disabled', true);
                $("#btnGuardar_mLogisticas, #btnEditar_mLogisticas, .ocultarDesdeVer_mLogisticas").addClass("ocultar");
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
                    $("#checkEsLightdata_mLogisticas").prop("checked", g_data.logisticaLD == 1);
                    if (g_data.logisticaLD == 1) {
                        $("#codLightdata_mLogisticas").val(g_data.codigoLD).prop('disabled', donde == 2);
                    }

                    g_direcciones = g_data.direcciones || []
                    renderDirecciones();

                    if (donde == 2) {
                        $('.campos_mLogisticas').prop('disabled', true);
                        $(".ocultarDesdeVer_mLogisticas").addClass("ocultar")
                    } else {
                        $('.campos_mLogisticas').prop('disabled', false);
                        $(".ocultarDesdeVer_mLogisticas").removeClass("ocultar")
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
            g_direcciones = [];

            globalValidar.limpiarTodas()
            globalValidar.deshabilitarTiempoReal({
                className: "camposObli_mLogisticas"
            })
        };

        function renderDirecciones() {
            globalActivarAcciones.formRepeater({
                id: "formDirecciones_mLogisticas",
                data: g_direcciones
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
                logisticaLD: $("#checkEsLightdata_mLogisticas").is(":checked") ? 1 : 0,
                direcciones: globalActivarAcciones.obtenerDataFormRepeater({
                    id: "formDirecciones_mLogisticas"
                }),
            };

            if (datos.logisticaLD == 1) {
                datos.codigoLD = $("#codLightdata_mLogisticas").val()
            }

            globalValidar.formRepeater({
                id: "formDirecciones_mLogisticas"
            })

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
                logisticaLD: $("#checkEsLightdata_mLogisticas").is(":checked") ? 1 : 0,
                direcciones: globalActivarAcciones.obtenerDataFormRepeater({
                    id: "formDirecciones_mLogisticas"
                }),
            };

            if (datosNuevos.logisticaLD == 1) {
                datosNuevos.codigoLD = $("#codLightdata_mLogisticas").val()
            }

            globalValidar.formRepeater({
                id: "formDirecciones_mLogisticas"
            })

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

            if (datosModificados.direcciones && datosModificados.direcciones.length > 0) {
                datosNuevos.direcciones = globalValidar.obtenerCambiosEnArray({
                    dataNueva: datosModificados.direcciones,
                    dataOriginal: g_direcciones
                })
            }

            globalSweetalert.confirmar({
                    titulo: "¿Estas seguro de modificar esta logistica?"
                })
                .then(function(confirmado) {
                    if (confirmado) {
                        globalRequest.put(`/${rutaAPI}/${g_did}`, datosNuevos, {
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
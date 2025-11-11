<script>
    const appOffCanvasConfiguracion = (function() {
        let g_did = 0
        let g_data;
        let donde = 0;

        const rutaAPI = "identificadores-especiales"

        const public = {}

        public.open = async function({
            mode = 0,
            did = 0
        } = {}) {
            await reset()
            g_did = did
            donde = mode

            await globalLlenarSelect.tiposIdentificadoresEspeciales({
                id: "tipo_oConfiguracion",
            })

            await globalActivarAcciones.select2({
                className: "select2_oConfiguracion"
            })

            if (mode == 0) {
                // NUEVO IDENTIFICADOR ESPECIAL
                $("#btnEditar_oConfiguracion").addClass("ocultar");
                $("#btnGuardar_oConfiguracion").removeClass("ocultar");
                await globalActivarAcciones.toggleOffcanvas({
                    id: "offCanvas_oConfiguracion"
                })
            } else if (mode == 1) {
                // MODIFICAR IDENTIFICADOR ESPECIAL
                await globalLoading.open()
                $("#btnGuardar_oConfiguracion").addClass("ocultar");
                $("#btnEditar_oConfiguracion").removeClass("ocultar");
                await get()
            }
        }

        function get() {
            globalRequest.get(`/${rutaAPI}/${g_did}`, {
                onSuccess: function(result) {
                    g_data = result.data;
                    $("#nombre_oConfiguracion").val(g_data.nombre);
                    $("#tipo_oConfiguracion").val(g_data.tipo).change();
                    globalActivarAcciones.toggleOffcanvas({
                        id: "offCanvas_oConfiguracion"
                    })
                }
            });
        }

        function reset() {
            globalValidar.deshabilitarTiempoReal({
                className: "camposObli_oConfiguracion"
            })

            $(".campos_oConfiguracion").val("")
            $("#armadores_oConfiguracion").change()
            g_did = 0
        }

        function validacion() {
            return globalValidar.obligatorios({
                className: "camposObli_oConfiguracion"
            })
        }

        public.guardar = function() {
            const datos = {
                nombre: $("#nombre_oConfiguracion").val().trim() || null,
                tipo: $("#tipo_oConfiguracion").val() || null,
            };

            globalValidar.habilitarTiempoReal({
                className: "camposObli_oConfiguracion",
                callback: validacion
            });

            if (validacion()) {
                globalSweetalert.alert({
                    titulo: "Verifique los campos"
                });
                return;
            }

            globalSweetalert.confirmar({
                    titulo: "¿Estas seguro de guardar este identificador especial?"
                })
                .then(function(confirmado) {
                    if (confirmado) {
                        globalRequest.post(`/${rutaAPI}`, datos, {
                            onSuccess: function(result) {
                                globalEstadosGlobales.add({
                                    key: "identificadoresEspeciales",
                                    data: result.data
                                })
                                globalActivarAcciones.toggleOffcanvas({
                                    id: "offCanvas_oConfiguracion"
                                })
                                globalSweetalert.exito();
                                appModuloConfiguracion.renderListadoIdentificadoresEspeciales();
                            }
                        });
                    }
                });
        };

        public.editar = function() {
            const datosNuevos = {
                nombre: $("#nombre_oConfiguracion").val().trim() || null,
                tipo: $("#tipo_oConfiguracion").val() || null,
            };

            globalValidar.habilitarTiempoReal({
                className: "camposObli_oConfiguracion",
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
                    titulo: "¿Estas seguro de modificar este identificador especial?"
                })
                .then(function(confirmado) {
                    if (confirmado) {
                        globalRequest.put(`/${rutaAPI}/${g_did}`, datosNuevos, {
                            onSuccess: function(result) {
                                globalEstadosGlobales.update({
                                    key: "identificadoresEspeciales",
                                    data: result.data
                                })
                                globalActivarAcciones.toggleOffcanvas({
                                    id: "offCanvas_oConfiguracion"
                                })
                                globalSweetalert.exito();
                                appModuloConfiguracion.renderListadoIdentificadoresEspeciales();
                            }
                        });
                    }
                });
        };

        public.eliminar = function(did) {
            globalSweetalert.confirmar({
                titulo: "¿Estas seguro de eliminar este identificador especial?",
                color: "var(--bs-danger)"
            }).then(function(confirmado) {
                if (confirmado) {
                    globalRequest.delete(`/${rutaAPI}/${did}`, {
                        onSuccess: function(result) {
                            globalEstadosGlobales.remove({
                                key: "identificadoresEspeciales",
                                data: result.data
                            })
                            globalSweetalert.exito({
                                titulo: "Eliminado con éxito!"
                            });
                            appModuloConfiguracion.renderListadoIdentificadoresEspeciales();
                        }
                    });
                }
            });
        };

        return public
    })()
</script>
<script>
    const appModalEnviosSincronizar = (function() {
        let g_did = 0;
        let g_data;
        let donde = 0;
        const rutaAPI = "enviosSincronizacion"

        const public = {};

        public.open = async function({
            mode = 0,
            did = 0
        } = {}) {
            await resetModal()
            g_did = did;
            donde = mode

            await globalLlenarSelect.clientes({
                id: "clientes_mEnviosSincronizar",
                multiple: true
            })

            await globalActivarAcciones.select2({
                className: "select2_mEnviosSincronizar"
            })

            if (mode == 0) {
                // NUEVO INSUMO
                $("#titulo_mEnviosSincronizar").text("Nuevo envio");
                $("#subtitulo_mEnviosSincronizar").text("Creacion de envio nuevo, completar formulario.");
                $('.campos_mEnviosSincronizar').prop('disabled', false);
                $("#btnEditar_mEnviosSincronizar").addClass("ocultar");
                $("#btnGuardar_mEnviosSincronizar").removeClass("ocultar");
                $("#modal_mEnviosSincronizar").modal("show")
            } else if (mode == 1) {
                // MODIFICAR INSUMO
                await globalLoading.open()
                $("#titulo_mEnviosSincronizar").text("Modificar envio");
                $("#subtitulo_mEnviosSincronizar").text("Modificacion de envio existente, completar formulario.");
                $('.campos_mEnviosSincronizar').prop('disabled', false);
                $("#btnGuardar_mEnviosSincronizar").addClass("ocultar");
                $("#btnEditar_mEnviosSincronizar").removeClass("ocultar");
                await get()
            } else {
                // VER INSUMO
                await globalLoading.open()
                $("#titulo_mEnviosSincronizar").text("Ver envio");
                $("#subtitulo_mEnviosSincronizar").text("Visualizacion de envio, no se puede modificar.");
                $('.campos_mEnviosSincronizar').prop('disabled', true);
                $("#btnGuardar_mEnviosSincronizar, #btnEditar_mEnviosSincronizar").addClass("ocultar");
                await get()
            }
        }

        function get() {
            globalRequest.get(`/${rutaAPI}/${g_did}`, {
                onSuccess: function(result) {
                    g_data = result.data;
                    $("#codigo_mEnviosSincronizar").val(g_data.codigo);
                    $("#nombre_mEnviosSincronizar").val(g_data.nombre);
                    $("#checkHabilitado_mEnviosSincronizar").prop("checked", g_data.habilitado == 1);
                    $("#checkUnidad_mEnviosSincronizar").prop("checked", g_data.unidad == 1);
                    $("#clientes_mEnviosSincronizar").val(g_data.clientes.split(",")).trigger("change");
                    $("#modal_mEnviosSincronizar").modal("show")
                }
            });
        }

        function resetModal() {
            globalActivarAcciones.activarPrimerTab({
                tabList: "tabs_mEnviosSincronizar"
            })

            $(".campos_mEnviosSincronizar").val("")
            $("#checkHabilitado_mEnviosSincronizar, #checkUnidad_mEnviosSincronizar").prop("checked", false);
            $("#clientes_mEnviosSincronizar").val(null).trigger("change");

            globalValidar.limpiarTodas()
            globalValidar.deshabilitarTiempoReal({
                className: "camposObli_mEnviosSincronizar"
            })
        };

        function validacion() {
            return globalValidar.obligatorios({
                className: "camposObli_mEnviosSincronizar"
            })
        }

        public.guardar = function() {
            const datos = {
                codigo: $("#codigo_mEnviosSincronizar").val().trim() || null,
                nombre: $("#nombre_mEnviosSincronizar").val().trim() || null,
                habilitado: $("#checkHabilitado_mEnviosSincronizar").is(":checked") ? 1 : 0,
                unidad: $("#checkUnidad_mEnviosSincronizar").is(":checked") ? 1 : 0,
                clientes: $("#clientes_mEnviosSincronizar").val().join(",")
            };

            globalValidar.habilitarTiempoReal({
                className: "camposObli_mEnviosSincronizar",
                callback: validacion
            });

            if (validacion()) {
                globalSweetalert.alert({
                    titulo: "Verifique los campos"
                });
                return;
            }

            globalSweetalert.confirmar({
                    titulo: "¿Estas seguro de guardar este envio?"
                })
                .then(function(confirmado) {
                    if (confirmado) {
                        globalRequest.post(`/${rutaAPI}`, datos, {
                            onSuccess: function(result) {
                                $("#modal_mEnviosSincronizar").modal("hide");
                                globalSweetalert.exito();
                                appModuloEnviosSincronizar.getListado();
                            }
                        });
                    }
                });
        };

        public.editar = function() {
            const datosNuevos = {
                codigo: $("#codigo_mEnviosSincronizar").val().trim() || null,
                nombre: $("#nombre_mEnviosSincronizar").val().trim() || null,
                habilitado: $("#checkHabilitado_mEnviosSincronizar").is(":checked") ? 1 : 0,
                unidad: $("#checkUnidad_mEnviosSincronizar").is(":checked") ? 1 : 0,
                clientes: $("#clientes_mEnviosSincronizar").val().join(",")
            };

            globalValidar.habilitarTiempoReal({
                className: "camposObli_mEnviosSincronizar",
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
                    titulo: "¿Estas seguro de modificar este envio?"
                })
                .then(function(confirmado) {
                    if (confirmado) {
                        globalRequest.put(`/${rutaAPI}/${g_did}`, datosModificados, {
                            onSuccess: function(result) {
                                $("#modal_mEnviosSincronizar").modal("hide");
                                globalSweetalert.exito();
                                appModuloEnviosSincronizar.getListado();
                            }
                        });
                    }
                });
        };

        public.eliminar = function(did) {
            globalSweetalert.confirmar({
                titulo: "¿Estas seguro de eliminar este envio?",
                color: "var(--bs-danger)"
            }).then(function(confirmado) {
                if (confirmado) {
                    globalRequest.delete(`/${rutaAPI}/${did}`, {
                        onSuccess: function(result) {
                            globalSweetalert.exito({
                                titulo: "Eliminado con éxito!"
                            });
                            appModuloEnviosSincronizar.getListado();
                        }
                    });
                }
            });
        };

        return public;
    })();
</script>
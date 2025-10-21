<script>
    const appModalInsumos = (function() {
        let g_did = 0;
        let g_data;
        let donde = 0;
        const rutaAPI = "insumos"

        const public = {};

        public.open = async function({
            mode = 0,
            did = 0
        } = {}) {
            await resetModal()
            g_did = did;
            donde = mode

            await globalLlenarSelect.clientes({
                id: "clientes_mInsumos",
                multiple: true
            })

            await globalActivarAcciones.select2({
                className: "select2_mInsumos"
            })

            if (mode == 0) {
                // NUEVO INSUMO
                $("#titulo_mInsumos").text("Nuevo insumo");
                $("#subtitulo_mInsumos").text("Creacion de insumo nuevo, completar formulario.");
                $('.campos_mInsumos').prop('disabled', false);
                $("#btnEditar_mInsumos").addClass("ocultar");
                $("#btnGuardar_mInsumos").removeClass("ocultar");
                $("#modal_mInsumos").modal("show")
            } else if (mode == 1) {
                // MODIFICAR INSUMO
                await globalLoading.open()
                $("#titulo_mInsumos").text("Modificar insumo");
                $("#subtitulo_mInsumos").text("Modificacion de insumo existente, completar formulario.");
                $('.campos_mInsumos').prop('disabled', false);
                $("#btnGuardar_mInsumos").addClass("ocultar");
                $("#btnEditar_mInsumos").removeClass("ocultar");
                await get()
            } else {
                // VER INSUMO
                await globalLoading.open()
                $("#titulo_mInsumos").text("Ver insumo");
                $("#subtitulo_mInsumos").text("Visualizacion de insumo, no se puede modificar.");
                $('.campos_mInsumos').prop('disabled', true);
                $("#btnGuardar_mInsumos, #btnEditar_mInsumos").addClass("ocultar");
                await get()
            }
        }

        function get() {
            globalRequest.get(`/${rutaAPI}/${g_did}`, {
                onSuccess: function(result) {
                    g_data = result.data;
                    $("#codigo_mInsumos").val(g_data.codigo);
                    $("#nombre_mInsumos").val(g_data.nombre);
                    $("#checkHabilitado_mInsumos").prop("checked", g_data.habilitado == 1);
                    $("#checkUnidad_mInsumos").prop("checked", g_data.unidad == 1);
                    $("#clientes_mInsumos").val(g_data.clientes_dids).trigger("change");
                    $("#modal_mInsumos").modal("show")
                }
            });
        }

        function resetModal() {
            globalActivarAcciones.activarPrimerTab({
                tabList: "tabs_mInsumos"
            })

            $(".campos_mInsumos").val("")
            $("#checkHabilitado_mInsumos, #checkUnidad_mInsumos").prop("checked", false);
            $("#clientes_mInsumos").val(null).trigger("change");

            globalValidar.limpiarTodas()
            globalValidar.deshabilitarTiempoReal({
                className: "camposObli_mInsumos"
            })
        };

        function validacion() {
            return globalValidar.obligatorios({
                className: "camposObli_mInsumos"
            })
        }

        public.guardar = function() {
            const datos = {
                codigo: $("#codigo_mInsumos").val().trim() || null,
                nombre: $("#nombre_mInsumos").val().trim() || null,
                habilitado: $("#checkHabilitado_mInsumos").is(":checked") ? 1 : 0,
                unidad: $("#checkUnidad_mInsumos").is(":checked") ? 1 : 0,
                clientes_dids: $("#clientes_mInsumos").val().map(Number) || []
            };

            globalValidar.habilitarTiempoReal({
                className: "camposObli_mInsumos",
                callback: validacion
            });

            if (validacion()) {
                globalSweetalert.alert({
                    titulo: "Verifique los campos"
                });
                return;
            }

            globalSweetalert.confirmar({
                    titulo: "¿Estas seguro de guardar este insumo?"
                })
                .then(function(confirmado) {
                    if (confirmado) {
                        globalRequest.post(`/${rutaAPI}`, datos, {
                            onSuccess: function(result) {
                                $("#modal_mInsumos").modal("hide");
                                globalSweetalert.exito();
                                appModuloInsumos.getListado();
                            }
                        });
                    }
                });
        };

        public.editar = function() {
            const datosNuevos = {
                codigo: $("#codigo_mInsumos").val().trim() || null,
                nombre: $("#nombre_mInsumos").val().trim() || null,
                habilitado: $("#checkHabilitado_mInsumos").is(":checked") ? 1 : 0,
                unidad: $("#checkUnidad_mInsumos").is(":checked") ? 1 : 0,
                clientes_dids: $("#clientes_mInsumos").val().map(Number) || []
            };

            globalValidar.habilitarTiempoReal({
                className: "camposObli_mInsumos",
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

            let clientesUpdateados = {}
            if (datosModificados.clientes_dids) {
                clientesUpdateados = globalValidar.obtenerCambiosEnArray({
                    dataNueva: datosModificados.clientes_dids,
                    dataOriginal: g_data.clientes_dids
                })
            }

            datosNuevos.clientes_dids = clientesUpdateados

            globalSweetalert.confirmar({
                    titulo: "¿Estas seguro de modificar este insumo?"
                })
                .then(function(confirmado) {
                    if (confirmado) {
                        globalRequest.put(`/${rutaAPI}/${g_did}`, datosNuevos, {
                            onSuccess: function(result) {
                                $("#modal_mInsumos").modal("hide");
                                globalSweetalert.exito();
                                appModuloInsumos.getListado();
                            }
                        });
                    }
                });
        };

        public.eliminar = function(did) {
            globalSweetalert.confirmar({
                titulo: "¿Estas seguro de eliminar este insumo?",
                color: "var(--bs-danger)"
            }).then(function(confirmado) {
                if (confirmado) {
                    globalRequest.delete(`/${rutaAPI}/${did}`, {
                        onSuccess: function(result) {
                            globalSweetalert.exito({
                                titulo: "Eliminado con éxito!"
                            });
                            appModuloInsumos.getListado();
                        }
                    });
                }
            });
        };

        return public;
    })();
</script>
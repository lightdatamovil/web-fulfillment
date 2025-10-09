<script>
    const appModalClientes = (function() {
        let g_did = 0;
        let g_data;
        let donde = 0;
        let g_direcciones = [];
        let g_contactos = [];
        let g_tiendas = [];
        let logosTiendas = {}
        const rutaAPI = "clientes"

        const public = {};

        public.open = async function({
            mode = 0,
            did = 0
        } = {}) {
            resetModal()
            g_did = did;
            donde = mode
            await globalLlenarSelect.tiendas({
                id: "tienda_mClientes"
            })
            await globalLlenarSelect.contactos({
                id: "tipo_contactos_mClientes"
            })

            logosTiendas = globalLogoTiendas.obtener()
            if (mode == 0) {
                // NUEVO CLIENTE
                $("#titulo_mClientes").text("Nuevo cliente");
                $("#subtitulo_mClientes").text("Creacion de cliente nuevo, completar formulario.");
                $('.campos_mClientes').prop('disabled', false);
                $("#btnEditar_mClientes").addClass("ocultar")
                $("#btnGuardar_mClientes, .forms_mClientes").removeClass("ocultar");
                renderDirecciones()
                renderContactos()
                $("#modal_mClientes").modal("show")
            } else if (mode == 1) {
                // MODIFICAR CLIENTE
                await globalLoading.open()
                $("#titulo_mClientes").text("Modificar cliente");
                $("#subtitulo_mClientes").text("Modificacion de cliente existente, completar formulario.");
                $('.campos_mClientes').prop('disabled', false);
                $("#btnGuardar_mClientes").addClass("ocultar")
                $("#btnEditar_mClientes, .forms_mClientes").removeClass("ocultar");
                await get()
            } else {
                // VER CLIENTE
                await globalLoading.open()
                $("#titulo_mClientes").text("Ver cliente");
                $("#subtitulo_mClientes").text("Visualizacion de cliente, no se puede modificar.");
                $('.campos_mClientes').prop('disabled', true);
                $("#btnGuardar_mClientes, #btnEditar_mClientes, .forms_mClientes").addClass("ocultar");
                await get()
            }

            await globalActivarAcciones.tooltips({
                idContainer: "modal_mClientes"
            })
        }

        function get() {
            globalRequest.get(`/${rutaAPI}/${g_did}`, {
                onSuccess: function(result) {
                    g_data = result.data;
                    $("#nombreFantasia_mClientes").val(g_data.nombre_fantasia || "");
                    $("#razonSocial_mClientes").val(g_data.razon_social || "");
                    $("#codigo_mClientes").val(g_data.codigo || "");
                    $("#estado_mClientes").val(g_data.habilitado || "0");
                    $("#observacion_mClientes").val(g_data.observaciones || "");
                    g_tiendas = g_data.cuentas || []
                    g_tiendas.forEach(tienda => {
                        appModalClientes.renderTienda(tienda.tipo, tienda.titulo, tienda.data, tienda.did);
                    });
                    g_direcciones = g_data.direcciones || []
                    renderDirecciones();
                    g_contactos = g_data.contactos || [];
                    renderContactos();
                    $("#modal_mClientes").modal("show")
                }
            });
        }

        function resetModal() {
            globalActivarAcciones.activarPrimerTab({
                tabList: "tabs_mClientes"
            })

            $(".campos_mClientes").val("")
            $(".contenedoresExtras_mClientes").html("");
            $(".btnAgregar_mClientes").prop("disabled", true);
            $("#estado_mClientes").val("1");

            g_data = {}
            g_direcciones = [];
            g_contactos = [];
            g_tiendas = [];

            globalValidar.limpiarTodas()
            globalValidar.deshabilitarTiempoReal({
                className: "camposObli_mClientes"
            })
        };

        public.habilitarBtnAgregarTienda = function() {
            $("#btnAgregarTienda_mClientes").prop("disabled", $("#tienda_mClientes").val() == "");
        };

        public.renderTienda = function(tipo, titulo = "", data = {}, did = 0) {
            $("#btnAgregarTienda_mClientes").prop("disabled", true)

            idUnico = `tienda_${tipo}_${Date.now()}`;
            tipo = tipo || $("#tienda_mClientes").val()
            if (typeof data == 'string') {
                data = JSON.parse(data);
            }

            tiendas = {
                '1': {
                    nombre: 'Mercado Libre',
                    campos: [{
                            label: 'ID vendedor',
                            placeholder: 'ID vendedor',
                            key: 'ml_id_vendedor'
                        },
                        {
                            label: 'Username',
                            placeholder: 'Username',
                            key: 'ml_user'
                        }
                    ]
                },
                '2': {
                    nombre: 'Tienda Nube',
                    campos: [{
                        label: 'URL Tiendanube',
                        placeholder: 'URL Tiendanube',
                        key: 'tn_url'
                    }]
                },
                '3': {
                    nombre: 'Shopify',
                    campos: [{
                            label: 'Shopify url',
                            placeholder: 'Shopify url',
                            key: 'sh_url'
                        },
                        {
                            label: 'Clave unica',
                            placeholder: 'Clave unica',
                            key: 'sh_clave_unica'
                        }
                    ]
                },
                '4': {
                    nombre: 'WooCommerce',
                    campos: [{
                            label: 'Woo-commerce API',
                            placeholder: 'Woo-commerce API',
                            key: 'wc_api'
                        },
                        {
                            label: 'Woo-commerce secreto',
                            placeholder: 'Woo-commerce secreto',
                            key: 'wc_secreto'
                        },
                        {
                            label: 'Woo-commerce url',
                            placeholder: 'Woo-commerce url',
                            key: 'wc_url'
                        }
                    ]
                }
            };

            $("#tienda_mClientes").val("")

            tienda = tiendas[tipo];
            if (!tienda) return '';
            vinculado = data.ml_user;

            let buffer = '';
            buffer += `<div class="col-12 border rounded-5 card p-5" id="${idUnico}" data-tipo="${tipo}" data-did="${did}">`;
            buffer += `<div class="row">`
            buffer += `<div class="d-flex align-items-center justify-content-between mb-3">`;

            buffer += `<div class="d-flex align-items-center justify-content-between gap-3">`;
            buffer += `<div class="containerSvg" style="width: 50px; height: auto;">${logosTiendas[tipo]}</div>`
            buffer += `<h6 class="mb-0">${tienda.nombre}</h6>`;

            if (tipo == 1 || tipo == 2) {
                if (donde == 0 && did == 0) {
                    buffer += `<span class="badge rounded-pill bg-label-warning">Debes hacer la vinculacion despues de crear el cliente</i></span>`;
                } else {
                    buffer += `<span class="badge rounded-pill bg-label-${vinculado ? "success" : "danger"}">${vinculado ? "Vinculado" : "No vinculado"}</span>`;
                }
            }

            buffer += `</div>`;

            if (donde != 2) {
                buffer += `<div class="d-flex align-items-center justify-content-between gap-3">`;

                if (donde != 0 && (tipo == 1 || tipo == 2)) {
                    urlVinculacion = `https://cuentasarg.lightdata.com.ar/${tipo == 1 ? "syncml.php" : "synctn.php"}`;

                    url = vinculado ? "javascript:void(0)" : urlVinculacion;
                    target = vinculado ? "" : `target="_blank"`;
                    color = vinculado ? "danger" : "primary";
                    icon = vinculado ? "-unlink" : "";
                    title = vinculado ? "Desvincular" : "Link vinculación";

                    buffer += `<a href="${url}" ${target} rel="noopener noreferrer" class="btn btn-icon btn-label-${color}" data-bs-toggle="tooltip" data-bs-placement="top" title="${title}"><i class="tf-icons ri-link${icon} ri-22px"></i></a>`;
                }

                buffer += `<button type="button" class="btn btn-icon btn-label-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar" onclick="document.getElementById('${idUnico}').remove()"><i class="tf-icons ri-delete-bin-5-fill ri-22px"></i></button>`
                buffer += `</div>`;
            }

            buffer += `</div>`;

            buffer += `<div class="col-12">`;
            buffer += `<div class="row g-4">`;

            buffer += `<div class="col-12 form-floating form-floating-outline">`;
            buffer += `<input type="text" class="form-control" placeholder="Titulo de cuenta" value="${titulo}" name="tituloCuenta" ${donde == 2 ? "disabled" : ""}/>`;
            buffer += `<label>Titulo de cuenta</label>`;
            buffer += `</div>`;

            tienda.campos.forEach(campo => {
                valor = data[campo.key] || '';

                if (tipo == 1 || tipo == 2) {
                    if (donde != 0) {
                        buffer += `<div class="col-12 form-floating form-floating-outline">`;
                        buffer += `<input type="text" class="form-control" placeholder="${valor ? campo.placeholder : "Debe hacer la vinculacion" }" value="${valor}" name="${campo.key}" disabled />`;
                        buffer += `<label>${campo.label}</label>`;
                        buffer += `</div>`;
                    }
                } else {
                    buffer += `<div class="col-12 form-floating form-floating-outline">`;
                    buffer += `<input type="text" class="form-control" placeholder="${campo.placeholder}" value="${valor}" name="${campo.key}" ${donde == 2 ? "disabled" : ""}/>`;
                    buffer += `<label>${campo.label}</label>`;
                    buffer += `</div>`;
                }
            });

            buffer += `</div>`;
            buffer += `</div>`;

            buffer += `</div>`;
            buffer += `</div>`;


            $("#contenedorTiendas_mClientes").append(buffer);
            globalActivarAcciones.tooltips({
                idContainer: "modal_mClientes"
            })
        }

        function obtenerTiendasParaGuardar() {
            const tiendasFinales = [];

            $("#contenedorTiendas_mClientes > div").each(function() {
                const tipo = $(this).data("tipo");
                const did = $(this).data("did");

                const inputs = $(this).find("input");
                const data = {};
                let titulo = "";

                inputs.each(function() {
                    const key = $(this).attr("name");
                    const value = $(this).val();

                    if (key === "tituloCuenta") {
                        titulo = value;
                    } else {
                        data[key] = value;
                    }
                });

                tiendasFinales.push({
                    tipo,
                    did,
                    titulo,
                    data
                });
            });

            g_tiendas = tiendasFinales;
        }

        function renderDirecciones() {
            globalActivarAcciones.formRepeater({
                id: "formDirecciones_mClientes",
                data: g_direcciones
            })
        };

        function renderContactos() {
            globalActivarAcciones.formRepeater({
                id: "formContactos_mClientes",
                data: g_contactos
            })
        };

        function validacion() {
            return globalValidar.obligatorios({
                className: "camposObli_mClientes"
            })
        }

        public.guardar = function() {
            const datos = {
                codigo: $("#codigo_mClientes").val().trim() || null,
                nombre_fantasia: $("#nombreFantasia_mClientes").val().trim() || null,
                razon_social: $("#razonSocial_mClientes").val().trim() || null,
                habilitado: $("#estado_mClientes").val(),
                observaciones: $("#observacion_mClientes").val().trim() || null,
                direcciones: g_direcciones,
                contactos: g_contactos,
                cuentas: g_tiendas,
            };

            globalValidar.formRepeater({
                id: "formDirecciones_mClientes"
            })

            globalValidar.formRepeater({
                id: "formContactos_mClientes"
            })

            globalValidar.habilitarTiempoReal({
                className: "camposObli_mClientes",
                callback: validacion
            });

            if (validacion()) {
                globalSweetalert.alert({
                    titulo: "Verifique los campos"
                });
                return;
            }

            globalSweetalert.confirmar({
                    titulo: "¿Estas seguro de guardar este cliente?"
                })
                .then(function(confirmado) {
                    if (confirmado) {
                        globalRequest.post(`/${rutaAPI}`, datos, {
                            onSuccess: function(result) {
                                $("#modal_mClientes").modal("hide");
                                globalSweetalert.exito();
                                appModuloClientes.getListado();
                            }
                        });
                    }
                });
        };

        public.editar = function() {
            const datosNuevos = {
                codigo: $("#codigo_mClientes").val().trim() || null,
                nombre_fantasia: $("#nombreFantasia_mClientes").val().trim() || null,
                razon_social: $("#razonSocial_mClientes").val().trim() || null,
                habilitado: $("#estado_mClientes").val() * 1,
                observaciones: $("#observacion_mClientes").val().trim() || null,
                direcciones: globalActivarAcciones.obtenerDataFormRepeater({
                    id: "formDirecciones_mClientes"
                }),
                contactos: globalActivarAcciones.obtenerDataFormRepeater({
                    id: "formContactos_mClientes"
                }),
                cuentas: g_tiendas,
            };

            globalValidar.formRepeater({
                id: "formDirecciones_mClientes"
            })

            globalValidar.formRepeater({
                id: "formContactos_mClientes"
            })

            globalValidar.habilitarTiempoReal({
                className: "camposObli_mClientes",
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

            if (datosModificados.contactos && datosModificados.contactos.length > 0) {
                datosNuevos.contactos = globalValidar.obtenerCambiosEnArray({
                    dataNueva: datosModificados.contactos,
                    dataOriginal: g_contactos
                })
            }

            globalSweetalert.confirmar({
                    titulo: "¿Estas seguro de modificar este cliente?"
                })
                .then(function(confirmado) {
                    if (confirmado) {
                        globalRequest.put(`/${rutaAPI}/${g_did}`, datosModificados, {
                            onSuccess: function(result) {
                                $("#modal_mClientes").modal("hide");
                                globalSweetalert.exito();
                                appModuloClientes.getListado();
                            }
                        });
                    }
                });
        };

        public.eliminar = function(did) {
            globalSweetalert.confirmar({
                titulo: "¿Estas seguro de eliminar este cliente?",
                color: "var(--bs-danger)"
            }).then(function(confirmado) {
                if (confirmado) {
                    globalRequest.delete(`/${rutaAPI}/${did}`, {
                        onSuccess: function(result) {
                            globalSweetalert.exito({
                                titulo: "Eliminado con éxito!"
                            });
                            appModuloClientes.getListado();
                        }
                    });
                }
            });
        };


        return public;
    }());
</script>
<script>
    const appEditarPerfil = (function() {
        let g_did;
        let g_data;
        let validarPasword = false

        public = {};

        public.open = function() {
            limpiarValidaciones()
            g_did = appSistema.didUser
            globalLlenarSelect.perfiles("perfil_editarPerfil")
            globalLlenarSelect.clientes("cliente_editarPerfil", true)

            globalLoading.open()
            getUsuario()
        }

        function getUsuario() {
            parametros = {
                idEmpresa: appSistema.idEmpresa,
                did: g_did
            };

            $.ajax({
                url: `${appSistema.urlServer}/usuario/getUsuarioById`,
                type: "POST",
                data: parametros,
                headers: {
                    Authorization: `Bearer ${appSistema.tkn}`
                },
                success: function(result) {
                    if (result.estado && result.data) {
                        g_data = result.data;
                        $("#nombre_editarPerfil").val(g_data.nombre);
                        $("#apellido_editarPerfil").val(g_data.apellido);
                        $("#usuario_editarPerfil").val(g_data.usuario);
                        $("#email_editarPerfil").val(g_data.mail);
                        $("#telefono_editarPerfil").val(g_data.telefono);
                        $("#perfil_editarPerfil").val(g_data.perfil);
                        $("#estado_editarPerfil").val(g_data.habilitado);
                        $("#modInicio_editarPerfil").val(g_data.modulo_inicial);
                        $("#appHabilitada_editarPerfil").val(g_data.app_habilitada);
                        globalInputImg.crear("imagen_editarPerfil", "../../assets/img/avatars/1.png")
                        if (g_data.perfil == 4) {
                            $("#containerCliente_editarPerfil").removeClass("ocultar")
                            $("#cliente_editarPerfil").val(g_data.codigo_cliente.split(",")).trigger("change");

                        } else {
                            $("#containerCliente_editarPerfil").addClass("ocultar")
                        }

                        globalLoading.close()
                        $(".winapp").hide();
                        $("#ContainerEditarPerfil").show();

                    }
                },
                error: function(xhr) {
                    console.log("Error", xhr.responseText);
                    globalLoading.close()
                    globalSweetalert.error()
                }
            });
        }

        function limpiarValidaciones() {
            $("#campos_editarPerfil").val("")
            $("#modInicio_editarPerfil, #estado_editarPerfil, #appHabilitada_editarPerfil").val(0);
            $("#checkEditPassword_editarPerfil, #checkEliminar_editarPerfil").prop("checked", false);

            globalValidar.limpiarTodas()
            globalValidar.deshabilitarTiempoReal("camposObli_editarPerfil")
        };

        public.editPassword = function() {
            $("#password_editarPerfil").val('');
            $("#repPassword_editarPerfil").val('');
            $("#password_editarPerfil").removeClass('is-invalid');
            $("#repPassword_editarPerfil").removeClass('is-invalid');

            if ($("#checkEditPassword_editarPerfil").is(":checked")) {
                $("#containerPassword_editarPerfil, #containerRepPassword_editarPerfil").removeClass("ocultar")
                validarPasword = true
            } else {
                $("#containerPassword_editarPerfil, #containerRepPassword_editarPerfil").addClass("ocultar")
                validarPasword = false
            }
        }

        function validacion() {
            nombre = $("#nombre_editarPerfil").val().trim();
            apellido = $("#apellido_editarPerfil").val().trim();
            usuario = $("#usuario_editarPerfil").val().trim();
            email = $("#email_editarPerfil").val().trim();
            password = $("#password_editarPerfil").val();
            repeatPassword = $("#repPassword_editarPerfil").val();
            perfil = $("#perfil_editarPerfil").val();

            faltanCampos = false

            $(".camposObli_editarPerfil").each(function() {
                if (!validarPasword && (this["id"] == "password_editarPerfil" || this["id"] == "repPassword_editarPerfil")) {
                    return
                } else if (this["id"] == "cliente_editarPerfil") {
                    if (perfil == 4 && globalValidar.vacio(this["id"])) faltanCampos = true;
                } else {
                    if (globalValidar.vacio(this["id"])) faltanCampos = true;
                }
            });

            if (email != "" && globalValidar.email("email_editarPerfil")) faltanCampos = true;
            if (nombre != "" && globalValidar.letrasYEspacios("nombre_editarPerfil")) faltanCampos = true;
            if (apellido != "" && globalValidar.letrasYEspacios("apellido_editarPerfil")) faltanCampos = true;
            if (usuario != "" && globalValidar.sinCaracteresEspeciales("usuario_editarPerfil")) faltanCampos = true;
            if (validarPasword && password !== "" && globalValidar.minCaracteres("password_editarPerfil", 6)) faltanCampos = true;
            if (validarPasword && password !== "" && repeatPassword !== "" && globalValidar.coincideContraseña("password_editarPerfil", "repPassword_editarPerfil")) faltanCampos = true;

            return faltanCampos
        }

        public.guardar = function() {
            const nombre = $("#nombre_editarPerfil").val().trim();
            const apellido = $("#apellido_editarPerfil").val().trim();
            const email = $("#email_editarPerfil").val().trim();
            const usuario = $("#usuario_editarPerfil").val().trim();
            const telefono = $("#telefono_editarPerfil").val().trim();
            const perfil = $("#perfil_editarPerfil").val();
            const habilitado = $("#estado_editarPerfil").val();
            const password = $("#password_editarPerfil").val();
            const repeatPassword = $("#repPassword_editarPerfil").val();
            const modInicio = $("#modInicio_editarPerfil").val();
            const appHabilitada = $("#appHabilitada_editarPerfil").prop("checked") ? 1 : 0;
            const cliente = $("#cliente_editarPerfil").val().join(",");
            // const imagen = globalInputImg.obtener("imagen_editarPerfil");


            globalValidar.habilitarTiempoReal("camposObli_editarPerfil", validacion)

            if (validacion()) {
                globalSweetalert.alert("Verifique los campos")
                return
            }

            const datos = {
                idEmpresa: appSistema.idEmpresa,
                did: g_did,
                nombre,
                apellido,
                mail: email,
                telefono,
                usuario,
                perfil,
                habilitado,
                contraseña: password,
                modulo_inicial: modInicio,
                app_habilitada: appHabilitada,
                codigo_cliente: cliente,
                // imagen
            };
            console.log("Datos a guardar:", datos);

            globalSweetalert.confirmar("¿Estas seguro de guardar este usuario?").then(function(confirmado) {
                if (confirmado) {
                    globalLoading.open()
                    $.ajax({
                        url: `${appSistema.urlServer}/usuario/postUsuario`,
                        type: "POST",
                        contentType: "application/json",
                        data: JSON.stringify(datos),
                        headers: {
                            Authorization: `Bearer ${appSistema.tkn}`
                        },
                        success: function(result) {
                            if (result.estado) {
                                globalLoading.close()
                                globalSweetalert.exito()
                                appMiPerfil.open()
                            } else {
                                globalLoading.close()
                                globalSweetalert.alert(result.message)
                            }
                        },
                        error: function(xhr) {
                            console.log("Error al guardar", xhr.responseText);
                            globalLoading.close()
                            globalSweetalert.error()
                        }
                    });

                }
            })
        };

        public.perfilCliente = function(e) {
            if ($(e).val() == 4) {
                $("#containerCliente_editarPerfil").removeClass("ocultar")
                $("#cliente_editarPerfil").val(null).trigger("change");
            } else {
                $("#containerCliente_editarPerfil").addClass("ocultar")
            }
        }

        public.activarEliminar = function() {
            if ($("#checkEliminar_editarPerfil").is(":checked")) {
                $("#btnEliminar_editarPerfil").prop("disabled", false);
            } else {
                $("#btnEliminar_editarPerfil").prop("disabled", true);
            }
        }

        public.eliminar = function() {
            const datos = {
                idEmpresa: appSistema.idEmpresa,
                did: g_did
            }

            globalSweetalert.confirmar("¿Estas seguro de eliminar esta usuario?", "var(--bs-danger)").then(function(confirmado) {
                if (confirmado) {
                    globalLoading.open()
                    $.ajax({
                        url: `${appSistema.urlServer}/usuario/deleteUsuario`,
                        type: "POST",
                        contentType: "application/json",
                        data: JSON.stringify(datos),
                        headers: {
                            Authorization: `Bearer ${appSistema.tkn}`
                        },
                        success: function(result) {
                            globalLoading.close()
                            globalSweetalert.exito("Eliminado con exito!")
                            appSistema.desloguear;
                        },
                        error: function(xhr) {
                            console.log("Error al guardar", xhr.responseText);
                            globalLoading.close()
                            globalSweetalert.error()
                        }
                    });

                }
            })
        };

        return public;
    }());
</script>
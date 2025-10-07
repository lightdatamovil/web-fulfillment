<script>
    const appMiPerfil = (function() {
        let g_did;
        let g_data;

        const public = {};

        public.open = function() {
            g_did = appSistema.didUser
            globalLoading.open();
            getUsuario()
        };

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
                        $("#nombreSup_miPerfil").html(`${g_data.nombre} ${g_data.apellido}` || "---");
                        $("#nombre_miPerfil").html(`${g_data.nombre} ${g_data.apellido}` || "---");
                        $("#usuario_miPerfil").html(g_data.usuario || "---");
                        $("#email_miPerfil").html(g_data.mail || "---");
                        $("#telefono_miPerfil").html(g_data.telefono || "---");
                        $("#perfil_miPerfil").html(g_data.perfil ? appSistema.perfilesTipos[g_data.perfil] : "---");
                        $("#perfilSup_miPerfil").html(g_data.perfil ? appSistema.perfilesTipos[g_data.perfil] : "---");
                        $("#estado_miPerfil").html(g_data.habilitado == 1 ? `<span class="badge rounded-pill bg-label-success">Habilitado</span>` : `<span class="badge rounded-pill bg-label-danger">Deshabilitado</span>` || "---");
                        $("#modInicio_miPerfil").html(g_data.modulo_inicial || "---");
                        $("#appHabilitada_miPerfil").html(g_data.app_habilitada == 1 ? `<span class="badge rounded-pill bg-label-success">Habilitada</span>` : `<span class="badge rounded-pill bg-label-danger">Deshabilitada</span>` || "---");
                        if (g_data.perfil == 4) {
                            $("#containerCliente_miPerfil").removeClass("ocultar")
                            $("#cliente_miPerfil").html(g_data.codigo_cliente || "---");
                        } else {
                            $("#containerCliente_miPerfil").addClass("ocultar")
                        }
                        globalLoading.close()
                        $(".winapp").hide();
                        $("#ContainerMiPerfil").show();
                    }
                },
                error: function(xhr) {
                    console.log("Error", xhr.responseText);
                    globalLoading.close()
                    globalSweetalert.error()
                }
            });
        }
        return public;
    })();
</script>
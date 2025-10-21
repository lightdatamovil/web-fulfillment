<script>
    const appModuloConfiguracion = (function() {
        let g_data;
        const rutaAPI = "configuracion";

        const public = {};

        public.open = function() {
            $(".winapp").hide();
            globalLoading.open();
            get();
            setTimeout(() => {
                globalLoading.close();
            }, 200);
            $("#modulo_configuracion").show();
        };

        function get() {
            g_data = {
                nombreEmpresa: "<?php echo $_SESSION["nombreEmpresa"]; ?>",
                codEmpresa: "<?php echo $_SESSION["codEmpresa"]; ?>",
                logoEmpresa: "<?php echo $_SESSION["logoEmpresa"]; ?>",
                modoTrabajoEmpresa: appSistema.modoDeTrabajoEmpresa,
            };

            $("#nombreFantasia_configuracion").html(g_data.nombreEmpresa);
            $("#razonSocial_configuracion").html(g_data.nombreEmpresa);

            $('input[name="modoDeTrabajo_configuracion"]').closest('.custom-option').removeClass('checked');
            $(`input[name="modoDeTrabajo_configuracion"][value="${g_data.modoTrabajoEmpresa}"]`)
                .prop('checked', true)
                .closest('.custom-option')
                .addClass('checked');

            $('#logoEmpresa_configuracion').attr('src', g_data.logoEmpresa);
            $('#logoEmpresa_configuracion').attr('onerror', "this.onerror=null; this.src='../../assets/img/extras/imagenDefault.jpg';");

            $("#qrcode").empty();
            new QRCode(document.getElementById("qrcode"), {
                text: g_data.codEmpresa,
                width: 200,
                height: 200,
                colorDark: "#000000",
                colorLight: "#ffffff",
                correctLevel: QRCode.CorrectLevel.H
            });
        }

        public.cambiarModoDeTrabajo = function(radio) {
            const datosNuevos = {
                modoTrabajo: $(radio).val() * 1
            };

            console.log(datosNuevos);

            globalSweetalert.confirmar({
                    titulo: "¿Estás seguro de modificar el modo de trabajo?"
                })
                .then(function(confirmado) {
                    if (confirmado) {
                        $('input[name="modoDeTrabajo_configuracion"]').closest('.custom-option').removeClass('checked');
                        $(radio).closest('.custom-option').addClass('checked');

                        globalRequest.put(`/${rutaAPI}/toggle-modo-trabajo`, datosNuevos, {
                            onSuccess: function(result) {
                                globalSweetalert.exito();
                                g_data.modoTrabajoEmpresa = datosNuevos.modoTrabajo;
                                appSistema.modoDeTrabajoEmpresa = datosNuevos.modoTrabajo;
                            }
                        });
                    } else {
                        $('input[name="modoDeTrabajo_configuracion"]').closest('.custom-option').removeClass('checked');
                        $(`input[name="modoDeTrabajo_configuracion"][value="${g_data.modoTrabajoEmpresa}"]`)
                            .prop('checked', true)
                            .closest('.custom-option')
                            .addClass('checked');
                    }
                });
        };

        return public;
    })();
</script>
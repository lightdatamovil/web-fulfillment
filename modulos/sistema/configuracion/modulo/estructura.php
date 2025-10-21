<script>
    const appModuloConfiguracion = (function() {
        let g_data;
        const rutaAPI = "configuracion";

        const public = {};

        public.open = async function() {
            $(".winapp").hide();
            await get();
            $("#modulo_configuracion").show();
        };

        function get() {
            globalRequest.get(`/${rutaAPI}`, {
                onSuccess: function(result) {
                    g_data = result.data;
                    completarDatos()

                    $.post('modulos/configuracion/controlador.php', {
                        modo_trabajo: g_data.modo_trabajo
                    });
                }
            });
        }

        function completarDatos() {
            g_data = {
                ...g_data,
                nombreEmpresa: "<?php echo $_SESSION["nombreEmpresa"]; ?>",
                codEmpresa: "<?php echo $_SESSION["codEmpresa"]; ?>",
                logoEmpresa: "<?php echo $_SESSION["logoEmpresa"]; ?>",
            };

            $("#nombreFantasia_configuracion").html(g_data.nombreEmpresa);
            $("#razonSocial_configuracion").html(g_data.nombreEmpresa);

            $('input[name="modoDeTrabajo_configuracion"]').closest('.custom-option').removeClass('checked');
            $(`input[name="modoDeTrabajo_configuracion"][value="${g_data.modo_trabajo}"]`)
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
                modo_trabajo: $(radio).val() * 1
            };

            globalSweetalert.confirmar({
                    titulo: "¿Estás seguro de modificar el modo de trabajo?"
                })
                .then(function(confirmado) {
                    if (confirmado) {
                        $('input[name="modoDeTrabajo_configuracion"]').closest('.custom-option').removeClass('checked');
                        $(radio).closest('.custom-option').addClass('checked');

                        globalRequest.put(`/${rutaAPI}/toggle-modo-trabajo`, datosNuevos, {
                            onSuccess: function(result) {
                                globalSweetalert.exito({
                                    titulo: "Modo de trabajo modificado con éxito."
                                });
                                get()
                            }
                        });
                    } else {
                        $('input[name="modoDeTrabajo_configuracion"]').closest('.custom-option').removeClass('checked');
                        $(`input[name="modoDeTrabajo_configuracion"][value="${g_data.modo_trabajo}"]`)
                            .prop('checked', true)
                            .closest('.custom-option')
                            .addClass('checked');
                    }
                });
        };

        return public;
    })();
</script>
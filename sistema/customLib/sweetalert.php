<script>
    const globalSweetalert = (function() {

        const public = {};

        public.confirmar = function({
            titulo = "¿Estás seguro?",
            color = "var(--bs-primary)",
            btnConfirmar = "Sí",
            btnCancelar = "Volver"
        } = {}) {
            return Swal.fire({
                title: titulo,
                icon: "warning",
                iconColor: color,
                showConfirmButton: true,
                showCancelButton: true,
                showDenyButton: false,
                confirmButtonText: btnConfirmar,
                cancelButtonText: btnCancelar,
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-secondary"
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    return true;
                }
            })
        }

        public.alert = function({
            titulo = "Completar proceso",
            color = "var(--bs-primary)",
            time = 1500
        } = {}) {
            Swal.fire({
                title: titulo,
                icon: "warning",
                iconColor: color,
                showConfirmButton: false,
                timer: time,
            })
        }

        public.error = function({
            titulo = "Error al actualizar",
            color = "var(--bs-danger)",
            time = 1500
        } = {}) {
            Swal.fire({
                title: titulo,
                icon: "error",
                iconColor: color,
                showConfirmButton: false,
                timer: time,
            })
        }

        public.exito = function({
            titulo = "Guardado con exito!",
            color = "var(--bs-success)",
            time = 1500
        } = {}) {
            Swal.fire({
                title: titulo,
                icon: "success",
                iconColor: color,
                showConfirmButton: false,
                timer: time,
            })
        }

        public.notificacion = function({
            titulo = "Alerta!",
            color = "var(--bs-warning)",
            time = 1500
        } = {}) {
            const Toast = Swal.mixin({
                toast: true,
                position: "bottom-end",
                showConfirmButton: false,
                timer: time,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer
                    toast.onmouseleave = Swal.resumeTimer
                },
            })
            Toast.fire({
                icon: "warning",
                title: titulo,
                iconColor: color,
            })
        }

        public.redireccion = function({
            titulo = "Realizado con exito!",
            color = "var(--bs-primary)",
            subtitulo = "",
            boton = "Redirigir",
            accion = ""
        } = {}) {
            Swal.fire({
                icon: "success",
                title: titulo,
                text: subtitulo,
                footer: `<a style="cursor: pointer;font-weight: bolder;color: ${color};font-size: 16px;" onclick="Swal.close(); ${accion}">${boton}</a>`,
                iconColor: color,
                confirmButtonText: "Volver",
                showDenyButton: false,
                showCancelButton: false,
                customClass: {
                    confirmButton: "btn btn-primary",
                },
                buttonsStyling: false
            });
        }

        public.redireccionObligada = function({
            titulo = "Realizado con éxito!",
            color = "var(--bs-primary)",
            boton = "Redirigir",
            accion = ""
        } = {}) {
            Swal.fire({
                icon: "warning",
                title: titulo,
                html: `<a style="cursor: pointer; font-weight: bolder; color: ${color}; font-size: 16px;" onclick="Swal.close(); ${accion}">${boton}</a>`,
                iconColor: color,
                showConfirmButton: false,
                showDenyButton: false,
                showCancelButton: false,
                buttonsStyling: false,
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false
            });
        };

        public.html = function({
            titulo = "Realizado con exito!",
            color = "var(--bs-success)",
            html = ""
        } = {}) {
            Swal.fire({
                icon: "success",
                title: titulo,
                html: html,
                iconColor: color,
                confirmButtonText: "Volver",
                showDenyButton: false,
                showCancelButton: false,
                customClass: {
                    confirmButton: "btn btn-primary",
                },
                buttonsStyling: false
            });

            globalActivarAcciones.tooltips({
                idContainer: "swal2-html-container"
            })
        }


        public.errorReportable = function({
            error,
            ruta,
            metodo
        }) {
            const link = window.location.href;
            const perfil = appSistema.perfiles[appSistema.perfilUser];
            const titulo = error.responseJSON?.title;
            const mensaje = error.responseJSON?.message;
            const codigo = error.status;

            const errorMsg = encodeURIComponent(`Estimado/a,\nMe comunico con el fin de reportar un problema en el sistema de Fulfillment\n\n*Link:* ${link || "No disponible"}\n*Titulo:* ${titulo || "No disponible"}\n*Mensaje:* ${mensaje || "No disponible"}\n*Codigo de error:* ${codigo || "No disponible"}\n*Ruta:* ${ruta || "No disponible"}\n*Metodo:* ${metodo || "No disponible"}\n*Usuario:* ${appSistema.usernameUser || "No disponible"} (${appSistema.didUser || "No disponible"})\n*Rol:* ${perfil || "No disponible"}\n\nEspero su respuesta,\nMuchas gracias.`);
            const buffer = `<a class="btn rounded-pill btn-label-success waves-effect" href="https://wa.me/?text=${errorMsg}" target="_blank"><span class="tf-icons ri-customer-service-2-fill ri-16px me-2"></span>Reportar error</a>`

            Swal.fire({
                icon: "warning",
                title: `Error del sistema${titulo ? `:</br>${titulo}`: ""}`,
                text: mensaje || "",
                footer: buffer,
                iconColor: "var(--bs-danger)",
                confirmButtonText: "Volver",
                showDenyButton: false,
                showCancelButton: false,
                customClass: {
                    confirmButton: "btn btn-primary",
                },
                buttonsStyling: false
            });

        }


        return public;
    })();
</script>

<style>
    .swal2-popup.swal2-toast {
        background: #30334e;
        padding: 5px 20px;
    }
</style>
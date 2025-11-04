<script>
    let sistemaIniciado = false;
    const appSistema = {
        idEmpresa: localStorage.getItem("idEmpresa") * 1,
        didUser: localStorage.getItem("didUser") * 1,
        usernameUser: localStorage.getItem("usernameUser"),
        perfilUser: localStorage.getItem("perfilUser") * 1,
        nombreEmpresa: "<?php echo $_SESSION["nombreEmpresa"]; ?>",
        modoDeTrabajoEmpresa: "<?php echo $_SESSION["modoTrabajoEmpresa"]; ?>",
        urlServer: "https://ffull.lightdata.app/api",
        authToken: localStorage.getItem("authToken"),
        productos: [],
        variantes: [],
        curvas: [],
        clientes: [],
        insumos: [],
        usuarios: [],
        ecommerce: {
            0: "Directo",
            1: "Mercado Libre",
            2: "Tiendanube",
            3: "Shopify",
            4: "WooCommerce",
        },
        perfiles: {
            1: "Administrador",
            2: "Operador",
            3: "Armador",
            4: "Cliente"
        },
        contactos: {
            1: "Celular",
            2: "Email",
            3: "Web",
        },
        estadosPedidos: {
            "confirmed": {
                "traduccion": "Confirmado",
                "color": "primary"
            },
            "payment_required": {
                "traduccion": "Pago requerido",
                "color": "warning"
            },
            "payment_in_process": {
                "traduccion": "Pago en proceso",
                "color": "dark"
            },
            "partially_paid": {
                "traduccion": "Parcialmente pagado",
                "color": "info"
            },
            "paid": {
                "traduccion": "Pagado",
                "color": "success"
            },
            "partially_refunded": {
                "traduccion": "Parcialmente reembolsado",
                "color": "info"
            },
            "pending_cancel": {
                "traduccion": "Cancelación pendiente",
                "color": "secondary"
            },
            "cancelled": {
                "traduccion": "Cancelado",
                "color": "danger"
            },
        },

        inicializar: async function() {
            if (sistemaIniciado) return;
            sistemaIniciado = true;
            await globalLoading.open();
            await this.activarComponentes()
            await this.expirarSesion();
            await this.cargarDatos();

            console.log("Sistema inicializado");
            await globalLoading.close();
        },

        activarComponentes: async function() {
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            [...tooltipTriggerList].map(el => new bootstrap.Tooltip(el));
        },

        cargarDatos: async function() {
            await globalRequest.get(`/preload`, {
                onSuccess: (result) => {
                    this.productos = result.data.productos;
                    this.variantes = result.data.variantes;
                    this.curvas = result.data.curvas;
                    this.clientes = result.data.clientes;
                    this.insumos = result.data.insumos;
                    this.usuarios = result.data.usuarios;
                },
            });
        },

        logout: async function() {
            try {
                const response = await fetch("login/logout.php");
                const data = await response.json();

                if (data.estado === true) {
                    localStorage.removeItem("horaInicioSesion");
                    localStorage.removeItem("didUser");
                    localStorage.removeItem("usernameUser");
                    localStorage.removeItem("perfilUser");
                    localStorage.removeItem("authToken");
                    location.reload();
                } else {
                    console.warn("Logout fallido:", data.mensaje);
                }
            } catch (error) {
                console.error("Error al cerrar sesión:", error);
            }
        },

        expirarSesion: async function() {
            const ahora = Date.now();
            let horaInicio = localStorage.getItem("horaInicioSesion");

            if (!horaInicio) {
                localStorage.setItem("horaInicioSesion", ahora);
                horaInicio = ahora;
            }

            const tiempoTranscurrido = ahora - horaInicio;
            const ochoHoras = 8 * 60 * 60 * 1000;

            const tiempoRestante = Math.max(ochoHoras - tiempoTranscurrido, 0);

            const redirigirYLimpiar = "appSistema.logout();"

            if (tiempoTranscurrido >= ochoHoras) {
                globalSweetalert.redireccionObligada({
                    titulo: "Su sesión ha expirado, por favor vuelva a iniciar sesión",
                    boton: "Ir a login",
                    accion: redirigirYLimpiar
                });
            } else {
                setTimeout(() => {
                    globalSweetalert.redireccionObligada({
                        titulo: "Su sesión ha expirado, por favor vuelva a iniciar sesión",
                        boton: "Ir a login",
                        accion: redirigirYLimpiar
                    });
                }, tiempoRestante);
            }
        },

    };

    // document.addEventListener("DOMContentLoaded", () => {
    //     appSistema.inicializar();

    // });
</script>
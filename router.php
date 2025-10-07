<?php
session_start();
$logueado = isset($_SESSION["logueado"]) && $_SESSION["logueado"] == true ? 'true' : 'false';
$jsonData = file_get_contents('sistema/configMenu/menuDefault.json');
?>

<script>
    const estaLogueado = <?php echo $logueado; ?>;
    let yaInicializado = false;

    const datos = <?php echo $jsonData; ?>;

    let routes = {};
    datos.forEach(item => {
        item.hijos.forEach(hijo => {
            if (hijo.ruta && hijo.accion) {
                routes[hijo.ruta] = {
                    accion: new Function(hijo.accion),
                    titulo: hijo.titulo
                };
            }
        });
    });

    routes = {
        ...routes,
        "perfil": {
            accion: () => appMiPerfil.open(),
            titulo: "Perfil"
        },
        "logout": {
            accion: () => appSistema.logout(),
            titulo: "Login"
        },
    };

    async function handleRoute(pathname, esEntradaInicial = false) {
        const route = pathname.replace(/^\//, "");
        document.title = routes[route]?.titulo ? `Lightdata | ${routes[route].titulo}` : "Lightdata";

        if (!estaLogueado) {
            if (route !== "/") {
                await history.replaceState(null, null, "/");
                document.title = "Lightdata | Login";
            }
            return;
        }

        if (esEntradaInicial && !yaInicializado) {
            if (typeof appSistema !== "undefined" && typeof appSistema.inicializar === "function") {

                await appSistema.inicializar();
                yaInicializado = true;
            }
        }

        if (routes[route]?.accion) {
            await routes[route].accion();
        } else {
            await history.replaceState(null, null, "/");

            if (typeof appSistema !== "undefined" && typeof appSistema.inicializar === "function") {
                await appSistema.inicializar();
            }
        }
    }


    function navigateTo(path) {
        history.pushState(null, null, path);
        handleRoute(path);
    }

    document.addEventListener("click", (e) => {
        const link = e.target.closest("a[data-route]");
        if (link) {
            e.preventDefault();
            if (e.metaKey || e.ctrlKey) return;

            const route = link.getAttribute("data-route");
            navigateTo("/" + route);
        }
    });

    document.addEventListener("DOMContentLoaded", () => {
        handleRoute(location.pathname, true);
    });

    window.addEventListener("popstate", () => {
        handleRoute(location.pathname);
    });
</script>
<script>
    const globalLlenarSelect = (function() {

        const public = {}

        public.variantes = function({
            id,
            multiple = false
        }) {
            if (appSistema.variantes.length == 0) {
                $(`#${id}`).html(`<option value="" ${multiple ? "" : "selected"} disabled>Sin variantes</option>`)
                return
            }

            buffer = ""
            if (!multiple) {
                buffer = `<option value="" selected>Seleccionar variante</option>`
            }

            for (variante of appSistema.variantes) {
                buffer += `<option value="${variante["did"]}">${variante["codigo"] || "Sin codigo"} - ${variante["nombre"] || "Sin nombre"}</option>`
            }

            $(`#${id}`).html(buffer)
        }

        public.curvas = function({
            id,
            multiple = false
        }) {
            if (appSistema.curvas.length == 0) {
                $(`#${id}`).html(`<option value="" ${multiple ? "" : "selected"} disabled>Sin curvas</option>`)
                return
            }

            buffer = ""
            if (!multiple) {
                buffer = `<option value="" selected>Seleccionar curva</option>`
            }

            for (curva of appSistema.curvas) {
                buffer += `<option value="${curva["did"]}">${curva["codigo"] || "Sin codigo"} - ${curva["nombre"] || "Sin nombre"}</option>`
            }

            $(`#${id}`).html(buffer)
        }

        public.clientes = function({
            id,
            multiple = false
        }) {
            if (appSistema.clientes.length == 0) {
                $(`#${id}`).html(`<option value="" ${multiple ? "" : "selected"} disabled>Sin clientes</option>`)
                return
            }

            buffer = ""
            if (!multiple) {
                buffer = `<option value="" selected>Seleccionar cliente</option>`
            }

            for (cliente of appSistema.clientes) {
                buffer += `<option value="${cliente["did"]}">${cliente["codigo"] || "Sin codigo"} - ${cliente["nombre_fantasia"] || "Sin nombre"}</option>`
            }

            $(`#${id}`).html(buffer)
        }

        public.armadores = function({
            id,
            multiple = false
        }) {
            const armadores = appSistema.usuarios.filter(item => item.perfil == 3)

            if (armadores.length == 0) {
                $(`#${id}`).html(`<option value="" ${multiple ? "" : "selected"} disabled>Sin armadores</option>`)
                return
            }

            buffer = ""
            if (!multiple) {
                buffer = `<option value="" selected>Seleccionar armador</option>`
            }

            for (armador of armadores) {
                buffer += `<option value="${armador["did"]}">${armador["nombre"]} ${armador["apellido"]}</option>`
            }

            $(`#${id}`).html(buffer)
        }

        public.insumos = function({
            id,
            multiple = false
        }) {
            if (appSistema.insumos.length == 0) {
                $(`#${id}`).html(`<option value="" ${multiple ? "" : "selected"} disabled>Sin insumos</option>`)
                return
            }

            buffer = ""
            if (!multiple) {
                buffer = `<option value="" selected>Seleccionar insumo</option>`
            }

            for (insumo of appSistema.insumos) {
                buffer += `<option value="${insumo["did"]}">${insumo["codigo"] || "Sin codigo"} - ${insumo["nombre"] || "Sin nombre"}</option>`
            }

            $(`#${id}`).html(buffer)
        }

        public.productos = function({
            id,
            multiple = false
        }) {
            if (appSistema.productos.length == 0) {
                $(`#${id}`).html(`<option value="" ${multiple ? "" : "selected"} disabled>Sin productos</option>`)
                return
            }

            buffer = ""
            if (!multiple) {
                buffer = `<option value="" selected>Seleccionar producto</option>`
            }

            for (producto of appSistema.productos) {
                buffer += `<option value="${producto["did"]}">${producto["titulo"] || "Sin titulo"}</option>`
            }

            $(`#${id}`).html(buffer)
        }

        public.contactos = function({
            id,
            multiple = false
        }) {
            buffer = ""
            if (!multiple) {
                buffer = `<option value="" selected>Seleccionar contacto</option>`
            }

            for (contacto in appSistema.contactos) {
                buffer += `<option value="${contacto}">${appSistema.contactos[contacto] || "Sin nombre"}</option>`
            }

            $(`#${id}`).html(buffer)
        }

        public.tiendas = function({
            id,
            multiple = false
        }) {
            buffer = ""
            if (!multiple) {
                buffer = `<option value="" selected>Seleccionar tienda</option>`
            }

            for (tienda in appSistema.ecommerce) {
                buffer += `<option value="${tienda}">${appSistema.ecommerce[tienda] || "Sin nombre"}</option>`
            }

            $(`#${id}`).html(buffer)
        }

        public.perfiles = function({
            id,
            multiple = false
        }) {
            buffer = ""
            if (!multiple) {
                buffer = `<option value="" selected>Seleccionar perfil</option>`
            }

            for (perfil in appSistema.perfiles) {
                buffer += `<option value="${perfil}">${appSistema.perfiles[perfil] || "Sin nombre"}</option>`
            }

            $(`#${id}`).html(buffer)
        }

        public.estadosOT = function({
            id,
            multiple = false
        }) {
            buffer = ""
            if (!multiple) {
                buffer = `<option value="" selected>Seleccionar estado</option>`
            }

            for (estado in appSistema.estadosOT) {
                buffer += `<option value="${appSistema.estadosOT[estado].did}">${appSistema.estadosOT[estado].nombre || "Sin nombre"}</option>`
            }

            $(`#${id}`).html(buffer)
        }


        public.estadosPedidos = function({
            id,
            multiple = false
        }) {
            buffer = ""
            if (!multiple) {
                buffer = `<option value="" selected>Seleccionar estado</option>`
            }

            for (estado in appSistema.estadosPedidos) {
                buffer += `<option value="${estado}">${appSistema.estadosPedidos[estado]["traduccion"] || "Sin nombre"}</option>`
            }

            $(`#${id}`).html(buffer)
        }

        return public
    }())
</script>
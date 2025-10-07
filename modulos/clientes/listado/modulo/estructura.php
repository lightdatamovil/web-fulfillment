<script>
    const appModuloClientes = (function() {
        let g_data;
        let g_meta;
        let order = "";
        let direction = "";
        let openModulo = 0
        const rutaAPI = "clientes"

        const public = {};

        public.paginaActual = 1;
        public.limitePorPagina = 10;

        public.open = async function() {
            $(".winapp").hide();
            $("#modulo_clientes").show();
            await appModuloClientes.getListado();
            await globalActivarAcciones.filtrarConEnter({
                className: "inputs_clientes",
                callback: appModuloClientes.getListado
            })
            await globalOrdenTablas.activar({
                idThead: "theadListado_clientes",
                callback: appModuloClientes.getListado,
                defaultOrder: "nombre_fantasia"
            })
        };

        public.limpiarCampos = function() {
            $(".campos_clientes").val(null).change();
            $(".inputs_clientes").val("");
        };

        function renderListado() {
            $("#tbodyListado_clientes").empty()
            buffer = ""

            if (!g_data || g_data.length < 1) {
                globalSinInformacion.tablasVacias({
                    idTbody: "tbodyListado_clientes",
                    open: openModulo
                })
                return
            };

            g_data.forEach(cliente => {
                buffer += `<tr>`
                buffer += `<td>${cliente.codigo || '---'}</td>`
                buffer += `<td>${cliente.nombre_fantasia || '---'}</td>`
                buffer += `<td>${cliente.razon_social || '---'}</td>`
                buffer += `<td><span class="badge rounded-pill bg-label-${cliente.habilitado == 0 ? 'danger' : 'success'}">${cliente.habilitado == 0 ? 'Deshabilitado' : 'Habilitado'}</span></td>`
                buffer += `<td>`
                buffer += `<button type="button" class="btn btn-icon rounded-pill btn-text-primary" onclick="appModalClientes.open({mode: 2, did: '${cliente.did}'})" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver">`
                buffer += `<i class="tf-icons ri-eye-line ri-22px"></i>`
                buffer += `</button>`
                buffer += `<button type="button" class="btn btn-icon rounded-pill btn-text-primary" onclick="appModalClientes.open({mode: 1, did: '${cliente.did}'})" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar">`
                buffer += `<i class="tf-icons ri-pencil-line ri-22px"></i>`
                buffer += `</button>`
                buffer += `<button type="button" class="btn btn-icon rounded-pill btn-text-primary" onclick="appModalClientes.eliminar('${cliente.did}')" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar">`
                buffer += `<i class="tf-icons ri-delete-bin-6-line ri-22px"></i>`
                buffer += `</button>`
                buffer += `</td>`
                buffer += `</tr>`
            });

            $("#tbodyListado_clientes").html(buffer)
            $("#totalRegistros_clientes").text(g_meta.totalItems)
            $("#totalPaginas_clientes").text(g_meta.totalPages)
            globalActivarAcciones.tooltips({
                idContainer: "modulo_clientes"
            })

        }

        public.getListado = function({
            type = 0,
            orderBy = "",
            orderDir = ""
        } = {}) {
            openModulo = type;
            order = orderBy || order;
            direction = orderDir || direction;

            const parametros = {
                page: type === 1 ? 1 : public.paginaActual,
                page_size: public.limitePorPagina,
                sort_by: order,
                sort_dir: direction,
                codigo: $("#filtroCodigo_clientes").val(),
                nombre_fantasia: $("#filtroNombreFantasia_clientes").val(),
                razon_social: $("#filtroRazonSocial_clientes").val(),
                habilitado: $("#filtroEstado_clientes").val()
            };

            const queryString = $.param(parametros);

            globalRequest.get(`/${rutaAPI}?${queryString}`, {
                onSuccess: function(result) {
                    g_data = result.data;
                    g_meta = result.meta;
                    public.paginaActual = parseInt(g_meta.page);
                    renderListado();
                    globalPaginado.generar({
                        idBase: "_clientes",
                        meta: g_meta,
                        estructura: appModuloClientes
                    });
                },
            });
        };

        return public;
    })();
</script>
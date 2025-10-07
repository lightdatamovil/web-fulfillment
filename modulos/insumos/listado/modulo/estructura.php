<script>
    const appModuloInsumos = (function() {
        let g_data;
        let g_meta;
        let order = "";
        let direction = "";
        let openModulo = 0
        const rutaAPI = "insumos"

        const public = {};

        public.paginaActual = 1;
        public.limitePorPagina = 10;

        public.open = async function() {
            $(".winapp").hide();
            $("#modulo_insumos").show();
            await appModuloInsumos.getListado();
            await globalActivarAcciones.filtrarConEnter({
                className: "inputs_insumos",
                callback: appModuloInsumos.getListado
            })
            await globalOrdenTablas.activar({
                idThead: "theadListado_insumos",
                callback: appModuloInsumos.getListado,
                defaultOrder: "codigo"
            })
        };

        public.limpiarCampos = function() {
            $(".campos_insumos").val("")
        };

        function renderListado() {
            $("#tbodyListado_insumos").empty()
            let buffer = ""

            if (!g_data || g_data.length < 1) {
                globalSinInformacion.tablasVacias({
                    idTbody: "tbodyListado_insumos",
                    open: openModulo
                })
                return
            };

            g_data.forEach(insumo => {
                buffer += `<tr>`
                buffer += `<td>${insumo.codigo || "---"}</td>`
                buffer += `<td>${insumo.nombre || "---"}</td>`
                buffer += `<td><span class="badge rounded-pill bg-label-${insumo.habilitado == 0 ? 'danger' : 'success'}">${insumo.habilitado == 0 ? 'Deshabilitado' : 'Habilitado'}</span></td>`
                buffer += `<td>`
                buffer += `<button type="button" class="btn btn-icon rounded-pill btn-text-primary" onclick="appModalInsumos.open({mode: 2, did: '${insumo.did}'})" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver">`
                buffer += `<i class="tf-icons ri-eye-line ri-22px"></i>`
                buffer += `</button>`
                buffer += `<button type="button" class="btn btn-icon rounded-pill btn-text-primary" onclick="appModalInsumos.open({mode: 1, did: '${insumo.did}'})" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar">`
                buffer += `<i class="tf-icons ri-pencil-line ri-22px"></i>`
                buffer += `</button>`
                buffer += `<button type="button" class="btn btn-icon rounded-pill btn-text-primary" onclick="appModalInsumos.eliminar('${insumo.did}')" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar">`
                buffer += `<i class="tf-icons ri-delete-bin-6-line ri-22px"></i>`
                buffer += `</button>`
                buffer += `</td>`
                buffer += `</tr>`
            });

            $("#tbodyListado_insumos").html(buffer)
            $("#totalRegistros_insumos").text(g_meta.totalItems)
            $("#totalPaginas_insumos").text(g_meta.totalPages)
            globalActivarAcciones.tooltips({
                idContainer: "modulo_insumos"
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
                nombre: $("#filtroNombre_insumos").val(),
                codigo: $("#filtroCodigo_insumos").val(),
                habilitado: $("#filtroEstado_insumos").val()
            };

            const queryString = $.param(parametros);

            globalRequest.get(`/${rutaAPI}?${queryString}`, {
                onSuccess: function(result) {
                    g_data = result.data;
                    g_meta = result.meta;
                    public.paginaActual = parseInt(g_meta.page);
                    renderListado();
                    globalPaginado.generar({
                        idBase: "_insumos",
                        meta: g_meta,
                        estructura: appModuloInsumos
                    });
                },
            });
        };

        return public;
    })();
</script>
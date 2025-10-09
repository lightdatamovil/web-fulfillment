<script>
    const appModuloLogisticas = (function() {
        let g_data;
        let g_meta;
        let order = "";
        let direction = "";
        let openModulo = 0
        const rutaAPI = "logisticas"

        const public = {};

        public.paginaActual = 1;
        public.limitePorPagina = 10;

        public.open = async function() {
            $(".winapp").hide();
            $("#modulo_logisticas").show();
            await appModuloLogisticas.getListado();
            await globalActivarAcciones.filtrarConEnter({
                className: "inputs_logisticas",
                callback: appModuloLogisticas.getListado
            })
            await globalOrdenTablas.activar({
                idThead: "theadListado_logisticas",
                callback: appModuloLogisticas.getListado,
                defaultOrder: "codigo"
            })
        };

        public.limpiarCampos = function() {
            $(".campos_logisticas").val("")
        };

        function renderListado() {
            $("#tbodyListado_logisticas").empty()
            let buffer = ""

            if (!g_data || g_data.length < 1) {
                globalSinInformacion.tablasVacias({
                    idTbody: "tbodyListado_logisticas",
                    open: openModulo
                })
                return
            };

            g_data.forEach(logistica => {
                buffer += `<tr>`
                buffer += `<td>${logistica.codigo || "---"}</td>`
                buffer += `<td>${logistica.nombre || "---"}</td>`
                buffer += `<td><span class="badge rounded-pill bg-label-${logistica.logisticaLD == 1 ? 'success' : 'danger'}">${logistica.logisticaLD == 1 ? (logistica.codigoLD || "Sin codigo") : "NO"}</span></td>`
                buffer += `<td><span class="badge rounded-pill bg-label-${logistica.habilitado == 1 ? 'success': 'danger'}">${logistica.habilitado == 1 ? 'Habilitado' : 'Deshabilitado'}</span></td>`
                buffer += `<td>`
                buffer += `<button type="button" class="btn btn-icon rounded-pill btn-text-primary" onclick="appModalLogisticas.open({mode: 2, did: '${logistica.did}'})" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver">`
                buffer += `<i class="tf-icons ri-eye-line ri-22px"></i>`
                buffer += `</button>`
                buffer += `<button type="button" class="btn btn-icon rounded-pill btn-text-primary" onclick="appModalLogisticas.open({mode: 1, did: '${logistica.did}'})" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar">`
                buffer += `<i class="tf-icons ri-pencil-line ri-22px"></i>`
                buffer += `</button>`
                buffer += `<button type="button" class="btn btn-icon rounded-pill btn-text-primary" onclick="appModalLogisticas.eliminar('${logistica.did}')" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar">`
                buffer += `<i class="tf-icons ri-delete-bin-6-line ri-22px"></i>`
                buffer += `</button>`
                buffer += `</td>`
                buffer += `</tr>`
            });

            $("#tbodyListado_logisticas").html(buffer)
            $("#totalRegistros_logisticas").text(g_meta.totalItems)
            $("#totalPaginas_logisticas").text(g_meta.totalPages)
            globalActivarAcciones.tooltips({
                idContainer: "modulo_logisticas"
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
                nombre: $("#filtroNombre_logisticas").val(),
                codigo: $("#filtroCodigo_logisticas").val(),
                habilitado: $("#filtroEstado_logisticas").val(),
                logisticaLD: $("#filtroEsLightdata_logisticas").val()
            };

            const queryString = $.param(parametros);

            globalRequest.get(`/${rutaAPI}?${queryString}`, {
                onSuccess: function(result) {
                    g_data = result.data;
                    g_meta = result.meta;
                    public.paginaActual = parseInt(g_meta.page);
                    renderListado();
                    globalPaginado.generar({
                        idBase: "_logisticas",
                        meta: g_meta,
                        estructura: appModuloLogisticas
                    });
                },
            });
        };

        return public;
    })();
</script>
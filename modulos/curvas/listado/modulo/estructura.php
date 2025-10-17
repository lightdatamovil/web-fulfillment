<script>
    const appModuloCurvas = (function() {
        let g_data;
        let g_meta;
        let order = "";
        let direction = "";
        let openModulo = 0
        const rutaAPI = "curvas"

        const public = {};

        public.paginaActual = 1;
        public.limitePorPagina = 10;

        public.open = async function() {
            $(".winapp").hide();
            $("#modulo_curvas").show();
            appModuloCurvas.getListado();
            await globalActivarAcciones.filtrarConEnter({
                className: "inputs_curvas",
                callback: appModuloCurvas.getListado
            })
            await globalOrdenTablas.activar({
                idThead: "theadListado_curvas",
                callback: appModuloCurvas.getListado,
                defaultOrder: "codigo"
            })
        };

        public.limpiarCampos = function() {
            $(".campos_curvas").val("");
        };

        function renderListado() {
            $("#tbodyListado_curvas").empty()
            buffer = ""

            if (!g_data || g_data.length < 1) {
                globalSinInformacion.tablasVacias({
                    idTbody: "tbodyListado_curvas",
                    open: openModulo
                })
                return
            };

            g_data.forEach(curva => {
                buffer += `<tr>`
                buffer += `<td>${curva.codigo || "---"}</td>`
                buffer += `<td>${curva.nombre || "---"}</td>`
                buffer += `<td><span class="badge rounded-pill bg-label-${curva.habilitado != 1 ? 'danger' : 'success'}">${curva.habilitado != 1 ? 'Deshabilitado' : 'Habilitado'}</span></td>`
                buffer += `<td>`
                buffer += `<button type="button" class="btn btn-icon rounded-pill btn-text-primary" onclick="appModalCurvas.open({mode: 2, did: '${curva.did}'})" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver">`
                buffer += `<i class="tf-icons ri-eye-line ri-22px"></i>`
                buffer += `</button>`
                buffer += `<button type="button" class="btn btn-icon rounded-pill btn-text-primary" onclick="appModalCurvas.open({mode: 1, did: '${curva.did}'})" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar">`
                buffer += `<i class="tf-icons ri-pencil-line ri-22px"></i>`
                buffer += `</button>`
                buffer += `<button type="button" class="btn btn-icon rounded-pill btn-text-primary" onclick="appModalCurvas.eliminar('${curva.did}')" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar">`
                buffer += `<i class="tf-icons ri-delete-bin-6-line ri-22px"></i>`
                buffer += `</button>`
                buffer += `</td>`
                buffer += `</tr>`
            });

            $("#tbodyListado_curvas").html(buffer)
            $("#totalRegistros_curvas").text(g_meta.totalRegistros)
            $("#totalPaginas_curvas").text(g_meta.totalPaginas)
            globalActivarAcciones.tooltips({
                idContainer: "modulo_curvas"
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
                nombre: $("#filtroNombre_curvas").val(),
                codigo: $("#filtroCodigo_curvas").val(),
                habilitado: $("#filtroEstado_curvas").val()
            };

            const queryString = $.param(parametros);

            globalRequest.get(`/${rutaAPI}?${queryString}`, {
                onSuccess: function(result) {
                    g_data = result.data;
                    g_meta = result.meta;
                    public.paginaActual = parseInt(g_meta.page);
                    renderListado();
                    globalPaginado.generar({
                        idBase: "_curvas",
                        meta: g_meta,
                        estructura: appModuloCurvas
                    });
                },
            });
        };

        return public;
    })();
</script>
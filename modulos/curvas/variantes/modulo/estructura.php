<script>
    const appModuloVariantes = (function() {
        let g_data;
        let g_meta;
        let order = "";
        let direction = "";
        let openModulo = 0
        const rutaAPI = "variantes"

        const public = {};

        public.paginaActual = 1;
        public.limitePorPagina = 10;

        public.open = async function() {
            $(".winapp").hide();
            $("#modulo_variantes").show();
            appModuloVariantes.getListado();
            await globalActivarAcciones.filtrarConEnter({
                className: "inputs_variantes",
                callback: appModuloVariantes.getListado
            })
            await globalOrdenTablas.activar({
                idThead: "theadListado_variantes",
                callback: appModuloVariantes.getListado,
                defaultOrder: "codigo"
            })
        };

        public.limpiarCampos = function() {
            $(".campos_variantes").val("");
        };

        function renderListado() {
            $("#tbodyListado_variantes").empty()
            buffer = ""

            if (!g_data || g_data.length < 1) {
                globalSinInformacion.tablasVacias({
                    idTbody: "tbodyListado_variantes",
                    open: openModulo
                })
                return
            };

            g_data.forEach(variante => {
                buffer += `<tr>`
                buffer += `<td>${variante.codigo || "---"}</td>`
                buffer += `<td>${variante.nombre || "---"}</td>`
                buffer += `<td>${variante.descripcion || "---"}</td>`
                buffer += `<td><span class="badge rounded-pill bg-label-${variante.habilitado == 0 ? 'danger' : 'success'}">${variante.habilitado == 0 ? 'Deshabilitado' : 'Habilitado'}</span></td>`
                buffer += `<td>`
                buffer += `<button type="button" class="btn btn-icon rounded-pill btn-text-primary" onclick="appModalVariantes.open({mode: 2, did: '${variante.did}'})" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver">`
                buffer += `<i class="tf-icons ri-eye-line ri-22px"></i>`
                buffer += `</button>`
                buffer += `<button type="button" class="btn btn-icon rounded-pill btn-text-primary" onclick="appModalVariantes.open({mode: 1, did: '${variante.did}'})" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar">`
                buffer += `<i class="tf-icons ri-pencil-line ri-22px"></i>`
                buffer += `</button>`
                buffer += `<button type="button" class="btn btn-icon rounded-pill btn-text-primary" onclick="appModalVariantes.eliminar('${variante.did}')" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar">`
                buffer += `<i class="tf-icons ri-delete-bin-6-line ri-22px"></i>`
                buffer += `</button>`
                buffer += `</td>`
                buffer += `</tr>`
            });

            $("#tbodyListado_variantes").html(buffer)
            $("#totalRegistros_variantes").text(g_meta.totalRegistros)
            $("#totalPaginas_variantes").text(g_meta.totalPaginas)
            globalActivarAcciones.tooltips({
                idContainer: "modulo_variantes"
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
                nombre: $("#filtroNombre_variantes").val(),
                codigo: $("#filtroCodigo_variantes").val(),
                habilitado: $("#filtroEstado_variantes").val()
            };

            const queryString = $.param(parametros);

            globalRequest.get(`/${rutaAPI}?${queryString}`, {
                onSuccess: function(result) {
                    g_data = result.data;
                    g_meta = result.meta;
                    public.paginaActual = parseInt(g_meta.page);
                    renderListado();
                    globalPaginado.generar({
                        idBase: "_variantes",
                        meta: g_meta,
                        estructura: appModuloVariantes
                    });
                },
            });
        };

        return public;
    })();
</script>
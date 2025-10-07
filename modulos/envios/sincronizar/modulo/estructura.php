<script>
    const appModuloEnviosSincronizar = (function() {
        let g_data;
        let g_meta;
        let order = "";
        let direction = "";
        let openModulo = 0
        const rutaAPI = "enviosSincronizacion"

        const public = {};

        public.paginaActual = 1;
        public.limitePorPagina = 10;

        public.open = async function() {
            $(".winapp").hide();
            $("#modulo_enviosSincronizar").show();
            await appModuloEnviosSincronizar.getListado();
            await globalActivarAcciones.filtrarConEnter({
                className: "inputs_enviosSincronizar",
                callback: appModuloEnviosSincronizar.getListado
            })
            await globalOrdenTablas.activar({
                idThead: "theadListado_enviosSincronizar",
                callback: appModuloEnviosSincronizar.getListado,
                defaultOrder: "codigo"
            })
        };

        public.limpiarCampos = function() {
            $(".campos_enviosSincronizar").val("")
        };

        function renderListado() {
            $("#tbodyListado_enviosSincronizar").empty()
            let buffer = ""

            if (!g_data || g_data.length < 1) {
                globalSinInformacion.tablasVacias({
                    idTbody: "tbodyListado_enviosSincronizar",
                    open: openModulo
                })
                return
            };

            g_data.forEach(envio => {
                buffer += `<tr>`
                buffer += `<td>${envio.codigo || "---"}</td>`
                buffer += `<td>${envio.nombre || "---"}</td>`
                buffer += `<td><span class="badge rounded-pill bg-label-${envio.habilitado == 0 ? 'danger' : 'success'}">${envio.habilitado == 0 ? 'Deshabilitado' : 'Habilitado'}</span></td>`
                buffer += `<td>`
                buffer += `<button type="button" class="btn btn-icon rounded-pill btn-text-primary" onclick="appModalEnviosSincronizar.open({mode: 2, did: '${envio.did}'})" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver">`
                buffer += `<i class="tf-icons ri-eye-line ri-22px"></i>`
                buffer += `</button>`
                buffer += `<button type="button" class="btn btn-icon rounded-pill btn-text-primary" onclick="appModalEnviosSincronizar.open({mode: 1, did: '${envio.did}'})" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar">`
                buffer += `<i class="tf-icons ri-pencil-line ri-22px"></i>`
                buffer += `</button>`
                buffer += `<button type="button" class="btn btn-icon rounded-pill btn-text-primary" onclick="appModalEnviosSincronizar.eliminar('${envio.did}')" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar">`
                buffer += `<i class="tf-icons ri-delete-bin-6-line ri-22px"></i>`
                buffer += `</button>`
                buffer += `</td>`
                buffer += `</tr>`
            });

            $("#tbodyListado_enviosSincronizar").html(buffer)
            $("#totalRegistros_enviosSincronizar").text(g_meta.totalItems)
            $("#totalPaginas_enviosSincronizar").text(g_meta.totalPages)
            globalActivarAcciones.tooltips({
                idContainer: "modulo_enviosSincronizar"
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
                nombre: $("#filtroNombre_enviosSincronizar").val(),
                codigo: $("#filtroCodigo_enviosSincronizar").val(),
                habilitado: $("#filtroEstado_enviosSincronizar").val()
            };

            const queryString = $.param(parametros);

            globalRequest.get(`/${rutaAPI}?${queryString}`, {
                onSuccess: function(result) {
                    g_data = result.data;
                    g_meta = result.meta;
                    public.paginaActual = parseInt(g_meta.page);
                    renderListado();
                    globalPaginado.generar({
                        idBase: "_enviosSincronizar",
                        meta: g_meta,
                        estructura: appModuloEnviosSincronizar
                    });
                },
            });
        };

        return public;
    })();
</script>
<script>
    const appModuloProductos = (function() {
        let g_data;
        let g_meta;
        let order = "";
        let direction = "";
        let openModulo = 0
        const rutaAPI = "productos"

        const public = {};

        public.paginaActual = 1;
        public.limitePorPagina = 10;

        public.open = async function() {
            $(".winapp").hide();
            $("#modulo_productos").show();

            await globalLlenarSelect.clientes({
                id: "filtroClientes_productos",
                multiple: true
            })

            await globalActivarAcciones.select2({
                className: "select2_productos"
            })

            await appModuloProductos.getListado();

            await globalActivarAcciones.filtrarConEnter({
                className: "inputs_productos",
                callback: appModuloProductos.getListado
            })

            await globalOrdenTablas.activar({
                idThead: "theadListado_productos",
                callback: appModuloProductos.getListado,
                defaultOrder: "titulo"
            })
        };

        public.limpiarCampos = function() {
            $(".campos_productos").val("")
            $(".select2_productos").trigger("change")
        };

        function renderListado() {
            $("#tbodyListado_productos").empty()
            let buffer = ""

            if (!g_data || g_data.length < 1) {
                globalSinInformacion.tablasVacias({
                    idTbody: "tbodyListado_productos",
                    open: openModulo
                })
                return
            };

            g_data.forEach(producto => {
                cliente = appSistema.clientes.find((cliente) => cliente.did == producto.did_cliente).nombre_fantasia;

                buffer += `<tr>`
                buffer += `<td>${cliente || "---"}</td>`
                buffer += `<td>${producto.titulo || "---"}</td>`
                buffer += `<td>${producto.sku || "---"}</td>`
                buffer += `<td><span class="badge rounded-pill bg-label-${producto.habilitado == 1 ? 'success' : 'danger'}">${producto.habilitado == 1 ? 'Habilitado' : 'Deshabilitado'}</span></td>`
                buffer += `<td>`
                buffer += `<button type="button" class="btn btn-icon rounded-pill btn-text-primary" onclick="appModalProductos.open({mode: 2, did: '${producto.did}'})" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver">`
                buffer += `<i class="tf-icons ri-eye-line ri-22px"></i>`
                buffer += `</button>`
                buffer += `<button type="button" class="btn btn-icon rounded-pill btn-text-primary" onclick="appModalProductos.open({mode: 1, did: '${producto.did}'})" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar">`
                buffer += `<i class="tf-icons ri-pencil-line ri-22px"></i>`
                buffer += `</button>`
                buffer += `<button type="button" class="btn btn-icon rounded-pill btn-text-primary" onclick="appModalProductos.eliminar('${producto.did}')" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar">`
                buffer += `<i class="tf-icons ri-delete-bin-6-line ri-22px"></i>`
                buffer += `</button>`
                buffer += `</td>`
                buffer += `</tr>`
            });

            $("#tbodyListado_productos").html(buffer)
            $("#totalRegistros_productos").text(g_meta.totalItems)
            $("#totalPaginas_productos").text(g_meta.totalPages)
            globalActivarAcciones.tooltips({
                idContainer: "modulo_productos"
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
                did_cliente: $("#filtroClientes_productos").val(),
                titulo: $("#filtroTitulo_productos").val(),
                sku: $("#filtroSku_productos").val(),
                habilitado: $("#filtroEstado_productos").val()
            };

            const queryString = $.param(parametros);

            globalRequest.get(`/${rutaAPI}?${queryString}`, {
                onSuccess: function(result) {
                    g_data = result.data;
                    g_meta = result.meta;
                    public.paginaActual = parseInt(g_meta.page);
                    renderListado();
                    globalPaginado.generar({
                        idBase: "_productos",
                        meta: g_meta,
                        estructura: appModuloProductos
                    });
                },
            });
        };

        return public;
    })();
</script>
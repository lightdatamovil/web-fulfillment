<script>
    const appProductosListado = (function() {
        let g_data;
        let paginaActual = 1;
        let totalPaginas = 1;
        let limitePorPagina = 10;
        let openModulo = 0

        const public = {};

        public.open = function() {
            $(".winapp").hide();
            $("#ContainerProductosListado").show();
            appProductosListado.getListado();
            globalLlenarSelect.clientes("filtroClientes_productos")
            globalActivarAcciones.filtrarConEnter("inputs_productos", () => appProductosListado.getListado(1))
        };

        public.limpiarCampos = function() {
            $("#filtroSku_productos").val("");
            $("#filtroTitulo_productos").val("");
            $("#filtroClientes_productos").val("");
        };

        function renderListado() {
            $("#tbodyListado_productos").empty()
            buffer = ""

            if (!g_data.data || g_data.data.length < 1) {
                globalSinInformacion.tablasVacias("tbodyListado_productos", openModulo)
                return
            };

            g_data.data.forEach(producto => {
                htmlHabilitado = `<span class="badge rounded-pill bg-label-success">Habilitado</span>`
                htmlDeshabilitado = `<span class="badge rounded-pill bg-label-danger">Deshabilitado</span>`

                cliente = appSistema.clientes.find((cliente) => cliente.did == producto.didCliente);

                buffer += `<tr>`
                buffer += `<td>${cliente ? cliente["nombre_fantasia"] : '---'}</td>`
                buffer += `<td>${producto.titulo || '---'}</td>`
                buffer += `<td>${producto.sku || '---'}</td>`
                buffer += `<td>${producto.ean || '---'}</td>`
                buffer += `<td>${producto.habilitado == 0 ? htmlDeshabilitado : htmlHabilitado}</td>`
                buffer += `<td>`
                buffer += `<button type="button" class="btn btn-icon rounded-pill btn-text-primary" onclick="appProducto.open(2, '${producto.did}')" title="Ver">`
                buffer += `<i class="tf-icons ri-eye-line ri-22px"></i>`
                buffer += `</button>`
                buffer += `<button type="button" class="btn btn-icon rounded-pill btn-text-primary" onclick="appProducto.open(1, '${producto.did}')" title="Editar">`
                buffer += `<i class="tf-icons ri-pencil-line ri-22px"></i>`
                buffer += `</button>`
                buffer += `<button type="button" class="btn btn-icon rounded-pill btn-text-primary" onclick="appProducto.eliminar('${producto.did}')" title="Eliminar">`
                buffer += `<i class="tf-icons ri-delete-bin-6-line ri-22px"></i>`
                buffer += `</button>`
                buffer += `</td>`
                buffer += `</tr>`
            });

            $("#tbodyListado_productos").html(buffer)
            $("#totalRegistros_productos").text(g_data.totalRegistros)
            $("#totalPaginas_productos").text(g_data.totalPaginas)

        }

        public.getListado = function(type) {
            openModulo = type
            sku = $("#filtroSku_productos").val();
            titulo = $("#filtroTitulo_productos").val();
            cliente = $("#filtroClientes_productos").val();

            const parametros = {
                "idEmpresa": appSistema.idEmpresa,
                "pagina": type == 1 ? 1 : paginaActual,
                "cantidad": limitePorPagina,
                "sku": sku,
                "titulo": titulo,
                "cliente": cliente,
            };

            globalLoading.open()
            $.ajax({
                url: `${appSistema.urlServer}/producto/getProductos`,
                type: "POST",
                data: JSON.stringify(parametros),
                contentType: "application/json",
                headers: {
                    "Authorization": `Bearer ${appSistema.tkn}`
                },
                success: function(result) {
                    g_data = result

                    if (g_data.estado && g_data.data) {
                        paginaActual = parseInt(g_data.pagina);
                        totalPaginas = parseInt(g_data.totalPaginas);
                        renderListado();

                        globalPaginado.generarFooter({
                            idBase: "_productos",
                            totalRegistros: g_data.totalRegistros,
                            totalPaginas: g_data.totalPaginas,
                            paginaActual: g_data.pagina,
                            limitePorPagina: g_data.cantidad,
                            onPageChange: (pagina) => {
                                paginaActual = pagina;
                                public.getListado();
                            },
                            onLimiteChange: (nuevoLimite) => {
                                limitePorPagina = nuevoLimite;
                                paginaActual = 1;
                                public.getListado();
                            }
                        });

                    }
                    globalLoading.close()

                },
                error: function() {
                    globalLoading.close()
                    globalSweetalert.error()
                },
                complete: function() {
                    globalLoading.close()
                }
            });
        };

        return public;
    })();
</script>
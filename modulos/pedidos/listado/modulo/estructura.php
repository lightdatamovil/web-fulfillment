<script>
	const appModuloPedidos = (function() {
		let g_data;
		let g_meta;
		let order = "";
		let direction = "";
		let openModulo = 0
		const rutaAPI = "pedidos"

		const public = {};

		public.paginaActual = 1;
		public.limitePorPagina = 10;

		public.open = async function() {
			$(".winapp").hide();
			$("#modulo_pedidos").show();

			await globalLlenarSelect.clientes({
				id: "filtroClientes_pedidos",
				multiple: true
			})

			await globalLlenarSelect.estadosPedidos({
				id: "filtroEstado_pedidos",
				multiple: true
			})

			await globalLlenarSelect.tiendas({
				id: "filtroOrigen_pedidos",
				multiple: true
			})

			await globalActivarAcciones.select2({
				className: "select2_pedidos"
			})

			await appModuloPedidos.getListado();

			await globalActivarAcciones.filtrarConEnter({
				className: "inputs_pedidos",
				callback: appModuloPedidos.getListado
			})

			await globalOrdenTablas.activar({
				idThead: "theadListado_pedidos",
				callback: appModuloPedidos.getListado,
				defaultOrder: "fecha"
			})
		};

		public.limpiarCampos = function() {
			$(".campos_pedidos").val("")
			$(".select2_pedidos").trigger("change")
		};

		function renderListado() {
			$("#tbodyListado_pedidos").empty()
			let buffer = ""

			if (!g_data || g_data.length < 1) {
				globalSinInformacion.tablasVacias({
					idTbody: "tbodyListado_pedidos",
					open: openModulo
				})
				return
			};

			g_data.forEach(pedido => {
				const cliente = appSistema.clientes.find(c => c.did == pedido.did_cliente)?.nombre_fantasia || "<b>Cliente eliminado</b>";

				htmlEstado = pedido.estado || "---"
				if (pedido.estado && appSistema.estadosPedidos[pedido.estado]) {
					htmlEstado = `<span class="badge rounded-pill bg-label-${appSistema.estadosPedidos[pedido.estado]["color"]}">${appSistema.estadosPedidos[pedido.estado]["traduccion"]}</span>`
				}

				buffer += `<tr>`
				buffer += `<td>${cliente || '---'}</td>`
				buffer += `<td>${ pedido.fecha ? globalFuncionesJs.formatearFecha({fecha: pedido.fecha, para: "frontend"}) : '---'}</td>`
				buffer += `<td>${appSistema.ecommerce[pedido.flex] || '---'}</td>`
				buffer += `<td>${pedido.id_venta || '---'}</td>`
				// buffer += `<td class="text-wrap">${pedido.comprador || '---'}</td>`
				buffer += `<td>${htmlEstado}</td>`
				// buffer += `<td>${pedido.total ? globalFuncionesJs.convertirPrecio(pedido.total) : '---'}</td>`
				buffer += `<td class="text-center"><span class="badge badge-center rounded-pill bg-label-${pedido.armado == 1 ? "success" : "danger"}"><i class="ri-${pedido.armado == 1 ? "check" : "close-large"}-line"></i></span></td>`
				buffer += `<td class="text-center">${pedido.trabajado || '---'}</td>`
				buffer += `<td>`
				buffer += `<button type="button" class="btn btn-icon rounded-pill btn-text-primary" onclick="appModalPedidos.open({mode: 2, did: '${pedido.did}'})" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver">`
				buffer += `<i class="tf-icons ri-eye-line ri-22px"></i>`
				buffer += `</button>`
				buffer += `<button type="button" class="btn btn-icon rounded-pill btn-text-primary" onclick="appModalPedidos.open({mode: 1, did: '${pedido.did}'})" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar">`
				buffer += `<i class="tf-icons ri-pencil-line ri-22px"></i>`
				buffer += `</button>`
				buffer += `<button type="button" class="btn btn-icon rounded-pill btn-text-primary" onclick="appModalPedidos.eliminar('${pedido.did}')" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar">`
				buffer += `<i class="tf-icons ri-delete-bin-6-line ri-22px"></i>`
				buffer += `</button>`
				buffer += `</td>`
				buffer += `</tr>`
			});

			$("#tbodyListado_pedidos").html(buffer)
			$("#totalRegistros_pedidos").text(g_meta.totalItems)
			$("#totalPaginas_pedidos").text(g_meta.totalPages)
			globalActivarAcciones.tooltips({
				idContainer: "modulo_pedidos"
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
				id_venta: $("#filtroIdVenta_pedidos").val().trim(),
				comprador: $("#filtroComprador_pedidos").val().trim(),
				armado: $("#filtroArmado_pedidos").val(),
				trabajado: $("#filtroTrabajado_pedidos").val().trim(),
				did_cliente: $("#filtroClientes_pedidos").val().join(","),
				flex: $("#filtroOrigen_pedidos").val().join(","),
				estado: $("#filtroEstado_pedidos").val().join(","),
			};

			const queryString = $.param(parametros);

			globalRequest.get(`/${rutaAPI}?${queryString}`, {
				onSuccess: function(result) {
					g_data = result.data;
					g_meta = result.meta;
					public.paginaActual = parseInt(g_meta.page);
					renderListado();
					globalPaginado.generar({
						idBase: "_pedidos",
						meta: g_meta,
						estructura: appModuloPedidos
					});
				},
			});
		};

		return public;
	})();
</script>
<script>
	const appPedidosListado = (function() {
		let g_data;
		let paginaActual = 1;
		let totalPaginas = 1;
		let limitePorPagina = 10;
		let openModulo = 0

		const public = {};

		public.open = function() {
			$(".winapp").hide();
			$("#ContainerPedidosListado").show();
			globalLlenarSelect.clientes("filtroCliente_pedidos")
			globalLlenarSelect.estadosPedidos("filtroEstado_pedidos")
			globalLlenarSelect.tiendas("filtroOrigen_pedidos")
			appPedidosListado.getListado();
			globalActivarAcciones.filtrarConEnter("inputs_pedidos", () => appPedidosListado.getListado(1))
		};

		public.limpiarCampos = function() {
			$(".campos_pedidos").val("");
		};

		function renderListado() {
			$("#tbodyListado_pedidos").empty()
			buffer = ""

			if (!g_data.data || g_data.data.length < 1) {
				globalSinInformacion.tablasVacias("tbodyListado_pedidos", openModulo)
				return
			};

			g_data.data.forEach(pedido => {
				htmlArmado = `<span class="badge badge-center rounded-pill bg-success"><i class="ri-check-line"></i></span>`
				htmlNoArmado = `<span class="badge badge-center rounded-pill bg-danger"><i class="ri-close-large-line"></i></span>`

				htmlEstado = pedido.estado || "---"
				if (pedido.estado && appSistema.estadosPedidos[pedido.estado]) {
					htmlEstado = `<span class="badge rounded-pill bg-label-${appSistema.estadosPedidos[pedido.estado]["color"]}">${appSistema.estadosPedidos[pedido.estado]["traduccion"]}</span>`
				}

				buffer += `<tr>`
				buffer += `<td>${pedido.cliente || '---'}</td>`
				buffer += `<td>${pedido.fecha || '---'}</td>`
				buffer += `<td>${pedido.origen ? appSistema.ecommerce[pedido.origen] : '---'}</td>`
				buffer += `<td>${pedido.idVenta || '---'}</td>`
				buffer += `<td class="text-wrap">${pedido.comprador || '---'}</td>`
				buffer += `<td>${htmlEstado}</td>`
				buffer += `<td>${pedido.total ? globalFuncionesJs.convertirPrecio(pedido.total) : '---'}</td>`
				buffer += `<td>${pedido.armado == 1 ? htmlArmado : htmlNoArmado}</td>`
				buffer += `<td>${pedido.ot || '---'}</td>`
				buffer += `<td>`
				buffer += `<button type="button" class="btn btn-icon rounded-pill btn-text-primary" onclick="appPedido.open('${pedido.did}')" title="Ver">`
				buffer += `<i class="tf-icons ri-eye-line ri-22px"></i>`
				buffer += `</button>`
				buffer += `<button type="button" class="btn btn-icon rounded-pill btn-text-primary" onclick="appPedido.eliminar('${pedido.did}')" title="Eliminar">`
				buffer += `<i class="tf-icons ri-delete-bin-6-line ri-22px"></i>`
				buffer += `</button>`
				buffer += `</td>`
				buffer += `</tr>`
			});

			$("#tbodyListado_pedidos").html(buffer)
			$("#totalRegistros_pedidos").text(g_data.totalRegistros)
			$("#totalPaginas_pedidos").text(g_data.totalPaginas)

		}

		public.getListado = function(type) {
			openModulo = type
			cliente = $("#filtroCliente_pedidos").val();
			idVenta = $("#filtroIdVenta_pedidos").val().trim();
			comprador = $("#filtroComprador_pedidos").val().trim();
			estado = $("#filtroEstado_pedidos").val();
			armado = $("#filtroArmado_pedidos").val();
			origen = $("#filtroOrigen_pedidos").val();
			ot = $("#filtroOT_pedidos").val().trim();

			const parametros = {
				"idEmpresa": appSistema.idEmpresa,
				"pagina": type == 1 ? 1 : paginaActual,
				"cantidad": limitePorPagina,
				"cliente": cliente,
				"idVenta": idVenta,
				"comprador": comprador,
				"estado": estado,
				"armado": armado,
				"origen": origen,
				"ot": ot
			};

			globalLoading.open()
			$.ajax({
				url: `${appSistema.urlServer}/pedido/getPedidos`,
				type: "POST",
				data: JSON.stringify(parametros),
				contentType: "application/json",
				headers: {
					Authorization: `Bearer ${appSistema.tkn}`
				},
				success: function(result) {
					g_data = result

					if (g_data.estado && g_data.data) {
						paginaActual = parseInt(g_data.pagina);
						totalPaginas = parseInt(g_data.totalPaginas);
						renderListado();

						globalPaginado.generarFooter({
							idBase: "_pedidos",
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
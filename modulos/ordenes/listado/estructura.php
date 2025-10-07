<script>
	const appPedidosListado = (function() {
		let g_data;
		let paginaActual = 1;
		let totalPaginas = 1;
		let limitePorPagina = 10;

		const public = {};

		public.open = function() {
			$(".winapp").hide();
			$("#ContainerPedidosListado").show();
			globalLlenarSelect.clientes("filtroCliente_pedidos")
			globalLlenarSelect.estadosPedidos("filtroEstado_pedidos")
			globalLlenarSelect.tiendas("filtroOrigen_pedidos")
			appPedidosListado.getListado();
		};

		public.limpiarCampos = function() {
			$(".campos_pedidos").val("");
		};

		function renderListado() {
			const tbody = document.getElementById("tbodyListado_pedidos");
			tbody.innerHTML = "";

			if (!g_data.estado || !g_data.data) return;

			g_data.data.forEach(pedido => {
				const tr = document.createElement("tr");

				htmlArmado = `<span class="badge badge-center rounded-pill bg-success"><i class="ri-check-line"></i></span>`
				htmlNoArmado = `<span class="badge badge-center rounded-pill bg-danger"><i class="ri-close-large-line"></i></span>`
				htmlPrecio = `<span class="badge rounded-pill bg-label-success">${globalFuncionesJs.convertirPrecio(pedido.total)}</span>`

				tr.innerHTML = `
						<td>${pedido.cliente || '---'}</td>
						<td>${pedido.fecha || '---'}</td>
						<td>${pedido.origen || '---'}</td>
						<td>${pedido.idVenta || '---'}</td>
						<td>${pedido.estado || '---'}</td>
						<td>${pedido.total ? htmlPrecio : '---'}</td>
						<td>${pedido.armado == 1 ? htmlArmado : htmlNoArmado}</td>
						<td>${pedido.ot || '---'}</td>
                        <td>
                            <button type="button" class="btn btn-icon rounded-pill btn-text-primary" onclick="appPedidos.open(2, '${pedido.did}')" title="Ver">
                            <i class="tf-icons ri-eye-line ri-22px"></i>
                            </button>
                                <button type="button" class="btn btn-icon rounded-pill btn-text-primary" onclick="appPedidos.open(1, '${pedido.did}')" title="Editar">
                                <i class="tf-icons ri-pencil-line ri-22px"></i>
                            </button>
                                <button type="button" class="btn btn-icon rounded-pill btn-text-primary" onclick="appPedidos.eliminar('${pedido.did}')" title="Eliminar">
                                <i class="tf-icons ri-delete-bin-6-line ri-22px"></i>
                            </button>
                        </td>
                    `;
				tbody.appendChild(tr);
			});

			$("#totalRegistros_pedidos").text(g_data.totalRegistros)
			$("#totalPaginas_pedidos").text(g_data.totalPaginas)

		}

		public.getListado = function(type) {
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
				url: `${appSistema.urlServer}/pedidos/getpedidos`,
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
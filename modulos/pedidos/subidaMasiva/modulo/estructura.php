<script>
	const appPedidosSubidaMasiva = (function() {
		let g_data;
		let pedidosObtenidos = []
		let columnasHojaPedidos = ["Numero de tracking", "Fecha de venta", "Valor declarado", "Peso declarado", "Destinatario", "Teléfono de contacto", "Dirección", "Localidad", "Código postal", "Observaciones", "Email", "Total a cobrar", "Logistica Inversa"]
		let columnasHojaProductos = ["Numero de tracking", "SKU", "EAN", "Cantidad"]
		let iconosPedidos = {
			"Numero de tracking": "ri-truck-line",
			"Fecha de venta": "ri-calendar-line",
			"Valor declarado": "ri-money-dollar-circle-line",
			"Peso declarado": "ri-weight-line",
			"Destinatario": "ri-user-location-line",
			"Teléfono de contacto": "ri-phone-line",
			"Dirección": "ri-map-pin-line",
			"Localidad": "ri-community-line",
			"Código postal": "ri-map-2-line",
			"Observaciones": "ri-sticky-note-line",
			"Email": "ri-mail-line",
			"Total a cobrar": "ri-money-dollar-circle-line",
			"Logistica Inversa": "ri-loop-left-line"
		}
		const rutaAPI = "pedidos"


		const public = {};

		public.open = function() {
			$(".winapp").hide();
			$("#modulo_pedidosSubidaMasiva").show();
			globalLlenarSelect.clientes({
				id: "cliente_pedidosSubidaMasiva"
			})
			appPedidosSubidaMasiva.limpiarCampos()
		};

		public.limpiarCampos = function() {
			pedidosObtenidos = []
			$('#archivo_pedidosSubidaMasiva').val('')
			$('#cliente_pedidosSubidaMasiva').val('').change();
			$('#containerTable_pedidosSubidaMasiva').empty();
			$("#instrucciones_pedidosSubidaMasiva").css("display", "")
		}

		public.descargarModelo = function() {
			const hoja1 = [columnasHojaPedidos]
			const hoja2 = [columnasHojaProductos];
			globalExcel.crear("modelo_pedidos_subida_masiva.xlsx", {
				"pedidos": hoja1,
				"productos": hoja2
			});
		};


		public.subirExcel = async function() {
			const archivo = $('#archivo_pedidosSubidaMasiva')[0].files[0];

			if (archivo) {
				try {
					const datos = await globalExcel.leer(archivo);
					console.log('datos', datos);
					g_data = datos;
					for (arr in g_data) {
						g_data[arr].shift()
					}

					armarPedidos()
				} catch (err) {
					globalSweetalert.error({
						titulo: `Error al leer el archivo: ${err}`,
					});
				}
			} else {
				globalSweetalert.alert({
					titulo: "Debe seleccionar un archivo para subir"
				});
			}
		}

		function armarPedidos() {
			pedidosObtenidos = g_data.pedidos.map(pedidoArray => {
				let pedidoObj = columnasHojaPedidos.reduce((acc, key, index) => {
					acc[key] = pedidoArray[index] ?? null;
					return acc;
				}, {});

				let productosPedido = g_data.productos
					.filter(prod => prod[0] === pedidoArray[0])
					.map(prodArray => {
						return columnasHojaProductos.reduce((acc, key, index) => {
							acc[key] = prodArray[index] ?? null;
							return acc;
						}, {});
					});

				pedidoObj.productos = productosPedido;

				return pedidoObj;
			});

			renderTable()
		}


		function renderTable() {
			if (pedidosObtenidos.length < 1) {
				globalSweetalert.error({
					titulo: "Excel vacio o incorrecto"
				});
				$('#archivo_pedidosSubidaMasiva').val('');
				return
			}

			buffer = ""

			buffer += `<div class="accordion accordion-custom-button" id="containerAccordion_pedidosSubidaMasiva" style="height: 600px; overflow-y: auto; overflow-x:hidden;">`

			pedidosObtenidos.forEach(pedido => {
				buffer += `<div class="accordion-item rounded-0">`
				buffer += `<h2 class="accordion-header" id="heading_${pedido[columnasHojaPedidos[0]]}_pedidoSubidaMasiva">`
				buffer += `<button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#acorrdion_${pedido[columnasHojaPedidos[0]]}_pedidoSubidaMasiva" aria-expanded="false" aria-controls="acorrdion_${pedido[columnasHojaPedidos[0]]}_pedidoSubidaMasiva">`
				buffer += `<div class="d-flex gap-10">`

				columnasHojaPedidos.slice(0, 3).forEach(columna => {
					buffer += `<div class="d-flex align-items-center">`
					buffer += `<i class="${iconosPedidos[columna]} ri-24px"></i><span class="fw-medium mx-2">${columna}:</span>`
					item = columna == "Fecha de venta" ? formatearFechaExcel(pedido[columna]) : pedido[columna]
					buffer += `<span class="text-primary fw-bold">${item}</span>`
					buffer += `</div>`
				})

				buffer += `</div>`
				buffer += `</button>`
				buffer += `</h2>`

				buffer += `<div id="acorrdion_${pedido[columnasHojaPedidos[0]]}_pedidoSubidaMasiva" class="accordion-collapse collapse" aria-labelledby="heading_${pedido[columnasHojaPedidos[0]]}_pedidoSubidaMasiva">`
				buffer += `<div class="accordion-body p-0">`
				buffer += `<div class="col-12">`
				buffer += `<div class="row">`
				buffer += `<div class="col-5">`
				buffer += `<ul class="list-unstyled p-7 m-0">`

				columnasHojaPedidos.slice(3).forEach(columna => {
					buffer += `<li class="d-flex align-items-center mb-4">`
					buffer += `<i class="${iconosPedidos[columna]} ri-24px"></i><span class="fw-medium mx-2">${columna}:</span>`
					buffer += `<span class="text-primary fw-bold">${pedido[columna] || "---"}</span>`
					buffer += `</li>`
				})

				buffer += `</ul>`
				buffer += `</div>`
				buffer += `<div class="col-7">`
				buffer += `<div class="table-responsive text-nowrap table-container border-start" style="height: 450px;">`
				buffer += `<table class="table table-hover">`
				buffer += `<thead class="table-thead">`
				buffer += `<tr>`
				columnasHojaProductos.slice(1).forEach(columna => {
					buffer += `<th>${columna}</th>`
				})
				buffer += `</tr>`
				buffer += `</thead>`
				buffer += `<tbody>`

				pedido.productos.forEach(producto => {
					buffer += `<tr>`
					columnasHojaProductos.slice(1).forEach(columna => {
						buffer += `<td>${producto[columna] || "---"}</td>`
					})
					buffer += `</tr>`
				})

				buffer += `</tbody>`
				buffer += `</table>`
				buffer += `</div>`
				buffer += `</div>`
				buffer += `</div>`
				buffer += `</div>`
				buffer += `</div>`
				buffer += `</div>`
				buffer += `</div>`
			})

			buffer += `</div>`

			buffer += `<div class="card-footer border-top">`
			buffer += `<div class="col-12">`
			buffer += `<div class="row g-3 justify-content-end">`
			buffer += `<div class="col-12 col-md-6 col-lg-2">`
			buffer += `<button type="reset" class="btn btn-outline-danger w-100" onclick="appPedidosSubidaMasiva.limpiarCampos()"><span class=" tf-icons ri-close-circle-fill ri-19px me-2"></span>Cancelar</button>`
			buffer += `</div>`
			buffer += `<div class="col-12 col-md-6 col-lg-3">`
			buffer += `<button type="button" class="btn btn-success w-100" onclick="appPedidosSubidaMasiva.guardar()"><span class=" tf-icons ri-upload-cloud-2-fill ri-19px me-2"></span>Subir</button>`
			buffer += `</div>`
			buffer += `</div>`
			buffer += `</div>`
			buffer += `</div>`

			$("#instrucciones_pedidosSubidaMasiva").css("display", "none")
			$("#containerTable_pedidosSubidaMasiva").html(buffer)
		}

		function formatearFechaExcel(numero) {
			if (!numero) ""
			const utc_days = Math.floor(numero - 25569)
			const utc_value = utc_days * 86400
			const date_info = new Date(utc_value * 1000)

			const day = String(date_info.getUTCDate()).padStart(2, '0')
			const month = String(date_info.getUTCMonth() + 1).padStart(2, '0')
			const year = date_info.getUTCFullYear()

			return `${day}/${month}/${year}`
		}

		public.guardar = function() {
			const datos = {
				cliente: $("#cliente_pedidosSubidaMasiva").val(),
				pedidos: pedidosObtenidos
			};


			if (datos.cliente == "") {
				globalSweetalert.alert({
					titulo: "Debe seleccionar un cliente"
				});
				return;
			}

			if (datos.pedidos.length < 0) {
				globalSweetalert.alert({
					titulo: "Debe seleccionar un excel con al menos un pedido"
				});
				return;
			}


			globalSweetalert.confirmar({
					titulo: "¿Estas seguro de subir estos pedido?"
				})
				.then(function(confirmado) {
					if (confirmado) {
						globalRequest.post(`/${rutaAPI}`, datos, {
							onSuccess: function(result) {
								globalSweetalert.exito({
									titulo: "Pedidos subidos con exito!"
								});
								appPedidosSubidaMasiva.limpiarCampos()
							}
						});
					}
				});
		};

		return public;
	})();
</script>
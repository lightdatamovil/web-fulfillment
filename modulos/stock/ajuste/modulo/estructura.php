<script>
	const appModuloAjusteStock = (function() {
		let g_data = {};
		let numberedStepper;
		let stepperInicializado = false;
		let g_productosPorCliente = [];
		let g_productosPorCliente_filtado = [];
		let g_productoSeleccionado = {}
		let g_listadoMovimientos = []

		const rutaAPI = "stock/productos"

		const public = {};

		public.open = async function() {
			$(".winapp").hide();
			await resetModulo()
			await accionesStepper()

			await globalLlenarSelect.clientes({
				id: "cliente_ajusteStock"
			})

			await globalActivarAcciones.select2({
				className: "select2_ajusteStock"
			})

			$("#modulo_ajusteStock").show();
		};

		function resetModulo() {
			volverAlPrimerStep();
			$(".campos_ajusteStock").val("");
			g_data = {};
			g_productosPorCliente = [];
			g_productosPorCliente_filtado = [];
			g_productoSeleccionado = {}
			g_listadoMovimientos = []
			stepperInicializado = false

			globalValidar.limpiarTodas()
			globalValidar.deshabilitarTiempoReal({
				className: "camposObliStep1_ajusteStock"
			})
			globalValidar.deshabilitarTiempoReal({
				className: "camposObliStep2_ajusteStock"
			})
		};


		function accionesStepper() {
			const wizardNumbered = document.querySelector('#steps_ajusteStock');
			if (!wizardNumbered || stepperInicializado) return;

			const wizardNumberedBtnNextList = [].slice.call(wizardNumbered.querySelectorAll('.btn-next_ajusteStock'));
			const wizardNumberedBtnPrevList = [].slice.call(wizardNumbered.querySelectorAll('.btn-prev_ajusteStock'));
			const wizardNumberedBtnSubmit = wizardNumbered.querySelector('.btn-submit_ajusteStock');

			numberedStepper = new Stepper(wizardNumbered, {
				linear: false
			});

			stepperInicializado = true;

			if (wizardNumberedBtnNextList) {
				wizardNumberedBtnNextList.forEach((wizardNumberedBtnNext, index) => {
					wizardNumberedBtnNext.addEventListener('click', event => {
						if (index === 0) {
							verificarCamposStep1()
						}
					});
				});
			}

			if (wizardNumberedBtnPrevList) {
				wizardNumberedBtnPrevList.forEach(wizardNumberedBtnPrev => {
					wizardNumberedBtnPrev.addEventListener('click', event => {
						numberedStepper.previous();
					});
				});
			}

			if (wizardNumberedBtnSubmit) {
				wizardNumberedBtnSubmit.addEventListener('click', event => {});
			}
		}

		function volverAlPrimerStep() {
			if (numberedStepper) {
				numberedStepper.to(1);
			}
		}

		function validacionStep1() {
			return globalValidar.obligatorios({
				className: "camposObliStep1_ajusteStock"
			})
		}

		async function verificarCamposStep1() {
			g_data = {
				ajuste: $('input[name="opcionAjuste_ajusteStock"]:checked').val(),
				cliente: $("#cliente_ajusteStock").val() || null,
				fecha: $("#fecha_ajusteStock").val() || "",
				observacion: $("#observacion_ajusteStock").val().trim() || "",
			};

			await globalValidar.habilitarTiempoReal({
				className: "camposObliStep1_ajusteStock",
				callback: validacionStep1
			})

			if (validacionStep1()) {
				globalSweetalert.alert({
					titulo: "Verifique los campos"
				})
				return
			} else {
				g_productosPorCliente = await appSistema.productos.filter(p => p.did_cliente == g_data.cliente)
				g_productosPorCliente_filtado = [...g_productosPorCliente]
				if (g_productosPorCliente.length < 1) {
					await globalSweetalert.alert({
						titulo: "Cliente sin productos"
					})
					return
				} else {
					await renderListadoProductos()
				}

				await numberedStepper.next();
			}
		}

		public.searchProducto = function() {
			let valor = $("#searchProducto_ajusteStock").val()
			g_productosPorCliente_filtado = g_productosPorCliente.filter(p => p.titulo.toLowerCase().includes(valor.toLowerCase()) || p.sku.toLowerCase().includes(valor.toLowerCase()))
			renderListadoProductos()
		}

		function renderListadoProductos() {
			$("#tbodyListado_ajusteStock").empty()
			$("#nombreDelCliente_ajusteStock").html(appSistema.clientes.find(c => c.did == g_data.cliente)?.nombre_fantasia || "Desconocido")
			$("#tipoDeMovimiento_ajusteStock").html(appSistema.ajusteStock[g_data.ajuste]?.nombre || "Desconocido")


			let buffer = ""

			g_productosPorCliente_filtado.forEach(producto => {
				buffer += `<tr>`
				buffer += `<td>`
				buffer += `<div class="d-flex justify-content-between align-items-center">`
				buffer += `<div class="d-flex justify-content-start align-items-center">`
				buffer += `<div class="avatar-wrapper me-3">`
				buffer += `<div class="avatar rounded-3 bg-label-secondary"><img src="${producto.imagen}" style="object-fit: cover;" onerror="this.onerror=null; this.src='../../assets/img/extras/imagenDefault.jpg';" alt="" class="rounded-2"></div>`
				buffer += `</div>`
				buffer += `<div class="d-flex flex-column">`
				buffer += `<span class="text-nowrap text-heading fw-medium">${producto.titulo}</span>`
				buffer += `<small class="text-truncate d-none d-sm-block">SKU: ${producto.sku}</small>`
				buffer += `</div>`
				buffer += `</div>`
				buffer += `<div class="d-flex justify-content-end align-items-center gap-3">`
				buffer += `<small class="text-truncate d-none d-sm-block">Stock: <b>${producto.stock_producto || 0}</b></small>`
				buffer += `<button type="button" onclick="appModuloAjusteStock.renderProductoSeleccionado(${producto.did})" class="btn btn-sm btn-icon btn-outline-secondary waves-effect">`
				buffer += `<span class="tf-icons ri-arrow-right-s-line ri-22px"></span>`
				buffer += `</button>`
				buffer += `</div>`
				buffer += `</div>`
				buffer += `</td>`
				buffer += `</tr>`
			})

			$("#tbodyListado_ajusteStock").html(buffer)
		}

		public.renderProductoSeleccionado = function(did) {
			let buffer = ""
			g_productoSeleccionado = g_productosPorCliente.find(p => p.did == did)

			if (!g_productoSeleccionado) {
				$("#containerProductoSeleccionado_ajusteStock").html(`<span class="text-nowrap text-heading fw-medium">Seleccione un producto</span>`)
				globalSweetalert.alert({
					titulo: "Hubo un error al seleccionar el producto"
				})
				return
			}

			buffer += `<div class="d-flex justify-content-start align-items-center">`
			buffer += `<div class="avatar-wrapper me-3">`
			buffer += `<div class="avatar rounded-3 bg-label-secondary"><img src="${g_productoSeleccionado.imagen}" style="object-fit: cover;" onerror="this.onerror=null; this.src='../../assets/img/extras/imagenDefault.jpg';" alt="" class="rounded-2"></div>`
			buffer += `</div>`
			buffer += `<div class="d-flex flex-column">`
			buffer += `<span class="text-nowrap text-heading fw-medium">${g_productoSeleccionado.titulo}</span>`
			buffer += `<small class="text-truncate d-none d-sm-block">SKU: ${g_productoSeleccionado.sku}</small>`
			buffer += `</div>`
			buffer += `</div>`
			buffer += `<div>`
			buffer += `<small class="text-truncate d-none d-sm-block">Stock total actual: <b>${g_productoSeleccionado.stock || 0}</b></small>`
			buffer += `</div>`

			globalValidar.limpiarTodas()
			globalValidar.deshabilitarTiempoReal({
				className: "camposObliStep2_ajusteStock"
			})

			$("#cantidad_ajusteStock").val("")
			$("#cantidad_ajusteStock, #btnAgregar_ajusteStock").prop("disabled", false)
			$("#containerProductoSeleccionado_ajusteStock").html(buffer)
			renderVariantes()
			renderIdentificadoresEspeciales()
		}

		function renderVariantes() {
			let variantes = obtenerVariantes({
				didProducto: g_productoSeleccionado.did
			});

			let buffer = ""

			if (variantes.length > 0) {
				buffer += `<option value="">Seleccionar variante</option>`
				variantes.forEach(v => buffer += `<option value="${v.did_producto_variante_valor}">${v.variante_descripcion} (Stock: ${v.stock_combinacion || 0})</option>`);
				$("#combinacion_ajusteStock").prop("disabled", false).html(buffer);
			} else {
				$("#combinacion_ajusteStock").prop("disabled", true).html('<option value="">Selecciona el producto para ver</option>');
			}
		};

		function obtenerVariantes({
			didProducto
		}) {
			const producto = appSistema.productos.find(p => p.did == didProducto);

			const retornoDefault = () => [{
				did_producto_variante_valor: "default",
				variante_descripcion: "Default"
			}];

			if (!producto) return retornoDefault();

			const {
				titulo,
				did_curva,
				valores
			} = producto;
			if (!did_curva || !valores?.length) return retornoDefault();

			const curva = appSistema.curvas.find(c => c.did == did_curva);
			if (!curva) return retornoDefault();

			return valores.map(grupo => {
				const partes = grupo.valores.map(valorDid => {
					for (const categoria of curva.categorias) {
						const variante = appSistema.variantes.find(v => v.did == categoria.did_variante);
						const valorEncontrado = categoria.valores.find(v => v.did == valorDid);
						if (valorEncontrado) {
							return `${variante?.nombre || "Variante desconocida"}: ${valorEncontrado.nombre}`;
						}
					}
					return null;
				}).filter(Boolean);

				return {
					did_producto_variante_valor: grupo.did_productos_variantes_valores,
					variante_descripcion: partes.join(" | ") || titulo || "Sin información",
					stock_combinacion: grupo.stock_combinacion
				};
			});
		}

		function renderIdentificadoresEspeciales() {
			$("#containerIdentificadoresEspeciales").empty()
			let buffer = ""

			if (g_productoSeleccionado.dids_ie.length > 0) {
				buffer += `<div class="row g-5">`
				g_productoSeleccionado.dids_ie.forEach((ie_producto) => {
					let campo = appSistema.identificadoresEspeciales.find(ie => ie.did == ie_producto)
					if (!campo) return;

					buffer += `<div class="col-12 col-md-12 col-lg-12">`
					buffer += `<div class="form-floating form-floating-outline">`
					buffer += `<input class="form-control campos_ajusteStock camposObliStep2_ajusteStock camposIdentificadoresEspeciales_ajusteStock" data-did="${campo.did}" type="${appSistema.tiposIdentificadoresEspeciales[campo.tipo]?.input || "text"}" id="identificadorEspecial_${campo.did}_ajusteStock" />`
					buffer += `<label for="identificadorEspecial_${campo.did}_ajusteStock">${campo.nombre}</label>`
					buffer += `<div class="invalid-feedback"> Debe completar el campo </div>`
					buffer += `</div>`
					buffer += `</div>`
				})

				buffer += `</div>`
				$("#containerIdentificadoresEspeciales").removeClass("ocultar").html(buffer)
			} else {
				$("#containerIdentificadoresEspeciales").addClass("ocultar").html(buffer)
			}
		}

		function validacionStep2() {
			return globalValidar.obligatorios({
				className: "camposObliStep2_ajusteStock"
			})
		}

		public.verificarCamposStep2 = function() {
			globalValidar.habilitarTiempoReal({
				className: "camposObliStep2_ajusteStock",
				callback: validacionStep2
			})

			if (validacionStep2()) {
				globalSweetalert.alert({
					titulo: "Verifique los campos"
				})
				return
			} else {
				agregarMovimiento()
			}
		}

		function agregarMovimiento() {
			const identificadores = [];

			$('.camposIdentificadoresEspeciales_ajusteStock').each(function() {
				const did = $(this).data('did');
				const valor = $(this).val();
				identificadores.push({
					did,
					valor
				});
			});

			let variantes = obtenerVariantes({
				didProducto: g_productoSeleccionado.did
			});


			let columnaIE = ""
			identificadores.forEach((camposIE) => {
				let identificador = appSistema.identificadoresEspeciales.find(ie => ie.did == camposIE.did)
				columnaIE += `${identificador.nombre}: ${identificador.tipo == 2 ? globalFuncionesJs.formatearFecha({fecha: camposIE.valor, para: "frontend"}).slice(0, 10) : camposIE.valor}<br>`
			})

			let did_combinacion = $("#combinacion_ajusteStock").val()

			const data = {
				did_producto: g_productoSeleccionado.did,
				combinaciones: [{
					did_combinacion,
					cantidad: $("#cantidad_ajusteStock").val(),
					identificadores_especiales: identificadores
				}],
				render: {
					nombreProducto: g_productoSeleccionado.titulo || "Desconocido",
					combinacion: variantes?.find(v => v.did_producto_variante_valor == did_combinacion)?.variante_descripcion || "Desconocido",
					identificadores_especiales: columnaIE || "No tiene",
					cantidad: $("#cantidad_ajusteStock").val(),
				}
			}

			g_listadoMovimientos.push(data)
			renderListadoMovimientos()
		}

		function renderListadoMovimientos() {
			$("#tbodyListaStock_ajusteStock").empty()
			let buffer = ""

			if (!g_listadoMovimientos || g_listadoMovimientos.length < 1) {
				$("#tbodyListaStock_ajusteStock").html(`<tr><td colspan="5"><div class="d-flex justify-content-center"><span class="badge rounded-pill bg-label-primary px-6">Sin stock nuevo</span></div></td></tr>`)
				return
			};

			g_listadoMovimientos.forEach((item, index) => {
				buffer += `<tr>`
				buffer += `<td>${item.render.nombreProducto}</td>`
				buffer += `<td>${item.render.combinacion}</td>`
				buffer += `<td>${item.render.identificadores_especiales}</td>`
				buffer += `<td>${item.render.cantidad}</td>`

				buffer += `<td>`
				buffer += `<button type="button" class="btn btn-icon rounded-pill btn-text-warning" onclick="appModuloAjusteStock.desestimarLinea(${index})" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar">`
				buffer += `<i class="tf-icons ri-delete-back-2-line ri-22px"></i>`
				buffer += `</button>`
				buffer += `</td>`

				buffer += `</tr>`
			});

			$("#tbodyListaStock_ajusteStock").html(buffer)

			globalActivarAcciones.tooltips({
				idContainer: "modulo_ajusteStock"
			})

		}

		public.desestimarLinea = function(index) {
			globalSweetalert.confirmar({
					titulo: "¿Estas seguro de desestimar este movimiento?"
				})
				.then(function(confirmado) {
					if (confirmado) {
						g_listadoMovimientos.splice(index, 1);
						renderListadoMovimientos();
					}
				});
		};

		public.subirStock = function() {
			switch (Number(g_data.ajuste)) {
				case 1:
					ingresarStock()
					break;
				case 2:
					egresarStock()
					break;
				case 3:
					formatearStock()
					break;
				default:
					break;
			}
		}

		function ingresarStock() {
			if (g_listadoMovimientos < 1) {
				globalSweetalert.alert({
					titulo: "No hay movimientos de stock"
				})
			} else {
				let data = {
					did_cliente: g_data.cliente,
					fecha: g_data.fecha,
					observacion: g_data.observacion,
					productos: []
				}

				data.productos = Object.values(
					g_listadoMovimientos.reduce((acc, item) => {
						const did_producto = Number(item.did_producto);

						if (!acc[did_producto]) {
							acc[did_producto] = {
								did_producto,
								combinaciones: []
							};
						}

						const combinacionesNormalizadas = item.combinaciones.map(c => ({
							did_combinacion: isNaN(c.did_combinacion) ? c.did_combinacion : Number(c.did_combinacion),
							cantidad: Number(c.cantidad),
							identificadores_especiales: c.identificadores_especiales.map(ie => ({
								did: Number(ie.did),
								valor: ie.valor
							}))
						}));

						acc[did_producto].combinaciones.push(...combinacionesNormalizadas);
						return acc;
					}, {})
				);


				console.log("data", data);

				globalSweetalert.confirmar({
						titulo: "¿Estas seguro de subir todos estos movimientos de stock?"
					})
					.then(function(confirmado) {
						if (confirmado) {
							globalRequest.post(`/${rutaAPI}/ingreso`, data, {
								onSuccess: function(result) {
									globalSweetalert.exito();
									appModuloAjusteStock.open();
								}
							});
						}
					});

			}

		}

		function egresarStock() {
			console.log("egresarStock");

		}

		function formatearStock() {
			console.log("formatearStock");
		}

		return public;
	})();
</script>
<script>
	const appImportadorMasivo = (function() {
		let g_data;
		let g_data_filtrada;
		let g_data_importados;
		let numberedStepper;
		let stepperInicializado = false;
		let logosTiendas = {}
		let cuentasSeleccionadas = [];
		let productosSeleccionados = []

		const public = {};

		public.open = function() {
			$(".winapp").hide();
			logosTiendas = globalLogoTiendas.obtener()
			appImportadorMasivo.resetModulo()
			globalLlenarSelect.clientes("selectorCliente_importadorMasivo")
			globalLlenarSelect.tiendas("filtroTienda_importadorMasivo")
			accionesStepper()
			$("#ContainerImportadorMasivo").show();
		};

		public.resetModulo = function() {
			volverAlPrimerStep();
			$("#selectorCliente_importadorMasivo").val("");
			$(".campos_importadorMasivo").val("");
			$("#checksAllTiendas_importadorMasivo").prop("checked", false);
			$("#lista_importadorMasivo, #step3_importadorMasivo").addClass("ocultar");
			$("#steps_importadorMasivo").removeClass("ocultar");
			$("#bodyCuentas_importadorMasivo").empty();
			g_data = [];
			g_data_importados = [];
			cuentasSeleccionadas = [];
			productosSeleccionados = [];
		};


		function accionesStepper() {
			const wizardNumbered = document.querySelector('#steps_importadorMasivo');
			if (!wizardNumbered || stepperInicializado) return;

			const wizardNumberedBtnNextList = [].slice.call(wizardNumbered.querySelectorAll('.btn-next_importadorMasivo'));
			const wizardNumberedBtnPrevList = [].slice.call(wizardNumbered.querySelectorAll('.btn-prev_importadorMasivo'));
			const wizardNumberedBtnSubmit = wizardNumbered.querySelector('.btn-submit_importadorMasivo');

			numberedStepper = new Stepper(wizardNumbered, {
				linear: false
			});

			stepperInicializado = true;

			if (wizardNumberedBtnNextList) {
				wizardNumberedBtnNextList.forEach((wizardNumberedBtnNext, index) => {
					wizardNumberedBtnNext.addEventListener('click', event => {
						const cliente = $('#selectorCliente_importadorMasivo').val();
						if (index === 0) {
							if (!cliente) {
								globalSweetalert.alert('Debes seleccionar un cliente');
							} else {
								renderTableCuentas()
							}
						} else if (index === 1) {
							if (cuentasSeleccionadas.length < 1) {
								globalSweetalert.alert('Debes seleccionar al menos una cuenta para continuar');
							} else {
								$("#containerCardsProductos_importadorMasivo").empty()
								getProductosImportados()
								numberedStepper.next();
							}
						}
					});
				});
			}

			if (wizardNumberedBtnPrevList) {
				wizardNumberedBtnPrevList.forEach(wizardNumberedBtnPrev => {
					wizardNumberedBtnPrev.addEventListener('click', event => {
						$("#step3_importadorMasivo").addClass("ocultar")
						numberedStepper.previous();
					});
				});
			}

			if (wizardNumberedBtnSubmit) {
				wizardNumberedBtnSubmit.addEventListener('click', event => {
					if (productosSeleccionados.length > 0) {
						appImportadorMasivo.importarProductos();
					} else {
						globalSweetalert.alert('Debes seleccionar al menos un producto para continuar');
					}
				});
			}
		}

		function volverAlPrimerStep() {
			if (numberedStepper) {
				numberedStepper.to(1);
			}
		}

		function renderTableCuentas() {
			$("#checksAllTiendas_importadorMasivo").prop("checked", false);
			cuentasSeleccionadas = [];
			const didCliente = $('#selectorCliente_importadorMasivo').val();
			cliente = appSistema.clientes.find((item) => item.did == didCliente);

			let tiendas = []
			if (cliente.cuentas.length > 0) {
				tiendas = cliente.cuentas.filter((item) => item.flex == 1 || item.flex == 2)
			}

			if (tiendas.length < 1) {
				globalSweetalert.error('El cliente seleccionado no tiene cuentas');
				volverAlPrimerStep();
				return;
			}

			let buffer = "";
			tiendas.forEach((item, index) => {
				buffer += `<tr>`;
				buffer += `<td class="dt-checkboxes-cell"><input type="checkbox" class="dt-checkboxes form-check-input checksTiendasClass_importadorMasivo" id="checksTiendas${item.did}_importadorMasivo" data-flex="${item.flex}" data-did="${item.did}" onchange="appImportadorMasivo.manejarSeleccionCuenta(this)" /></td>`
				buffer += `<td>`
				buffer += `<div class="d-flex justify-content-start align-items-center gap-3 user-name">`
				buffer += `<div class="containerSvg" style="width: 60px; height: auto;">${logosTiendas[item.flex]}</div>`;
				buffer += `<div class="d-flex flex-column">`
				buffer += `<span class="emp_name text-truncate text-heading fw-medium">${appSistema.ecommerceTipos[item.flex]}</span>`
				buffer += `<small class="emp_post text-truncate">${item.titulo || "Sin titulo"}</small>`
				buffer += `</div></div></td>`
				buffer += `</tr>`;
			});

			$("#bodyCuentas_importadorMasivo").html(buffer);
			numberedStepper.next();
		}

		public.manejarSeleccionCuenta = function(checkbox) {
			checkboxSeleccionado = $(checkbox);
			isChecked = checkboxSeleccionado.is(":checked");

			if (checkboxSeleccionado.attr("id") === "checksAllTiendas_importadorMasivo") {
				$(".checksTiendasClass_importadorMasivo").each(function() {
					this.checked = isChecked;
					$(this).trigger("change");
				});
				return;
			}

			flex = checkboxSeleccionado.data("flex");
			did = checkboxSeleccionado.data("did");

			if (isChecked) {
				if (!cuentasSeleccionadas.some(item => item.flex === flex && item.did === did)) {
					cuentasSeleccionadas.push({
						flex,
						did
					});
				}
			} else {
				cuentasSeleccionadas = cuentasSeleccionadas.filter(item => !(item.flex === flex && item.did === did));
			}

			total = $(".checksTiendasClass_importadorMasivo").length;
			seleccionados = $(".checksTiendasClass_importadorMasivo:checked").length;
			$("#checksAllTiendas_importadorMasivo").prop("checked", total > 0 && seleccionados === total);
		};

		public.importarProductos = function() {
			g_data = g_data_importados.data["productos"].filter(item => productosSeleccionados.includes(item.sku));
			g_data_filtrada = g_data
			$("#steps_importadorMasivo").addClass("ocultar")
			$("#lista_importadorMasivo").removeClass("ocultar")
			renderListado()
		}

		function getProductosImportados() {
			const parametros = {
				"idEmpresa": appSistema.idEmpresa,
			};

			globalLoading.open();

			$.ajax({
				url: `${appSistema.urlServer}/publicaciones/getProductosImportados`,
				type: "POST",
				data: JSON.stringify(parametros),
				contentType: "application/json",
				headers: {
					Authorization: `Bearer ${appSistema.tkn}`
				},
				success: function(result) {
					g_data_importados = result;
					if (g_data_importados.estado && g_data_importados.data) {
						renderCardsProductos();
					} else {
						globalSweetalert.error(g_data_importados.mensaje || 'Error al obtener productos importados');
					}
					globalLoading.close();
				},
				error: function() {
					globalSweetalert.error();
					globalLoading.close();
				}
			});
		};

		function renderCardsProductos() {
			bufferNav = "";
			bufferBody = "";

			bufferNav += `<div class="nav-align-top col-12 mb-6">`;
			bufferNav += `<ul id="tabs_importadorMasivo" class="nav nav-pills" role="tablist">`;

			bufferBody += `<div class="tab-content p-0">`;

			const orden = ["productos", "variantes"];
			const keys = Object.keys(g_data_importados.data);

			const objetosOrdenados = [
				...orden,
				...keys.filter(k => !orden.includes(k))
			];

			let isActive = true;
			for (const key of objetosOrdenados) {
				let arrData = g_data_importados.data[key];
				nombreTab = key;
				nombreTabVacio = key;
				if (!orden.includes(key)) {
					partes = key.split("_");
					prefijo = `${partes[0]}.`;
					resto = partes.slice(1).map(p => p.charAt(0).toUpperCase() + p.slice(1)).join(" ");
					nombreTab = `${prefijo} ${resto}`;
					nombreTabVacio = `productos de ${resto}`;
				}

				bufferNav += `<li class="nav-item">`;
				bufferNav += `<button type="button" class="nav-link ${isActive ? "active" : ""}" role="tab" data-bs-toggle="tab" data-bs-target="#${key}Tab_importadorMasivo" aria-controls="${key}Tab_importadorMasivo" aria-selected="${isActive}">${nombreTab}</button>`;
				bufferNav += `</li>`;

				bufferBody += `<div class="tab-pane fade ${isActive ? "active show" : ""}" id="${key}Tab_importadorMasivo" role="tabpanel">`;
				isActive = false;

				if (key == "productos") {
					bufferBody += `<div class="row g-3 mb-3">`
					bufferBody += `<div class="col-12 col-md-12 col-lg-6 form-floating form-floating-outline">`
					bufferBody += `<input type="search" class="form-control campos_importadorMasivo" id="searchCardsProductos_importadorMasivo" oninput="appImportadorMasivo.filtrarCards()" placeholder="Buscar por SKU, nombre o descripción" />`
					bufferBody += `<label for="searchCardsProductos_importadorMasivo">Buscar</label>`
					bufferBody += `</div>`
					bufferBody += `<div class="col-12 col-md-6 col-lg-3">`
					bufferBody += `<button class="btn btn-label-primary w-100" onclick="appImportadorMasivo.seleccionarProductos(1)">Seleccionar todo</button>`
					bufferBody += `</div>`
					bufferBody += `<div class="col-12 col-md-6 col-lg-3">`
					bufferBody += `<button class="btn btn-label-warning w-100" onclick="appImportadorMasivo.seleccionarProductos(2)">Deseleccionar todo</button>`
					bufferBody += `</div>`
					bufferBody += `</div>`
				}

				bufferBody += `<div class="row justify-content-center align-items-center" style="overflow-y: auto; overflow-x: hidden;">`;

				if (key == "productos") {
					bufferBody += `<div id="sinCards_importadorMasivo" class="ocultar d-flex justify-content-center align-items-center" style="height: 680px; gap: 1.3rem;">`
					bufferBody += `<div>`
					bufferBody += `<svg width="86" height="76" viewBox="0 0 86 76" fill="none" xmlns="http://www.w3.org/2000/svg">`
					bufferBody += `<path d="M31.0658 26.3034C27.6029 26.3034 24.6725 25.1038 22.2746 22.7046C19.8767 20.3054 18.6771 17.375 18.6758 13.9134C18.6745 10.4519 19.8741 7.52146 22.2746 5.12225C24.6751 2.72304 27.6055 1.52344 31.0658 1.52344C34.5261 1.52344 37.4571 2.72304 39.8589 5.12225C42.2606 7.52146 43.4596 10.4519 43.4558 13.9134C43.4558 15.3113 43.2334 16.6297 42.7886 17.8687C42.3438 19.1077 41.7402 20.2037 40.9778 21.1568L51.6522 31.8313C52.0017 32.1807 52.1764 32.6255 52.1764 33.1656C52.1764 33.7056 52.0017 34.1504 51.6522 34.4999C51.3027 34.8493 50.858 35.0241 50.3179 35.0241C49.7778 35.0241 49.3331 34.8493 48.9836 34.4999L38.3092 23.8254C37.3561 24.5879 36.26 25.1915 35.021 25.6363C33.782 26.081 32.4636 26.3034 31.0658 26.3034ZM31.0658 22.4911C33.4485 22.4911 35.4741 21.6575 37.1426 19.9902C38.8111 18.323 39.6447 16.2974 39.6435 13.9134C39.6422 11.5295 38.8086 9.5045 37.1426 7.83852C35.4766 6.17254 33.451 5.33828 31.0658 5.33574C28.6805 5.3332 26.6556 6.16746 24.9909 7.83852C23.3262 9.50958 22.4919 11.5345 22.4881 13.9134C22.4843 16.2923 23.3185 18.3179 24.9909 19.9902C26.6632 21.6626 28.6882 22.4962 31.0658 22.4911Z" fill="var(--bs-body-color)"></path>`
					bufferBody += `<path fill-rule="evenodd" clip-rule="evenodd" d="M76.8247 29.2823L85.3419 20.7651C85.8133 20.2937 86.0361 19.6294 85.9477 18.9688C85.8592 18.3081 85.4694 17.7241 84.8907 17.3936L54.9431 0.280805C54.2103 -0.137804 53.311 -0.0798089 52.6411 0.397539L52.3695 0.627291L44.6117 8.38532C44.6533 8.47008 44.6942 8.55559 44.7344 8.64146C45.4433 10.159 45.8967 11.8204 46.0389 13.5696L69.9002 27.2034L69.9905 27.2562L71.7516 28.2622L71.4397 28.4302L48.368 40.8569C47.4334 41.3599 46.388 41.6213 45.3266 41.6216C44.9615 41.6216 44.5983 41.5904 44.2408 41.5291C43.9139 41.4733 43.5917 41.3922 43.2774 41.2863L19.6931 27.809L22.6592 26.1141C21.504 25.2014 20.4913 24.1159 19.66 22.8969L14.4984 25.8465L1.86651 30.0571C1.0661 30.3236 0.495624 31.0389 0.412534 31.8784C0.330374 32.7174 0.750284 33.5283 1.48211 33.9465L13.2431 40.6669L13.2418 40.6903L13.2394 40.7472L13.2389 40.8026V52.7891C13.2385 54.6751 13.7381 56.5269 14.6845 58.1578C15.6308 59.7887 16.9913 61.1412 18.6284 62.0766L40.0194 74.3014C41.6351 75.2243 43.4648 75.7095 45.3255 75.7095C47.1862 75.7095 49.0158 75.2243 50.6315 74.3014L72.0226 62.0766C73.6597 61.1412 75.0201 59.7887 75.9665 58.1578C76.7944 56.731 77.2788 55.1353 77.387 53.4951L77.4121 52.7891V32.7769C77.4121 31.5824 77.2119 30.4017 76.8247 29.2823ZM47.4655 71.0648V45.6783C48.484 45.4701 49.4723 45.1218 50.3943 44.6255L73.1221 32.3862C73.1299 32.5159 73.134 32.6464 73.134 32.7769V52.7891C73.1342 53.92 72.8362 55.032 72.2691 56.0105C71.7012 56.989 70.8824 57.8013 69.9002 58.3626L48.5091 70.5873C48.1751 70.7782 47.8256 70.9377 47.4655 71.0648ZM43.1874 71.0655C42.8266 70.9382 42.4766 70.7785 42.1418 70.5873L20.7508 58.3626C19.7686 57.8013 18.9497 56.989 18.3819 56.0105C17.8147 55.032 17.5168 53.92 17.5171 52.7891V43.1094L31.4296 51.0593C31.9579 51.3608 32.5906 51.4232 33.1676 51.2307L43.1874 47.8907V71.0655ZM40.1031 44.4039L39.9847 44.4433L32.7207 46.8646L7.76162 32.6015L15.144 30.1404L39.6551 44.1481L40.1031 44.4039ZM72.0226 23.4891L48.8182 10.2241L54.2371 4.8052L80.3325 19.7205L74.9138 25.1394L72.0226 23.4891Z" fill="var(--bs-body-color)"></path>`
					bufferBody += `</svg>`
					bufferBody += `</div>`
					bufferBody += `<div>`
					bufferBody += `<p class="fs-4 fw-bold lh-1 mb-1">No encontramos productos que<br>coincidan con la busqueda</p>`
					bufferBody += `</div></div>`
				}

				if (arrData && arrData.length > 0) {

					if (key != "variantes") {
						bufferBody += `<div ${key == "productos" ? `id="containerCards_importadorMasivo"` : ""} style="height: ${key == "productos" ? `680px;` : `740px;`}" class="row row-cols-1 row-cols-md-3 row-cols-lg-5 g-6 m-0 pb-5">`;
					} else {
						bufferBody += `<div class="row m-0 pb-5" style="height:740px;">`;
					}

					modo = document.documentElement.getAttribute("data-style");

					arrData.forEach(producto => {
						if (key != "variantes") {
							bufferBody += `<div class="col">`;
							bufferBody += `<div class="card h-100 ${key == "productos" ? "cardsProductos_importadorMasivo" : ""}" style="border-radius: 0.9rem; background-color: ${modo == "dark"? "#eaeaff0f" : "#f6f6f6"};" ${key == "productos" ? `data-sku="${producto.sku}" id="cardProducto_${producto.sku}_importadorMasivo" onclick="appImportadorMasivo.seleccionarProductos(0, '${producto.sku}')"` : "" }>`;
							bufferBody += `<img class="card-img-top" style="height: 200px; object-fit: cover;" src="${producto.imagenUrl}" onerror="this.onerror=null; this.src='../../assets/img/extras/imagenDefault.jpg';" alt="Card image cap" />`;
							bufferBody += `<div class="card-body">`;
							bufferBody += `<h6 class="card-title fw-bold">${producto.titulo || producto.producto}</h6>`;
							if (producto.descripcion) {
								bufferBody += `<p class="card-text ">${producto.descripcion}</p>`;
							}
							bufferBody += `<p class="card-text" style="font-size: 12px;">SKU: <span class="fw-bold">${producto.sku || "S/D"}</span></p>`;
							bufferBody += `</div>`;
							bufferBody += `</div>`;
							bufferBody += `</div>`;
						} else {
							bufferBody += `<div class="col-12 m-0">`;
							bufferBody += `<table class="table table-bordered">`
							bufferBody += `<thead><tr>`
							bufferBody += `<th>Variante: <span class="badge rounded-pill bg-primary lh-1">${producto.atributoNombre || "Sin nombre"}</span></th>`
							bufferBody += `</tr></thead><tbody>`

							if (producto.variantes.length < 1) {
								bufferBody += `<tr><td class="text-center">No hay valores para esta variante</td></tr>`;
							} else {
								producto.variantes.forEach(variantes => {
									bufferBody += `<tr>`
									bufferBody += `<td>${variantes.valor}</td>`
									bufferBody += `</tr>`;
								});
							}
							bufferBody += `</tbody></table></div>`
						}
					});

					bufferBody += `</div>`;
				} else {
					bufferBody += `<div ${key == "productos" ? `id="containerCards_importadorMasivo"` : ""} class="d-flex justify-content-center align-items-center" style="height: ${key == "productos" ? `680px;` : `740px;`} gap: 1.3rem;">`
					bufferBody += `<div>`
					bufferBody += `<svg width="86" height="76" viewBox="0 0 86 76" fill="none" xmlns="http://www.w3.org/2000/svg">`
					bufferBody += `<path d="M31.0658 26.3034C27.6029 26.3034 24.6725 25.1038 22.2746 22.7046C19.8767 20.3054 18.6771 17.375 18.6758 13.9134C18.6745 10.4519 19.8741 7.52146 22.2746 5.12225C24.6751 2.72304 27.6055 1.52344 31.0658 1.52344C34.5261 1.52344 37.4571 2.72304 39.8589 5.12225C42.2606 7.52146 43.4596 10.4519 43.4558 13.9134C43.4558 15.3113 43.2334 16.6297 42.7886 17.8687C42.3438 19.1077 41.7402 20.2037 40.9778 21.1568L51.6522 31.8313C52.0017 32.1807 52.1764 32.6255 52.1764 33.1656C52.1764 33.7056 52.0017 34.1504 51.6522 34.4999C51.3027 34.8493 50.858 35.0241 50.3179 35.0241C49.7778 35.0241 49.3331 34.8493 48.9836 34.4999L38.3092 23.8254C37.3561 24.5879 36.26 25.1915 35.021 25.6363C33.782 26.081 32.4636 26.3034 31.0658 26.3034ZM31.0658 22.4911C33.4485 22.4911 35.4741 21.6575 37.1426 19.9902C38.8111 18.323 39.6447 16.2974 39.6435 13.9134C39.6422 11.5295 38.8086 9.5045 37.1426 7.83852C35.4766 6.17254 33.451 5.33828 31.0658 5.33574C28.6805 5.3332 26.6556 6.16746 24.9909 7.83852C23.3262 9.50958 22.4919 11.5345 22.4881 13.9134C22.4843 16.2923 23.3185 18.3179 24.9909 19.9902C26.6632 21.6626 28.6882 22.4962 31.0658 22.4911Z" fill="var(--bs-body-color)"></path>`
					bufferBody += `<path fill-rule="evenodd" clip-rule="evenodd" d="M76.8247 29.2823L85.3419 20.7651C85.8133 20.2937 86.0361 19.6294 85.9477 18.9688C85.8592 18.3081 85.4694 17.7241 84.8907 17.3936L54.9431 0.280805C54.2103 -0.137804 53.311 -0.0798089 52.6411 0.397539L52.3695 0.627291L44.6117 8.38532C44.6533 8.47008 44.6942 8.55559 44.7344 8.64146C45.4433 10.159 45.8967 11.8204 46.0389 13.5696L69.9002 27.2034L69.9905 27.2562L71.7516 28.2622L71.4397 28.4302L48.368 40.8569C47.4334 41.3599 46.388 41.6213 45.3266 41.6216C44.9615 41.6216 44.5983 41.5904 44.2408 41.5291C43.9139 41.4733 43.5917 41.3922 43.2774 41.2863L19.6931 27.809L22.6592 26.1141C21.504 25.2014 20.4913 24.1159 19.66 22.8969L14.4984 25.8465L1.86651 30.0571C1.0661 30.3236 0.495624 31.0389 0.412534 31.8784C0.330374 32.7174 0.750284 33.5283 1.48211 33.9465L13.2431 40.6669L13.2418 40.6903L13.2394 40.7472L13.2389 40.8026V52.7891C13.2385 54.6751 13.7381 56.5269 14.6845 58.1578C15.6308 59.7887 16.9913 61.1412 18.6284 62.0766L40.0194 74.3014C41.6351 75.2243 43.4648 75.7095 45.3255 75.7095C47.1862 75.7095 49.0158 75.2243 50.6315 74.3014L72.0226 62.0766C73.6597 61.1412 75.0201 59.7887 75.9665 58.1578C76.7944 56.731 77.2788 55.1353 77.387 53.4951L77.4121 52.7891V32.7769C77.4121 31.5824 77.2119 30.4017 76.8247 29.2823ZM47.4655 71.0648V45.6783C48.484 45.4701 49.4723 45.1218 50.3943 44.6255L73.1221 32.3862C73.1299 32.5159 73.134 32.6464 73.134 32.7769V52.7891C73.1342 53.92 72.8362 55.032 72.2691 56.0105C71.7012 56.989 70.8824 57.8013 69.9002 58.3626L48.5091 70.5873C48.1751 70.7782 47.8256 70.9377 47.4655 71.0648ZM43.1874 71.0655C42.8266 70.9382 42.4766 70.7785 42.1418 70.5873L20.7508 58.3626C19.7686 57.8013 18.9497 56.989 18.3819 56.0105C17.8147 55.032 17.5168 53.92 17.5171 52.7891V43.1094L31.4296 51.0593C31.9579 51.3608 32.5906 51.4232 33.1676 51.2307L43.1874 47.8907V71.0655ZM40.1031 44.4039L39.9847 44.4433L32.7207 46.8646L7.76162 32.6015L15.144 30.1404L39.6551 44.1481L40.1031 44.4039ZM72.0226 23.4891L48.8182 10.2241L54.2371 4.8052L80.3325 19.7205L74.9138 25.1394L72.0226 23.4891Z" fill="var(--bs-body-color)"></path>`
					bufferBody += `</svg>`
					bufferBody += `</div>`
					bufferBody += `<div>`
					bufferBody += `<p class="fs-4 fw-bold lh-1 mb-1">No encontramos ${nombreTabVacio}</p>`
					bufferBody += `</div></div>`
				}
				bufferBody += `</div></div>`;
			}

			bufferBody += `</div>`;
			bufferNav += `</ul>`;
			bufferNav += `</div>`;

			const buffer = bufferNav + bufferBody;
			$("#containerCardsProductos_importadorMasivo").html(buffer);
			$("#step3_importadorMasivo").removeClass("ocultar")
		}

		public.seleccionarProductos = function(type, sku) {
			if (type == 0) {
				const index = productosSeleccionados.indexOf(sku.toString());

				if (index !== -1) {
					productosSeleccionados.splice(index, 1);
					$(`.cardsProductos_importadorMasivo[data-sku="${sku}"]`).removeClass("border border-4 border-success");
				} else {
					productosSeleccionados.push(sku.toString());
					$(`.cardsProductos_importadorMasivo[data-sku="${sku}"]`).addClass("border border-4 border-success");
				}

			} else if (type == 1) {
				productosSeleccionados = [];

				$(".cardsProductos_importadorMasivo").each(function() {
					const cardSku = $(this).data("sku");
					productosSeleccionados.push(cardSku.toString());
					$(this).addClass("border border-4 border-success");
				});

			} else if (type == 2) {
				productosSeleccionados = [];
				$(".cardsProductos_importadorMasivo").removeClass("border border-4 border-success");
			}
		};

		public.filtrarCards = function() {
			const buscador = $("#searchCardsProductos_importadorMasivo").val().toLowerCase();
			let contador = 0;

			$(".cardsProductos_importadorMasivo").each(function() {
				const sku = $(this).data("sku").toString().toLowerCase();
				const titulo = $(this).find(".card-title").text().toLowerCase();
				const descripcion = $(this).find(".card-text").first().text().toLowerCase();

				if (sku.includes(buscador) || titulo.includes(buscador) || descripcion.includes(buscador)) {
					$(this).parent().show();
					contador++;
				} else {
					$(this).parent().hide();
				}
			});

			if (contador == 0) {
				$("#containerCards_importadorMasivo").addClass("ocultar");
				$("#sinCards_importadorMasivo").removeClass("ocultar");
			} else {
				$("#sinCards_importadorMasivo").addClass("ocultar");
				$("#containerCards_importadorMasivo").removeClass("ocultar");
			}
		}

		function renderListado() {
			$("#tbodyListado_importadorMasivo").empty()
			buffer = ""

			if (!g_data_filtrada || g_data_filtrada.length < 1) {
				globalSinInformacion.tablasVacias("tbodyListado_importadorMasivo", 1, "productos importados")
				return
			};

			g_data_filtrada.forEach(producto => {
				buffer += `<tr>`
				buffer += `<td>${producto.titulo || "---"}</td>`
				buffer += `<td>${producto.sku || "---"}</td>`
				buffer += `<td>${producto.precio || "---"}</td>`
				buffer += `<td class="text-center">`
				buffer += `<button type="button" class="btn btn-icon rounded-pill btn-text-danger" onclick="appImportadorMasivo.desestimarProducto('${producto.sku}')" title="Desestimar">`
				buffer += `<i class="tf-icons ri-close-line ri-22px"></i>`
				buffer += `</button>`
				buffer += `</td>`
				buffer += `</tr>`
			});

			$("#tbodyListado_importadorMasivo").html(buffer)
		}

		public.filtrarLista = function() {
			filtroTitulo = $("#filtroTitulo_importadorMasivo").val()
			filtroSku = $("#filtroSku_importadorMasivo").val()

			if (filtroTitulo || filtroSku) {
				g_data_filtrada = g_data.filter((item) => {
					return (filtroTitulo && item.titulo.toLowerCase().includes(filtroTitulo)) ||
						(filtroSku && item.sku.toLowerCase().includes(filtroSku));

				})
			} else {
				g_data_filtrada = g_data
			}

			renderListado()
		}

		public.limpiarCampos = function() {
			$(".campos_importadorMasivo").val("")
			g_data_filtrada = g_data
			renderListado()
		};

		public.desestimarProducto = function(sku) {
			g_data = g_data.filter(item => item.sku != sku)
			g_data_filtrada = g_data_filtrada.filter(item => item.sku != sku)
			renderListado()
		}

		return public;
	})();
</script>
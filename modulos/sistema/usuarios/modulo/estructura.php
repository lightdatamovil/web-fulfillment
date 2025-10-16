<script>
	const appModuloUsuarios = (function() {
		let g_data;
		let g_meta;
		let order = "";
		let direction = "";
		let openModulo = 0
		const rutaAPI = "usuarios"

		const public = {};

		public.paginaActual = 1;
		public.limitePorPagina = 10;

		public.open = async function() {
			$(".winapp").hide();
			$("#modulo_usuarios").show();
			await globalLlenarSelect.perfiles({
				id: "filtroPerfil_usuarios",
				multiple: true
			})
			await appModuloUsuarios.getListado();
			await globalActivarAcciones.filtrarConEnter({
				className: "inputs_usuarios",
				callback: appModuloUsuarios.getListado
			})
			await globalOrdenTablas.activar({
				idThead: "theadListado_usuarios",
				callback: appModuloUsuarios.getListado,
				defaultOrder: "nombre"
			})
			await globalActivarAcciones.select2({
				className: "select2_usuarios"
			})
		};

		public.limpiarCampos = function() {
			$(".campos_usuarios").val(null).change();
			$(".inputs_usuarios").val("");
		};

		function renderListado() {
			$("#tbodyListado_usuarios").empty()
			let buffer = ""

			if (!g_data || g_data.length < 1) {
				globalSinInformacion.tablasVacias({
					idTbody: "tbodyListado_usuarios",
					open: openModulo
				})
				return
			};

			g_data.forEach(user => {
				buffer += `<tr>`
				buffer += `<td>${user.usuario || '---'}</td>`
				buffer += `<td>${user.nombre || '---'}</td>`
				buffer += `<td>${user.apellido || '---'}</td>`
				buffer += `<td>${user.email || '---'}</td>`
				buffer += `<td>${user.perfil ? appSistema.perfiles[user.perfil] : '---'}</td>`
				buffer += `<td><span class="badge rounded-pill bg-label-${user.habilitado == 1 ? 'success' : 'danger'}">${user.habilitado == 1 ? 'Habilitado' : 'Deshabilitado'}</span></td>`
				buffer += `<td>`
				buffer += `<button type="button" class="btn btn-icon rounded-pill btn-text-primary" onclick="appModalUsuarios.open({mode: 2, did: '${user.did}'})" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver">`
				buffer += `<i class="tf-icons ri-eye-line ri-22px"></i>`
				buffer += `</button>`
				buffer += `<button type="button" class="btn btn-icon rounded-pill btn-text-primary" onclick="appModalUsuarios.open({mode: 1, did: '${user.did}'})" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar">`
				buffer += `<i class="tf-icons ri-pencil-line ri-22px"></i>`
				buffer += `</button>`
				buffer += `<button type="button" class="btn btn-icon rounded-pill btn-text-primary" onclick="appModalUsuarios.eliminar('${user.did}')" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar">`
				buffer += `<i class="tf-icons ri-delete-bin-6-line ri-22px"></i>`
				buffer += `</button>`
				buffer += `</td>`
				buffer += `</tr>`
			});

			$("#tbodyListado_usuarios").html(buffer)
			$("#totalRegistros_usuarios").text(g_meta.totalItems)
			$("#totalPaginas_usuarios").text(g_meta.totalPages)
			globalActivarAcciones.tooltips({
				idContainer: "modulo_usuarios"
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
				nombre: $("#filtroNombre_usuarios").val(),
				apellido: $("#filtroApellido_usuarios").val(),
				usuario: $("#filtroUsuario_usuarios").val(),
				perfil: $("#filtroPerfil_usuarios").val().join(","),
				habilitado: $("#filtroEstado_usuarios").val()
			};

			const queryString = $.param(parametros);

			globalRequest.get(`/${rutaAPI}?${queryString}`, {
				onSuccess: function(result) {
					g_data = result.data;
					g_meta = result.meta;
					public.paginaActual = parseInt(g_meta.page);
					renderListado();
					globalPaginado.generar({
						idBase: "_usuarios",
						meta: g_meta,
						estructura: appModuloUsuarios
					});
				},
			});
		};

		return public;
	})();
</script>
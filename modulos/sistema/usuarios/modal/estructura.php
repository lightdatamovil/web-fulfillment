<script>
	const appModalUsuarios = (function() {
		let g_did = 0;
		let g_data;
		let donde = 0;
		let validarPasword = false
		const didPerfilCliente = 4
		const rutaAPI = "usuarios"

		const public = {};

		public.open = async function({
			mode = 0,
			did = 0
		} = {}) {
			await resetModal()
			g_did = did;
			donde = mode
			await globalLlenarSelect.perfiles({
				id: "perfil_mUsuarios"
			})
			await globalLlenarSelect.clientes({
				id: "cliente_mUsuarios",
				multiple: true
			})
			await globalActivarAcciones.select2({
				className: "select2_mUsuarios"
			})

			if (mode == 0) {
				// NUEVA VARIANTE
				$("#titulo_mUsuarios").text("Nuevo usuario");
				$("#subtitulo_mUsuarios").html("Recordá presionar <b>Guardar</b> antes de salir, así conservás todos los cambios.");
				$('.campos_mUsuarios').prop('disabled', false);
				$("#btnEditar_mUsuarios, #containerCliente_mUsuarios, #containerEditPassword_mUsuarios").addClass("ocultar")
				$("#btnGuardar_mUsuarios, #containerPassword_mUsuarios, #containerRepPassword_mUsuarios").removeClass("ocultar");
				$("#modal_mUsuarios").modal("show")
				validarPasword = true
			} else if (mode == 1) {
				// MODIFICAR VARIANTE
				await globalLoading.open()
				$("#titulo_mUsuarios").text("Modificar usuario");
				$("#subtitulo_mUsuarios").html("Recordá presionar <b>Guardar</b> antes de salir, así conservás todos los cambios.");
				$('.campos_mUsuarios').prop('disabled', false);
				$("#btnGuardar_mUsuarios, #containerPassword_mUsuarios, #containerRepPassword_mUsuarios").addClass("ocultar");
				$("#btnEditar_mUsuarios, #containerEditPassword_mUsuarios").removeClass("ocultar");
				await get()
			} else {
				// VER VARIANTE
				await globalLoading.open()
				$("#titulo_mUsuarios").text("Ver usuario");
				$("#subtitulo_mUsuarios").html("<b>Estás en modo visualización.</b> Para actualizar la información, debés hacerlo desde la opción Editar.");
				$('.campos_mUsuarios').prop('disabled', true);
				$("#btnGuardar_mUsuarios, #btnEditar_mUsuarios, #containerPassword_mUsuarios, #containerRepPassword_mUsuarios, #containerEditPassword_mUsuarios").addClass("ocultar");
				await get()
			}
		}

		function get() {
			globalRequest.get(`/${rutaAPI}/${g_did}`, {
				onSuccess: function(result) {
					g_data = result.data;

					$("#nombre_mUsuarios").val(g_data.nombre);
					$("#apellido_mUsuarios").val(g_data.apellido);
					$("#usuario_mUsuarios").val(g_data.usuario);
					$("#email_mUsuarios").val(g_data.email);
					$("#telefono_mUsuarios").val(g_data.telefono);
					$("#perfil_mUsuarios").val(g_data.perfil);
					$("#estado_mUsuarios").prop("checked", g_data.habilitado == 1);
					$("#modInicio_mUsuarios").val(g_data.modulo_inicial);
					$("#appHabilitada_mUsuarios").prop("checked", g_data.app_habilitada == 1);

					if (g_data.perfil == didPerfilCliente) {
						$("#containerCliente_mUsuarios").removeClass("ocultar");
						$("#cliente_mUsuarios").val(g_data.codigo_cliente.split(",")).trigger("change");
					} else {
						$("#containerCliente_mUsuarios").addClass("ocultar");
						$("#cliente_mUsuarios").val([]).trigger("change");
					}

					$("#modal_mUsuarios").modal("show");
				}
			});
		}

		function resetModal() {
			globalActivarAcciones.activarPrimerTab({
				tabList: "tabs_mUsuarios"
			})

			$(".campos_mUsuarios").val("")
			$("#perfil_mUsuarios").val('1');
			$("#estado_mUsuarios").prop("checked", true);
			$("#modInicio_mUsuarios").val('1');
			$("#appHabilitada_mUsuarios, #checkEditPassword_mUsuarios").prop("checked", false);
			$("#cliente_mUsuarios").val([]).trigger("change");
			validarPasword = false

			globalValidar.limpiarTodas()
			globalValidar.deshabilitarTiempoReal({
				className: "camposObli_mUsuarios"
			})
		};

		public.editPassword = function() {
			$("#password_mUsuarios, #repPassword_mUsuarios").val('').removeClass('is-invalid');

			if ($("#checkEditPassword_mUsuarios").is(":checked")) {
				$("#containerPassword_mUsuarios, #containerRepPassword_mUsuarios").removeClass("ocultar")
				validarPasword = true
			} else {
				$("#containerPassword_mUsuarios, #containerRepPassword_mUsuarios").addClass("ocultar")
				validarPasword = false
			}
		}

		function validacion() {
			nombre = $("#nombre_mUsuarios").val().trim();
			apellido = $("#apellido_mUsuarios").val().trim();
			usuario = $("#usuario_mUsuarios").val().trim();
			password = $("#password_mUsuarios").val();
			repeatPassword = $("#repPassword_mUsuarios").val();
			perfil = $("#perfil_mUsuarios").val();
			email = $("#email_mUsuarios").val().trim();

			faltanCampos = false

			$(".camposObli_mUsuarios").each(function() {
				if (!validarPasword && (this["id"] == "password_mUsuarios" || this["id"] == "repPassword_mUsuarios")) {
					return
				} else if (this["id"] == "cliente_mUsuarios") {
					if (perfil == didPerfilCliente && globalValidar.vacio({
							id: this["id"]
						})) faltanCampos = true;
				} else {
					if (globalValidar.vacio({
							id: this["id"]
						})) faltanCampos = true;
				}
			});

			if (email != "" && globalValidar.email({
					id: "email_mUsuarios"
				})) faltanCampos = true;
			if (nombre != "" && globalValidar.letrasYEspacios({
					id: "nombre_mUsuarios"
				})) faltanCampos = true;
			if (apellido != "" && globalValidar.letrasYEspacios({
					id: "apellido_mUsuarios"
				})) faltanCampos = true;
			if (usuario != "" && globalValidar.sinCaracteresEspeciales({
					id: "usuario_mUsuarios"
				})) faltanCampos = true;
			if (validarPasword && password != "" && repeatPassword != "" && globalValidar.coincideContraseña({
					idOriginal: "password_mUsuarios",
					idCopia: "repPassword_mUsuarios"
				})) faltanCampos = true;
			if (validarPasword && password != "" && globalValidar.carecteresMinimos({
					id: "password_mUsuarios",
					minimo: 6
				})) faltanCampos = true;

			return faltanCampos
		}

		public.guardar = function() {
			const datos = {
				nombre: $("#nombre_mUsuarios").val().trim() || null,
				apellido: $("#apellido_mUsuarios").val().trim() || null,
				email: $("#email_mUsuarios").val().trim() || null,
				telefono: $("#telefono_mUsuarios").val().trim() || null,
				usuario: $("#usuario_mUsuarios").val().trim() || null,
				perfil: Number($("#perfil_mUsuarios").val()) || null,
				habilitado: $("#estado_mUsuarios").prop("checked") ? 1 : 0,
				modulo_inicial: Number($("#modInicio_mUsuarios").val()) || null,
				app_habilitada: $("#appHabilitada_mUsuarios").prop("checked") ? 1 : 0,
				codigo_cliente: $("#cliente_mUsuarios").val().join(",") || null,
				password: $("#password_mUsuarios").val() || null
			};

			globalValidar.habilitarTiempoReal({
				className: "camposObli_mUsuarios",
				callback: validacion
			});

			if (validacion()) {
				globalSweetalert.alert({
					titulo: "Verifique los campos"
				});
				return;
			}

			globalSweetalert.confirmar({
					titulo: "¿Estas seguro de guardar este usuario?"
				})
				.then(function(confirmado) {
					if (confirmado) {
						globalRequest.post(`/${rutaAPI}`, datos, {
							onSuccess: function(result) {
								$("#modal_mUsuarios").modal("hide");
								globalSweetalert.exito();
								appModuloUsuarios.getListado();
							}
						});
					}
				});
		};

		public.editar = function() {
			const datosNuevos = {
				nombre: $("#nombre_mUsuarios").val().trim() || null,
				apellido: $("#apellido_mUsuarios").val().trim() || null,
				email: $("#email_mUsuarios").val().trim() || null,
				telefono: $("#telefono_mUsuarios").val().trim() || null,
				usuario: $("#usuario_mUsuarios").val().trim() || null,
				perfil: Number($("#perfil_mUsuarios").val()) || null,
				habilitado: $("#estado_mUsuarios").prop("checked") ? 1 : 0,
				modulo_inicial: Number($("#modInicio_mUsuarios").val()) || null,
				app_habilitada: $("#appHabilitada_mUsuarios").prop("checked") ? 1 : 0,
				codigo_cliente: $("#cliente_mUsuarios").val().join(",") || null
			};

			const password = $("#password_mUsuarios").val();
			if (password !== "") {
				datosNuevos.password = password;
			}

			globalValidar.habilitarTiempoReal({
				className: "camposObli_mUsuarios",
				callback: validacion
			});

			if (validacion()) {
				globalSweetalert.alert({
					titulo: "Verifique los campos"
				});
				return;
			}

			const datosModificados = globalValidar.obtenerCambios({
				dataNueva: datosNuevos,
				dataOriginal: g_data
			});

			if (Object.keys(datosModificados).length === 0) {
				globalSweetalert.alert({
					titulo: "No se realizaron cambios"
				});
				return;
			}

			globalSweetalert.confirmar({
					titulo: "¿Estas seguro de modificar este usuario?"
				})
				.then(function(confirmado) {
					if (confirmado) {
						globalRequest.put(`/${rutaAPI}/${g_did}`, datosNuevos, {
							onSuccess: function(result) {
								$("#modal_mUsuarios").modal("hide");
								globalSweetalert.exito();
								appModuloUsuarios.getListado();
							}
						});
					}
				});
		};

		public.perfilCliente = function(e) {
			$("#cliente_mUsuarios").val([]).trigger("change");
			if ($(e).val() == didPerfilCliente) {
				$("#containerCliente_mUsuarios").removeClass("ocultar")
			} else {
				$("#containerCliente_mUsuarios").addClass("ocultar")
			}
		}

		public.eliminar = function(did) {
			globalSweetalert.confirmar({
				titulo: "¿Estas seguro de eliminar este usuario?",
				color: "var(--bs-danger)"
			}).then(function(confirmado) {
				if (confirmado) {
					globalRequest.delete(`/${rutaAPI}/${did}`, {
						onSuccess: function(result) {
							globalSweetalert.exito({
								titulo: "Eliminado con éxito!"
							});
							appModuloUsuarios.getListado();
						}
					});
				}
			});
		};


		return public;
	}());
</script>
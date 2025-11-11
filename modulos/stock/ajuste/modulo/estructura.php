<script>
	const appModuloAjusteStock = (function() {
		let g_data = {};
		let numberedStepper;
		let stepperInicializado = false;

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
			g_data = [];

			globalValidar.limpiarTodas()
			globalValidar.deshabilitarTiempoReal({
				className: "camposObliStep1_ajusteStock"
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

		function verificarCamposStep1() {
			g_data = {
				ajuste: $('input[name="opcionAjuste_ajusteStock"]:checked').val(),
				cliente: $("#cliente_ajusteStock").val() || null,
				fecha: $("#fecha_ajusteStock").val() || "",
				observacion: $("#observacion_ajusteStock").val().trim() || "",
			};

			globalValidar.habilitarTiempoReal({
				className: "camposObliStep1_ajusteStock",
				callback: validacionStep1
			})

			if (validacionStep1()) {
				globalSweetalert.alert({
					titulo: "Verifique los campos"
				})
				return
			} {
				numberedStepper.next();
			}
		}

		return public;
	})();
</script>
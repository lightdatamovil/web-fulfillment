<div class="modal fade" id="modal_mVariantes" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
	<div class="modal-dialog modal-dialog-centered modal-lg modal-simple">
		<div class="modal-content">

			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			<div class="modal-body p-0">
				<div class=" col-12 text-center mb-6">
					<h4 class="mb-2" id="titulo_mVariantes">Nuevo variante</h4>
					<p class="mb-6" id="subtitulo_mVariantes">Creacion de variantes de productos, llenar formulario.</p>
				</div>
				<div class="nav-align-top col-12 mb-6">
					<ul id="tabs_mVariantes" class="nav nav-tabs nav-fill" role="tablist">
						<li class="nav-item">
							<button
								type="button"
								class="nav-link active"
								role="tab"
								data-bs-toggle="tab"
								data-bs-target="#tabGeneral_mVariantes"
								aria-controls="tabGeneral_mVariantes"
								aria-selected="true">
								<span class="d-none d-sm-block"><i class="tf-icons ri-survey-line me-2"></i> General</span>
								<i class="ri-survey-line ri-20px d-sm-none"></i>
							</button>
						</li>
						<li class="nav-item">
							<button
								type="button"
								class="nav-link"
								role="tab"
								data-bs-toggle="tab"
								data-bs-target="#tabValores_mVariantes"
								aria-controls="tabValores_mVariantes"
								aria-selected="false">
								<span class="d-none d-sm-block"><i class="tf-icons ri-palette-line me-2"></i> Valores</span>
								<i class="ri-palette-line ri-20px d-sm-none"></i>
							</button>
						</li>
					</ul>
				</div>

				<div class="tab-content p-0">
					<div class="tab-pane fade show active" id="tabGeneral_mVariantes" role="tabpanel">
						<form class="row g-5" onsubmit="return false">
							<div class="col-12 col-md-4">
								<div class="form-floating form-floating-outline">
									<input type="text" id="codigo_mVariantes" class="form-control campos_mVariantes camposObli_mVariantes" placeholder="Codigo" />
									<label for="codigo_mVariantes">Codigo</label>
									<div class="invalid-feedback"> Debe completar el campo </div>
								</div>
							</div>
							<div class="col-12 col-md-8">
								<div class="form-floating form-floating-outline">
									<input type="text" id="nombre_mVariantes" class="form-control campos_mVariantes camposObli_mVariantes" placeholder="Nombre" />
									<label for="nombre_mVariantes">Nombre</label>
									<div class="invalid-feedback"> Debe completar el campo </div>
								</div>
							</div>
							<div class="col-12 col-md-12">
								<div class="form-floating form-floating-outline">
									<textarea type="text" id="descripcion_mVariantes" class="form-control campos_mVariantes h-px-100" placeholder="Descripción"></textarea>
									<label for="descripcion_mVariantes">Descripción</label>
									<div class="invalid-feedback"> Debe completar el campo </div>
								</div>
							</div>
							<div class="col-12 col-md-12">
								<div class="form-check">
									<input class="form-check-input campos_mVariantes" type="checkbox" value="" id="checkHabilitado_mVariantes" checked />
									<label class="form-check-label" for="checkHabilitado_mVariantes"> Habilitado </label>
								</div>
							</div>
						</form>
					</div>

					<div class="tab-pane fade" id="tabValores_mVariantes" role="tabpanel">
						<form class="row g-5 mb-5 align-items-center" id="formValores_mVariantes" onsubmit="return false">
							<div class="col-12 col-md-12 col-lg-4">
								<div class="form-floating form-floating-outline">
									<input type="text" id="codigo_valores_mVariantes" class="form-control campos_mVariantes" placeholder="Codigo" onkeyup="appModalVariantes.habilitarBtnAgregar()" />
									<label for="codigo_valores_mVariantes">Codigo</label>
								</div>
							</div>
							<div class="col-12 col-md-12 col-lg-6">
								<div class="form-floating form-floating-outline">
									<input type="text" id="valor_valores_mVariantes" class="form-control campos_mVariantes" placeholder="Valor" onkeyup="appModalVariantes.habilitarBtnAgregar()" />
									<label for="valor_valores_mVariantes">Valor</label>
								</div>
							</div>
							<div class="col-12 col-md-12 col-lg-2">
								<button id="btnAgregarValor_mVariantes" class="btn btn-label-success w-100" disabled onclick="appModalVariantes.agregarValor()">Agregar</button>
							</div>
						</form>
						<div id="listaValores_mVariantes"></div>
					</div>


				</div>

				<div class="col-12 mt-7">
					<div class="row justify-content-end g-3">
						<div class="col-12 col-md-6 col-lg-3">
							<button type="submit" class="btn btn-success w-100" id="btnGuardar_mVariantes" onclick="appModalVariantes.guardar()">Guardar</button>
							<button type="submit" class="btn btn-success w-100" id="btnEditar_mVariantes" onclick="appModalVariantes.editar()">Editar</button>
						</div>
						<div class="col-12 col-md-6 col-lg-2">
							<button type="reset" class="btn btn-outline-danger w-100" data-bs-dismiss="modal">Cerrar</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
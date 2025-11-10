 <div class="offcanvas offcanvas-end" tabindex="-1" id="offCanvas_oConfiguracion">
     <button type="button" class="btn-close position-absolute top-0 end-0 m-5" data-bs-dismiss="offcanvas"></button>
     <div class="offcanvas-body text-center d-flex flex-column justify-content-evenly">
         <div class="d-flex flex-column gap-2">
             <i class="ri-sound-module-line text-primary" style="font-size: 55px;"></i>
             <h4 class="lh-sm m-0 text-primary">Identificadores especiales</h4>
         </div>
         <div>
             <form class="row g-5 align-items-baseline" onsubmit="return false">

                 <div class="col-12 col-md-12 col-lg-12">
                     <div class="form-floating form-floating-outline">
                         <input type="text" id="nombre_oConfiguracion" class="form-control campos_oConfiguracion camposObli_oConfiguracion" placeholder="Nomrbe" />
                         <label for="nombre_oConfiguracion">Nombre</label>
                         <div class="invalid-feedback"> Debe completar el campo </div>
                     </div>
                 </div>

                 <div class="col-12 col-md-12 col-lg-12">
                     <div class="form-floating form-floating-outline">
                         <select id="tipo_oConfiguracion" class="form-select campos_oConfiguracion camposObli_oConfiguracion select2_oConfiguracion"></select>
                         <label for="tipo_oConfiguracion">Tipo</label>
                         <div class="invalid-feedback">Debe seleccionar uno</div>
                     </div>
                 </div>

             </form>
         </div>
         <div>
             <button id="btnGuardar_oConfiguracion" type="button" class="btn rounded-pill btn-label-success waves-effect" onclick="appOffCanvasConfiguracion.guardar()">
                 <i class="tf-icons ri-check-line ri-22px me-2"></i>Aceptar
             </button>

             <button id="btnEditar_oConfiguracion" type="button" class="btn rounded-pill btn-label-success waves-effect" onclick="appOffCanvasConfiguracion.editar()">
                 <i class="tf-icons ri-check-line ri-22px me-2"></i>Aceptar
             </button>
         </div>
     </div>
 </div>
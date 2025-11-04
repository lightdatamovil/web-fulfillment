 <div class="offcanvas offcanvas-end" tabindex="-1" id="offCanvas_oPedidos">
     <button type="button" class="btn-close position-absolute top-0 end-0 m-5" data-bs-dismiss="offcanvas"></button>
     <div class="offcanvas-body text-center d-flex flex-column justify-content-evenly">
         <div class="d-flex flex-column gap-2">
             <i class="ri-inbox-archive-line text-primary" style="font-size: 55px;"></i>
             <h4 class="lh-sm m-0 text-primary">Trabajar pedido</h4>
         </div>
         <div>
             <form class="row g-5 align-items-baseline" onsubmit="return false">
                 <div class="col-12 col-md-12 col-lg-12">
                     <p class="m-0">ID venta</p>
                     <h4 class="m-0" id="idVenta_oPedidos">Sin informacion</h4>
                 </div>

                 <div class="col-12 col-md-12 col-lg-12">
                     <div class="form-floating form-floating-outline">
                         <select id="armadores_oPedidos" class="form-select campos_oPedidos camposObli_oPedidos select2_oPedidos"></select>
                         <label for="armadores_oPedidos">Asignar armador</label>
                         <div class="invalid-feedback">Debe seleccionar uno</div>
                     </div>
                 </div>

             </form>
         </div>
         <div>
             <button id="btnResolver_oPedidos" type="button" class="btn rounded-pill btn-label-success waves-effect" onclick="appOffCanvasPedidos.trabajarPedido()">
                 <i class="tf-icons ri-check-line ri-22px me-2"></i>Trabajar pedido
             </button>
         </div>
     </div>
 </div>
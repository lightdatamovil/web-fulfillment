<script>
    const globalPaginado = (function() {

        const public = {}

        public.generar = function({
            idBase,
            meta,
            estructura
        }) {
            const {
                totalItems = 0, totalPages = 1, page = 1, pageSize = 5
            } = meta || {};

            const $footer = $(`#footer${idBase}`);
            if (!$footer.length) return;

            let buffer = `
                        <div class="col-12">
                        <div class="row">
                            
                            <div class="col-12 col-md-3 col-lg-4 mb-3 mb-md-0">
                            <div class="d-flex flex-column gap-1">
                                <p class="m-0" style="color: #7b7c95;">
                                Total de registros: 
                                <span id="totalRegistros${idBase}" class="badge badge-center rounded-pill bg-label-primary">${totalItems}</span>
                                </p>
                                <p class="m-0" style="color: #7b7c95;">
                                Total de páginas: 
                                <span id="totalPaginas${idBase}" class="badge badge-center rounded-pill bg-label-primary">${totalPages}</span>
                                </p>
                            </div>
                            </div>

                            <div class="col-12 col-md-6 col-lg-4 mb-3 mb-md-0">
                            <div class="row align-items-center h-100 justify-content-center" id="paginacion${idBase}"></div>
                            </div>

                            <div class="col-12 col-md-3 col-lg-4">
                            <div class="row align-items-center h-100 justify-content-end">
                                ${totalItems > 5 ? `
                                <div class="col-12 col-md-12 col-lg-4">
                                <div class="form-floating form-floating-outline">
                                    <select id="filtroMostrar${idBase}" class="form-select">
                                    <option value="5">5</option>
                                    ${totalItems > 10 ? `<option value="10" ${totalItems > 9 && pageSize == 10 ? "selected" : ""}>10</option>` : ""}
                                    ${totalItems > 25 ? `<option value="25" ${pageSize == 25 ? "selected" : ""}>25</option>` : ""}
                                    ${totalItems > 50 ? `<option value="50" ${pageSize == 50 ? "selected" : ""}>50</option>` : ""}
                                    ${totalItems > 100 ? `<option value="100" ${pageSize == 100 ? "selected" : ""}>100</option>` : ""}
                                    ${totalItems < 100 ? `<option value="${totalItems}" ${pageSize >= totalItems ? "selected" : ""}>Todos</option>` : ""}
                                    </select>
                                    <label for="filtroMostrar${idBase}">Mostrar</label>
                                </div></div>` : ""}
                            </div>
                            </div>
                        </div>
                        </div>
                    `;

            $footer.html(buffer);
            const $contenedor = $(`#paginacion${idBase}`);
            $contenedor.empty();

            if (totalPages > 1) {
                const $ul = $('<ul class="pagination pagination-rounded m-0 p-0 d-flex justify-content-center align-items-center gap-2 flex-wrap"></ul>');

                function crearItem(pagina, label, disabled = false, active = false) {
                    const $li = $(`<li class="page-item ${active ? "active" : ""} ${disabled ? "disabled" : ""}"></li>`);
                    const $a = $(`<a href="javascript:void(0);" class="page-link m-0">${label}</a>`);

                    if (!disabled && !active) {
                        $a.on("click", function() {
                            if (pagina >= 1 && pagina <= totalPages) {
                                estructura.paginaActual = pagina;
                                estructura.getListado();
                            }
                        });
                    }

                    $li.append($a);
                    return $li;
                }

                const maxPaginasVisibles = 5;
                $ul.append(crearItem(1, `<i class="tf-icon ri-skip-back-mini-line ri-20px"></i>`, page === 1));
                $ul.append(crearItem(page - 1, `<i class="tf-icon ri-arrow-left-s-line ri-20px"></i>`, page === 1));

                let mitad = Math.floor(maxPaginasVisibles / 2);
                let inicio = Math.max(1, page - mitad);
                let fin = Math.min(totalPages, inicio + maxPaginasVisibles - 1);
                if (fin - inicio + 1 < maxPaginasVisibles) {
                    inicio = Math.max(1, fin - maxPaginasVisibles + 1);
                }

                for (let i = inicio; i <= fin; i++) {
                    $ul.append(crearItem(i, i, false, i === page));
                }

                $ul.append(crearItem(page + 1, `<i class="tf-icon ri-arrow-right-s-line ri-20px"></i>`, page === totalPages));
                $ul.append(crearItem(totalPages, `<i class="tf-icon ri-skip-forward-mini-line ri-20px"></i>`, page === totalPages));

                $contenedor.append($ul);
            }

            const $selector = $(`#filtroMostrar${idBase}`);
            if ($selector.length) {
                $selector.off("change").on("change", function() {
                    estructura.limitePorPagina = parseInt($(this).val());
                    estructura.paginaActual = 1;
                    estructura.getListado();
                });
            }
        }

        return public;
    })();
</script>
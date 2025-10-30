<script>
    const globalActivarAcciones = (function() {

        const public = {}

        public.tooltips = function({
            idContainer,
            className
        }) {
            let container;

            if (idContainer) {
                container = document.getElementById(idContainer);
            } else if (className) {
                container = document.querySelector(`.${className}`);
            }

            if (!container) return;

            const nuevosTooltips = container.querySelectorAll('[data-bs-toggle="tooltip"]');

            nuevosTooltips.forEach(el => {
                if (!el.hasAttribute('data-bs-initialized')) {
                    const tooltip = new bootstrap.Tooltip(el, {
                        trigger: 'hover'
                    });

                    el.addEventListener('click', () => {
                        tooltip.hide();
                    });

                    el.setAttribute('data-bs-initialized', 'true');
                }
            });
        }


        // USO TOOLTIP
        // <button type="button" class="btn btn-icon btn-label-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Texto"></button>
        // globalActivarAcciones.tooltips({ id: "ID_DEL_MODULO_O_MODAL" })

        public.select2 = function({
            className,
            container = null // 👈 nuevo parámetro opcional
        }) {
            let $targets;

            if (container) {
                $targets = container.find(`.${className}`);
            } else {
                $targets = $(`.${className}`);
            }

            $targets.each(function() {
                const $el = $(this);
                if ($el.data('select2')) {
                    $el.select2('destroy');
                }

                const $modalParent = $el.closest('.modal');

                if ($modalParent.length) {
                    $el.select2({
                        dropdownParent: $modalParent,
                        dropdownCssClass: 'select2-inside-modal',
                        width: '100%'
                    });
                } else {
                    $el.select2({
                        width: '100%'
                    });
                }
            });
        };

        public.activarPrimerTab = function({
            tabList
        }) {
            bootstrap.Tab.getInstance($(`#${tabList} li:first-child button`)).show()
            $(`#${tabList} .tab-slider`).css("left", "0")
        }

        public.mostrarOcultarTab = function({
            tab,
            opcion
        }) {
            const li = document.querySelector(`li.nav-item button[data-bs-target="#${tab}"]`).parentElement;
            if (opcion == 0) {
                li.classList.add(`d-none`);
            } else {
                li.classList.remove(`d-none`);
            }
        }

        public.filtrarConEnter = function({
            className,
            callback
        }) {
            $(`.${className}`).each(function() {
                $(this).off("keydown._enterFiltro");
                $(this).on("keydown._enterFiltro", function(e) {
                    if (e.key === "Enter") {
                        e.preventDefault();
                        if (typeof callback === "function") {
                            callback({
                                type: 1
                            });
                        }
                    }
                });
            });
        }

        public.toggleOffcanvas = function({
            id
        }) {
            const offcanvasEl = document.getElementById(id);
            if (!offcanvasEl) return;
            const offcanvas = bootstrap.Offcanvas.getOrCreateInstance(offcanvasEl);
            offcanvas.toggle();
        }

        public.inicializarExpandirImagen = function() {
            const lightbox = new PhotoSwipeLightbox({
                dataSource: [],
                pswpModule: PhotoSwipe,
                initialZoomLevel: 'fit',
                secondaryZoomLevel: 3,
                maxZoomLevel: 5,
            });

            lightbox.on('uiRegister', function() {
                lightbox.pswp.ui.registerElement({
                    name: 'download-button',
                    order: 9,
                    isButton: true,
                    tagName: 'button',
                    html: '',
                    className: 'pswp__download-button',
                    onInit: (el, pswp) => {
                        pswp.on('change', () => {
                            const imageUrl = pswp.currSlide.data.src;
                            if (imageUrl.startsWith("data:image")) {
                                el.style.display = "none";
                            } else {
                                el.style.display = "";
                            }
                        });

                        el.addEventListener('click', async (e) => {
                            e.preventDefault();

                            const imageUrl = pswp.currSlide.data.src;
                            if (imageUrl.startsWith("data:image")) {
                                return;
                            }

                            try {
                                const arrUrl = imageUrl.split('/');
                                const nombreFoto = arrUrl[arrUrl.length - 1];

                                const body = {
                                    idEmpresa,
                                    did: arrUrl[arrUrl.length - 2],
                                    nombreFoto,
                                };

                                const response = await fetch('https://altaenvios.lightdata.com.ar/api/descargarFoto', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify(body),
                                });

                                if (!response.ok) throw new Error('Fallo la descarga');

                                const blob = await response.blob();
                                const blobUrl = URL.createObjectURL(blob);

                                const tempLink = document.createElement('a');
                                tempLink.href = blobUrl;
                                tempLink.download = nombreFoto;
                                document.body.appendChild(tempLink);
                                tempLink.click();
                                document.body.removeChild(tempLink);
                                URL.revokeObjectURL(blobUrl);
                            } catch (err) {
                                console.error('Error al descargar la imagen:', err);
                                Swal.fire({
                                    title: "Error al descargar",
                                    icon: "warning",
                                    iconColor: "#C70000",
                                    showConfirmButton: false,
                                    timer: 1500,
                                });
                            }
                        });
                    }

                });
            });

            lightbox.init();

            return lightbox;
        }


        // USO EXPANDIR IMAGEN

        // lightboxExpandir = globalActivarAcciones.inicializarExpandirImagen();

        //    public.expandirImagen = function(event, src) {
        //     event.stopPropagation();

        //     const img = new Image();
        //     img.src = src;

        //     img.onload = function() {
        //         lightboxExpandir.options.dataSource = [{
        //             src: src,
        //             width: img.naturalWidth,
        //             height: img.naturalHeight
        //         }];
        //         lightboxExpandir.loadAndOpen(0);
        //     };

        // };

        // /USO EXPANDIR IMAGEN


        public.formRepeater = function({
            id,
            data = []
        }) {
            const $repeater = $(`#${id}`);
            let contador = 0;

            const partesId = id.split("_");
            const sufijoModulo = partesId[partesId.length - 1];

            if (!$repeater.data('template')) {
                $repeater.data('template', $repeater.html());
            }
            $repeater.html($repeater.data('template'));

            $repeater.repeater({
                initEmpty: false,

                show: function() {
                    contador++;
                    const self = $(this);

                    self.find('input, select, textarea').each(function() {
                        if (!$(this).val()) $(this).val('');
                        const idOriginal = $(this).attr('id');
                        if (idOriginal) $(this).attr('id', `${idOriginal}_${contador}`);
                    });

                    self.find(`select.select2_repeater_${sufijoModulo}`).each(function() {
                        globalActivarAcciones.select2({
                            className: `select2_repeater_${sufijoModulo}`,
                            container: self
                        });
                    });

                    self.stop(true, true).slideDown();
                    globalActivarAcciones.tooltips({
                        idContainer: id
                    });
                },

                hide: function(deleteElement) {
                    const self = $(this);
                    const totalFilas = self.parent().find('[data-repeater-item]').length;

                    if (totalFilas <= 1) {
                        globalSweetalert.alert({
                            titulo: "Debe haber al menos una fila"
                        });
                        return;
                    }

                    const todosVacios = self.find('input:not([type="hidden"]),select:not([type="hidden"]),textarea:not([type="hidden"])')
                        .toArray()
                        .every(input => $(input).val() ? $(input).val().trim() == '' : true);

                    if (todosVacios) {
                        self.stop(true, true).slideUp(deleteElement);
                        return;
                    }

                    globalSweetalert.confirmar({
                        titulo: "¿Estas seguro de eliminar esta fila?",
                        color: "var(--bs-danger)"
                    }).then(function(confirmado) {
                        if (confirmado) {
                            self.stop(true, true).slideUp(deleteElement);
                        }
                    });
                }
            });

            if (data && data.length > 0) {
                $repeater.setList(data);
            }

            // 👇 ESTE BLOQUE ES LA SOLUCIÓN 👇
            if (!data || data.length === 0) {
                $repeater.find(`select.select2_repeater_${sufijoModulo}`).each(function() {
                    globalActivarAcciones.select2({
                        className: `select2_repeater_${sufijoModulo}`,
                        container: $repeater
                    });
                });
            }
        };




        public.obtenerDataFormRepeater = function({
            id
        }) {
            const $element = $(`#${id}`);
            if ($element.length === 0) return [];

            const data = $element?.repeaterVal();
            if (!data || Object.keys(data).length === 0) return [];

            const primeraClave = Object.keys(data)[0];
            const lista = Array.isArray(data[primeraClave]) ? data[primeraClave] : [];

            const filtrado = lista.filter(item =>
                Object.values(item).some(valor => valor && valor.toString().trim() !== '')
            );

            return filtrado;
        };



        return public
    }())
</script>
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
            className
        }) {
            $(`.${className}`).each(function() {
                if ($(this).hasClass("select2-hidden-accessible")) {
                    $(this).select2('destroy');
                }

                const $modalParent = $(this).closest('.modal');

                if ($modalParent.length) {
                    $(this).select2({
                        dropdownParent: $modalParent,
                        dropdownCssClass: 'select2-inside-modal',
                        width: '100%'
                    });
                } else {
                    $(this).select2({
                        width: '100%'
                    });
                }
            });
        }

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

        public.formRepeater = function({
            id,
            data = []
        }) {
            const $repeater = $(`#${id}`);
            let contador = 0;

            if (!$repeater.data('template')) {
                $repeater.data('template', $repeater.html());
            }
            $repeater.html($repeater.data('template'));

            $repeater.repeater({
                initEmpty: false,

                show: function() {
                    contador++;
                    const self = $(this);

                    self.find('input').each(function() {
                        const idOriginal = $(this).attr('id');
                        if (idOriginal) $(this).attr('id', `${idOriginal}_${contador}`);
                    });

                    self.stop(true, true).slideDown();
                    globalActivarAcciones.tooltips({
                        idContainer: id
                    })
                },

                hide: function(deleteElement) {
                    const self = $(this);

                    const todosVacios = self.find('input:not([type="hidden"]),select:not([type="hidden"])').toArray().every(input => {
                        return $(input).val().trim() == '';
                    });

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

        };

        public.obtenerDataFormRepeater = function({
            id
        }) {
            if ($(`#${id}`).length === 0) {
                console.warn(`⚠️ No se encontró el elemento "${`#${id}`}"`);
                return {};
            }
            return $(`#${id}`).repeaterVal();
        }

        return public
    }())
</script>
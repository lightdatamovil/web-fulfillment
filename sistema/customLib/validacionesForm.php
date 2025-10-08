<script>
    const globalValidar = (function() {

        const public = {};

        public.vacio = function({
            id
        }) {
            const $elemento = $(`#${id}`);
            let value = $elemento.val();
            value = Array.isArray(value) ? value.join(', ') : value;
            const mensaje = $elemento.siblings('.invalid-feedback');

            if (value === "" || value === null) {
                $elemento.addClass('is-invalid');

                if ($elemento.is('select')) {
                    mensaje.text("Debe seleccionar al menos uno");
                } else {
                    mensaje.text("Debe completar el campo");
                }

                return true;
            } else {
                $elemento.removeClass('is-invalid');
                return false;
            }
        };


        public.sinCaracteresEspeciales = function({
            id
        }) {
            let value = $(`#${id}`).val().trim();
            let mensaje = $(`#${id}`).siblings('.invalid-feedback');

            if (value.match(/[^a-z0-9]/)) {
                $(`#${id}`).addClass('is-invalid');
                mensaje.text("Solo se permiten letras minúsculas y números");
                return true;
            } else {
                $(`#${id}`).removeClass('is-invalid');
                return false;
            }
        };

        public.soloLetras = function({
            id
        }) {
            value = $(`#${id}`).val().trim();
            mensaje = $(`#${id}`).siblings('.invalid-feedback');

            if (value.match(/[^a-zA-Z]/)) {
                $(`#${id}`).addClass('is-invalid');
                mensaje.text("Solo se permiten letras");
                return true
            } else {
                $(`#${id}`).removeClass('is-invalid');
                return false
            }
        };

        public.letrasYEspacios = function({
            id
        }) {
            let value = $(`#${id}`).val().trim();
            let mensaje = $(`#${id}`).siblings('.invalid-feedback');

            if (value.match(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/)) {
                $(`#${id}`).addClass('is-invalid');
                mensaje.text("Solo se permiten letras y espacios");
                return true;
            } else {
                $(`#${id}`).removeClass('is-invalid');
                return false;
            }
        };


        public.soloNumeros = function({
            id
        }) {
            value = $(`#${id}`).val().trim();
            mensaje = $(`#${id}`).siblings('.invalid-feedback');

            if (value.match(/[^0-9]/)) {
                $(`#${id}`).addClass('is-invalid');
                mensaje.text("Solo se permiten números");
                return true
            } else {
                $(`#${id}`).removeClass('is-invalid');
                return false
            }
        };

        public.email = function({
            id
        }) {
            value = $(`#${id}`).val().trim();
            mensaje = $(`#${id}`).siblings('.invalid-feedback');

            if (value.match(/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/)) {
                $(`#${id}`).removeClass('is-invalid');
                return false
            } else {
                $(`#${id}`).addClass('is-invalid');
                mensaje.text("Ingrese un email válido");
                return true
            }
        };

        public.carecteresMinimos = function({
            id,
            minimo
        }) {
            value = $(`#${id}`).val().trim();
            mensaje = $(`#${id}`).siblings('.invalid-feedback');

            if (value.length < minimo) {
                $(`#${id}`).addClass('is-invalid');
                mensaje.text(`El campo debe tener al menos ${minimo} caracteres`);
                return true
            } else {
                $(`#${id}`).removeClass('is-invalid');
                return false
            }
        };

        public.coincideContraseña = function({
            idOriginal,
            idCopia
        }) {
            value = $(`#${idOriginal}`).val().trim();
            value2 = $(`#${idCopia}`).val().trim();
            mensaje = $(`#${idOriginal}`).siblings('.invalid-feedback');
            mensaje2 = $(`#${idCopia}`).siblings('.invalid-feedback');


            if (value !== value2) {
                $(`#${idOriginal}, #${idCopia}`).addClass('is-invalid');
                mensaje.text("Las contraseñas no coinciden");
                mensaje2.text("Las contraseñas no coinciden");
                return true
            } else {
                $(`#${idOriginal}, #${idCopia}`).removeClass('is-invalid');
                return false
            }
        };


        public.formulario = function({
            idForm
        }) {
            return $(`#${idForm} .is-invalid`).length > 0;
        };

        public.limpiarUna = function({
            id
        }) {
            $(`#${id}`).removeClass('is-invalid')
        }

        public.limpiarTodas = function() {
            $(".is-invalid").removeClass('is-invalid')
        }

        public.habilitarTiempoReal = function({
            className,
            callback
        }) {
            $(`.${className}`).each(function() {
                if ($(this).is("select")) {
                    $(this).on("change", function() {
                        callback();
                    });
                } else {
                    $(this).on("keyup", function() {
                        callback();
                    });
                }
            });
        }

        public.deshabilitarTiempoReal = function({
            className
        }) {
            $(`.${className}`).each(function() {
                if ($(this).is("select")) {
                    $(this).off("change");
                } else {
                    $(this).off("keyup");
                }
            });
        }

        public.obligatorios = function({
            className
        }) {
            let faltanCampos = false

            $(`.${className}`).each(function() {
                if (globalValidar.vacio({
                        id: this["id"]
                    })) faltanCampos = true;
            });

            return faltanCampos
        }

        public.obtenerCambios = function({
            dataNueva,
            dataOriginal
        }) {
            const cambios = {};

            // función para normalizar fechas
            function normalizarFecha(valor) {
                if (!valor) return null;
                try {
                    return new Date(valor).toISOString().slice(0, 19); // YYYY-MM-DDTHH:mm:ss en UTC
                } catch {
                    return valor; // si no es parseable, lo dejo igual
                }
            }

            Object.keys(dataNueva).forEach(key => {
                let nuevo = dataNueva[key];
                let original = dataOriginal[key];

                if (Array.isArray(nuevo) && Array.isArray(original)) {
                    nuevo = _.sortBy(nuevo);
                    original = _.sortBy(original);
                }

                if (
                    typeof nuevo === "string" &&
                    typeof original === "string" &&
                    (key.toLowerCase().includes("fecha") || key.toLowerCase().includes("hora"))
                ) {
                    nuevo = normalizarFecha(nuevo);
                    original = normalizarFecha(original);
                }

                if (!_.isEqual(nuevo, original)) {
                    cambios[key] = dataNueva[key];
                }
            });

            return cambios;
        };


        public.obtenerCambiosParaPUT = function({
            dataNueva,
            dataOriginal
        }) {
            const cambios = {};

            // función para normalizar fechas
            function normalizarFecha(valor) {
                if (!valor) return null;
                try {
                    return new Date(valor).toISOString().slice(0, 19); // YYYY-MM-DDTHH:mm:ss en UTC
                } catch {
                    return valor; // si no es parseable, lo dejo igual
                }
            }

            Object.keys(dataNueva).forEach(key => {
                let nuevo = dataNueva[key];
                let original = dataOriginal[key];

                if (Array.isArray(nuevo) && Array.isArray(original)) {
                    // normalizamos arrays (ordenamos para comparar)
                    const arrNuevo = _.sortBy(nuevo);
                    const arrOriginal = _.sortBy(original);

                    if (!_.isEqual(arrNuevo, arrOriginal)) {
                        const removidos = _.difference(arrOriginal, arrNuevo);
                        const agregados = _.difference(arrNuevo, arrOriginal);

                        if (removidos.length > 0) {
                            cambios[`${key}_remove`] = removidos;
                        }
                        if (agregados.length > 0) {
                            cambios[`${key}_add`] = agregados;
                        }
                    }
                } else {
                    // normalización de fechas/horas en strings
                    if (
                        typeof nuevo === "string" &&
                        typeof original === "string" &&
                        (key.toLowerCase().includes("fecha") || key.toLowerCase().includes("hora"))
                    ) {
                        nuevo = normalizarFecha(nuevo);
                        original = normalizarFecha(original);
                    }

                    if (!_.isEqual(nuevo, original)) {
                        cambios[key] = dataNueva[key];
                    }
                }
            });

            return cambios;
        };

        public.obtenerCambiosEnArray = function({
            dataNueva,
            dataOriginal
        }) {
            let obj = {
                add: [],
                update: [],
                remove: []
            }

            dataNueva.forEach(dato => {
                if (dato.did == 0) {
                    obj.add.push(dato)
                } else {
                    let viejo = dataOriginal.find(datoOriginal => datoOriginal.did == dato.did)
                    if (viejo) {
                        obj.update.push(dato)
                    } else {
                        obj.remove.push(dato.did)
                    }
                }
            })
        }

        public.formRepeater = function({
            id
        }) {
            const $repeater = $(`#${id}`);
            $repeater.find('[data-repeater-item]').each(function() {
                const $fila = $(this);
                const did = $fila.find('input[name="did"]').val()?.trim();
                const $inputs = $fila.find('input, select, textarea');

                if (!did) {
                    const todosVacios = $inputs.toArray().every(input => $(input).val().trim() === '');
                    const sufijo = id.substring(id.lastIndexOf('_') + 1);
                    if (todosVacios) {
                        $inputs.removeClass(`camposObli_${sufijo}`);
                        $inputs.removeClass('is-invalid')
                    } else {
                        $inputs.addClass(`camposObli_${sufijo}`);
                    }
                }
            });
        }

        return public;
    })();
</script>
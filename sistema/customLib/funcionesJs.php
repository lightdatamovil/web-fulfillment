<script>
    const globalFuncionesJs = (function() {

        const public = {}

        public.inputSoloNumeros = function(input) {
            input.value = input.value.replace(/[^0-9]/g, "")
        }

        public.inputSoloDecimales = function(input) {
            input.value = input.value
                .replace(/[^0-9.]/g, "")
                .replace(/(\..*)\./g, "$1")
        }

        public.compararDosObjetos = function(a, b) {
            if (a === b) return true;

            if (typeof a !== 'object' || typeof b !== 'object' || a == null || b == null) {
                return false;
            }

            const keysA = Object.keys(a);
            const keysB = Object.keys(b);

            if (keysA.length !== keysB.length) return false;

            for (let key of keysA) {
                if (!keysB.includes(key)) return false;
                if (!globalFuncionesJs.compararDosObjetos(a[key], b[key])) return false;
            }

            return true;
        }

        public.convertirPrecio = function(precio) {
            if (!precio) return "$0"

            return new Intl.NumberFormat('es-AR', {
                style: 'currency',
                currency: 'ARS',
                minimumFractionDigits: 2,
            }).format(precio);
        }

        public.formatearFecha = function({
            fecha,
            para
        }) {
            const f = fecha ? new Date(fecha) : new Date();

            const dia = String(f.getDate()).padStart(2, "0");
            const mes = String(f.getMonth() + 1).padStart(2, "0");
            const anio = f.getFullYear();
            const horas = String(f.getHours()).padStart(2, "0");
            const minutos = String(f.getMinutes()).padStart(2, "0");

            switch (para) {
                case "frontend":
                    return `${dia}/${mes}/${anio} ${horas}:${minutos}`;
                case "api":
                    return `${anio}-${mes}-${dia} ${horas}:${minutos}:00`;
                case "datetimeLocal":
                    return `${anio}-${mes}-${dia}T${horas}:${minutos}`;
                case "date":
                    return `${anio}-${mes}-${dia}`;
                default:
                    return `${anio}-${mes}-${dia}T${horas}:${minutos}`;
            }
        };



        return public;

    }())
</script>
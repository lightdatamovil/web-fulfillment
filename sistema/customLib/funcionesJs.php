<script>
    const globalFuncionesJs = (function() {

        const public = {}

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

        public.formatearFecha = function(fechaISO) {
            const fecha = new Date(fechaISO);

            const dia = String(fecha.getDate()).padStart(2, '0');
            const mes = String(fecha.getMonth() + 1).padStart(2, '0'); // Meses van de 0 a 11
            const anio = fecha.getFullYear();

            const horas = String(fecha.getHours()).padStart(2, '0');
            const minutos = String(fecha.getMinutes()).padStart(2, '0');

            return `${dia}/${mes}/${anio} ${horas}:${minutos}`;
        }

        return public;

    }())
</script>
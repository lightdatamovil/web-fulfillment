<script>
    const globalEstadosGlobales = (function() {

        const public = {};

        public.add = function({
            key,
            data
        }) {
            if (!appSistema[key]) appSistema[key] = [];

            if (Array.isArray(data)) {
                appSistema[key].push(...data);
            } else {
                appSistema[key].push(data);
            }
        };

        public.update = function({
            key,
            data
        }) {
            if (!appSistema[key]) appSistema[key] = [];

            if (!data?.did) {
                console.warn("Falta el campo 'did' para update.");
                return;
            }

            const arr = appSistema[key];
            const i = arr.findIndex(o => o.did == data.did);

            if (i !== -1) {
                arr[i] = {
                    ...arr[i],
                    ...data
                };
            } else {
                console.warn(`No se encontró el elemento con did ${data.did} en ${key}.`);
            }
        };

        public.remove = function({
            key,
            data
        }) {
            if (!appSistema[key]) appSistema[key] = [];
            appSistema[key] = appSistema[key].filter(o => o.did != data.did);
        };

        return public;
    })();
</script>
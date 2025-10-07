<script>
    const globalRequest = (function() {

        const public = {}

        function request({
            url,
            method = "GET",
            data = null,
            onSuccess = () => {},
            onError = () => {},
            onComplete = () => {}
        }) {
            globalLoading.open();

            return new Promise((resolve, reject) => {
                $.ajax({
                    url: `${appSistema.urlServer}${url}`,
                    type: method,
                    contentType: data ? "application/json" : false,
                    data: data ? JSON.stringify(data) : null,
                    headers: {
                        Authorization: `Bearer ${appSistema.authToken}`
                    },
                    success: (result) => {
                        onSuccess(result);
                        resolve(result);
                    },
                    error: function(xhr) {
                        globalSweetalert.errorReportable({
                            error: xhr,
                            ruta: this.url,
                            metodo: this.type
                        });
                        onError(xhr);
                        reject(xhr);
                    },
                    complete: function() {
                        globalLoading.close();
                        onComplete();
                    }
                });
            });
        }



        public.get = (url, callbacks) => request({
            url,
            method: "GET",
            ...callbacks
        });

        public.post = (url, data, callbacks) => request({
            url,
            method: "POST",
            data,
            ...callbacks
        });

        public.put = (url, data, callbacks) => request({
            url,
            method: "PUT",
            data,
            ...callbacks
        });

        public.delete = (url, callbacks) => request({
            url,
            method: "DELETE",
            ...callbacks
        });


        return public
    })()
</script>
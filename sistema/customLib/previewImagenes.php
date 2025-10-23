<script>
    const globalImageCarousel = (function() {
        let lightboxExpandir;
        const public = {};

        public.init = function({
            id,
            type = "subir",
            arrUrls = [],
            multiple = true // ✅ nueva opción
        }) {
            const container = document.getElementById(id);
            if (!container) return;

            container.innerHTML = `
            <div id="carousel_${id}" class="carousel slide h-100 w-100">
                ${type === "subir" ? `<input type="file" accept="image/*" ${multiple ? "multiple" : ""} style="display:none;">` : ""}
                <div class="carousel-inner h-100 rounded border"></div>

                <a class="carousel-control-prev d-none" href="#carousel_${id}" role="button" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </a>
                <a class="carousel-control-next d-none" href="#carousel_${id}" role="button" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </a>
            </div>
        `;

            const input = container.querySelector("input[type='file']");
            const carouselInner = container.querySelector(".carousel-inner");

            container.dataset.type = type;
            container.dataset.files = JSON.stringify(arrUrls);
            container.dataset.multiple = multiple; // ✅ guardamos la opción

            if (arrUrls.length > 0) {
                _reloadUpload(id, arrUrls);
            } else if (type === "subir") {
                carouselInner.innerHTML = `<div class="carousel-item active h-100">
                <div class="d-block w-100 h-100 bg-body"></div>
                <div class="carousel-caption p-0">
                    <p class="m-0 text-body" style="font-size: 0.6rem;">Haz clic o arrastra imágenes aquí</p>
                </div>
            </div>`;
            }

            if (type === "subir" && input) {
                carouselInner.addEventListener("click", () => input.click());

                input.addEventListener("change", (e) => {
                    if (!e.target.files || e.target.files.length === 0) return;
                    _previewImages(container, e.target.files);
                });

                carouselInner.addEventListener("dragover", (e) => {
                    e.preventDefault();
                    carouselInner.classList.add("border", "border-primary");
                });
                carouselInner.addEventListener("dragleave", () => {
                    carouselInner.classList.remove("border", "border-primary");
                });
                carouselInner.addEventListener("drop", (e) => {
                    e.preventDefault();
                    carouselInner.classList.remove("border", "border-primary");
                    _previewImages(container, e.dataTransfer.files);
                });
            }

            lightboxExpandir = globalActivarAcciones.inicializarExpandirImagen();
        };

        public.loadImages = function({
            id,
            arrUrls = []
        }) {
            const container = document.getElementById(id);
            const carouselInner = container.querySelector(".carousel-inner");
            container.dataset.files = JSON.stringify(arrUrls);

            carouselInner.innerHTML = "";
            _toggleArrows(container, arrUrls.length);

            arrUrls.forEach((url, index) => {
                const div = document.createElement("div");
                div.className = `carousel-item h-100 ${index === 0 ? "active" : ""}`;
                div.innerHTML = `
                <img src="${url}" class="d-block w-100 h-100" style="object-fit:cover;">
                <div class="carousel-caption p-0" style="bottom: 5%">
                    <button type="button" class="btn rounded btn-icon btn-label-info btn-xs" onclick="globalImageCarousel.expandirImagen(event, '${url}')">
                        <i class="tf-icons ri-expand-diagonal-fill ri-13px"></i>
                    </button>
                </div>
            `;
                carouselInner.appendChild(div);
            });
        };

        public.getImages = function({
            id
        }) {
            const container = document.getElementById(id);
            return JSON.parse(container.dataset.files || "[]");
        };

        public.expandirImagen = function(event, src) {
            event.stopPropagation();

            const img = new Image();
            img.src = src;
            img.onload = function() {
                lightboxExpandir.options.dataSource = [{
                    src: src,
                    width: img.naturalWidth,
                    height: img.naturalHeight
                }];
                lightboxExpandir.loadAndOpen(0);
            };
        };

        function _previewImages(container, filesOrUrls) {
            const carouselInner = container.querySelector(".carousel-inner");
            const multiple = container.dataset.multiple === "true";
            let currentFiles = JSON.parse(container.dataset.files || "[]");

            // Si no es multiple, limpiar antes
            if (!multiple) currentFiles = [];

            carouselInner.innerHTML = "";

            if (filesOrUrls instanceof FileList) {
                // ✅ si multiple = false, tomamos solo el primer archivo
                const files = multiple ? Array.from(filesOrUrls) : [filesOrUrls[0]];

                files.forEach((file, index) => {
                    if (!file.type.startsWith("image/")) return;
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        currentFiles.push(e.target.result);
                        _appendCarouselItem(container, e.target.result, currentFiles.length === 1);
                        container.dataset.files = JSON.stringify(currentFiles);
                        _toggleArrows(container, currentFiles.length);
                    };
                    reader.readAsDataURL(file);
                });
            } else {
                // si es array de urls/base64
                const urls = multiple ? filesOrUrls : [filesOrUrls[0]];
                urls.forEach((src, index) => {
                    currentFiles.push(src);
                    _appendCarouselItem(container, src, index === 0);
                });
                container.dataset.files = JSON.stringify(currentFiles);
                _toggleArrows(container, currentFiles.length);
            }
        }


        function _appendCarouselItem(container, src, isActive) {
            const carouselInner = container.querySelector(".carousel-inner");
            const div = document.createElement("div");
            div.className = `carousel-item h-100 ${isActive ? "active" : ""}`;
            div.innerHTML = `
            <img src="${src}" class="d-block w-100 h-100" style="object-fit:cover;">
            <div class="carousel-caption p-0" style="bottom: 5%">
                <button type="button" class="btn rounded btn-icon btn-label-info btn-xs me-1" onclick="globalImageCarousel.expandirImagen(event, '${src}')">
                    <i class="tf-icons ri-expand-diagonal-fill ri-13px"></i>
                </button>
                <button type="button" class="btn rounded btn-icon btn-label-danger btn-xs" onclick="globalImageCarousel.removeImage(event, '${container.id}', '${src}')">
                    <i class="tf-icons ri-delete-bin-line ri-13px"></i>
                </button>
            </div>
        `;
            carouselInner.appendChild(div);
        }

        public.removeImage = function(event, containerId, src) {
            event.stopPropagation();
            const container = document.getElementById(containerId);
            let currentFiles = JSON.parse(container.dataset.files || "[]");
            currentFiles = currentFiles.filter((img) => img !== src);
            _reloadUpload(containerId, currentFiles);
        };

        function _reloadUpload(containerId, base64Array) {
            const container = document.getElementById(containerId);
            const carouselInner = container.querySelector(".carousel-inner");

            container.dataset.files = JSON.stringify(base64Array);
            carouselInner.innerHTML = "";

            if (base64Array.length === 0) {
                carouselInner.innerHTML = `<div class="carousel-item active h-100">
                <div class="d-block w-100 h-100 bg-body"></div>
                <div class="carousel-caption p-0">
                    <p class="m-0 text-secondary" style="font-size: 0.6rem;">Haz clic o arrastra imágenes aquí</p>
                </div>`;
                _toggleArrows(container, 0);
                return;
            }

            base64Array.forEach((src, index) => {
                _appendCarouselItem(container, src, index === 0);
            });
            _toggleArrows(container, base64Array.length);
        }

        function _toggleArrows(container, count) {
            const prev = container.querySelector(".carousel-control-prev");
            const next = container.querySelector(".carousel-control-next");
            if (count > 1) {
                prev.classList.remove("d-none");
                next.classList.remove("d-none");
            } else {
                prev.classList.add("d-none");
                next.classList.add("d-none");
            }
        }

        return public;
    })();
</script>
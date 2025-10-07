<script>
    const globalInputImg = (function() {
        let _uploaderBase64s = {};

        const public = {}

        public.crear = function(id, imagenUrl = "") {
            const $el = $('#' + id);
            if (!$el.length) return console.error("Contenedor no encontrado:", id);
            $el.empty();

            buffer = "";
            buffer += `<div class="drop-zone" id="${id}-dz">`
            buffer += `<span class="dz-title" style="font-size: 22px;">Subir imagen</span>`
            buffer += `<span class="dz-text" style="font-size: 13px;">Arrastrá y soltá una imagen aquí o hacé click</span>`
            buffer += `<img id="${id}-preview" />`
            buffer += `<input type="file" id="${id}-input" accept="image/*" />`
            buffer += `<button type="button" id="${id}-clear" class="btn btn-icon btn-danger ocultar"><i class="tf-icons ri-delete-bin-5-fill ri-22px"></i></button>`
            buffer += `</div>`

            $el.html(buffer);

            const $dz = $(`#${id}-dz`);
            const $input = $(`#${id}-input`);
            const $preview = $(`#${id}-preview`);
            const $title = $dz.find(".dz-title");
            const $text = $dz.find(".dz-text");
            const $clearBtn = $(`#${id}-clear`);

            $clearBtn.hide();

            _uploaderBase64s[id] = "";

            if (imagenUrl) {
                $preview.attr("src", imagenUrl).show();
                $title.hide();
                $text.hide();
                $clearBtn.removeClass("ocultar");
            }

            $dz.off("click").on("click", function(e) {
                if (e.target !== $input[0]) {
                    $input.trigger("click");
                }
            });
            $input.off("click").on("click", e => e.stopPropagation());

            $dz.off("dragover").on("dragover", (e) => {
                e.preventDefault();
                $dz.addClass("dragover");
            });

            $dz.off("dragleave").on("dragleave", () => {
                $dz.removeClass("dragover");
            });

            $dz.off("drop").on("drop", (e) => {
                e.preventDefault();
                $dz.removeClass("dragover");
                const file = e.originalEvent.dataTransfer.files[0];
                if (file && file.type.startsWith("image/")) {
                    leerImagen(file);
                }
            });

            $input.off("change").on("change", function() {
                if (this.files.length) leerImagen(this.files[0]);
            });

            $clearBtn.off("click").on("click", (e) => {
                e.stopPropagation();
                $preview.hide().attr("src", "");
                $title.show();
                $text.show();
                $clearBtn.addClass("ocultar");

                $input.val('');
                _uploaderBase64s[id] = "";
            });

            function leerImagen(file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const base64 = e.target.result;
                    _uploaderBase64s[id] = base64;

                    $preview.attr("src", base64).show();
                    $title.hide();
                    $text.hide();
                    $clearBtn.removeClass("ocultar");

                };
                reader.readAsDataURL(file);
            }
        };

        public.obtener = function(id) {
            return _uploaderBase64s[id] || "";
        }

        return public;
    }())
</script>

<style>
    .drop-zone {
        width: 100%;
        height: 100%;
        border: 2px dashed #cfd0d6;
        border-radius: 10px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #cfd0d6;
        cursor: pointer;
        transition: border-color 0.3s;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .drop-zone img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 10px;
        display: none;
    }

    .drop-zone.dragover {
        border-color: var(--bs-primary);
        color: var(--bs-primary);
    }

    .drop-zone input[type="file"] {
        display: none;
    }

    .drop-zone button {
        position: absolute;
        top: 10px;
        right: 10px;
    }
</style>
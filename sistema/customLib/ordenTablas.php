<script>
    const globalOrdenTablas = (function() {
        const public = {}

        public.activar = function({
            idThead,
            callback,
            defaultOrder = null
        }) {
            let currentOrder = defaultOrder;
            let currentDir = "asc";

            $(`#${idThead} th[data-order]`).each(function() {
                if ($(this).find("i").length === 0) {
                    $(this).append(' <i class="ri-sort-desc text-secondary"></i>');
                }
            }).css("cursor", "pointer");

            $(`#${idThead} th[data-order] i`)
                .removeClass("active-icon text-primary text-info")
                .attr("class", "ri-sort-desc text-secondary");

            if (defaultOrder) {
                const $thDefault = $(`#${idThead} th[data-order="${defaultOrder}"]`);
                $thDefault.find("i").attr("class", "ri-sort-asc text-primary active-icon");
            }

            $(`#${idThead} th[data-order]`)
                .off("mouseenter mouseleave")
                .hover(
                    function() {
                        const $icon = $(this).find("i");
                        if ($icon.hasClass("active-icon")) {
                            $icon.removeClass("text-primary").addClass("text-info");
                        } else {
                            $icon.removeClass("text-secondary");
                        }
                    },
                    function() {
                        const $icon = $(this).find("i");
                        if ($icon.hasClass("active-icon")) {
                            $icon.removeClass("text-info").addClass("text-primary");
                        } else {
                            $icon.addClass("text-secondary");
                        }
                    }
                );

            $(`#${idThead} th[data-order]`)
                .off("click")
                .on("click", function() {
                    let order = $(this).data("order");
                    let dir = "asc";

                    if (currentOrder === order) {
                        dir = currentDir === "asc" ? "desc" : "asc";
                    }

                    currentOrder = order;
                    currentDir = dir;

                    $(`#${idThead} th[data-order] i`)
                        .removeClass("active-icon text-primary text-info")
                        .attr("class", "ri-sort-desc text-secondary");

                    let icon = dir === "asc" ? "ri-sort-asc" : "ri-sort-desc";
                    $(this).find("i").attr("class", icon + " text-primary active-icon");

                    callback({
                        type: 1,
                        orderBy: order,
                        orderDir: dir
                    });
                });

            if (defaultOrder) {
                callback({
                    type: 1,
                    orderBy: defaultOrder,
                    orderDir: currentDir
                });
            }
        }

        return public;
    }())
</script>
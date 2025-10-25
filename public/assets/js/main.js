// import { roundArrow } from "tippy.js";
document.addEventListener("DOMContentLoaded", () => {
    tippy("nav ul li", {
        // arrow: roundArrow,
        onShow(instance) {
            instance.popper.querySelector(".tippy-box").style.backgroundColor =
                "#bec7d4";
            instance.popper.querySelector(".tippy-box").style.color =
                "#383838";
        },
        animation: "fade",
        theme: "material",
        placement: "right",
        delay: [100, 100],
    });
});

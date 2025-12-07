document.addEventListener("DOMContentLoaded", () => {
    tippy("nav ul li", {
        animation: "fade",
        theme: "material",
        placement: "right",
        delay: [100, 100],
    });
    tippy("#tooltipLearning", {
        animation: "apple",
        theme: "liquid",
        placement: "bottom",
        delay: [100, 100],
        arrow: true,
    });
});

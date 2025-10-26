    document.addEventListener("DOMContentLoaded", () => {
            const html = document.documentElement;
            const themeToggle = document.getElementById("theme-toggle");
            const body = document.body;

            // 🌓 Fungsi untuk menerapkan tema dari localStorage
            function applyTheme(theme) {
                if (theme === "dark") {
                    html.classList.add("dark");
                } else {
                    html.classList.remove("dark");
                }
            }

            // 🌗 Cek dan terapkan tema awal
            const savedTheme = localStorage.getItem("theme");
            if (savedTheme) {
                applyTheme(savedTheme);
            } else {
                // jika belum ada di localStorage, gunakan preferensi sistem
                const prefersDark = window.matchMedia("(prefers-color-scheme: dark)").matches;
                applyTheme(prefersDark ? "dark" : "light");
                localStorage.setItem("theme", prefersDark ? "dark" : "light");
            }

            // ✨ Event: klik tombol toggle
            themeToggle.addEventListener("click", () => {
                const currentTheme = localStorage.getItem("theme");

                let newTheme;

                if (currentTheme === "dark") {
                    const themeAnimation = document.createElement("div");
                    themeAnimation.classList.add("theme-animation-light");
                    body.appendChild(themeAnimation);
                    newTheme = "light";
                } else {
                    const themeAnimation = document.createElement("div");
                    themeAnimation.classList.add("theme-animation-dark");
                    body.appendChild(themeAnimation);
                    newTheme = "dark";
                }


                setTimeout(() => {
                    applyTheme(newTheme);
                    localStorage.setItem("theme", newTheme);
                    setTimeout(() => {
                        document.querySelector(".theme-animation-dark")?.remove(), document
                            .querySelector(".theme-animation-light")?.remove();
                    }, 100)
                }, 1000);
            });

            // 🔄 Update otomatis jika localStorage berubah di tab lain
            window.addEventListener("storage", (e) => {
                if (e.key === "theme") {
                    applyTheme(e.newValue);
                }
            });
        });
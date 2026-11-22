// Apply the saved theme before the stylesheet paints to avoid a theme flash.
(function () {
    var theme = null;

    try {
        theme = localStorage.getItem("sms-theme");
    } catch (error) {
        // Storage can be unavailable in private or restricted contexts.
    }

    if (theme !== "light" && theme !== "dark") {
        theme = window.matchMedia &&
            window.matchMedia("(prefers-color-scheme: dark)").matches
            ? "dark"
            : "light";
    }

    document.documentElement.setAttribute("data-theme", theme);
    document.documentElement.style.colorScheme = theme;
})();

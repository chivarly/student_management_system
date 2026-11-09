// Confirm before deleting a student record.
document.addEventListener("submit", function (event) {
    const form = event.target;

    if (form instanceof HTMLFormElement && form.matches("[data-confirm]")) {
        const message = form.getAttribute("data-confirm") || "Are you sure you want to continue?";

        if (!window.confirm(message)) {
            event.preventDefault();
        }
    }
});

// Toggle password visibility using the eye icon.
document.addEventListener("click", function (event) {
    const target = event.target;
    if (!(target instanceof Element)) return;

    const toggle = target.closest(".password-toggle");
    if (!toggle) return;

    const wrapper = toggle.closest(".password-wrapper");
    const input = wrapper ? wrapper.querySelector("input") : null;
    if (!input) return;

    const showing = input.type === "password";
    input.type = showing ? "text" : "password";
    toggle.classList.toggle("is-visible", showing);
    toggle.setAttribute("aria-label", showing ? "Hide password" : "Show password");
});

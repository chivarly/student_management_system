// Confirm before deleting a student
document.addEventListener("submit", function (event) {
    const form = event.target;

    if (form.matches("[data-confirm]")) {
        const message = form.getAttribute("data-confirm");

        if (!confirm(message)) {
            event.preventDefault();
        }
    }
});

// Show / hide password when the eye icon is clicked
document.addEventListener("click", function (event) {

    // Did the click happen on (or inside) a password toggle button?
    const toggle = event.target.closest(".password-toggle");

    if (!toggle) {
        return; // Not a toggle click, so do nothing
    }

    // Find the password input that sits in the same wrapper
    const wrapper = toggle.closest(".password-wrapper");
    const input = wrapper.querySelector("input");

    // If it is currently hidden, we are about to show it
    const showing = input.type === "password";

    input.type = showing ? "text" : "password";

    // Swap the eye / eye-off icon (CSS reads this class)
    toggle.classList.toggle("is-visible", showing);

    // Update the label for screen readers
    toggle.setAttribute("aria-label", showing ? "Hide password" : "Show password");
});
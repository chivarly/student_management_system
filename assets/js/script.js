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
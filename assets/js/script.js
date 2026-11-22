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

// Keep every theme toggle's accessible label in sync with the active theme.
function syncThemeToggles() {
    const isDark = document.documentElement.getAttribute("data-theme") === "dark";
    const label = isDark ? "Switch to light mode" : "Switch to dark mode";

    document.querySelectorAll("[data-theme-toggle]").forEach(function (button) {
        button.setAttribute("aria-label", label);
        button.setAttribute("title", label);
    });
}

// Switch between light and dark mode and remember the choice.
document.addEventListener("click", function (event) {
    const target = event.target;
    if (!(target instanceof Element)) return;

    const toggle = target.closest("[data-theme-toggle]");
    if (!toggle) return;

    const isDark = document.documentElement.getAttribute("data-theme") === "dark";
    const theme = isDark ? "light" : "dark";

    document.documentElement.setAttribute("data-theme", theme);
    document.documentElement.style.colorScheme = theme;

    try {
        localStorage.setItem("sms-theme", theme);
    } catch (error) {
        // The theme still applies for this page even if storage is unavailable.
    }

    syncThemeToggles();
});

// Mobile sidebar drawer.
function initNavigation() {
    const toggle = document.querySelector("[data-nav-toggle]");
    const backdrop = document.querySelector("[data-nav-backdrop]");

    if (!toggle) return;

    function setOpen(open) {
        document.body.classList.toggle("nav-open", open);
        toggle.setAttribute("aria-expanded", open ? "true" : "false");
        toggle.setAttribute("aria-label", open ? "Close navigation" : "Open navigation");

        if (backdrop) {
            backdrop.hidden = !open;
        }
    }

    toggle.addEventListener("click", function () {
        setOpen(!document.body.classList.contains("nav-open"));
    });

    if (backdrop) {
        backdrop.addEventListener("click", function () {
            setOpen(false);
        });
    }

    document.addEventListener("keydown", function (event) {
        if (event.key === "Escape") {
            setOpen(false);
        }
    });

    document.querySelectorAll("[data-sidebar] a").forEach(function (link) {
        link.addEventListener("click", function () {
            if (window.matchMedia("(max-width: 1080px)").matches) {
                setOpen(false);
            }
        });
    });

    window.addEventListener("resize", function () {
        if (window.innerWidth > 1080) {
            setOpen(false);
        }
    });
}

// Filter courses by the selected department. The department/course data is
// rendered from the database; nothing is mapped in JavaScript.
function initDependentCourses() {
    document.querySelectorAll("[data-department-select]").forEach(function (departmentSelect) {
        const form = departmentSelect.closest("form");
        const courseSelect = form ? form.querySelector("[data-course-select]") : null;
        if (!courseSelect) return;

        const allCourses = Array.prototype.slice
            .call(courseSelect.querySelectorAll("option[data-department]"))
            .map(function (option) {
                return {
                    value: option.value,
                    label: option.textContent,
                    department: option.getAttribute("data-department")
                };
            });

        const initialCourse = courseSelect.value;

        function renderCourses(keepSelection) {
            const departmentId = departmentSelect.value;
            const selected = keepSelection ? initialCourse : "";

            courseSelect.innerHTML = "";

            const placeholder = document.createElement("option");
            placeholder.value = "";
            placeholder.textContent = departmentId
                ? "Select Course"
                : "Select a department first";
            courseSelect.appendChild(placeholder);

            if (!departmentId) {
                courseSelect.disabled = true;
                return;
            }

            const matching = allCourses.filter(function (course) {
                return course.department === departmentId;
            });

            courseSelect.disabled = matching.length === 0;

            if (matching.length === 0) {
                placeholder.textContent = "No courses available";
                return;
            }

            matching.forEach(function (course) {
                const option = new Option(course.label, course.value);
                option.setAttribute("data-department", course.department);
                courseSelect.appendChild(option);
            });

            if (selected && matching.some(function (course) {
                return course.value === selected;
            })) {
                courseSelect.value = selected;
            }
        }

        renderCourses(true);

        departmentSelect.addEventListener("change", function () {
            renderCourses(false);
        });
    });
}

syncThemeToggles();
initNavigation();
initDependentCourses();

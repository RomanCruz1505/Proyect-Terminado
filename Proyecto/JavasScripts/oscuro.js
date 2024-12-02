document.addEventListener("DOMContentLoaded", function() {
    const toggleThemeButton = document.getElementById("toggle-theme-btn");

    toggleThemeButton.addEventListener("click", function() {
        document.body.classList.toggle("dark-theme");
    });
});

document.addEventListener("DOMContentLoaded", function () {
    document.querySelector(".messages-section").addEventListener("click", function (event) {
        if (event.target.classList.contains("delete-btn")) {
            if (!confirm("¿Estás seguro de que deseas eliminar este mensaje? Esta acción no se puede deshacer.")) {
                event.preventDefault();
            }
        }
    });
});

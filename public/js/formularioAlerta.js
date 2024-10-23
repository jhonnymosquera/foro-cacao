
const formularios_ajax = document.querySelectorAll(".formularioAlerta");

formularios_ajax.forEach((formularios) => {
    formularios.addEventListener("submit", formularioAlerta);
});

const texto = {
    save: "Los datos quedarán guardados en el sistema",
    delete: "Los datos serán eliminados completamente del sistema",
    update: "Los datos del sistema serán actualizados",
    search: "Se eliminará el término de búsqueda y tendrás que escribir uno nuevo",
    loans: "Desea remover los datos seleccionados para acción",
};

async function formularioAlerta(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const method = this.getAttribute("method");
    const action = this.getAttribute("action");
    const tipo = this.getAttribute("data-form");

    const result = await Swal.fire({
        title: "¿Estás seguro?",
        text: texto[tipo] || "Quieres realizar la operación solicitada",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#198754",
        cancelButtonColor: "#dc3545",
        confirmButtonText: "Confirmar",
        cancelButtonText: "Cancelar",
    });

    if (result.isConfirmed) {
        try {
            const headers = new Headers();
            headers.append("Content-Type", "application/json");

            const body = {};
            for (const [key, value] of formData.entries()) {
                body[key] = value;
            }

            const res = await fetch(action, {
                method,
                headers,
                body: JSON.stringify(body),
            });

            const { message, icon, redirect, data } = await res.json();

            console.log(data);

            await Swal.fire({
                title: message,
                icon,
                confirmButtonColor: "#159650",
                confirmButtonText: "Ok",
            });

            if (redirect) window.location.href = redirect;
        } catch (error) {
            Swal.fire({
                title: "Error",
                text: `Algo salió mal: ${error.message}`,
                icon: "error",
                confirmButtonColor: "#dc3545",
                confirmButtonText: "Ok",
            });
        }
    }
}

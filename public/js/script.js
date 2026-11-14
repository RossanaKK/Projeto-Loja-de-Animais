function submitForm(formId) {
    document.getElementById(formId).submit();
}

document.addEventListener('DOMContentLoaded', function () {
    const alertas = document.querySelectorAll('.alerta-sucesso');
    alertas.forEach(function (alerta) {
        setTimeout(function () {
            alerta.style.display = 'none';
        }, 4000);
    });
});

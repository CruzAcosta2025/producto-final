console.log('toggle-files.js cargado');

document.addEventListener('DOMContentLoaded', function() {
    function toggleFiles(event) {
        const button = event.currentTarget;
        const targetId = button.getAttribute('data-target');
        const targetElement = document.getElementById(targetId);

        if (targetElement) {
            const isHidden = targetElement.classList.contains('hidden');

            // Cambiar el texto del botón
            button.textContent = isHidden ? 'Ocultar Archivos' : 'Ver Archivos';

            // Animación suave para mostrar u ocultar
            targetElement.classList.toggle('hidden');
            if (isHidden) {
                targetElement.style.display = 'block';
                targetElement.style.opacity = '0';
                setTimeout(() => {
                    targetElement.style.opacity = '1';
                }, 10);
            } else {
                targetElement.style.opacity = '0';
                setTimeout(() => {
                    targetElement.style.display = 'none';
                }, 200);
            }
        }
    }

    const toggleButtons = document.querySelectorAll('.toggle-files');
    toggleButtons.forEach(button => {
        button.addEventListener('click', toggleFiles);
    });
});

const dropdowns = document.querySelectorAll('.dropdown');

dropdowns.forEach(dropdown => {
    const trigger = dropdown.querySelector('a');
    const content = dropdown.querySelector('.dropdown-content');

    trigger.addEventListener('click', (event) => {
        event.preventDefault(); // Prevent default link behavior
        content.classList.toggle('active');
    });
});

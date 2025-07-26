document.getElementById('dropdown-menu').addEventListener('click', function() {
    this.classList.toggle('active');
    const menuContent = document.getElementById('dropdown-menu-content');
    menuContent.classList.toggle('active');
});


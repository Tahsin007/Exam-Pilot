// Toggle menu on mobile devices
var menuIcon = document.querySelector('.menu-icon');
var menuItems = document.querySelector('.menu-items');
menuIcon.addEventListener('click', function() {
  menuItems.classList.toggle('active');
});

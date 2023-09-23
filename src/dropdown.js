import '../styles/dashboard.css';
import '../styles/faculty&staff.css';
import '../styles/modern-normalize.css';

document.addEventListener("DOMContentLoaded", function() {
  // Get all the parent menu items
  var parentMenuItems = document.querySelectorAll('.sidebar-menu .has-dropdown');
  var sidebarToggle = document.querySelector('.sidebar-toggle');
  var sidebar = document.querySelector('.sidebar');

  // Add event listener to each parent menu item
  parentMenuItems.forEach(function(parentMenuItem) {
    parentMenuItem.addEventListener('click', function() {
      // Toggle the "active" class on the clicked parent menu item
      this.classList.toggle('active');

      // Toggle the "expanded" class on the corresponding dropdown menu
      var dropdownMenu = this.querySelector('.dropdown-menu');
      dropdownMenu.classList.toggle('expanded');
    });
  });

  sidebarToggle.addEventListener('click', function() {
    sidebar.classList.toggle('open');
  });




});

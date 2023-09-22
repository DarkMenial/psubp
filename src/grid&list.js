document.addEventListener('DOMContentLoaded', function() {
  var toggleButtons = document.querySelectorAll('.toggle-btn');
  var announcementLists = document.querySelectorAll('.announcement-list');
  var loadMoreButton = document.getElementById('load-more-btn');

  var itemsPerPage = 9; // Number of items to show by default
  var itemsToShow = itemsPerPage; // Initial number of items to show

  // Hide items beyond the initially shown items
  var listItems = document.querySelectorAll('.announcement-list.list-view li');
  for (var i = itemsToShow; i < listItems.length; i++) {
    listItems[i].style.display = 'none';
  }

  toggleButtons.forEach(function(button) {
    button.addEventListener('click', function() {
      var displayType = this.getAttribute('data-display-type');

      toggleButtons.forEach(function(btn) {
        btn.classList.remove('active');
      });
      this.classList.add('active');

      announcementLists.forEach(function(list) {
        list.classList.remove('grid-view', 'list-view');
        list.classList.add(displayType + '-view');
      });
    });
  });

  loadMoreButton.addEventListener('click', function() {
    itemsToShow += 3;

    // Show additional items
    for (var i = 0; i < listItems.length; i++) {
      if (i < itemsToShow) {
        listItems[i].style.display = 'block';
      }
    }
  
    // Hide "Load More" button if all items are shown
    if (itemsToShow >= listItems.length) {
      loadMoreButton.style.display = 'none';
    }
  });

  // Fetch announcements from the server and render them
  function fetchAnnouncements() {
    fetch('/api/announcements')
      .then(response => response.json())
      .then(data => {
        const announcementsContainer = document.getElementById('announcements');
        announcementsContainer.innerHTML = '';

        // Iterate through the announcements and create <li> elements
        data.forEach(announcement => {
          const listItem = document.createElement('li');
          listItem.textContent = announcement.title;
          announcementsContainer.appendChild(listItem);
        });
      })
      .catch(error => {
        console.error('Error fetching announcements:', error);
      });
  }

  // Call the function to fetch and render the announcements
  fetchAnnouncements();
});

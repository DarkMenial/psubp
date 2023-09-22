var editProfileBtns = document.querySelectorAll('.edit-profile-btn');
  var floatingForm = document.getElementById('floating-form');
  var cancelBtn = document.querySelector('#floating-form .cancel-btn');

  // Show floating form on Edit Profile button click
  editProfileBtns.forEach(function(btn) {
    btn.addEventListener('click', function() {
      floatingForm.classList.remove('hidden');
    });
  });

  // Hide floating form on Cancel button click
  cancelBtn.addEventListener('click', function() {
    floatingForm.classList.add('hidden');
  });

  // Submit form data and handle form submission
  document.getElementById('edit-profile-form').addEventListener('submit', function(event) {
    event.preventDefault();
    // Handle form submission, e.g., perform AJAX request or update data
    floatingForm.classList.add('hidden');
  });
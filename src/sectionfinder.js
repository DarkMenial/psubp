const navButtons = document.querySelectorAll('.nav-button');
const sections = document.querySelectorAll('section');

// Function to check if a section is currently in view

// function isSectionInView(section) {
//   const rect = section.getBoundingClientRect();
//   return rect.top >= 0 && rect.bottom <= window.innerHeight;
// }




// Function to activate the button for the currently active section
function activateButtonForSection(sectionId) {
  navButtons.forEach(button => {
    const buttonSectionId = button.getAttribute('data-section');
    if (sectionId === buttonSectionId) {
      button.classList.add('active');
    } else {
      button.classList.remove('active');
    }
  });
}

// Event listener for scroll event
window.addEventListener('scroll', function() {
  let activeSectionId = null;

  // Loop through sections to find the active section
  sections.forEach(section => {
    if (isSectionInView(section)) {
      activeSectionId = section.id;
    }
  });

  // Activate the button for the active section
  if (activeSectionId) {
    activateButtonForSection(activeSectionId);
  }
});

// Event listeners for button click
navButtons.forEach(button => {
  button.addEventListener('click', function() {
    const sectionId = button.getAttribute('data-section');
    const targetSection = document.getElementById(sectionId);

    if (targetSection) {
      // Scroll to the target section
      targetSection.scrollIntoView({ behavior: 'smooth' });

      // Activate the button for the target section
      activateButtonForSection(sectionId);
    }
  });
});

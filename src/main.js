import './sectionfinder.js';
import './carousel.js';
import './grid&list.js';
import './nav.js';
import '../script.js';
import './floating.js';
import './create-post.js';
import './main.js';
import './dropdown.js';
import './manage-post.js';

import '../styles/style.css';
import '../styles/modern-normalize.css';
import '../styles/utils.css';
import '../styles/nav.css';




const navButtons = document.querySelectorAll('.nav-button');

navButtons.forEach(button => {
  button.addEventListener('click', function() {
    // Remove active class from all buttons
    navButtons.forEach(btn => btn.classList.remove('active'));
    // Add active class to the clicked button
    button.classList.add('active');
  });
});











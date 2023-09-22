

const nav = document.querySelector('nav');
const navHeight = nav.offsetHeight;
const shrinkDistance = 200; // Distance in pixels to shrink the nav

window.addEventListener('scroll', function() {
  if (window.scrollY > shrinkDistance) {
    nav.classList.add('shrink');
  } else {
    nav.classList.remove('shrink');
  }
});

// JavaScript code to handle dropdown behavior
var timeoutId;

function showDropdown() {
  clearTimeout(timeoutId);
  document.querySelector('.dropdown').style.display = 'block';
}

function hideDropdown() {
  timeoutId = setTimeout(function() {
    document.querySelector('.dropdown').style.display = 'none';
  }, 200);
}

// Add event listeners to the dropdown trigger element
var triggerElement = document.querySelector('.secondary-list li');
triggerElement.addEventListener('mouseenter', showDropdown);
triggerElement.addEventListener('mouseleave', hideDropdown);

const faqItems = document.querySelectorAll('.faq-item');

faqItems.forEach(item => {
  const question = item.querySelector('.faq-question');
  const answer = item.querySelector('.faq-answer');

  question.addEventListener('click', () => {
    item.classList.toggle('active');
  });
});

// JavaScript code to toggle search bar visibility
const searchIcon = document.getElementById('search-icon');
const searchBar = document.getElementById('search-bar');
const searchResultsContainer = document.getElementById('search-results-container');
const navButton = document.getElementById('nav-button');

searchIcon.addEventListener('click', function() {
  searchBar.style.display = searchBar.style.display === 'none' ? 'block' : 'none';
  searchIcon.classList.toggle('active');
});

navButton.addEventListener('click', function() {
  searchBar.style.display = 'none';
});

searchIcon.addEventListener('mouseover', function() {
  searchIcon.style.color = 'white';
});

searchIcon.addEventListener('mouseout', function() {
  if (!searchIcon.classList.contains('active')) {
    searchIcon.style.color = 'black';
  }
});
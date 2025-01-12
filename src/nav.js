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





// banner overlay


// Get the image element
const img = document.querySelector('.container__pages img');

// Calculate the average brightness of the image
const getAverageBrightness = () => {
  const canvas = document.createElement('canvas');
  const context = canvas.getContext('2d');
  const imgWidth = img.width;
  const imgHeight = img.height;

  canvas.width = imgWidth;
  canvas.height = imgHeight;
  context.drawImage(img, 0, 0, imgWidth, imgHeight);

  let sum = 0;

  const imageData = context.getImageData(0, 0, imgWidth, imgHeight);
  const data = imageData.data;

  for (let i = 0; i < data.length; i += 4) {
    const brightness = (data[i] + data[i + 1] + data[i + 2]) / 3;
    sum += brightness;
  }

  const averageBrightness = sum / (imgWidth * imgHeight);
  return averageBrightness;
};

// Adjust the overlay color based on the image's average brightness
const overlay = document.querySelector('.banner__overlay');
const averageBrightness = getAverageBrightness();

const maxBrightness = 255;  // Max value for RGB channel
const overlayOpacity = averageBrightness / maxBrightness;

overlay.style.backgroundColor = `rgba(0, 0, 0, ${overlayOpacity})`;




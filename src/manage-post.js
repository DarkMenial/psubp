// Get the elements
const changeFeaturedBtn = document.querySelector(".change-featured");
const featurePostOptions = document.querySelector(".feature-post-options");
const searchFeaturePostInput = document.querySelector(".search-feature-post");
const changeFeaturedDropdown = document.querySelector(".change-featured-dropdown");
const saveButton = document.querySelector(".save-button");
const doneButton = document.querySelector(".done-button");
const featurePostForm = document.getElementById("featurePostForm");

// Add event listener to the "Change" button
changeFeaturedBtn.addEventListener("click", () => {
  changeFeaturedBtn.classList.add("hidden");
  featurePostOptions.classList.remove("hidden");
});

// Add event listener to the form submission
featurePostForm.addEventListener("submit", (event) => {
  event.preventDefault(); // Prevent the default form submission
  
  const newTitle = searchFeaturePostInput.value;
  if (newTitle.trim() === "") {
    alert("Please enter a post title.");
    return;
  }

  const selectedType = changeFeaturedDropdown.value;
  
  // Set the form action dynamically based on the selected type
  featurePostForm.action = `./php/update_featured_post.php?type=${encodeURIComponent(selectedType)}`;

  // Submit the form
  featurePostForm.submit();
});

// Add event listener to the "Done" button
doneButton.addEventListener("click", () => {
  doneButton.classList.add("hidden");
  changeFeaturedBtn.classList.remove("hidden");
  searchFeaturePostInput.value = ""; // Reset the input field
});
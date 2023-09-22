// Get the elements
const changeFeaturedBtn = document.querySelector(".change-featured");
const featurePostOptions = document.querySelector(".feature-post-options");
const searchFeaturePostInput = document.querySelector(".search-feature-post");
const changeFeaturedDropdown = document.querySelector(".change-featured-dropdown");
const saveButton = document.querySelector(".save-button");
const doneButton = document.querySelector(".done-button");

// Add event listener to the "Change" button
changeFeaturedBtn.addEventListener("click", () => {
  featurePostOptions.classList.toggle("hidden");
});

// Add event listener to the "Save" button
saveButton.addEventListener("click", () => {
  saveButton.textContent = "Saved";
  saveButton.classList.add("saved");
  saveButton.disabled = true;
  doneButton.classList.remove("hidden");
});

// Add event listener to the "Done" button
doneButton.addEventListener("click", () => {
  featurePostOptions.classList.add("hidden");
  saveButton.textContent = "Save";
  saveButton.classList.remove("saved");
  saveButton.disabled = false;
  doneButton.classList.add("hidden");
});

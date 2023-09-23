function previewImage(event) {
    var input = event.target;
    var preview = document.getElementById("image-preview");
    var discardButton = document.getElementById("discard-image");
  
    if (input.files && input.files[0]) {
      var reader = new FileReader();
  
      reader.onload = function(e) {
        preview.src = e.target.result;
        preview.style.display = "block";
        discardButton.style.display = "inline-block";
        input.style.display = "none";
      };
  
      reader.readAsDataURL(input.files[0]);
    } else {
      preview.src = "";
      preview.style.display = "none";
      discardButton.style.display = "none";
      input.style.display = "block";
    }
  }
  
  function discardImage() {
    var input = document.getElementById("image");
    var preview = document.getElementById("image-preview");
    var discardButton = document.getElementById("discard-image");
  
    input.value = "";
    preview.src = "";
    preview.style.display = "none";
    discardButton.style.display = "none";
    input.style.display = "block";
  }
  
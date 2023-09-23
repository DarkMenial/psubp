// Assume 'content' is the string containing the content entered by the admin
const parser = new DOMParser();
const htmlDoc = parser.parseFromString(content, 'text/html');

// 'formattedContent' will store the formatted content with proper HTML structure
let formattedContent = '';

// Loop through each paragraph element and extract its inner HTML
const paragraphs = htmlDoc.getElementsByTagName('p');
for (let i = 0; i < paragraphs.length; i++) {
  formattedContent += paragraphs[i].innerHTML;
}

// Display the formatted content
console.log(formattedContent);




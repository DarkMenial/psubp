<main>
  <!-- Contact Us and Newsletter Section -->
  <div class="contact-us-wrapper">
    <!-- Contact Us Section -->
    <!-- <section class="contact-section">
      <div class="container">
        <h2 class="section-title">Contact Us</h2>
        <input type="text" id="subject" placeholder="Subject" required>
        <p>Have a question or feedback? Feel free to send us a message.</p>
        <textarea id="message" placeholder="Type your message here" required></textarea>
        <input type="email" id="user-email" placeholder="Your Email" required>
        <button onclick="sendEmail()">Send</button>
      </div>
    </section> -->

    <!-- Newsletter Subscription Section -->
    <section class="newsletter-section">
      <div class="container">
        <h2 class="section-title">Subscribe to Our Newsletter</h2>
        <p>Select the department you would like to receive updates from:</p>
        <label for="department-choice">Choose a department:</label>
        <select id="department-choice">
<<<<<<< Updated upstream
          <option value="bsit">BSIT</option>
          <option value="bshm">BSHM</option>
          <option value="university">University</option>
=======
        <option value="all">All</option>
        <?php
            $topicsQuery = "SELECT * FROM accounts";
            $topicsResult = mysqli_query($conn, $topicsQuery);

            while ($row = mysqli_fetch_assoc($topicsResult)) {
              $topicID = $row['account_id'];
              $topicName = $row['account_name'];

              echo '<option value="' . $topicName . '">' . $topicName . '</option>';
            }

            mysqli_free_result($topicsResult);
            ?>
>>>>>>> Stashed changes
        </select>
        <input type="email" id="newsletter-email" placeholder="Your Email" required>
        <button onclick="subscribeNewsletter()">Subscribe</button>
      </div>
    </section>
  </div>

<<<<<<< Updated upstream
=======


>>>>>>> Stashed changes
  <!-- Map Section -->
  <section class="map-section">
    <div class="container">
      <h2 class="section-title">Our Location</h2>
      <div id="google-map">
        <iframe 
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3942.749474859703!2d117.82441387445249!3d8.80959059238603!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3234f85554ceb7df%3A0xaa8e0b20e351edde!2sPalawan%20State%20University%20-%20Brooke&#39;s%20Point%20Campus!5e0!3m2!1sen!2sph!4v1696016965417!5m2!1sen!2sph" 
          width="100%" 
          height="300" 
          style="border:0;" 
          allowfullscreen="" 
          loading="lazy" 
          referrerpolicy="no-referrer-when-downgrade">
<<<<<<< Updated upstream
        </iframe>
=======
        </iframe> 
>>>>>>> Stashed changes
      </div>
    </div>
  </section>
</main>

<style>
  /* General Layout */
  .contact-us-wrapper {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
  }

  /* Contact Us and Newsletter Section Styles */
  .contact-section,
  .newsletter-section {
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #f9f9f9;
  }

  input,
  textarea,
  select {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
  }

  button {
    padding: 10px 20px;
    background-color: #f05c26;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
  }

  button:hover {
    background-color: #e04a20;
  }

  /* Map Section Styles */
  .map-section {
    margin-top: 20px;
    max-width: 1200px;
    margin: 20px auto;
  }

  .map-section iframe {
    width: 100%;
    height: 300px;
    border-radius: 8px;
    border: 1px solid #ccc;
  }
</style>

<script>
  // Function to send email
  function sendEmail() {
    const subject = document.getElementById('subject').value;
    const message = document.getElementById('message').value;
    const email = document.getElementById('user-email').value;

    if (subject && message && email) {
      console.log(`Email Sent!\nSubject: ${subject}\nMessage: ${message}\nFrom: ${email}`);
      alert("Your message has been sent!");
    } else {
      alert("Please fill in all fields.");
    }
  }

  // Function to subscribe to the newsletter
  function subscribeNewsletter() {
    const email = document.getElementById('newsletter-email').value;
    const department = document.getElementById('department-choice').value;

    if (email) {
      console.log(`Subscribed to ${department} updates with email: ${email}`);
      alert(`You have successfully subscribed to ${department} updates.`);
    } else {
      alert("Please enter your email address.");
    }
  }

  // Function to dynamically set user's email
  document.addEventListener('DOMContentLoaded', () => {
    fetch('/get_user_email.php') // Replace with your actual API endpoint
      .then(response => response.json())
      .then(data => {
        if (data.email) {
          document.getElementById('user-email').value = data.email;
          document.getElementById('newsletter-email').value = data.email;
        }
      })
      .catch(error => console.error('Error fetching user email:', error));
  });
</script>


<?php include './html_utils/header.php';?>

<main>

  <section class="container__pages container__banner">
    <div>
      <div class="banner__content">
        <h2>Program Heads</h2>
      </div>
      <img src="./public/banner.jpg" alt="Banner Image" />
      <div class="banner__overlay"></div>
    </div>
  </section>

  <div class="section"></div>

  <main>
    <section class="container">
      <div class="profile-container">
        <div class="profile-card">
          <div class="program">Information Technology</div>
          <div class="profile-card__image">
            <img src="./public/featured1.jpg" alt="Program Head Image" class="profile-card__image">
          </div>
          <div class="profile-card__details">
            <h3>Dr. John Doe</h3>
            <p>Designation: Program Head, Faculty</p>
            <p>Email: john.doe@example.com</p>
            <p>Phone: +1 123 456 7890</p>
            <button class="view-profile-button">View Profile</button>
          </div>
        </div>

        <div class="profile-card">
          <div class="program">Information Technology</div>
          <div class="profile-card__image">
            <img src="./public/featured1.jpg" alt="Program Head Image" class="profile-card__image">
          </div>
          <div class="profile-card__details">
            <h3>Dr. John Doe</h3>
            <p>Designation: Program Head, Faculty</p>
            <p>Email: john.doe@example.com</p>
            <p>Phone: +1 123 456 7890</p>
            <button class="view-profile-button">View Profile</button>
          </div>
        </div>


        <div class="profile-card">
          <div class="program">Information Technology</div>
          <div class="profile-card__image">
            <img src="./public/featured1.jpg" alt="Program Head Image" class="profile-card__image">
          </div>
          <div class="profile-card__details">
            <h3>Dr. John Doe</h3>
            <p>Designation: Program Head, Faculty</p>
            <p>Email: john.doe@example.com</p>
            <p>Phone: +1 123 456 7890</p>
            <button class="view-profile-button">View Profile</button>
          </div>
        </div>

        <div class="profile-card">
          <div class="program">Information Technology</div>
          <div class="profile-card__image">
            <img src="./public/featured1.jpg" alt="Program Head Image" class="profile-card__image">
          </div>
          <div class="profile-card__details">
            <h3>Dr. John Doe</h3>
            <p>Designation: Program Head, Faculty</p>
            <p>Email: john.doe@example.com</p>
            <p>Phone: +1 123 456 7890</p>
            <button class="view-profile-button">View Profile</button>
          </div>
        </div>


        <div class="profile-card">
          <div class="program">Information Technology</div>
          <div class="profile-card__image">
            <img src="./public/featured1.jpg" alt="Program Head Image" class="profile-card__image">
          </div>
          <div class="profile-card__details">
            <h3>Dr. John Doe</h3>
            <p>Designation: Program Head, Faculty</p>
            <p>Email: john.doe@example.com</p>
            <p>Phone: +1 123 456 7890</p>
            <button class="view-profile-button">View Profile</button>
          </div>
        </div>


        <div class="profile-card">
          <div class="program">Business Administration</div>
          <div class="profile-card__image">
            <img src="./public/featured1.jpg" alt="Program Head Image" class="profile-card__image">
          </div>
          <div class="profile-card__details">
            <h3>Dr. John Doe</h3>
            <p>Designation: Program Head, Faculty</p>
            <p>Email: john.doe@example.com</p>
            <p>Phone: +1 123 456 7890</p>
            <button class="view-profile-button">View Profile</button>
          </div>
        </div>


        <div class="profile-card">
          <div class="program">Agriculture</div>
          <div class="profile-card__image">
            <img src="./public/featured1.jpg" alt="Program Head Image" class="profile-card__image">
          </div>
          <div class="profile-card__details">
            <h3>Dr. John Doe</h3>
            <p>Designation: Program Head, Faculty</p>
            <p>Email: john.doe@example.com</p>
            <p>Phone: +1 123 456 7890</p>
            <button class="view-profile-button">View Profile</button>
          </div>
        </div>

        <!-- Add more profile cards as needed -->

      </div>
    </section>
  </main>

  <style>
    /* Existing styles */

    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }

    .section {
      padding: 20px;
    }

    .profile-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 20px;
    }

    .profile-card {
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 20px;
      background-color: #f5f5f5;
      border: 1px solid #ccc;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      width: 280px;
      text-align: center;
    }

    .profile-card:hover {
      box-shadow: 0 6px 10px rgba(0, 0, 0, 0.2);
    }

    .program {
  font-size: 24px;
  font-weight: bold;
  margin-bottom: 10px;
  max-width: 200px; /* Adjust the maximum width as needed */
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}


    .profile-card__image img {
      width: 100px;
      height: 100px;
      object-fit: cover;
      border-radius: 50%;
    }

    .profile-card__details {
      flex: 1;
      margin-top: 10px;
    }

    .profile-card h3 {
      font-size: 20px;
      margin-bottom: 5px;
    }

    .profile-card p {
      font-size: 16px;
      margin: 0;
    }

    .view-profile-button {
      margin-top: 10px;
      padding: 10px 20px;
      background-color: #007BFF;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .view-profile-button:hover {
      background-color: #0056b3;
    }
  </style>

  <?php include './html_utils/footer.php';?>

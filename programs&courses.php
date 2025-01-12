<?php include './html_utils/header.php';?>


<main>


<section class="container__pages container__banner">
  <div>
    <div class="banner__content">
      <h2>Programs & Courses</h2>
    </div>
    <img src="./public/banner.jpg" alt="Banner Image" />
    <div class="banner__overlay"></div>
  </div>
</section>


<div class="section"></div>

  <section class="container">
      <ul class="program-list">
        <li class="program-card">
          <h3>Bachelor of Science in Criminology</h3>
          <button class="department-button"><a href="criminology_department.php">View Department</a></button>
        </li>
        <li class="program-card">
          <h3>Bachelor of Science in Business Administration</h3>
          <ul class="subprogram-list">
            <li>Human Resource Development Management</li>
            <li>Financial Management</li>
            <li>Marketing Management</li>
            <li>Management Accounting</li>
          </ul>
          <button class="department-button"><a href="business_department.php">View Department</a></button>
        </li>
        <li class="program-card">
          <h3>Bachelor of Science in Hospitality Management</h3>
          <button class="department-button"><a href="hospitality_department.php">View Department</a></button>
        </li>
        <li class="program-card">
          <h3>Bachelor of Science in Agriculture</h3>
          <button class="department-button"><a href="agriculture_department.php">View Department</a></button>
        </li>
        <li class="program-card">
          <h3>Bachelor of Science in Information Technology</h3>
          <button class="department-button"><a href="it_department.php">View Department</a></button>
        </li>
        <li class="program-card">
          <h3>Bachelor of Elementary Education</h3>
          <ul class="subprogram-list">
            <li>English</li>
            <li>Mathematics</li>
          </ul>
          <button class="department-button"><a href="elementary_education_department.php">View Department</a></button>
        </li>
        <li class="program-card">
          <h3>Bachelor of Secondary Education</h3>
          <ul class="subprogram-list">
            <li>English</li>
            <li>Mathematics</li>
          </ul>
          <button class="department-button"><a href="secondary_education_department.php">View Department</a></button>
        </li>
      </ul>
    </section>
  </main>

  <style>
    /* Your existing styles */

    .department-button {
      margin-top: 10px;
      padding: 5px 15px;
      background-color: #f05c26;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      text-decoration: none;
      font-size: 15px;
    }

    .department-button:hover {
      background-color: #333;
    }



    .program-list {
      list-style-type: none;
      padding: 0;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      grid-gap: 20px;
    }

    .program-card {
      background-color: white;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
    }

    .program-card h3 {
      margin: 0;
      font-size: 18px;
      font-weight: 600;
      color: #333333;
    }

    .subprogram-list {
      list-style-type: disc;
      margin-top: 10px;
      margin-bottom: 0;
      padding-left: 20px;
    }

    .subprogram-list li {
      font-size: 14px;
      color: #555555;
    }
  </style>

  <?php include './html_utils/footer.php'; ?>
</main>


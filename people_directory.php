<?php include './html_utils/header.php'; ?>



<section class="container__pages container__banner">
  <div>
    <div class="banner__content">
      <h2>People Directory</h2>
    </div>
    <img src="public/banner.jpg" alt="Banner Image" />
    <div class="banner__overlay"></div>
  </div>
</section>

<div class="section">
  <main class="container">

    <input type="text" id="searchInput" class="search-bar" placeholder="Search for names..">

    <select id="accountFilter">
      <option value="all">All Category</option>
      <option value="bsit">Information Technology</option>
      <option value="bcom">Business Administration</option>
      <!-- Add other options based on your categories -->
    </select>

    <select id="designationFilter">
      <option value="all">All Designation</option>
      <option value="faculty">Faculty</option>
      <option value="staff">Staff</option>
      <option value="others">Others</option>
    </select>

    <div id="contactList">
      <div class="card" data-account="bsit" data-designation="faculty">
        <h3>Department of Information Technology</h3>
        <p>Email: info_tech@psu.edu</p>
        <p>Phone: +123 456 7890</p>
      </div>

      <div class="card" data-account="bsit" data-designation="staff">
        <h3>Admissions Office</h3>
        <p>Email: admissions@psu.edu</p>
        <p>Phone: +123 456 7890</p>
      </div>

      <div class="card" data-account="bcom" data-designation="faculty">
        <h3>Student Affairs</h3>
        <p>Email: student_affairs@psu.edu</p>
        <p>Phone: +123 456 7890</p>
      </div>
    </div>
  </main>
</div>



<style>
</style>


<script>
  const searchInput = document.getElementById('searchInput');
  const accountFilter = document.getElementById('accountFilter');
  const designationFilter = document.getElementById('designationFilter');
  const cards = document.querySelectorAll('.card');

  function applyFilters() {
    const selectedAccount = accountFilter.value;
    const selectedDesignation = designationFilter.value;
    const searchText = searchInput.value.toLowerCase();

    cards.forEach(card => {
      const account = card.getAttribute('data-account');
      const designation = card.getAttribute('data-designation');
      const cardText = card.innerText.toLowerCase();

      const isAccountMatch = selectedAccount === 'all' || account === selectedAccount;
      const isDesignationMatch = selectedDesignation === 'all' || designation === selectedDesignation;
      const isTextMatch = searchText === '' || cardText.includes(searchText);

      if (isAccountMatch && isDesignationMatch && isTextMatch) {
        card.style.display = 'block';
      } else {
        card.style.display = 'none';
      }
    });
  }

  accountFilter.addEventListener('change', applyFilters);
  designationFilter.addEventListener('change', applyFilters);
  searchInput.addEventListener('input', applyFilters);
</script>

<?php include './html_utils/footer.php'; ?>
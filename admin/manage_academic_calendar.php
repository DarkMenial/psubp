<?php
require_once './php/db_connect.php';

session_start();

if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
<<<<<<< HEAD
?>

<?php
include './admin_utils/admin_header.php';
?>

<?php
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Update the database with the edited calendar data
  $activities = $_POST['activities'];
  $firstSemesterStart = $_POST['first_semester_start'];
  $secondSemesterStart = $_POST['second_semester_start'];

  // Prepare and execute the SQL query to update the calendar data
  $updateSql = "UPDATE academic_calendar SET first_semester_start = ?, second_semester_start = ? WHERE activities = ?";
  $updateStmt = mysqli_prepare($conn, $updateSql);

  foreach ($activities as $index => $activity) {
    $firstSemesterEnd = date('Y-m-d', strtotime($_POST['first_semester_end'][$index]));
    $secondSemesterEnd = date('Y-m-d', strtotime($_POST['second_semester_end'][$index]));
    mysqli_stmt_bind_param($updateStmt, 'sss', $firstSemesterStart[$index] . ' - ' . $firstSemesterEnd, $secondSemesterStart[$index] . ' - ' . $secondSemesterEnd, $activity);
    mysqli_stmt_execute($updateStmt);
  }

  mysqli_stmt_close($updateStmt);

  // Delete rows from the database
  $deleteIds = $_POST['delete_ids'];

  // Prepare and execute the SQL query to delete rows
  $deleteSql = "DELETE FROM academic_calendar WHERE id = ?";
  $deleteStmt = mysqli_prepare($conn, $deleteSql);

  foreach ($deleteIds as $id) {
    mysqli_stmt_bind_param($deleteStmt, 's', $id);
    mysqli_stmt_execute($deleteStmt);
  }

  mysqli_stmt_close($deleteStmt);

  // Add new rows to the database
  $newActivities = $_POST['new_activities'];
  $newFirstSemesterStart = $_POST['new_first_semester_start'];
  $newSecondSemesterStart = $_POST['new_second_semester_start'];

  // Prepare and execute the SQL query to insert new rows
  $insertSql = "INSERT INTO academic_calendar (activities, first_semester_start, second_semester_start) VALUES (?, ?, ?)";
  $insertStmt = mysqli_prepare($conn, $insertSql);

  foreach ($newActivities as $index => $activity) {
    $newFirstSemesterEnd = date('Y-m-d', strtotime($_POST['new_first_semester_end'][$index]));
    $newSecondSemesterEnd = date('Y-m-d', strtotime($_POST['new_second_semester_end'][$index]));
    mysqli_stmt_bind_param($insertStmt, 'sss', $activity, $newFirstSemesterStart[$index] . ' - ' . $newFirstSemesterEnd, $newSecondSemesterStart[$index] . ' - ' . $newSecondSemesterEnd);
    mysqli_stmt_execute($insertStmt);
  }

  mysqli_stmt_close($insertStmt);

  // Redirect to the same page to prevent form resubmission
  header('Location: academic_calendar.php');
  exit();
}

// Fetch calendar data from the database
$sql = "SELECT * FROM academic_calendar";
$result = mysqli_query($conn, $sql);
$calendarData = mysqli_fetch_all($result, MYSQLI_ASSOC);
=======
  // Handle form submission
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update the database with the edited calendar data
    $activities = $_POST['activities'];
    $firstSemesterStart = $_POST['first_semester_start'];
    $secondSemesterStart = $_POST['second_semester_start'];

    // Prepare and execute the SQL query to update the calendar data
    $updateSql = "UPDATE academic_calendar SET first_semester_start = ?, second_semester_start = ? WHERE activities = ?";
    $updateStmt = mysqli_prepare($conn, $updateSql);

    foreach ($activities as $index => $activity) {
      $firstSemesterEnd = date('Y-m-d', strtotime($_POST['first_semester_end'][$index]));
      $secondSemesterEnd = date('Y-m-d', strtotime($_POST['second_semester_end'][$index]));
      mysqli_stmt_bind_param($updateStmt, 'sss', $firstSemesterStart[$index] . ' - ' . $firstSemesterEnd, $secondSemesterStart[$index] . ' - ' . $secondSemesterEnd, $activity);
      mysqli_stmt_execute($updateStmt);
    }

    mysqli_stmt_close($updateStmt);

    // Delete rows from the database
    $deleteIds = $_POST['delete_ids'];

    // Prepare and execute the SQL query to delete rows
    $deleteSql = "DELETE FROM academic_calendar WHERE id = ?";
    $deleteStmt = mysqli_prepare($conn, $deleteSql);

    foreach ($deleteIds as $id) {
      mysqli_stmt_bind_param($deleteStmt, 's', $id);
      mysqli_stmt_execute($deleteStmt);
    }

    mysqli_stmt_close($deleteStmt);

    // Add new rows to the database
    $newActivities = $_POST['new_activities'];
    $newFirstSemesterStart = $_POST['new_first_semester_start'];
    $newSecondSemesterStart = $_POST['new_second_semester_start'];

    // Prepare and execute the SQL query to insert new rows
    $insertSql = "INSERT INTO academic_calendar (activities, first_semester_start, second_semester_start) VALUES (?, ?, ?)";
    $insertStmt = mysqli_prepare($conn, $insertSql);

    foreach ($newActivities as $index => $activity) {
      $newFirstSemesterEnd = date('Y-m-d', strtotime($_POST['new_first_semester_end'][$index]));
      $newSecondSemesterEnd = date('Y-m-d', strtotime($_POST['new_second_semester_end'][$index]));
      mysqli_stmt_bind_param($insertStmt, 'sss', $activity, $newFirstSemesterStart[$index] . ' - ' . $newFirstSemesterEnd, $newSecondSemesterStart[$index] . ' - ' . $newSecondSemesterEnd);
      mysqli_stmt_execute($insertStmt);
    }

    mysqli_stmt_close($insertStmt);

    // Redirect to the same page to prevent form resubmission
    header('Location: academic_calendar.php');
    exit();
  }

  // Fetch calendar data from the database
  $sql = "SELECT * FROM academic_calendar";
  $result = mysqli_query($conn, $sql);
  $calendarData = mysqli_fetch_all($result, MYSQLI_ASSOC);
>>>>>>> origin/main
?>

<main class="page-wrapper">
  <div class="lg-box">
<<<<<<< HEAD
    <!-- Content of the dashboardgoes here -->
    <h1>Academic Calendar</h1>

<form method="POST">
  <table>
    <thead>
      <tr>
        <th>ACTIVITIES</th>
        <th>FIRST SEMESTER</th>
        <th>SECOND SEMESTER</th>
        <th>ACTION</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($calendarData as $data): ?>
        <tr>
          <td><?php echo $data['activities']; ?></td>
          <td>
            Start:
            <input type="date" name="first_semester_start[]" value="<?php echo $data['first_semester_start']; ?>" readonly>
            <br>End:
            <input type="date" name="first_semester_end[]" value="<?php echo substr($data['first_semester_start'], strpos($data['first_semester_start'], '-') + 2); ?>" readonly>
          </td>
          <td>
            Start:
            <input type="date" name="second_semester_start[]" value="<?php echo $data['second_semester_start']; ?>" readonly>
            <br>End:
            <input type="date" name="second_semester_end[]" value="<?php echo substr($data['second_semester_start'], strpos($data['second_semester_start'], '-') + 2); ?>" readonly>
          </td>
          <td>
            <button type="button" class="edit-button">Edit</button>
            <button type="button" class="save-button" style="display: none;">Save</button>
            <button type="button" class="delete-button">Delete</button>
          </td>
          <input type="hidden" name="activities[]" value="<?php echo $data['activities']; ?>">
          <input type="hidden" name="delete_ids[]" value="<?php echo $data['id']; ?>">
        </tr>
      <?php endforeach; ?>
      <!-- Add a new row for adding new activities -->
      <tr class="new-row">
        <td><input type="text" name="new_activities[]" placeholder="New Activity"></td>
        <td>
          <input type="date" name="new_first_semester_start[]" placeholder="First Semester Start" readonly>
          <input type="date" name="new_first_semester_end[]" placeholder="First Semester End" readonly>
        </td>
        <td>
          <input type="date" name="new_second_semester_start[]" placeholder="Second Semester Start" readonly>
          <input type="date" name="new_second_semester_end[]" placeholder="Second Semester End" readonly>
        </td>
        <td>
          <button type="button" class="save-button">Save</button>
        </td>
      </tr>
    </tbody>
  </table>

  <button type="submit">Save</button>
</form>
</div>
</main>

<script>
const editButtons = document.querySelectorAll('.edit-button');
const saveButtons = document.querySelectorAll('.save-button');
const deleteButtons = document.querySelectorAll('.delete-button');
const newRows = document.querySelectorAll('.new-row');

editButtons.forEach((button, index) => {
button.addEventListener('click', () => {
  const row = button.parentNode.parentNode;
  const inputs = row.querySelectorAll('input');

  inputs.forEach(input => {
    input.removeAttribute('readonly');
  });

  saveButtons[index].style.display = 'inline-block';
  editButtons[index].style.display = 'none';
});
});

saveButtons.forEach((button, index) => {
button.addEventListener('click', () => {
  const row = button.parentNode.parentNode;
  const inputs = row.querySelectorAll('input');

  inputs.forEach(input => {
    input.setAttribute('readonly', true);
      });

      saveButtons[index].style.display = 'none';
      editButtons[index].style.display = 'inline-block';
    });
  });

  deleteButtons.forEach((button) => {
    button.addEventListener('click', () => {
      const row = button.parentNode.parentNode;
      const deleteInput = row.querySelector('input[name="delete_ids[]"]');

      row.remove();
      deleteInput.setAttribute('name', 'delete_ids[]');
    });
  });

  // Logic to enable editing of new rows
  newRows.forEach((row) => {
    const saveButton = row.querySelector('.save-button');

    saveButton.addEventListener('click', () => {
      const inputs = row.querySelectorAll('input');

      inputs.forEach(input => {
        input.setAttribute('readonly', true);
      });

      saveButton.style.display = 'none';
    });
  });
=======
    <!-- Content of the dashboard goes here -->
    <h1>Academic Calendar</h1>

    <form method="POST">
      <table>
        <thead>
          <tr>
            <th>ACTIVITIES</th>
            <th>FIRST SEMESTER</th>
            <th>SECOND SEMESTER</th>
            <th>ACTION</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($calendarData as $data): ?>
            <tr>
              <td><?php echo $data['activities']; ?></td>
              <td>
                <input type="date" name="first_semester_start[]" value="<?php echo $data['first_semester_start']; ?>" readonly>
                <input type="date" name="first_semester_end[]" value="<?php echo substr($data['first_semester_start'], strpos($data['first_semester_start'], '-') + 2); ?>" readonly>
              </td>
              <td>
                <input type="date" name="second_semester_start[]" value="<?php echo $data['second_semester_start']; ?>" readonly>
                <input type="date" name="second_semester_end[]" value="<?php echo substr($data['second_semester_start'], strpos($data['second_semester_start'], '-') + 2); ?>" readonly>
              </td>
              <td>
                <button type="button" class="edit-button">Edit</button>
                <button type="button" class="save-button" style="display: none;">Save</button>
                <button type="button" class="delete-button">Delete</button>
              </td>
              <input type="hidden" name="activities[]" value="<?php echo $data['activities']; ?>">
              <input type="hidden" name="delete_ids[]" value="<?php echo $data['id']; ?>">
            </tr>
          <?php endforeach; ?>
          <!-- Add a new row for adding new activities -->
          <tr class="new-row">
            <td><input type="text" name="new_activities[]" placeholder="New Activity"></td>
            <td>
              <input type="date" name="new_first_semester_start[]" placeholder="First Semester Start" readonly>
              <input type="date" name="new_first_semester_end[]" placeholder="First Semester End" readonly>
            </td>
            <td>
              <input type="date" name="new_second_semester_start[]" placeholder="Second Semester Start" readonly>
              <input type="date" name="new_second_semester_end[]" placeholder="Second Semester End" readonly>
            </td>
            <td>
              <button type="button" class="save-button">Save</button>
            </td>
          </tr>
        </tbody>
      </table>

      <button type="submit">Save</button>
    </form>
  </div>
</main>

<script>
  const editButtons = document.querySelectorAll('.edit-button');
  const saveButtons = document.querySelectorAll('.save-button');
  const deleteButtons = document.querySelectorAll('.delete-button');
  const newRows = document.querySelectorAll('.new-row');

  editButtons.forEach((button, index) => {
    button.addEventListener('click', () => {
      // Enable editing for the corresponding row
      enableRowEditing(index);
    });
  });

  saveButtons.forEach((button, index) => {
    button.addEventListener('click', () => {
      // Disable editing for the corresponding row
      disableRowEditing(index);
    });
  });

  deleteButtons.forEach((button, index) => {
    button.addEventListener('click', () => {
      // Delete the corresponding row
      deleteRow(index);
    });
  });

  function enableRowEditing(index) {
    const row = document.querySelectorAll('tbody tr')[index];
    const inputs = row.querySelectorAll('input');

    inputs.forEach((input) => {
      input.removeAttribute('readonly');
    });

    const editButton = row.querySelector('.edit-button');
    const saveButton = row.querySelector('.save-button');
    const deleteButton = row.querySelector('.delete-button');

    editButton.style.display = 'none';
    saveButton.style.display = 'block';
    deleteButton.style.display = 'none';
  }

  function disableRowEditing(index) {
    const row = document.querySelectorAll('tbody tr')[index];
    const inputs = row.querySelectorAll('input');

    inputs.forEach((input) => {
      input.setAttribute('readonly', true);
    });

    const editButton = row.querySelector('.edit-button');
    const saveButton = row.querySelector('.save-button');
    const deleteButton = row.querySelector('.delete-button');

    editButton.style.display = 'block';
    saveButton.style.display = 'none';
    deleteButton.style.display = 'block';
  }

  function deleteRow(index) {
    const row = document.querySelectorAll('tbody tr')[index];
    const deleteInput = row.querySelector('input[name="delete_ids[]"]');

    if (deleteInput) {
      // If the row is already present in the database, hide it and mark it for deletion
      row.style.display = 'none';
      deleteInput.removeAttribute('name');
    } else {
      // If the row is newly added and not yet saved, remove it from the DOM
      row.remove();
    }
  }

  const newRow = document.querySelector('.new-row');
  const newInputs = newRow.querySelectorAll('input');

  newInputs.forEach((input) => {
    input.removeAttribute('readonly');
  });
>>>>>>> origin/main
</script>

<?php
include './admin_utils/admin_footer.php';
?>

<?php
} else {
  header('Location: login.php');
  exit();
}
?>
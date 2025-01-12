<div class="filters">
          <input type="text" placeholder="Search Post..." class="search-post" />

          <div class="filter-container">
            <label for="filter-account">Account:</label>
            <select id="filter-account" name="filter-account">
              <option value="all">All</option> <!-- Add the "All" option -->
              <?php
              require_once './admin/php/db_connect.php';

              // Construct the SQL query to retrieve all account names from the accounts table
              $accountsQuery = "SELECT account_id, account_name FROM accounts";
              $accountsResult = mysqli_query($conn, $accountsQuery);

              while ($account = mysqli_fetch_assoc($accountsResult)) {
                $accountID = $account['account_id'];
                $accountName = $account['account_name'];

                $selected = ($accountID === $filterAccount) ? 'selected' : '';
                echo '<option value="' . $accountID . '"' . $selected . '>' . $accountName . '</option>';
              }

              mysqli_free_result($accountsResult);
              ?>
            </select>
          </div>

          <div class="filter-container">
            <label for="filter-topic">Topic:</label>
            <select id="filter-topic" name="filter-topic">
              <option value="all">All</option>
              <?php
              $query = "SELECT * FROM topics";
              $result = mysqli_query($conn, $query);

              while ($row = mysqli_fetch_assoc($result)) {
                $topicID = $row['topic_id'];
                $topicName = $row['topic_name'];

                $selected = ($topicID === $filterTopic) ? 'selected' : '';
                echo '<option value="' . $topicID . '"' . $selected . '>' . $topicName . '</option>';
              }

              mysqli_free_result($result);
              ?>
            </select>
          </div>
        </div>
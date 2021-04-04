<?php 
$link = new mysqli(MYSQL_HOST,MYSQL_USER,MYSQL_PASS,MYSQL_DB);
$link->set_charset("utf8");
?>
<div class="container">
  <h1 class="text-center">Reviews</h1>
  <div class="card shadow">
    <div class="card-header">
      <div class="card-tools">
      </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <div class=" table-responsive p-0">
        <table class="display table table-hover text-nowrap" id="generalTable">
          <thead>
            <tr>
              <th>No.</th>
              <th>Name</th>
              <th>Position</th>
              <th>Review</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $sql = "SELECT * FROM REVIEWS WHERE DELETED = 'FALSE' ORDER BY ID DESC";
            $result = mysqli_query($link, $sql);
            if ($result) {
              if (mysqli_num_rows($result) > 0) {
                $i = 1;
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

                  echo  '<tr>
               <td>' . $i . '</td>
               <td>' . $row['NAME'] . '</td>
               <td>' . $row['POSITION'] . '</td>
               <td>' . $row['REVIEW'] . '</td>
               <td>' . $row['DATE'] . '</td>
               </tr>';
               $i++;
                }
              } 
            }
            ?>
          </tbody>
          <tfoot>
            <tr>
              <th>No.</th>
              <th>Name</th>
              <th>Position</th>
              <th>Review</th>
              <th>Date</th>
            </tr>
          </tfoot>
        </table>
      </div>

    </div>
    <!-- /.card-body -->
  </div>
</div>

<?php
session_start();
include("../config.php");

if (!isset($_SESSION['n']) || !isset($_SESSION['p'])) {
    header("Location: login.php");
    exit();
}
include("header.php");
?>

<div class="d-flex align-items-stretch">

  <!-- Sidebar -->
  <?php include("sidebar.php"); ?>

  <?php
    /* =========================
       TOTAL COUNTS (DYNAMIC)
    ========================= */

    $user_query = mysqli_query($connection, "SELECT COUNT(*) AS total_users FROM users");
    $user_data = mysqli_fetch_assoc($user_query);
    $total_users = $user_data['total_users'];

    $book_query = mysqli_query($connection, "SELECT COUNT(*) AS total_books FROM books");
    $book_data = mysqli_fetch_assoc($book_query);
    $total_books = $book_data['total_books'];

    $order_query = mysqli_query($connection, "SELECT COUNT(*) AS total_orders FROM orders");
    $order_data = mysqli_fetch_assoc($order_query);
    $total_orders = $order_data['total_orders'];

    $competition_query = mysqli_query($connection, "SELECT COUNT(*) AS total_competitions FROM competitions");
    $competition_data = mysqli_fetch_assoc($competition_query);
    $total_competitions = $competition_data['total_competitions'];
  ?>

  <!-- Page Content -->
  <div class="page-content">

    <div class="page-header">
      <div class="container-fluid">
        <h2 class="h5 no-margin-bottom">Dashboard</h2>
      </div>
    </div>

    <!-- STAT CARDS -->
    <section class="no-padding-top no-padding-bottom">
      <div class="container-fluid">
        <div class="row">

          <!-- USERS -->
          <div class="col-md-3 col-sm-6">
            <div class="statistic-block block">
              <div class="progress-details d-flex justify-content-between align-items-end">
                <div class="title">
                  <div class="icon"><i class="fa fa-user"></i></div>
                  <strong>Users</strong>
                </div>
                <div class="number"><?php echo $total_users; ?></div>
              </div>
            </div>
          </div>

          <!-- BOOKS -->
          <div class="col-md-3 col-sm-6">
            <div class="statistic-block block">
              <div class="progress-details d-flex justify-content-between align-items-end">
                <div class="title">
                  <div class="icon"><i class="fa fa-book"></i></div>
                  <strong>Books</strong>
                </div>
                <div class="number"><?php echo $total_books; ?></div>
              </div>
            </div>
          </div>

          <!-- ORDERS -->
          <div class="col-md-3 col-sm-6">
            <div class="statistic-block block">
              <div class="progress-details d-flex justify-content-between align-items-end">
                <div class="title">
                  <div class="icon"><i class="fa fa-truck"></i></div>
                  <strong>Orders</strong>
                </div>
                <div class="number"><?php echo $total_orders; ?></div>
              </div>
            </div>
          </div>

          <!-- COMPETITIONS -->
          <div class="col-md-3 col-sm-6">
            <div class="statistic-block block">
              <div class="progress-details d-flex justify-content-between align-items-end">
                <div class="title">
                  <div class="icon"><i class="fa fa-trophy"></i></div>
                  <strong>Competitions</strong>
                </div>
                <div class="number"><?php echo $total_competitions; ?></div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>

    <!-- <section class="no-padding-bottom">
          <div class="container-fluid">
            <div class="row">

              <div class="col-lg-4">
                <div class="bar-chart block no-margin-bottom">
                  <canvas id="barChartExample1"></canvas>
                </div>
                <div class="bar-chart block">
                  <canvas id="barChartExample2"></canvas>
                </div>
              </div>
              
              <div class="col-lg-8">
                <div class="line-cahrt block">
                  <canvas id="lineCahrt"></canvas>
                </div>
              </div>
            </div>
          </div>
        </section> -->

 <section>
          <div class="container-fluid">
            <div class="row">
              <div class="col-lg-4">
                <div class="stats-with-chart-2 block">
                  <div class="title"><strong class="d-block">Total Users</strong>
                  <!-- <span class="d-block">Lorem ipsum dolor sit</span> -->
                </div>
                  <div class="piechart chart">
                    <canvas id="pieChartHome1"></canvas>
                    <div class="text"><strong class="d-block"><?php echo $total_users; ?></strong><span class="d-block">Users</span></div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="stats-with-chart-2 block">
                  <div class="title"><strong class="d-block">Existing Books</strong>
                  <!-- <span class="d-block">Lorem ipsum dolor sit</span> -->
                </div>
                  <div class="piechart chart">
                    <canvas id="pieChartHome2"></canvas>
                    <div class="text"><strong class="d-block"><?php echo $total_books; ?></strong><span class="d-block">Books</span></div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="stats-with-chart-2 block">
                  <div class="title"><strong class="d-block">Recieve Orders</strong>
                  <!-- <span class="d-block">Lorem ipsum dolor sit</span> -->
                </div>
                  <div class="piechart chart">
                    <canvas id="pieChartHome3"></canvas>
                    <div class="text"><strong class="d-block"><?php echo $total_orders; ?></strong><span class="d-block">Orders</span></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        
  </div>
</div>

<?php
include("footer.php");
?>
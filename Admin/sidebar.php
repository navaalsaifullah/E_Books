
<nav id="sidebar">
  <!-- Sidebar Header-->
  <div class="sidebar-header d-flex align-items-center">
    <div class="avatar"><img src="img/admin.jpg" alt="admin" class="img-fluid rounded-circle"></div>
    <div class="title">
      <h1 class="h5">Admin</h1>
      <!-- <p>Web Designer</p> -->
    </div>
  </div>
  <!-- Sidebar Navidation Menus--><span class="heading">Main</span>
  <ul class="list-unstyled">
    <li class="active"><a href="./dashboard.php"> <i class="fa fa-home"></i>Home </a></li>

    <!-- Users -->
    <li><a href="#exampledropdownDropdown1" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-user"></i>User</a>
      <ul id="exampledropdownDropdown1" class="collapse list-unstyled ">
        <li><a href="./createuser.php"><i class="fa fa-plus-circle"></i>Create</a></li>
        <li><a href="./viewusers.php"><i class="fa fa-eye"></i>View</a></li>
      </ul>
    </li>

    <!-- Books -->
    <li><a href="#exampledropdownDropdown2" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-book"></i> Books</a>
      <ul id="exampledropdownDropdown2" class="collapse list-unstyled ">
        <li><a href="./addbooks.php"><i class="fa fa-plus"></i>Add</a></li>
        <li><a href="./viewbooks.php"><i class="fa fa-eye"></i>View</a></li>

      </ul>
    </li>

    <!-- Orders -->
    <li><a href="#exampledropdownDropdown3" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-truck"></i> Orders</a>
      <ul id="exampledropdownDropdown3" class="collapse list-unstyled ">
        <!-- <li><a href="addbooks.php"><i class="fa fa-pencil"></i>Edit</a></li> -->
        <li><a href="./vieworders.php"><i class="fa fa-eye"></i>View</a></li>
      </ul>
    </li>

    <!-- Competition -->
    <li><a href="#exampledropdownDropdown4" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-trophy"></i> Competition</a>
      <ul id="exampledropdownDropdown4" class="collapse list-unstyled ">
        <li><a href="./createcompetition.php"><i class="fa fa-plus-circle"></i>Create</a></li>
        <li><a href="./viewcompetitions.php"><i class="fa fa-eye"></i>View</a></li>
        <li><a href="./participants.php"><i class="fa fa-users"></i>Participants</a></li>
      </ul>
    </li>

  </ul>

</nav>
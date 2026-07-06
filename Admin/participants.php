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
    <?php include("sidebar.php"); ?>
    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">
                <h2 class="h5 no-margin-bottom">VIEW PARTICIPANTS</h2>
            </div>
        </div>

        <section class="no-padding-top no-padding-bottom">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="block margin-bottom-sm table">
                            <div class="title"><strong>Participants Table</strong></div>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Participant Name</th>
                                            <th>Competition Book</th>
                                            <th>Essay / Story</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $selectQuery = "SELECT participants.*, users.name AS user_name 
                                                        FROM participants 
                                                        LEFT JOIN users ON participants.participant_id = users.id";
                                        $data = mysqli_query($connection, $selectQuery);
                                        if ($data && mysqli_num_rows($data) > 0) {
                                            foreach ($data as $row) {
                                                $displayName = !empty($row['user_name']) ? $row['user_name'] : "Guest (ID: " . $row['participant_id'] . ")";
                                        ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($displayName); ?></td>
                                                <td><?php echo htmlspecialchars($row['competition_name']); ?></td>
                                                <td style="white-space: pre-wrap; max-width: 400px;"><?php echo htmlspecialchars($row['essay_story'] ?? ''); ?></td>
                                            </tr>
                                        <?php 
                                            }
                                        } else {
                                            echo "<tr><td colspan='3' class='text-center'>No participants found.</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php include("footer.php"); ?>
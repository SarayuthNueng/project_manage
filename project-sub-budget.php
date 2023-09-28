<?php
session_start();
include('./db/connect.php');
?>
<?php include('./include/head.php') ?>
<?php include('./include/sidebar.php') ?>
<!--  Header Start -->
<?php include('./include/header.php') ?>
<!--  Header End -->

<div class="container-fluid">

    <div class="card">
        <div class="card-body">
            <div class="row p-2">
                <?php
                if (!$_GET) {
                    Header("Location: home.php");
                } else { ?>
                    <?php

                    // echo "<pre>";
                    // print_r($_GET);
                    // print_r($_SESSION);
                    // echo "</pre>";

                    // sum total
                    $sql = "SELECT SUM(s1.sub_budget)
                    FROM sub_budget s1 
                    LEFT JOIN project s2 on s1.sub_p_name_id = s2.project_id
                    WHERE s2.project_id = '" . $_GET['project_id'] . "' ";
                    $result = $conn->query($sql);
                    $row_sum_total = mysqli_fetch_array($result);
                    // echo 'total:' . $row_sum_total[0];

                    // remain
                    $sql2 = "SELECT ((s2.project_budget) - SUM(s1.sub_budget))
                    FROM sub_budget s1 
                    LEFT JOIN project s2 on s1.sub_p_name_id = s2.project_id
                    WHERE s2.project_id = '" . $_GET['project_id'] . "' ";
                    $result2 = $conn->query($sql2);
                    $row_remain = mysqli_fetch_array($result2);
                    // echo 'remain:' . $row_remain[0];
                    // exit;

                    ?>

                    <body>
                        <div class="container">
                            <div class="row p-3 text-center">
                                <div class="col-md-6">
                                    <h3>ชื่อแผนงาน : <?php echo $_GET['project_plan']; ?></h3>
                                </div>
                                <div class="col-md-6">
                                    <h3>ชื่อโครงการ/กิจกรรม : <?php echo $_GET['project_name']; ?></h3>
                                </div>
                            </div>


                            <div class="col-md-12">
                                <a type="button" class="btn btn-warning" href="./project-manage.php">ย้อนกลับ</a>
                                <?php if (($_SESSION['level'] == 'finance') or $_SESSION['level'] == 'admin') { ?>
                                    <a type="button" class="btn btn-primary" href="./project-budget.php">+ เบิกงบโครงการ</a>
                                <?php } ?>
                            </div>


                            <div class="row p-2">

                                <!-- Data list table -->

                                <table id="example" class="table table-hover" style="margin-top: 3%; width: 100%; border-color: #fff; height: 325px;">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>รายการงบที่เบิก</th>
                                            <th>งบประมาณที่ใช้เบิก</th>
                                            <?php
                                            if (($_SESSION['level'] == 'finance') or ($_SESSION['level'] == 'admin')) { ?>
                                                <th>แก้ไข</th>
                                            <?php } ?>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Get member rows 
                                        $result = $conn->query("SELECT * FROM sub_budget s1
                                                LEFT JOIN project s2 on s1.sub_p_name_id = s2.project_id 
                                                WHERE s2.project_id = '" . $_GET['project_id'] . "'
                                                ORDER BY project_id ASC");
                                        if ($result->num_rows > 0) {
                                            $i = 0;
                                            while ($row = $result->fetch_assoc()) {
                                                $i++;
                                        ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td><?php echo $row['sub_name']; ?></td>
                                                    <td><?php $budget = $row['sub_budget'];
                                                        echo number_format($budget, 2) ?> บาท</td>
                                                    <?php if (($_SESSION['level'] == 'finance') or ($_SESSION['level'] == 'admin')) { ?>
                                                        <td class="text-center"><a href="project-sub-budget_edit.php?sub_budget_id=<?php echo $row['sub_id'] ?>"><i class="fa-regular fa-pen-to-square"></i></a></td>
                                                    <?php } ?>
                                                </tr>
                                            <?php }
                                        } else { ?>
                                            <tr>
                                            <td>ไม่มีข้อมูล...</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <div class="row mt-3 text-center">
                                    <div class="col-md-4">
                                        <h6>งบประมาณตั้งต้น : <?php $start_budget = $_GET['project_budget'];
                                                                echo number_format($start_budget, 2) ?> บาท</h6>
                                    </div>
                                    <div class="col-md-4">
                                        <h6>งบประมาณรวมที่เบิก : <?php $total_sub = $row_sum_total[0];
                                                                    echo number_format($total_sub, 2) ?> บาท</h6>
                                    </div>
                                    <div class="col-md-4">
                                        <h6>งบประมาณคงเหลือ : <?php $remain = $row_remain[0];
                                                                echo number_format($remain, 2) ?> บาท</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </body>

                    </html>
                <?php } ?>
            </div>
        </div>
    </div>



    <?php include('./include/footer.php') ?>
    <?php include('./include/datatable.php')?>
</div>
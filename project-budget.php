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

    <?php if (!$_SESSION) {
        Header("Location: home.php");
    } else { ?>

        <?php
        //   dropdrown
        $sql1 = " SELECT * FROM project ";
        $query1 = mysqli_query($conn, $sql1);

        $sql2 = " SELECT * FROM project ";
        $query2 = mysqli_query($conn, $sql2);

        //   date,time
        $currentDate = date('Y-m-d');
        // echo $currentDate;
        date_default_timezone_set("Asia/Bangkok");
        $Time = date('h:i:s');
        $currentTime = date('h:i:s', strtotime($Time));
        // echo $newTime;
        // exit;

        ?>

        <body>
            <div class="container mt-4">
                <h2>เบิกงบโครงการ</h2>

                <div class="mt-3">
                    <form class="row g-3" action="project-budget_db.php" method="POST">
                        <div class="col-md-6">
                            <label class="form-label">ชื่อรายการเบิก</label>
                            <input type="text" name="sub_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">จำนวนเงิน</label>
                            <input type="float" name="sub_budget" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="inputState" class="form-label">แผนงาน</label>
                            <select name="sub_p_plan_id" class="form-select" required>
                                <option value="">กรุณาเลือกแผนงาน</option>
                                <?php foreach ($query1 as $p) { ?>
                                    <option value="<?php echo $p["project_id"]; ?>">
                                        <?php echo $p["project_plan"]; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="inputState" class="form-label">โครงการ/กิจกรรม</label>
                            <select name="sub_p_name_id" class="form-select" required>
                                <option value="">กรุณาเลือกโครงการ</option>
                                <?php foreach ($query2 as $n) { ?>
                                    <option value="<?php echo $n["project_id"]; ?>">
                                        <?php echo $n["project_name"]; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>



                        <input type="hidden" name="sub_date" class="form-control" value="<?php echo $currentDate ?>">
                        <input type="hidden" name="sub_time" class="form-control" value="<?php echo $currentTime ?>">

                        <div class="col-12">
                            <!-- <a href="home.php" type="submit" class="btn btn-warning">กลับ</a> -->
                            <button type="submit" name="project_budget" class="btn btn-success">บันทึก</button>
                        </div>

                    </form>
                </div>
            </div>
        </body>

        </html>
    <?php } ?>

    <?php include('./include/footer.php') ?>
</div>
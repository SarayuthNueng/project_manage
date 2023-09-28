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
        // edit
        $sub_budgetID = $_GET['sub_budget_id'];
        $sql = " SELECT *, s2.project_plan as project_plan, s2.project_name as project_name, s2.project_id as project_plan_id, s2.project_budget as project_budget
            FROM sub_budget s1
            LEFT JOIN project s2 on s1.sub_p_plan_id = s2.project_id
            WHERE s1.sub_id = '" . $sub_budgetID . "' ";
        $query = mysqli_query($conn, $sql);
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
                <h2>แก้ไขข้อมูลการเบิกงบโครงการ</h2>

                <div class="mt-3">
                    <form class="row g-3" action="project-sub-budget_edit_db.php" method="POST">
                        <?php while ($row = mysqli_fetch_array($query)) { ?>
                            <div class="col-md-6">
                                <label class="form-label">ชื่อรายการเบิก</label>
                                <input type="text" name="sub_name" class="form-control" value="<?php echo $row['sub_name'] ?>" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">จำนวนเงิน</label>
                                <input type="float" name="sub_budget" class="form-control" value="<?php echo $row['sub_budget'] ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="inputState" class="form-label">แผนงาน</label>
                                <select name="sub_p_plan_id" class="form-select">
                                    <option value="<?php echo $row['project_id'] ?>"><?php echo $row['project_plan'] ?></option>
                                    <?php foreach ($query1 as $p) { ?>
                                        <option value="<?php echo $p["project_id"]; ?>"><?php echo $p["project_plan"]; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="inputState" class="form-label">โครงการ/กิจกรรม</label>
                                <select name="sub_p_name_id" class="form-select">
                                    <option value="<?php echo $row['project_id'] ?>"><?php echo $row['project_name'] ?></option>
                                    <?php foreach ($query2 as $n) { ?>
                                        <option value="<?php echo $n["project_id"]; ?>"><?php echo $n["project_name"]; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>



                            <input type="hidden" name="sub_id" class="form-control" value="<?php echo $row['sub_id'] ?>">

                            <div class="col-12">
                                <a href="./project-sub-budget.php?project_id=<?php echo $row['project_plan_id'] ?>&&project_name=<?php echo $row['project_name'] ?>&&project_plan=<?php echo $row['project_plan'] ?>&&project_budget=<?php echo $row['project_budget'] ?>" type="submit" class="btn btn-warning">กลับ</a>
                                <button type="submit" name="sub_budget_edit" class="btn btn-success">บันทึก</button>
                            </div>
                        <?php } ?>
                    </form>
                </div>
            </div>
        </body>

        </html>
    <?php } ?>

    <?php include('./include/footer.php') ?>
</div>
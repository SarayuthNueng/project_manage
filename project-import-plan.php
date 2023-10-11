<?php
session_start();
include('./db/connect.php');

// sum total
$sql = "SELECT SUM(project_budget) FROM project ";
$result = $conn->query($sql);
$row_sum_total = mysqli_fetch_array($result);
// echo 'total:' . $row_sum_total[0];
// exit;
?>
<!-- Show/hide Excel file upload form -->
<script>
    function formToggle(ID) {
        var element = document.getElementById(ID);
        if (element.style.display === "none") {
            element.style.display = "block";
        } else {
            element.style.display = "none";
        }
    }
</script>
<?php include('./include/head.php') ?>
<?php include('./include/sidebar.php') ?>
<!--  Header Start -->
<?php include('./include/header.php') ?>
<!--  Header End -->


<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row p-2">
                <!-- Import link -->
                <div class="col-md-12 head mb-2">
                    <div class="float-end">
                        <a href="javascript:void(0);" class="btn btn-success" onclick="formToggle('importFrm');"><i class="plus"></i> นำเข้าโครงการ</a>
                    </div>
                </div>
                <!-- Excel file upload form -->
                <div class="col-md-12" id="importFrm" style="display: none;">
                    <form class="row g-3" action="import.php" method="post" enctype="multipart/form-data">
                        <div class="col-auto">
                            <label for="fileInput" class="visually-hidden">File</label>
                            <input type="file" class="form-control" name="file" id="fileInput" />
                            <input type="hidden" class="form-control" name="user_import" value="<?php echo $_SESSION['m_id']?>" />
                        </div>
                        <div class="col-auto">
                            <input type="submit" class="btn btn-primary mb-3" name="importSubmit" value="นำเข้าไฟล์ excel">
                        </div>
                    </form>
                </div>

                <!-- Data list table -->
                <table id="example" class="table table-hover" style="margin-top: 4%; width: 100%; border-color: #fff;">
                    <thead class="table-dark">
                        <tr>
                            <th>ลำดับ</th>
                            <th>รหัสโครงการ</th>
                            <th>ชื่อแผนงาน</th>
                            <th>ชื่อโครงการ/กิจกรรม</th>
                            <th>งบประมาณตั้งต้น(บาท)</th>
                            <th>แก้ไข</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Get member rows 
                        $result = $conn->query("SELECT * FROM project WHERE project_status='อนุมัติ' ORDER BY project_id ASC");
                        if ($result->num_rows > 0) {
                            $i = 0;
                            while ($row = $result->fetch_assoc()) {
                                $i++;
                        ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row['plan_code']; ?></td>
                                    <td><?php echo $row['project_plan']; ?></td>
                                    <td><?php echo $row['project_name']; ?></td>
                                    <td><?php $budget = $row['project_budget'];
                                        echo number_format($budget, 2) ?> บาท</td>
                                    <td class="text-center"><a href="project_edit.php?p_id=<?php echo $row['project_id'] ?>"><i class="fa-solid fa-pen-to-square" style="color: #e8d611;"></i></a></td>
                                </tr>
                            <?php }
                        } else { ?>
                            <tr>
                                <td>ไม่พบข้อมูล...</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <h6>งบประมาณตั้งต้นรวมทั้งหมด : <?php $total = $row_sum_total[0];
                                                        echo number_format($total, 2) ?> บาท</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>



</div>
</body>

<?php include('./include/footer.php') ?>

<?php include('./include/datatable.php') ?>
</div>
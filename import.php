<?php 
session_start();
 $user_id_import = $_SESSION['m_id'];

 echo '<pre>';
 print_r($_POST);
 echo '</pre>';
//  exit;

// Load the database configuration file 
include ('./db/connect.php'); 
 
// Include PhpSpreadsheet library autoloader 
require_once 'vendor/autoload.php'; 
use PhpOffice\PhpSpreadsheet\Reader\Xlsx; 
 
if(isset($_POST['importSubmit'])){ 
     
    // Allowed mime types 
    $excelMimes = array('text/xls', 'text/xlsx', 'application/excel', 'application/vnd.msexcel', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); 
     
    // Validate whether selected file is a Excel file 
    if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $excelMimes)){ 
         
        // If the file is uploaded 
        if(is_uploaded_file($_FILES['file']['tmp_name'])){ 
            $reader = new Xlsx(); 
            $spreadsheet = $reader->load($_FILES['file']['tmp_name']); 
            $worksheet = $spreadsheet->getActiveSheet();  
            $worksheet_arr = $worksheet->toArray(); 
 
            // Remove header row 
            unset($worksheet_arr[0]); 
 
            foreach($worksheet_arr as $row){ 
                $plan_code = $row[0];
                $project_plan = $row[1]; 
                $project_name = $row[2]; 
                $project_budget = $row[3];

                //check data
                $check_import = "SELECT * FROM project WHERE project_plan = '$project_plan' AND project_name = '$project_name' ";
                $import = mysqli_query($conn, $check_import);
                $num = mysqli_num_rows($import);

                // update if ซ้ำ
                if($num > 0){
                    $sql1 = " UPDATE project SET project_budget = '".$project_budget."', modified = NOW(), user_id_import = '".$user_id_import."' WHERE project_plan = '".$project_plan."' AND project_name = '".$project_name."' ";
                    $update_import = mysqli_query($conn, $sql1);

                // บันทึกถ้าไม่ซ้ำ 
                }else{
                    $sql2 = " INSERT INTO project (plan_code,project_plan, project_name, project_budget, project_status, created, modified, user_id_import) VALUES ('".$plan_code."','".$project_plan."', '".$project_name."', '".$project_budget."', 'อนุมัติ', NOW(), NOW(), '".$user_id_import."' ) ";
                    $import = mysqli_query($conn, $sql2);
                }
 
            } 
             
            $qstring = '?status=succ'; 
        }else{ 
            $qstring = '?status=err'; 
        } 
    }else{ 
        $qstring = '?status=invalid_file'; 
    } 
} 
 
// Redirect to the listing page 
header("Location: project-import-plan.php".$qstring);

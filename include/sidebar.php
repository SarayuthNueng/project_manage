<?php 
if($_SESSION['level'] == 'admin') {
    include('./include/sidebar_admin.php');
}else if($_SESSION['level'] == 'plan') {
    include('./include/sidebar_plan.php');
}else if($_SESSION['level'] == 'finance') {
    include('./include/sidebar_finance.php');
}else if($_SESSION['level'] == 'member') {
    include('./include/sidebar_member.php');
}
?>
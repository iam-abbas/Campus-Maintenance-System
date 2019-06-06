<?php
header('Content-type: application/json');
$data = array();

if(isset($_POST['op'])) {
if($_POST['op'] == 1){
$data['hi'] = True;
} else {
    $data['hi'] = False;
}

}
echo json_encode($data);


?>
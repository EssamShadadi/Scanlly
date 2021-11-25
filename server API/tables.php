<?php

header('Access-Control-Allow-Origin: *');

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Credentials:true");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "./config/config.php";


$postjson = json_decode(file_get_contents('php://input'),true);

if($postjson["method"]=="getTables"){
    $sqlQuery = mysqli_query($mysqli,"SELECT * FROM Tables");
    if(mysqli_num_rows($sqlQuery)>0){
    while($row = mysqli_fetch_assoc($sqlQuery)){
        $data []=$row; 
    }
    $result = json_encode(array('success'=>true,'data'=>$data));
    
    }
    else{
         $result = json_encode(array('success'=>false,'msg'=>'error'));
    }
     echo $result;
}

?>
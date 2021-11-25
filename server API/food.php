<?php

header('Access-Control-Allow-Origin: *');

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Credentials:true");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "./config/config.php";


$postjson = json_decode(file_get_contents('php://input'),true);
/*
req.: catId
*/
if($postjson["method"]=="getFoodByCatId"){
    $sqlQuery = mysqli_query($mysqli,"SELECT * FROM Food WHERE catId = $postjson[catId] AND foodIsAvailable =1");
    if(mysqli_num_rows($sqlQuery)>0){
    while($row = mysqli_fetch_assoc($sqlQuery)){
        $data []=$row; 
    }
    $result = json_encode(array('success'=>true,'food'=>$data));
    
    }
    else{
         $result = json_encode(array('success'=>false,'msg'=>'error'));
    }
     echo $result;
}
/*
method: getFoodDetails,
req.: foodId
*/
if($postjson["method"]=="getFoodDetails"){
    $sqlQuery = mysqli_query($mysqli,"SELECT * FROM Food WHERE Food.foodId = $postjson[foodId]");
    if(mysqli_num_rows($sqlQuery)>0){
    while($row = mysqli_fetch_assoc($sqlQuery)){
        $data []=$row; 
    }
    $sqlPicture = mysqli_query($mysqli, "SELECT  Picture.picpath as image,Picture.picpath as thumbImage  FROM Foodpicture, Picture WHERE Foodpicture.foodId =$postjson[foodId] AND Foodpicture.picId = Picture.picId ");
    if (mysqli_num_rows($sqlPicture)>0){
        while($rowPic = mysqli_fetch_assoc($sqlPicture)){
            $pics[]=$rowPic; 
        }
        $result = json_encode(array('success'=>true,'foodDetails'=>$data,"pics"=>$pics));
    }
    }
    else{
         $result = json_encode(array('success'=>false,'msg'=>'error'));
    }
     echo $result;
}
/*
method : getOrderedFood
req.: ids: array of food ids
*/
if($postjson["method"]=="getOrderedFood"){

    $arr = $postjson["ids"];

    for  ($i=0;$i<count($arr);$i++){
        $id=json_encode($postjson["ids"][$i]);
        $id = preg_replace("/[^0-9,.]/","",$id);
        $sqlQuery = mysqli_query($mysqli,"SELECT * FROM Food WHERE Food.foodId = $id");
        if(mysqli_num_rows($sqlQuery)>0){
            while($row = mysqli_fetch_assoc($sqlQuery)){
                $data []=$row; 
            }
            $result = json_encode(array('success'=>true,'data'=>$data));
    }
    else{
        $result = json_encode(array('success'=>false,'msg'=>'error'));
  }
    
}
echo $result;
}

?>
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
method: getTables
req:None
*/
if($postjson["method"]=="getTables")
{
    # get all tables
    $sqlQuery = mysqli_query($mysqli,"SELECT * FROM Tables");
    if(mysqli_num_rows($sqlQuery)>0)
    {
        while($row = mysqli_fetch_assoc($sqlQuery))
        {
            if($row['tableIsAvailable']==0)
            {
                $sqlTotalAmount = mysqli_query($mysqli, "SELECT DISTINCT Invoice.invTotalAmount AS totalAmount , Invoice.invId AS invId FROM Tables, Orders, Invoice WHERE Tables.tableId = Orders.tableId AND Orders.invId = Invoice.invId and Invoice.invStatus = 'Pending' AND Orders.tableId = $row[tableId]");
                if(mysqli_num_rows($sqlTotalAmount)>0)
                {
                    $rowTotal = mysqli_fetch_assoc($sqlTotalAmount);
                    $totalAmount = $rowTotal['totalAmount'];
                    $invId = $rowTotal['invId']; 
                    $row['invId'] = $invId;
                }
                else
                {
                    $result = json_encode(array('success'=>false,'msg'=>'error getting the total amount!!'));
                    $totalAmount =0;
                }
            }else
            {
                $totalAmount =0;
            }
            $row['totalAmount'] = $totalAmount;
           
            $data []=$row; 
        }
        $result = json_encode(array('success'=>true,'data'=>$data));
    }
    else
    {
         $result = json_encode(array('success'=>false,'msg'=>'error'));
    }
    echo $result;
}

/*
method: freeTable
req: -tableId
     - invId
*/
if($postjson["method"]=="freeTable")
{
    $sqlFreeTable = mysqli_query($mysqli,"UPDATE Tables SET tableIsAvailable = 1 WHERE tableId = $postjson[tableId]");
    if($sqlFreeTable)
    {
        $sqlUpdateInvoice= mysqli_query($mysqli,"UPDATE Invoice SET invStatus = 'Paid' WHERE invId = $postjson[invId]");
        if($sqlUpdateInvoice)
        {
            $result = json_encode(array('success'=>true,'msg'=>'Table has been freed'));
        }
        else
        {
            $result = json_encode(array('success'=>false,'msg'=>'error in updating the invoice status'));
        }
    }
    else{
        $result = json_encode(array('success'=>false,'msg'=>'error in updating the table avilability'));
    }
    echo $result;
}
?>
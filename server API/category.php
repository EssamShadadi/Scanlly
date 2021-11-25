<?php

header('Access-Control-Allow-Origin: *');

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Credentials:true");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "./config/config.php";


$postjson = json_decode(file_get_contents('php://input'),true);

if($postjson["method"]=="getCat"){
    
        $sqlQuery = mysqli_query($mysqli,"SELECT * FROM Category");
        if(mysqli_num_rows($sqlQuery)>0){
        while($row = mysqli_fetch_assoc($sqlQuery))
        {
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
req: tableId
*/
if($postjson["method"]=="getCategories"){

    $tableIsAvilable;
    # test 1
    $sqlQuery = mysqli_query($mysqli,"SELECT tableIsAvailable FROM Tables WHERE tableId = $postjson[tableId]");
    if(mysqli_num_rows($sqlQuery)>0)
    {
        $row = mysqli_fetch_assoc($sqlQuery);
        $tableIsAvailable =$row["tableIsAvailable"]; 
        if ($tableIsAvailable == 1)
        {
            //make table not available
            $sqlAvailavle = mysqli_query($mysqli,"UPDATE Tables SET tableIsAvailable = 0 WHERE tableId = $postjson[tableId]");
            if($sqlAvailavle)
            {
                # make new invoice
                /*
                    req: - invDt
                        - invTotalAmount
                        - invStatus
                */
                //get the last inserted invId
                # test 2
                $sqlInvoice =  mysqli_query($mysqli,"SELECT MAX(invId) AS invId FROM Invoice");
                $rowInvoice = mysqli_fetch_assoc($sqlInvoice);
                $maxInvId = $rowInvoice['invId'];
                $maxInvId = $maxInvId + 1;
                // get the date now
                $invDt = date('y-m-d h:i:s');
                // create a new invoice
                $sqlInvoiceInsert = mysqli_query($mysqli,"INSERT INTO Invoice (invId,tableId, invDt, invTotalAmount, invStatus) VALUES ($maxInvId,$postjson[tableId], '$invDt', 00,'Pending')");
                if($sqlInvoiceInsert)
                {
                    # get the categories back
                    $sqlQuery = mysqli_query($mysqli,"SELECT * FROM Category");
                    if(mysqli_num_rows($sqlQuery)>0){
                    while($row = mysqli_fetch_assoc($sqlQuery))
                    {
                        $data []=$row; 
                    }
                    $result = json_encode(array('success'=>true,'data'=>$data,'invoicId'=>$maxInvId));
                    }
                    else
                    {
                        $result = json_encode(array('success'=>false,'msg'=>'error'));
                    }
                }
                else
                {
                    $result = json_encode(array('success'=>false,'msg'=>'unable to insert invoice'));
                }
            }
            else
            {
                $result = json_encode(array('success'=>false,'msg'=>'unable to update table status'));
            }
        }
        else
        {
            # table is not avilable
             // get the invId for this table
             $sqlInvoice = mysqli_query($mysqli,"SELECT MAX(invId)AS invId FROM Invoice WHERE tableId='$postjson[tableId]' AND invStatus = 'Pending'");
             if($sqlInvoice)
            { 
                $rowInvoice = mysqli_fetch_assoc($sqlInvoice);
                $maxInvId = $rowInvoice['invId'];
                # get the categories back
                $sqlQuery = mysqli_query($mysqli,"SELECT * FROM Category");
                if(mysqli_num_rows($sqlQuery)>0){
                    while($row = mysqli_fetch_assoc($sqlQuery))
                    {
                        $data []=$row; 
                    }
                    $result = json_encode(array('success'=>true,'data'=>$data,'invoicId'=>$maxInvId));
                }
                else
                {
                    $result = json_encode(array('success'=>false,'msg'=>'unable to get categories'));
                }
            }
            else{
                $result = json_encode(array('success'=>false,'msg'=>'can not get the invoiceId when table is not avilable'));
            }
            
        }
    }
    else
    {
        $result = json_encode(array('success'=>false,'msg'=>'can not get table status'));
    }
    echo $result;
}

?>
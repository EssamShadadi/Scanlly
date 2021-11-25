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
req.: tableId
*/

if($postjson["method"]=="getBill"){
    
     // get the invId for this table
            $sqlInvoice = mysqli_query($mysqli,"SELECT MAX(Invoice.invId) AS invId FROM Invoice, Orders, Tables WHERE Invoice.invId=Orders.invId AND Orders.tableId = Tables.tableId AND Tables.tableId=$postjson[tableId] AND invStatus = 'Pending'");
            $rowInvoice = mysqli_fetch_assoc($sqlInvoice);
            $maxInvId = $rowInvoice['invId'];
            
            if(mysqli_num_rows($sqlInvoice)>0){
                $sqlInvoiceTotalAmount = mysqli_query($mysqli,"SELECT invTotalAmount AS invTotal FROM Invoice WHERE invId= $maxInvId");
                $rowInvTotal = mysqli_fetch_assoc($sqlInvoiceTotalAmount);
                $totalAmount = $rowInvTotal['invTotal'];
                
                  if(mysqli_num_rows($sqlInvoiceTotalAmount)>0){

                    $result = json_encode(array('success'=>true,'total'=>$totalAmount));
                      
                   }
                     else{
                           $result = json_encode(array('success'=>false,'msg'=>'error in getting total amount'));
                     }
            }else{
                
                $result = json_encode(array('success'=>false,'msg'=>'error in getting invoiceId'));
            }
     
            
     echo $result;
}


//get bill for Accountant
if($postjson["method"]=="getAccountantBill"){
    $aqlTablesIds= mysqli_query($mysqli,"SELECT tableId FROM Tables");
    $rowTable = mysqli_fetch_assoc($aqlTablesIds);
    //$tableID = $rowTable['tableId'];
    if(mysqli_num_rows($aqlTablesIds)>0){
            while($row = mysqli_fetch_assoc($aqlTablesIds)){
                $ids []=(int)$row; 
            }
    }else{
         $result = json_encode(array('success'=>false,'msg'=>'error in getting tables ids'));
    }
     // get the total for each table
     foreach  ($ids as $id){
            $sqlInvoice = mysqli_query($mysqli,"SELECT MAX(Invoice.invId) AS invId FROM Invoice, Orders, Tables WHERE Invoice.invId=Orders.invId AND Orders.tableId = Tables.tableId AND Tables.tableId=$id AND invStatus = 'Pending'");
            $rowInvoice = mysqli_fetch_assoc($sqlInvoice);
            $maxInvId = $rowInvoice['invId'];
            
            if(mysqli_num_rows($sqlInvoice)>0){
                $sqlInvoiceTotalAmount = mysqli_query($mysqli,"SELECT invTotalAmount AS invTotal FROM Invoice WHERE invId= $maxInvId");
                $rowInvTotal = mysqli_fetch_assoc($sqlInvoiceTotalAmount);
                $totalAmount = $rowInvTotal['invTotal'];
                
                  if(mysqli_num_rows($sqlInvoiceTotalAmount)>0){
                        while($row = mysqli_fetch_assoc($sqlInvoiceTotalAmount)){
                            $data []=$row; 
                        }
                    $result = json_encode(array('success'=>true,'total'=>$ids,'data'=>$data));
                      
                   }else{
                        $result = json_encode(array('success'=>false,'msg'=>'error in getting total amount'));
                    }
            }else{
                
                $result = json_encode(array('success'=>false,'msg'=>'error in getting invoiceId'));
            }
     
    }   
     echo $result;
}
/*
method: getUnpaidInvoices
req: None
*/
if($postjson["method"]=="getUnpaidInvoices"){
    $sqlUnpaid = mysqli_query($mysqli, "SELECT Tables.tableId,Tables.tableIsAvailable, Invoice.invTotalAmount FROM Tables, Orders, Invoice WHERE Tables.tableId = Orders.TableId AND Orders.invId = Invoice.invId and Invoice.invStatus = 'Pending'");
    if(mysqli_num_rows($sqlUnpaid)>0){
            while($row = mysqli_fetch_assoc($sqlUnpaid)){
                $data []= $row; 
            }
            $result = json_encode(array('success'=>true,'data'=>$data));
    }else{
         $result = json_encode(array('success'=>false,'msg'=>'error in getting tables ids'));
    }
    echo $result;
}
?>
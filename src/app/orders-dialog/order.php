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
req: 
    - tableId
    - Assoc array of food and quantity 
*/
if($postjson["method"]=="insertOrder")
{
    $tableIsAvailable;
    #check the table avilability

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
            $sqlInvoiceInsert = mysqli_query($mysqli,"INSERT INTO Invoice (invId, invDt, invTotalAmount, invStatus) VALUES ($maxInvId, '$invDt', 00,'Pending')");
            if ($sqlInvoiceInsert)
            {
                // echo ("maxInvId 47 " .$maxInvId);
                # make new order
            /*
                req:- tableId
                    - invId
                    - ordDt
                    - ordTotalAmount
                    - ordStatus
            */
            // get the kast iserted orderId
            # test 3
                $sqlOrder =  mysqli_query($mysqli,"SELECT MAX(orderId) AS orderId FROM Orders");
                $rowOrder = mysqli_fetch_assoc($sqlOrder);
                $maxOrderId = $rowOrder['orderId'];
                $maxOrderId = $maxOrderId + 1;
                // create a new order
                $sqlInsertOrder = mysqli_query($mysqli,"INSERT INTO Orders (orderId, tableId, invId, ordDt,ordTotalAmount,ordStatus) values ($maxOrderId,$postjson[tableId],$maxInvId,'$invDt',0.0,'Pending');");
                if ($sqlInsertOrder)
                {
                    // echo ("maxInvId 65 " .$maxInvId);
                   # make order details
                   /*
                    req: - food: associated array of food ids and quantitiy
                         - orderId 
                   */
                  # calculate the order amount
                  
                  # test 4 to be continued
                  $ordTotalAmount = 0;
                  $fakeAssocArray =  $postjson['foodIttems'];
                  foreach($fakeAssocArray as $id => $quantity)
                  {
                      # get the price for each food item
                      $sqlPrice = mysqli_query($mysqli,"SELECT foodPrice FROM Food WHERE foodId = $id;");
                      if ($sqlPrice)
                      {
                        $rowPrice = mysqli_fetch_assoc($sqlPrice);
                        $foodPrice = (float)$rowPrice['foodPrice'];
                        $ordTotalAmount += $foodPrice * $quantity;
                        // insert the ordered food into orderDetails
                        $sqlorderDetails = mysqli_query($mysqli,"INSERT INTO Orderdetails (orderId, foodId, quantity) VALUES ($maxOrderId,$id,$quantity)");
                        if ($sqlorderDetails)
                        {
                            $result = json_encode(array('success'=>true,'msg'=>'inserting orderDetails successfully'));
                        }
                        else
                        {
                            $result = json_encode(array('success'=>false,'msg'=>'ERORR in inserting OrderDetails'));
                        }
                      }
                      else
                      {
                        $result = json_encode(array('success'=>false,'msg'=>'ERORR in getting the foodPrice'));
                      }
                  }
                  # test 5 
                  //update the order's total amount
                  $sqlOrderTotalAmount = mysqli_query($mysqli,"UPDATE Orders SET ordTotalAmount =$ordTotalAmount WHERE orderId=$maxOrderId");
                  if ($sqlOrderTotalAmount)
                  {
                      $result = json_encode(array('success'=>true,'msg'=>"order total Amount updated successfully!!"));
                  }
                  else
                  {
                    $result = json_encode(array('success'=>false,'msg'=>"Erorr in updating order total Amount"));
                  }
                }
                else
                {
                    $result = json_encode(array('success'=>false,'msg'=>'not Inserted ERORR in inserting order for new Invoic'));
                }
            }
            else
            {
                $result = json_encode(array('success'=>false,'msg'=>'not Inserted ERORR in creating new Invoic'));
            }
            # test 7
            $sqlSumOrdersAmount = mysqli_query($mysqli, "SELECT SUM(ordTotalAmount) AS total FROM Orders WHERE invId =$maxInvId ");
            // echo ("maxInvId" .$maxInvId);
            if($sqlSumOrdersAmount){
                $rowSUM = mysqli_fetch_assoc($sqlSumOrdersAmount);
                $total = $rowSUM['total'];
                $sqlUpdateInvoiceTotalAmount = mysqli_query($mysqli,"UPDATE Invoice SET invTotalAmount =$total WHERE invId=$maxInvId");
                if($sqlUpdateInvoiceTotalAmount){
                    $result = json_encode(array('success'=>true,'msg'=>"Invoice total Amount updated successfully!!",'invId' =>$maxInvId,'total'=>$total,  "ordId"=>$maxOrderId));
                }
                else
                {
                    $result = json_encode(array('success'=>false,'msg'=>'ERORR in updatinng Invoice total amount'));
                }
            }
            else
                {
                    $result = json_encode(array('success'=>false,'msg'=>'ERORR in getting sum of orders amounts for invoice'));
                }
                
            }

            
        }
        #Table is not avilabile
        else
        {
            // gert the invId for this table
            $sqlInvoice = mysqli_query($mysqli,"SELECT MAX(Invoice.invId) AS invId FROM Invoice, Orders, Tables WHERE Invoice.invId=Orders.invId AND Orders.tableId = Tables.tableId AND Tables.tableId=$postjson[tableId] AND invStatus = 'Pending'");
            $rowInvoice = mysqli_fetch_assoc($sqlInvoice);
            $maxInvId = $rowInvoice['invId'];
            // get the date now
            $date = date('y-m-d h:i:s');
           # make new order
            /*
                req:- tableId
                    - invId
                    - ordDt
                    - ordTotalAmount
                    - ordStatus
            */
            // get the last iserted orderId
            $sqlOrder =  mysqli_query($mysqli,"SELECT MAX(orderId) AS orderId FROM Orders");
            $rowOrder = mysqli_fetch_assoc($sqlOrder);
            $maxOrderId = $rowOrder['orderId'];
            $maxOrderId = $maxOrderId + 1;
            // create a new order
            $sqlInsertOrder = mysqli_query($mysqli,"INSERT INTO Orders (orderId, tableId, invId, ordDt,ordTotalAmount,ordStatus) values ($maxOrderId,$postjson[tableId],$maxInvId,'$date',0.0,'Pending');");
                if ($sqlInsertOrder)
                {
                    // echo ("maxInvId 65 " .$maxInvId);
                   # make order details
                   /*
                    req: - food: associated array of food ids and quantitiy
                         - orderId 
                   */
                  # calculate the order amount
                  
                  # test 4 to be continued
                  $ordTotalAmount = 0;
                  $fakeAssocArray =  $postjson['foodIttems'];
                  foreach($fakeAssocArray as $id => $quantity)
                  {
                      # get the price for each food item
                      $sqlPrice = mysqli_query($mysqli,"SELECT foodPrice FROM Food WHERE foodId = $id;");
                      if ($sqlPrice)
                      {
                        $rowPrice = mysqli_fetch_assoc($sqlPrice);
                        $foodPrice = (float)$rowPrice['foodPrice'];
                        $ordTotalAmount += $foodPrice * $quantity;
                        // insert the ordered food into orderDetails
                        $sqlorderDetails = mysqli_query($mysqli,"INSERT INTO Orderdetails (orderId, foodId, quantity) VALUES ($maxOrderId,$id,$quantity)");
                        if ($sqlorderDetails)
                        {
                            $result = json_encode(array('success'=>true,'msg'=>'inserting orderDetails successfully'));
                        }
                        else
                        {
                            $result = json_encode(array('success'=>false,'msg'=>'ERORR in inserting OrderDetails'));
                        }
                      }
                      else
                      {
                        $result = json_encode(array('success'=>false,'msg'=>'ERORR in getting the foodPrice'));
                      }
                  }
                  # test 5 
                  //update the order's total amount
                  $sqlOrderTotalAmount = mysqli_query($mysqli,"UPDATE Orders SET ordTotalAmount =$ordTotalAmount WHERE orderId=$maxOrderId");
                  if ($sqlOrderTotalAmount)
                  {
                      $result = json_encode(array('success'=>true,'msg'=>"order total Amount updated successfully!!"));
                  }
                  else
                  {
                    $result = json_encode(array('success'=>false,'msg'=>"Erorr in updating order total Amount"));
                  }
                }
                else
                {
                    $result = json_encode(array('success'=>false,'msg'=>'not Inserted ERORR in inserting order for new Invoic'));
                }
                # test 7
            $sqlSumOrdersAmount = mysqli_query($mysqli, "SELECT SUM(ordTotalAmount) AS total FROM Orders WHERE invId =$maxInvId ");
            // echo ("maxInvId" .$maxInvId);
            if($sqlSumOrdersAmount){
                $rowSUM = mysqli_fetch_assoc($sqlSumOrdersAmount);
                $total = $rowSUM['total'];
                $sqlUpdateInvoiceTotalAmount = mysqli_query($mysqli,"UPDATE Invoice SET invTotalAmount =$total WHERE invId=$maxInvId");
                if($sqlUpdateInvoiceTotalAmount){
                    $result = json_encode(array('success'=>true,'msg'=>"Invoice total Amount updated successfully!!",'invId' =>$maxInvId,'total'=>$total,  "ordId"=>$maxOrderId));
                }
                else
                {
                    $result = json_encode(array('success'=>false,'msg'=>'ERORR in updatinng Invoice total amount'));
                }
            }
            else
                {
                    $result = json_encode(array('success'=>false,'msg'=>'ERORR in getting sum of orders amounts for invoice'));
                }
        }
    }
    else
    {
        $result = json_encode(array('success'=>false,'msg'=>'ERORR in getting tableIsAvailable'));
    }
    echo $result;
}

/*

method :calculatTotal
req: foodIttems : array of food ids
*/
if($postjson["method"]=="calculatTotal")
{
    $ordTotalAmount = 0;
                  $fakeAssocArray =  $postjson['foodIttems'];
                  foreach($fakeAssocArray as $id => $quantity)
                  {
                      # get the price for each food item
                      $sqlPrice = mysqli_query($mysqli,"SELECT foodPrice FROM Food WHERE foodId = $id;");
                      if ($sqlPrice)
                      {
                        $rowPrice = mysqli_fetch_assoc($sqlPrice);
                        $foodPrice = (float)$rowPrice['foodPrice'];
                        $ordTotalAmount += $foodPrice * $quantity;
                        $result = json_encode(array('success'=>true,'totalAmount'=>$ordTotalAmount));
                      }
                      else
                      {
                        $result = json_encode(array('success'=>false,'msg'=>'ERORR in getting the foodPrice'));
                      }
                  }
                  echo $result;
}
?>
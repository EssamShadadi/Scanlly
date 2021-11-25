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
     $sqlOrder =  mysqli_query($mysqli,"SELECT MAX(orderId) AS orderId FROM Orders");
                $rowOrder = mysqli_fetch_assoc($sqlOrder);
                $maxOrderId = $rowOrder['orderId'];
                $maxOrderId = $maxOrderId + 1;
                $ordDate=date('y-m-d h:i:s');
                // create a new order
                $sqlInsertOrder = mysqli_query($mysqli,"INSERT INTO Orders (orderId, tableId, invId, ordDt,ordTotalAmount,ordStatus) values ($maxOrderId,$postjson[tableId],$postjson[invId],'$ordDate',0.0,'Pending');");
                if ($sqlInsertOrder)
                {
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
                      #update invoice total amount
                      // to check
                      $sqlInvoiceTotal = mysqli_query($mysqli,"UPDATE Invoice set invTotalAmount =(SELECT invTotalAmount FROM Invoice WHERE invId = $postjson[invId])+$ordTotalAmount WHERE invId = $postjson[invId]");
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
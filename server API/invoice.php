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
method: getInvoice
req.: tableId
*/

if($postjson["method"]=="getInvoice")
{
    // get invId for this table
    $sqlInvoice = mysqli_query($mysqli,"SELECT MAX(Invoice.invId) AS invId, invDt FROM Invoice, Orders, Tables WHERE Invoice.invId=Orders.invId AND Orders.tableId = Tables.tableId AND Tables.tableId=$postjson[tableId] AND invStatus = 'Pending'");
    
    if (mysqli_num_rows($sqlInvoice)>0)
    {
        $rowInvoice = mysqli_fetch_assoc($sqlInvoice);
        $invId = $rowInvoice['invId'];
        $invDt = $rowInvoice['invDt'];
        # get the total amount
        $sqlTotalInvoice = mysqli_query($mysqli,"SELECT invTotalAmount FROM Invoice WHERE invId = $invId");
        $rowTotal = mysqli_fetch_assoc($sqlTotalInvoice);
        $totalAmount = $rowTotal['invTotalAmount'];
        # get all orders from orders table that belong to this invoice
        $sqlOrderIds = mysqli_query($mysqli,"SELECT orderId FROM Orders WHERE invId = $invId");
        if(mysqli_num_rows($sqlOrderIds)>0)
        {
            $sqlOrderDetails = mysqli_query($mysqli,"CREATE TEMPORARY TABLE CustomerOrders(foodId int,quantity int,FoodEnName varchar(50),foodPrice float)");
            while($roworderIds = mysqli_fetch_assoc($sqlOrderIds)){
                $orderId =  $roworderIds['orderId'];
                $sqlOrderDetails = mysqli_query($mysqli,"INSERT INTO CustomerOrders SELECT Orderdetails.foodId, Orderdetails.quantity, Food.FoodEnName, Food.foodPrice FROM Orderdetails, Food WHERE Orderdetails.foodId = Food.foodId AND Orderdetails.orderId = $orderId ");
                
                
            } 
            $sqlCustomerOrdeerDetails = mysqli_query($mysqli,"SELECT foodId, SUM(quantity) AS quantity,FoodEnName,foodPrice FROM CustomerOrders GROUP BY foodId");
            if(mysqli_num_rows($sqlCustomerOrdeerDetails)>0)
                {
                    while($rowFoodDetails = mysqli_fetch_assoc($sqlCustomerOrdeerDetails))
                    {
                        $data []= $rowFoodDetails;
                    }
                } 
        }
        $result = json_encode(array('success'=>true,'data'=>$data,'totalAmount'=>$totalAmount,'invDt'=>$invDt,"invId"=>$invId));
    }
    else
    {
        $result = json_encode(array('success'=>false,'msg'=>'error'));
    }
    echo $result;
}
?>
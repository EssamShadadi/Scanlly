import { Component, OnInit } from '@angular/core';
import{PostProviderService} from '../providers/post-provider.service';
import {MatDialog} from '@angular/material/dialog';
import{OrdersDialogComponent} from '../orders-dialog/orders-dialog.component';
import{DeleteDialogComponent} from '../delete-dialog/delete-dialog.component';
import{ConfirmDialogComponent} from '../confirm-dialog/confirm-dialog.component';
import { ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-shopping-cart',
  templateUrl: './shopping-cart.component.html',
  styleUrls: ['./shopping-cart.component.css']
})
export class ShoppingCartComponent implements OnInit {
  foods: any={};
  quantitiy;
  orderdFormDialog :boolean;
  confirm :boolean;
  keyValue;
  order:any={};
  tableId;
  totalAmount;
  flag:boolean = false;
  constructor(private postProvider: PostProviderService,
    public matDialog: MatDialog,private route: ActivatedRoute) { }

  ngOnInit(): void {
    this.keyValue = this.keysValueAssoc();
    this.getOrderedFood();
    this.calculatTotal();
    this.tableId = +this.route.snapshot.paramMap.get('tableId');
    console.log("Category::table NO: ",this.tableId);
    this.checkStorge();
  }
  checkStorge(){
    if(localStorage.length>0){
      this.flag=true
      console.log("flag: ",this.flag)
    }
  }
  //get ids from local storge
  getAllKeys():Array<string>{
    var allKey =[];
    for (var i = 0 ;i < localStorage.length; i++){
      allKey.push(localStorage.key(i));
    }
    return allKey;
  }
  keysValueAssoc(){
    var keysVal =[];
    for (var i = 0 ;i < localStorage.length; i++){
      keysVal[localStorage.key(i)]=localStorage.getItem(localStorage.key(i));
    }
    return keysVal;
  }

// request for food data
  getOrderedFood(){
    if ( localStorage.length > 0){
      let ids=this.getAllKeys()
    let body=
    {
      ids: ids,
      method:"getOrderedFood"
    }
    this.postProvider.postData(body,"food.php").subscribe
    (food=>
      {
        this.foods=food;
        console.log(ids);
        console.log("Ordered Food: ",JSON.stringify(this.foods.data));
      }
    )
    }
  }
  openDialog(id,name){
    let dialogRef =this.matDialog.open(OrdersDialogComponent,{ data: {"id":id,"name":name}});
   dialogRef.afterClosed().subscribe(result => {
    this.orderdFormDialog= result;
    console.log(this.orderdFormDialog);
    this.ngOnInit();
    // location.reload();
   })
  }
  clearStorge(){
    
    let dialogRef =this.matDialog.open(DeleteDialogComponent);

    dialogRef.afterClosed().subscribe(result => {
      if (result== "true"){
        console.log("confirm "+result);
        localStorage.clear();
        location.reload();
    }
     })
  }
  confirmOrder(){
    let dialogRef =this.matDialog.open(ConfirmDialogComponent);

    dialogRef.afterClosed().subscribe(result => {
      if (result== "true"){
        console.log("confirm "+result);
        let body=
    {
      tableId:this.tableId,
      foodIttems:this.keyValue,
      method:"insertOrder"
    }
    this.postProvider.postData(body,"order.php").subscribe
    (cat=>
      {
        this.order=cat;
        if (this.order.success==true){
          
          console.log("success",JSON.stringify(this.order.success));
          console.log("order",JSON.stringify(this.order.msg),JSON.stringify(this.order.invId),JSON.stringify(this.order.total));
          localStorage.clear();
          location.reload()
        }
        else {
          console.log("order",JSON.stringify(this.order.msg));
        }
      }
    )

    }
    else 
    {
      console.log("order has't confirmed");
    }
     })
  }
  calculatTotal(){
    let body=
    {
      tableId:this.tableId,
      foodIttems:this.keyValue,
      method:"calculatTotal"
    }
    this.postProvider.postData(body,"order.php").subscribe
    (cat=>
      {
        this.order=cat;
        if (this.order.success==true){
          this.totalAmount = this.order.totalAmount;
          console.log("success",JSON.stringify(this.order.success));
          console.log("totalAmount",JSON.stringify(this.order.totalAmount));
        }
        else {
          console.log("success",JSON.stringify(this.order.success));
          console.log("order",JSON.stringify(this.order.msg));
        }
      }
    )
  }
}


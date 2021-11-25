import { QueryValueType } from '@angular/compiler/src/core';
import { Component, OnInit,Inject } from '@angular/core';
import {MAT_DIALOG_DATA} from '@angular/material/dialog';

@Component({
  selector: 'app-orders-dialog',
  templateUrl: './orders-dialog.component.html',
  styleUrls: ['./orders-dialog.component.css']
})

export class OrdersDialogComponent implements OnInit {
  quntity = 1;
  keyValue;
  id: any;
  constructor( @Inject(MAT_DIALOG_DATA) public data:any) { }

  ngOnInit(): void {
    this.keyValue = this.keysValueAssoc();
  }
  addOne(){
    
    this.quntity=this.quntity+1;
    
  }
  
  subOne(){
    if (this.quntity>1)
        this.quntity=this.quntity-1;
  }
  assignQuantity(id){
    this.quntity=+this.keyValue[id];
  }
  addItemTostorage(id){
    localStorage.setItem(id,''+this.quntity);
    console.log(id)
  }
  deletefromStorge(id){
    localStorage.removeItem(id);
    this.ngOnInit()
  }
  keysValueAssoc(){
    var keysVal =[];
    for (var i = 0 ;i < localStorage.length; i++){
      keysVal[localStorage.key(i)]=localStorage.getItem(localStorage.key(i));
    }
    return keysVal;
  }
}
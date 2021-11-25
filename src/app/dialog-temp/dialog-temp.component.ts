import { Component, OnInit,Inject } from '@angular/core';
import {MAT_DIALOG_DATA} from '@angular/material/dialog';

@Component({
  selector: 'app-dialog-temp',
  templateUrl: './dialog-temp.component.html',
  styleUrls: ['./dialog-temp.component.css']
})
export class DialogTempComponent implements OnInit {
  quntity = 1;
  id: any;
  constructor(@Inject(MAT_DIALOG_DATA) public data:any) { }

  ngOnInit(): void {
  }
  addOne(){
    this.quntity= this.quntity+1;
  }
  
  subOne(){
    if (this.quntity>1) {
       this.quntity=this.quntity-1;
    }
  }
  addItemTostorage(id){
    localStorage.setItem(id,''+this.quntity);
    console.log(id)
  }
}

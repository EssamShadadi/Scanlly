import { Component, OnInit} from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { Location } from '@angular/common';
import{PostProviderService} from '../providers//post-provider.service';
import {MatDialog} from '@angular/material/dialog';
import {DialogTempComponent} from '../dialog-temp/dialog-temp.component';



@Component({
  selector: 'app-food-menu',
  templateUrl: './food-menu.component.html',
  styleUrls: ['./food-menu.component.css']
})
export class FoodMenuComponent implements OnInit {
  catId;
  food:any={};
  orderdFormDialog :boolean;
  tableId;

  constructor( private route: ActivatedRoute,
    private location: Location,
    private postProvider:PostProviderService,
    public matDialog: MatDialog,
    ) { }

  ngOnInit(): void {
    this.getFood();
    this.tableId = +this.route.snapshot.paramMap.get('tableId');
    console.log("Food Menu::table NO: ",this.tableId);
  }

  getFood() {
    this.catId = +this.route.snapshot.paramMap.get('catId');
   let body={
     catId:this.catId,
     method:"getFoodByCatId"
   }
   this.postProvider.postData(body,"food.php").subscribe(food=>{
     this.food=food;
     console.log("food",JSON.stringify(this.food.food))
   })
 }

 openDialog(id, name){
   let dialogRef =this.matDialog.open(DialogTempComponent,{ data: {"id":id, "name": name},});
   dialogRef.afterClosed().subscribe(result => {
    this.orderdFormDialog= result;
    console.log(this.orderdFormDialog)
   })

 }
}



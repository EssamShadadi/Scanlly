import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { Location } from '@angular/common';
import{PostProviderService} from '../providers//post-provider.service';
import {DialogTempComponent} from '../dialog-temp/dialog-temp.component';
import {MatDialog} from '@angular/material/dialog';

@Component({
  selector: 'app-food-details',
  templateUrl: './food-details.component.html',
  styleUrls: ['./food-details.component.css']
})
export class FoodDetailsComponent implements OnInit {
  foodId;
  food:any={};
  imageObject: Array<object>;
  orderdFormDialog :boolean;
  tableId;

  constructor(private route: ActivatedRoute,
    private location: Location,
    private postProvider:PostProviderService,
    public matDialog: MatDialog) { }

  ngOnInit(): void {
    this.getFoodDetails();
    this.tableId = +this.route.snapshot.paramMap.get('tableId');
    console.log("Food Details:: table NO: ",this.tableId)
  }

  getFoodDetails() {
    this.foodId = +this.route.snapshot.paramMap.get('foodId');
   let body={
    foodId:this.foodId,
     method:"getFoodDetails"
   }
   this.postProvider.postData(body,"food.php").subscribe(food=>{
     this.food=food;
     console.log("foodDetails",JSON.stringify(this.food.foodDetails))
     console.log("pics",JSON.stringify(this.food.pics))
        this.imageObject =this.food.pics;
   console.log("imageObject",this.imageObject);
   });
}
openDialog(id, name){
  let dialogRef =this.matDialog.open(DialogTempComponent,{ data: {"id":id, "name": name},});
  dialogRef.afterClosed().subscribe(result => {
   this.orderdFormDialog= result;
   console.log(this.orderdFormDialog)
  })
}
}

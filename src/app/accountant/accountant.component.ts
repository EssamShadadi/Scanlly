import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { Location } from '@angular/common';
import{PostProviderService} from '../providers//post-provider.service';
import {MatDialog} from '@angular/material/dialog';
import { InvoiceComponent } from '../invoice/invoice.component';
import { FreeDialogComponent } from '../free-dialog/free-dialog.component';

@Component({
  selector: 'app-accountant',
  templateUrl: './accountant.component.html',
  styleUrls: ['./accountant.component.css']
})
export class AccountantComponent implements OnInit {
  tables:any={};
  confirm:boolean;
  constructor(private route: ActivatedRoute,
    private location: Location,
    private postProvider:PostProviderService,
    public matDialog: MatDialog) { }

  ngOnInit(): void {
    this.getTables();
  }

  getTables() {
   
   let body={
     
     method:"getTables"
   }
   this.postProvider.postData(body,"accountant.php").subscribe(tables=>{
     this.tables=tables;
     console.log("tables",JSON.stringify(this.tables.data))
   })
 }

 freeTable(tableId,invId){
   
     let body=
  {
    tableId: tableId,
    invId: invId,
    method:"freeTable"
  }
  this.postProvider.postData(body,"accountant.php").subscribe(tables=>{
    this.tables=tables;
    console.log("MSG: ",JSON.stringify(this.tables.msg));
    this.ngOnInit();
  })
   
  
 }

 openDialog(id,invId){
  let dialogRef =this.matDialog.open(FreeDialogComponent,{ data: {"id":id,"invId":invId},});
  dialogRef.afterClosed().subscribe(result => {
   this.confirm= result;
   if(result=="true"){
    this.freeTable(id,invId);
   }

  
  })
  
 
}
}

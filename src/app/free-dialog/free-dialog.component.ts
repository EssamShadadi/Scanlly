import { Component, OnInit,Inject} from '@angular/core';
import{PostProviderService} from '../providers/post-provider.service';
import {MAT_DIALOG_DATA} from '@angular/material/dialog';

@Component({
  selector: 'app-free-dialog',
  templateUrl: './free-dialog.component.html',
  styleUrls: ['./free-dialog.component.css']
})
export class FreeDialogComponent implements OnInit {
  invoice:any = {};
  constructor( private postProvider: PostProviderService,@Inject(MAT_DIALOG_DATA) public data:any) { }

  ngOnInit(): void {
    this.getInvoice(this.data.id)
  }
  getInvoice(id) {
    let body=
    {
      tableId:id,
      method:"getInvoice"
    }
    this.postProvider.postData(body,"invoice.php").subscribe
    (cat=>
      {
        this.invoice=cat;
        if (this.invoice.success==true){
          console.log("success",JSON.stringify(this.invoice.success));
          console.log("invoice",JSON.stringify(this.invoice.totalAmount));
        }
        else {
          console.log("invoice",JSON.stringify(this.invoice.msg));
        }

      }
    )
  }
  cal(x,y):number{
    return x*y;
  }
}

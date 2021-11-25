import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import{PostProviderService} from '../providers/post-provider.service';
@Component({
  selector: 'app-invoice',
  templateUrl: './invoice.component.html',
  styleUrls: ['./invoice.component.css']
})
export class InvoiceComponent implements OnInit {
  tableId;
  invoice:any = {};
  constructor(private route: ActivatedRoute, private postProvider: PostProviderService) { }

  ngOnInit(): void {
    this.tableId = +this.route.snapshot.paramMap.get('tableId');
    this.getInvoice();
  }
  getInvoice() {
    let body=
    {
      tableId:this.tableId,
      method:"getInvoice"
    }
    this.postProvider.postData(body,"invoice.php").subscribe
    (cat=>
      {
        this.invoice=cat;
        if (this.invoice.success==true){
          console.log("success",JSON.stringify(this.invoice.success));
          console.log("category",JSON.stringify(this.invoice.data));
        }
        else {
          console.log("category",JSON.stringify(this.invoice.msg));
        }

      }
    )
  }
}

import { Component, OnInit } from '@angular/core';
import{PostProviderService} from '../providers/post-provider.service';
import { ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-category',
  templateUrl: './category.component.html',
  styleUrls: ['./category.component.css']
})
export class CategoryComponent implements OnInit {

  category:any={};
  tableId;
  constructor(private postProvider: PostProviderService,private route: ActivatedRoute) { }

  ngOnInit(): void {
    this.tableId = +this.route.snapshot.paramMap.get('tableId');
    console.log("Category::table NO: ",this.tableId);
    this.getCategory();
  }
  // get the category from the database 
  getCategory() {
    let body=
    {
      tableId: this.tableId,
      method:"getCat"
    }
    this.postProvider.postData(body,"category.php").subscribe
    (cat=>
      {
        this.category=cat;
        if (this.category.success==true){
          console.log("success",JSON.stringify(this.category.success));
          console.log("category",JSON.stringify(this.category.data));
        }
        else {
          console.log("category",JSON.stringify(this.category.msg));
        }

      }
    )
  }

}

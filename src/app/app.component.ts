import { Component } from '@angular/core';
import { ActivatedRoute } from '@angular/router';


@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  tableId;
  
  ngOnInit(): void {
    this.tableId = +this.route.snapshot.paramMap.get('tableId');
    console.log("main ::table NO: ",this.tableId);
  }
  title = 'scanlly';
  openCart(){
    
  }
  constructor(private route: ActivatedRoute) { }
}

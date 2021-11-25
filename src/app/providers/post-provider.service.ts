import { Injectable } from '@angular/core';
import { HttpClient} from "@angular/common/http";
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class PostProviderService {
  
  server:string="https://scanlly.000webhostapp.com/server_api/";
  url:string="https://scanlly.000webhostapp.com/";

  constructor(private http: HttpClient) { }

  postData(body:object,fileName:string):Observable<object>
  {
    return this.http.post(this.server + fileName, JSON.stringify(body));
  }
}

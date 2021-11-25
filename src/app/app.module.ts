import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { CommonModule } from '@angular/common';
import { AppComponent } from './app.component';
import { CategoryComponent } from './category/category.component';
import { FoodMenuComponent } from './food-menu/food-menu.component';
import { AppRoutingModule } from './app-routing.module';
import {HttpClientModule} from '@angular/common/http';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import {MterialModule} from './mterial/mterial.module';
import { DialogTempComponent } from './dialog-temp/dialog-temp.component';
import { FoodDetailsComponent } from './food-details/food-details.component';
import { NgImageSliderModule } from 'ng-image-slider';
import { ShoppingCartComponent } from './shopping-cart/shopping-cart.component';
import { OrdersDialogComponent } from './orders-dialog/orders-dialog.component';
import { DeleteDialogComponent } from './delete-dialog/delete-dialog.component';
import { ConfirmDialogComponent } from './confirm-dialog/confirm-dialog.component';
import { InvoiceComponent } from './invoice/invoice.component';
import { AccountantComponent } from './accountant/accountant.component';
import { FreeDialogComponent } from './free-dialog/free-dialog.component';




@NgModule({
  declarations: [
    AppComponent,
    CategoryComponent,
    FoodMenuComponent,
    DialogTempComponent,
    FoodDetailsComponent,
    ShoppingCartComponent,
    OrdersDialogComponent,
    DeleteDialogComponent,
    ConfirmDialogComponent,
    InvoiceComponent,
    AccountantComponent,
    FreeDialogComponent,
  ],
  imports: [
    BrowserModule,
    CommonModule,
    AppRoutingModule,
    HttpClientModule,
    BrowserAnimationsModule,
    MterialModule,
    NgImageSliderModule
    
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }

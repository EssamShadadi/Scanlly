import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import {RouterModule, Routes} from '@angular/router';
import {CategoryComponent} from './category/category.component';
import {FoodMenuComponent} from './food-menu/food-menu.component';
import {FoodDetailsComponent} from './food-details/food-details.component';
import {ShoppingCartComponent} from './shopping-cart/shopping-cart.component';
import {InvoiceComponent} from './invoice/invoice.component';
import { AccountantComponent } from './accountant/accountant.component';

const routes:Routes=[
  {path: 'categories/:tableId',component: CategoryComponent},
  {path: 'food/:catId/:tableId',component: FoodMenuComponent},
  {path: 'food-details/:foodId/:tableId',component: FoodDetailsComponent},
  {path: 'shopping-cart/:tableId',component: ShoppingCartComponent},
  {path: 'invoice/:tableId',component: InvoiceComponent},
  {path: 'accountant',component: AccountantComponent},
  // {path: '',redirectTo:'/categories/:tableId',pathMatch:'full'}

];


@NgModule({
  declarations: [],
  imports: [
    CommonModule,
    RouterModule.forRoot(routes)
  ],
  exports: [RouterModule]
})
export class AppRoutingModule { }

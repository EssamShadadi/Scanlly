import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import {MatDialogModule} from '@angular/material/dialog';
import {MatButtonModule} from '@angular/material/button';
import {MatSnackBarModule} from '@angular/material/snack-bar';
import {MatIconModule} from '@angular/material/icon';
import {MatBadgeModule} from '@angular/material/badge';
const materilComponent =[
                        MatDialogModule,
                        MatButtonModule,
                        MatSnackBarModule,
                        MatIconModule,
                        MatBadgeModule
                      ];


@NgModule({
  declarations: [],
  imports: [
    CommonModule,
    materilComponent
  ],
  exports: [
    materilComponent
  ]
})
export class MterialModule { }

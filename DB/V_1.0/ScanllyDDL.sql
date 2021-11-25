/*================================================================*/
/* Author:    Essam Shadadi   						*/
/*DBMS name:  MySQL 5.0                                           */
/*Purpose:	  To create the database schema .      	            */
/*Created on: 3/13/2021 10:02:16 AM                               */
/*Database:   id16376938_scanllydb				            		*/
/*================================================================*/

USE id16376938_scanlly;

drop table if exists Parameter;

drop table if exists Usernotification;

drop table if exists Scan;

drop table if exists Foodpicture;

drop table if exists Orderdetails;

drop table if exists Users;

drop table if exists Qrcode;

drop table if exists Notifications;

drop table if exists Orders;

drop table if exists Tables;

drop table if exists Scanner;

drop table if exists Invoice;

drop table if exists Food;

drop table if exists Picture;

drop table if exists Food;

drop table if exists Category;

/*==============================================================*/
/* Table: Category                                              */
/*==============================================================*/
create table Category
(
   catId                int not null,
   catEnName            varchar(255) not null,
   catArname            varchar(255) not null,
   catPicturepath       varchar(255) not null,
   primary key (catId)
);

/*==============================================================*/
/* Table: Food                                                  */
/*==============================================================*/
create table Food
(
   foodId               int not null,
   catId                int not null,
   foodEnName           varchar(255) not null,
   foodArName           varchar(255) not null,
   foodIsAvailable      bool not null,
   foodEnDescription    text not null,
   foodArDescription     text not null,
   foodPicturepath      varchar(255) not null,
   foodPrice            float not null,
   primary key (foodId)
);

/*==============================================================*/
/* Table: Foodpicture                                           */
/*==============================================================*/
create table Foodpicture
(
   foodId               int not null,
   picId                int not null,
   primary key (foodId, picId)
);

/*==============================================================*/
/* Table: Invoice                                               */
/*==============================================================*/
create table Invoice
(
   invId                int not null,
   invDt                datetime not null,
   invTotalAmount       float not null,
   invStatus            varchar(50) not null,
   primary key (invId)
);

/*==============================================================*/
/* Table: Notifications                                         */
/*==============================================================*/
create table Notifications
(
   notId                int not null,
   orderId              int not null,
   notText              varchar(255) not null,
   notDt                datetime not null,
   notType              varchar(255) not null,
   primary key (notId)
);

/*==============================================================*/
/* Table: Orderdetails                                          */
/*==============================================================*/
create table Orderdetails
(
   orderId              int not null,
   foodId               int not null,
   quantity             int,
   primary key (orderId, foodId)
);

/*==============================================================*/
/* Table: Orders                                                */
/*==============================================================*/
create table Orders
(
   orderId              int not null,
   tableId              int not null,
   invId             int not null,
   ordDt                datetime not null,
   ordTotalAmount       float not null,
   ordStatus            varchar(50) not null,
   primary key (orderId)
);

/*==============================================================*/
/* Table: Parameter                                             */
/*==============================================================*/
create table Parameter
(
   parid                int not null,
   parname              varchar(50) not null,
   parvalue             varchar(250) not null,
   partype              varchar(50),
   primary key (parid)
);

/*==============================================================*/
/* Table: Picture                                               */
/*==============================================================*/
create table Picture
(
   picId                int not null,
   picpath              varchar(255) not null,
   primary key (picId)
);

/*==============================================================*/
/* Table: Qrcode                                                */
/*==============================================================*/
create table Qrcode
(
   qrId                 int not null,
   tableId              int,
   qr                   text not null,
   qrFor                varchar(50) not null,
   primary key (qrId)
);

/*==============================================================*/
/* Table: Scan                                                  */
/*==============================================================*/
create table Scan
(
   qrId                 int not null,
   scannerId            int not null,
   scanDT               datetime not null,
   primary key (qrId, scannerId,scanDT)
);

/*==============================================================*/
/* Table: Scanner                                               */
/*==============================================================*/
create table Scanner
(
   scannerId            int not null,
   scannerLat           varchar(100),
   scannerLong          varchar(100),
   scannerToken         varchar(250) not null,
   scannerIsActive      bool not null,
   primary key (scannerId)
);

/*==============================================================*/
/* Table: Tables                                                */
/*==============================================================*/
create table Tables
(
   tableId              int not null,
   tableIsAvailable     bool not null,
   primary key (tableId)
);

/*==============================================================*/
/* Table: Usernotification                                      */
/*==============================================================*/
create table Usernotification
(
   notId                int not null,
   scannerId            int not null,
   notIsRead            bool not null,
   primary key (notId, scannerId)
);

/*==============================================================*/
/* Table: Users                                                 */
/*==============================================================*/
create table Users
(
   scannerId            int not null,
   userName             varchar(50),
   userRole             varchar(50),
   qrId                  int not null,
   primary key (scannerId)
);





alter table Food add constraint fk_foodcategory foreign key (catId)
      references Category (catId) on delete restrict on update restrict;

alter table Foodpicture add constraint fk_foodpicture foreign key (foodId)
      references Food (foodId) on delete restrict on update restrict;

alter table Foodpicture add constraint fk_foodpicture2 foreign key (picId)
      references Picture (picId) on delete restrict on update restrict;

alter table Notifications add constraint fk_ordernot foreign key (orderId)
      references Orders (orderId) on delete restrict on update restrict;

alter table Orderdetails add constraint fk_orderdetails foreign key (orderId)
      references Orders (orderId) on delete restrict on update restrict;

alter table Orderdetails add constraint fk_orderdetails2 foreign key (foodId)
      references Food (foodId) on delete restrict on update restrict;

alter table Orders add constraint fk_makeorder foreign key (tableId)
      references Tables (tableId) on delete restrict on update restrict;

alter table Orders add constraint fk_orderinvoice foreign key (invId)
      references Invoice (invId) on delete restrict on update restrict;

alter table Qrcode add constraint fk_tablecode foreign key (tableId)
      references Tables (tableId) on delete restrict on update restrict;

alter table Scan add constraint fk_scan foreign key (qrId)
      references Qrcode (qrId) on delete restrict on update restrict;

alter table Scan add constraint fk_scan2 foreign key (scannerId)
      references Scanner (scannerId) on delete restrict on update restrict;

alter table Usernotification add constraint fk_usernotification foreign key (notId)
      references Notifications (notId) on delete restrict on update restrict;

alter table Usernotification add constraint fk_usernotification2 foreign key (scannerId)
      references Users (scannerId) on delete restrict on update restrict;

alter table Users add constraint fk_is foreign key (scannerId)
      references Scanner (scannerId) on delete restrict on update restrict;
alter table Users add constraint fk_codeuser foreign key (qrId)
      references Qrcode (qrId) on delete restrict on update restrict;

ALTER TABLE Invoice ADD COLUMN tableId not null int AFTER invId;

alter table Invoice add constraint fk_invoictable foreign key (tableId) references Tables (tableId) on delete restrict on update restrict;
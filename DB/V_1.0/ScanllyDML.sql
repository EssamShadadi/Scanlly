/*================================================================*/
/* Author:    Essam Shadadi   						*/
/*DBMS name:  MySQL 5.0                                           */
/*Purpose:	  To  insert data iinto database .      	            */
/*Created on: 3/13/2021 10:02:16 AM                               */
/*Database:   id16376938_scanllydb				            		*/
/*================================================================*/
USE id16376938_scanlly;

/*==============================================================*/
/* Clear all the tables	                                        */
/*==============================================================*/

USE id16376938_scanlly;

DELETE FROM Parameter;

DELETE FROM Usernotification;

DELETE FROM Scan;

DELETE FROM Foodpicture;

DELETE FROM Orderdetails;

DELETE FROM Users;

DELETE FROM Qrcode;

DELETE FROM Notifications;

DELETE FROM Orders;

DELETE FROM Tables;

DELETE FROM Scanner;

DELETE FROM Invoice;

DELETE FROM Food;

DELETE FROM Picture;

DELETE FROM Food;

DELETE FROM Category;


/*==============================================================*/
/* Table: Category                                           		*/
/*==============================================================*/
insert into Category (catId, catEnName, catArname, catPicturepath) values

	(1, 'Drinks', 'مشروبات',"https://scanlly.000webhostapp.com/server_api/images/cat/drinks_icon.jpg"),
	(2, 'Griled', 'مشاوي',"https://scanlly.000webhostapp.com/server_api/images/cat/grilled_icon.jpg"),
	(3, 'Sea food', 'مأكولات بحرية',"https://scanlly.000webhostapp.com/server_api/images/cat/seafood_icon.jpgg"),
	(4, 'Sweets', 'حلويات',"https://scanlly.000webhostapp.com/server_api/images/cat/desser_icon.jpg");

/*==============================================================*/
/* Table: Food                                           		*/
/*==============================================================*/
insert into Food (foodId, catId, foodEnName, foodArName,foodIsAvailable,foodEnDescription,foodArDescription,foodPicturepath,foodPrice) values

	(1,1,'Coffe','Ar',1,"Rich Arabic cofee",'Ar','images/cat/drinks/coffe.png',5.0),
	(2,1,'tea','Ar',1,"ordanary tea",'Ar','images/cat/drinks/tea.png',5.0),
	(3,2,'Cheken breast','Ar',1,"Cheken breast",'Ar','images/cat/griled/ckbreast.png',12.0),
	(4,2,'Kabab','Ar',1,"Kabab",'Ar','images/cat/drinks/Kabab.png',20.0),
	(5,3,'creaspy Shrimp','Ar',1,"deep fried creaspy Shrimp with garlic souce and mashed poteto",'Ar','images/cat/seafood/creaspy Shrimp.png',27.0),
	(6,4,'Choclate mose','Ar',1,"soft dark melted chokalte",'Ar','images/cat/sweets/Choclate mose.png',10.0),
	(7,4,'Chees cake','Ar',1,"Chees cake",'Ar','images/cat/sweets/Chees cake.png',10.0),
	(8,4,'Cup cake','Ar',1,"Cup cake",'Ar','images/cat/sweets/Cup cake.png',5.0);

/*==============================================================*/
/* Table: Picture                                           		*/
/*==============================================================*/
insert into Picture (picId, picpath) values

	(1,'images/cat/drinks/coffe1.png'),
	(2,'images/cat/drinks/tea1.png'),
	(3,'images/cat/griled/ckbreast.png'),
	(4,'images/cat/griled/ckbreast1.png'),
	(5,'images/cat/griled/Kabab.png'),
	(6,'images/cat/griled/Kabab1.png'),
	(7,'images/cat/Sea food/creaspy Shrimp.png'),
	(8,'images/cat/Sweets/Choclate mose.png'),
	(9,'images/cat/Sweets/Choclate mose1.png'),
	(10,'images/cat/Sweets/Chees cake.png'),
	(11,'images/cat/Sweets/Chees cake1.png'),
	(12,'images/cat/Sweets/Cup cake.png'),
	(13,'images/cat/Sweets/Cup cake.png'),
	(14,'images/cat/Sweets/Cup cake1.png');

/*==============================================================*/
/* Table: Foodpicture                                           */
/*==============================================================*/
insert into Foodpicture (foodId, picId) values
	(1,1),
	(2,2),
	(3,3),
	(3,4),
	(4,5),
	(4,6),
	(5,7),
	(6,8),
	(6,9),
	(7,10),
	(7,11),
	(8,12),
	(8,13),
	(8,14);
/*==============================================================*/
/* Table: Invoice                                           	*/
/*==============================================================*/
insert into Invoice (invId, invDt, invTotalAmount, invStatus) values

	(1, '2021-03-22 01:35:05', 50,"Paid"),
	(2, '2021-03-22 01:35:05', 20,"Paid"),
	(3, '2021-03-22 01:35:05', 53,"Paid"),
	(4, '2021-03-22 01:35:05', 90,"Paid");

/*==============================================================*/
/* Table: Tables                                           		*/
/*==============================================================*/
insert into Tables (tableId, tableIsAvailable) values

	(1, 1),
	(2, 1),
	(3, 0),
	(4, 1);

/*==============================================================*/
/* Table: QRCode                                           		*/
/*==============================================================*/
insert into Qrcode (qrId, tableId,qr,qrFor) values

	(1, 1,"Place holder","table"),
	(2, 2,"Place holder","table"),
	(3, 3,"Place holder","table"),
	(4, 4,"Place holder","table"),
	(5, null,"Place holder","accountant"),
	(6, null,"Place holder","accountant"),
	(7, null,"Place holder","chief");

/*==============================================================*/
/* Table: Orders                                           		*/
/*==============================================================*/
insert into Orders (orderId, tableId, invId, ordDt,ordTotalAmount,ordStatus) values

	(1,1,1,'2021-03-22 01:35:05',50.0,'Delivered'),
	(2,1,1,'2021-03-22 01:35:05',70.0,'Canceled'),
	(3,1,1,'2021-03-22 01:35:05',20.0,'Delivered'),
	(4,2,2,'2021-03-22 01:35:05',20.0,'Delivered'),
	(5,2,2,'2021-03-22 01:35:05',10.0,'Delivered'),
	(6,3,3,'2021-03-22 01:35:05',15.0,'Pending'),
	(7,3,4,'2021-03-22 01:35:05',10.0,'Pending');

/*==============================================================*/
/* Table: Orderdetails                                          */
/*==============================================================*/
insert into Orderdetails (orderId, foodId, quantity) values

	(1,1,2),
	(1,4,1),
	(3,1,1),
	(4,2,2),
	(5,2,2),
	(6,2,3),
	(7,3,1),
	(7,6,1);

/*==============================================================*/
/* Table: Scanner                                           	*/
/*==============================================================*/
insert into Scanner (scannerId, scannerLat, scannerLong, scannerToken,scannerIsActive) values

	(1,"lat place holder",'long place holder','token place holder',1),
	(2,"lat place holder",'long place holder','token place holder',1),
	(3,"lat place holder",'long place holder','token place holder',1),
	(4,"lat place holder",'long place holder','token place holder',1),
	(5,"lat place holder",'long place holder','token place holder',1),
	(6,"lat place holder",'long place holder','token place holder',1),
	(7,"lat place holder",'long place holder','token place holder',1),
	(8,"lat place holder",'long place holder','token place holder',1),
	(9,"lat place holder",'long place holder','token place holder',1),
	(10,"lat place holder",'long place holder','token place holder',1),
	(11,"lat place holder",'long place holder','token place holder',1),
	(12,"lat place holder",'long place holder','token place holder',1),
	(13,"lat place holder",'long place holder','token place holder',1);

/*==============================================================*/
/* Table: Users                                          		*/
/*==============================================================*/
insert into Users (scannerId, userName, userRole,qrId) values

	(1,'Maher','Accountant',5),
	(2,'Essam','Chef',7),
	(3,'Ssally','Accountant',6);

/*==============================================================*/
/* Table: Notifications                                         */
/*==============================================================*/
insert into Notifications (notId, orderId, notText, notDt,notType) values

	(1,1,'2 Cup of coffee for table number 1','2021-03-22 01:35:05','push notifcation'),
	(2,2,'2 Kabab for table number 1','2021-03-22 01:35:05','push notifcation'),
	(3,2,'canceled 2 Kabab for table number 1','2021-03-22 01:35:05','push notifcation'),
	(4,3,'1 Cup of tea for table number 1','2021-03-22 01:35:05','push notifcation'),
	(5,4,'2 Cup of tea for table number 2','2021-03-22 01:35:05','push notifcation'),
	(6,5,'2 Cup of tea for table number 2','2021-03-22 01:35:05','push notifcation'),
	(7,3,'2 Cup of tea for table number ','2021-03-22 01:35:05','push notifcation');

/*==============================================================*/
/* Table: Users                                          				*/
/*==============================================================*/
insert into Usernotification (notId, scannerId, notIsRead) values

	(1,1,0),
	(1,2,0),
	(3,1,0),
	(4,1,0),
	(5,1,0),
	(6,1,0),
	(7,1,0);

/*==============================================================*/
/* Table: Scan                                           		*/
/*==============================================================*/
insert into Scan (qrId, scannerId, scanDT) values

	(7,1,'2021-03-22 01:35:05'),
	(6,2,'2021-03-22 01:35:05'),
	(1,1,'2021-03-22 01:35:05'),
	(1,11,'2021-03-22 01:35:05'),
	(1,13,'2021-03-22 01:35:05'),
	(1,5,'2021-03-22 01:35:05'),
	(2,7,'2021-03-22 01:35:05'),
	(2,8,'2021-03-22 01:35:05'),
	(3,6,'2021-03-22 01:35:05'),
	(3,4,'2021-03-22 01:35:05'),
	(4,3,'2021-03-22 01:35:05');

/*==============================================================*/
/* Table: Parameter                                          		*/
/*==============================================================*/
insert into Parameter (parId, parName, parValue,parType) values

	(1,'canceling time','15','time');
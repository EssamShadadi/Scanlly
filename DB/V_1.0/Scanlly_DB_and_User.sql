/*==============================================================*/
/*	Author:		Essam Shadadi   								*/
/* DBMS name:      MySQL 5.0                                    */
/*	Purpose:	To create the database schema and its user. 	*/
/* Created on:     3/13/2021 10:02:16 AM                        */
/*	Database: id16376938_scanlly										*/
/*==============================================================*/

DROP DATABASE IF EXISTS id16376938_scanlly;
CREATE DATABASE id16376938_scanlly CHARACTER SET utf8 COLLATE utf8_general_ci;
USE id16376938_scanlly;

/*==============================================================*/
/*	User: Scanlly_user       									*/
/*==============================================================*/
DROP USER IF EXISTS Scanlly_user@localhost;
CREATE USER Scanlly_user@localhost IDENTIFIED BY '$c@NLLy21$@lly';
GRANT SELECT, INSERT, UPDATE, DELETE, FILE ON *.* TO Scanlly_user@localhost;
GRANT ALL PRIVILEGES ON id16376938_scanlly.* TO Scanlly_user@localhost;
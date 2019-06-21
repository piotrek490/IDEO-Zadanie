drop database HaszSet;

create database HaszSet DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

use HaszSet;

create table MainTableData(
val bigint,
valNext bigint,
dataKey text,
isFirst int(1)
)CHARSET=utf8;




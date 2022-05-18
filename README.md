# SiSiAk( Sistem Simple Absensi Karyawan )


Platform Absensi Karywan

Started at 18 Mei 2022

## Installation

`composer install` always install / update after pull

`cp env .env` copy .env file

*_NOTES_*  :
>make sure your was setting config 
-CI_ENVIRONMENT you input with 'development'or 'production'  

- app.base_url you should input with http://localhost:9092/ ;

- host ;
- username ;
- database;
- password ;

after that your create database appropriate with in .env


`php spark migrate` always migrate after pull



### svelte

source location
```
./public/src/*
```

source distribution
```
./public/dist/*
```
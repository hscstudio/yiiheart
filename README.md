YiiHeart
========
---
YiiHeart is Yii Webapp Startup

AppVersion 1.0, 
manualVersion 1.0
By Hafid Mukhlasin [milisstudio @ gmail dot com]
---

## Apa Itu YiiHeart
Yii Hearts adalah webapp atau bootsrap yang digenerate dari framework Yii dan telah dikustomisasi. Sehingga siap digunakan sebagai base untuk membuat sebuah aplikasi.

## Fitur fitur YiiHeart
* Yiibooster ready
* PHPExcel ready via EexcelView (export) dan XPHPExcel(import) serta telah dimodifikasi
* CRUD+++ (Create, Read, Update, Delete, Export, Import, Editable) via CRUD Yiibooster yang telah dimodifikasi.
* Yii rights yang telah dimodifikasi
* Soft Delete, apa itu.. ? bukan hapus tapi hanya dengan mengupdate field deleted, dan menghidennya dari view

## Manajemen Folder
Pengelolaan folder pada Yii Heart adalah sebagai berikut:
*	Diroot directori ada dua folder yaitu:
 
  folder yii adalah folder framework yii
  folder heart adalah folder aplikasi kita
 
*	Secara umum menggunakan default Yii
*	Extension yiibooster diletakkan pada folder protected/extension/yiibooster
*	Extension XPHPExcel dan EexcelView diletakkan pada folder protected/extension/phpexcel, sedangkan library php excelnya sendiri diletakkan di folder protected/vendor/phpexcel
*	Extension right diletakkan pada folder modules/rights, sebagaimana default yang disarankan.

## Struktur Database
Bundel dari Yii Heart ada 9 tabel, sbb:

dimana 6 tabel yang dichecklist merupakan tabel utama, selebihnya adalah tabel contoh. Tb_admin adalah tabel yang berisi username password user, bagi yang sudah mengenal Rights Extension, maka inilah tabel user itu.. (disini diganti dengan tb_admin), sedangkan tb_employee  digunakan untuk menyimpan informasi dari si user.. misal nama, alamat, no hpp, pin bbm dll..Tabel utama lainnya adalah merupakan tabel bawaan Right Extension.

## Aturan-aturan di YiiHeart
Agar lebih maksimal dalam penggunaan Yii Heart, berikut ini beberapa aturan yang diterapkan:
### DATABASE
*	Kembalikan ke bahasa aslinya, jadi kalau bikin nama database, nama tabel, nama field sebaiknya gunakan bahasa inggris dan bentuknya tunggal. Misal tabel data karyawan, maka tulislah tb_employee bukan tb_karyawan, tb_employees (takut kedinginan kalo ditambah dg es), atau tb_pemandangan (sangat out of the box.. gak nyambung dengan isinya).
*	Penulisan nama tabel sebaiknya diawali dengan prefix tb_ untuk tabel utama dan ref_ untuk tabel referensi, contoh: ref_religion, tb_training
*	Penulisan nama field untuk primary key sebaiknya id,
*	Disamping id, nama filed yang sebaiknya
*	Penulisan nama field sebaiknya gunakan huruf kecil, jika terdiri dari dua kata atau lebih maka formatnya capitalize tanpa spasi. Contoh: id, name, birthDay, namaLainLagi, dst
*	Penulisan nama field untuk foreign key sebaiknya gunakan prefix tabelnya didepan. Contoh: ref_religion_id, tb_training_id
*	Tambahkan field2 default pada setiap tabel Anda, yaitu created, createdBy, modified, modifiedBy, deleted, deletedBy.
*	Tools untuk desain database mysql yang recomendate dan profesional adalah MySQL Workbench (ini yang belum ada di PostgreeSQL dan MariaDB), dan aturan diatas selaras dengan MySQL Workbench
### Generator
*	Untuk generate model, pada gii, gunakan Model X Generator. Isikan field Tabel prefix tabel baru kemudian field Table Name. Lalu biarkan apa adanya field Model Class
 
*	Untuk generate CRUD, pada gii, gunakan Crud X Generator. Gunakan seperti biasa.
 
Pada contoh diatas akan mengcreated CRUD dengan model Student, lihat pada field Controller ID.. disana ditambahkan prefix folder.. jadi nanti file controller akan disimpan dalam folder /controllers/latihan/studentController.php
Gunakan selalu prefix agar mudah maintenis kode Anda.. nama prefixnya ya gak harus latihan.. hehehe
*	Selesai.. yah dengan langkah diatas Anda sudah akan mendapatkan CRUD+++.. “tanpa edit” lagi.. hhihihi tapi kalo mau lebih ikuti yang dibawah
*	Adapun Crud Y Generator (parent) dan Crud Z Generator (child) digunakan untuk kasus tabel parent n child.. 
Misal ada dua tabel yaitu tb_training (diklat), dan tb_training_document (dokumen diklat). Relasi One to Many, Jadi 1 diklat punya banyak dokumen. Implementasinya adalah sebelum mengakses dokumen, maka user harus memilih diklatnya. 
Untuk menggunakannya, 
*	silahkan digenerate tabel parent (tb_training)  pada Crud Y Generator, 
 
 
*	Agar CRUD Training tersebut bisa diakses oleh user maka kita buat dulu donk linknya.. silahkan buka file protected/views/layouts/main.php
 array('label'=>'LATIHAN', 'url'=>'#', 'icon'=>'fa fa-sitemap', 'visible'=>!Yii::app()->user->isGuest, 'active'=>($currRoutes[0]=='latihan') ,'items'=>array(array('label'=>'Manage Training', 'url'=>array('/latihan/training'), 'icon'=>'fa fa-', 'visible'=>!Yii::app()->user->isGuest),						)),

*	lalu generate juga tabel child (tb_training_document) pada Crud Z Generator 
CrudZ lo jangan salah 
 
*	Apakah selesai? Belum selesai.. perlu kita lakukan sedikit editing pada hasil generatenya. 
1.	Hasil Generate Crud Y, buka file view.php pada folder protected/views/NAMA_PARENT_MODEL/view.php
misal : protected/views/latihan/training/view.php
 
 
Lihat line 10, masukkan link ke childnya yaitu document training, contoh:
array('label'=>Training Document,'url'=>Yii::app()->createUrl("latihan/trainingDocument/index", array("pId"=>$model->id)),'icon'=>'fa fa-list-alt'),
2.	Hasil Generate Crud Z, buka file controller childnya pada folder protected/controllers/NAMA_CHILD_MODELController.php
misal : protected/controllers/latihan/trainingDocumentController.php
 Update line 9 – 12, sesuaikan dengan parentnya.
3.	Selesai. Ready to use.

YiiHeart dibuat dengan segenap cinta :)

Thx

Hafid Mukhlasin
Depok - Jawa Barat

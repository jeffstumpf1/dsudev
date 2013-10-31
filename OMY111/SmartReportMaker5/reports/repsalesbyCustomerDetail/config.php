<?php
//Sales by Customer Detail,29-Oct-2013 17:43:23
$back='http://dsudev.local:8888/sprocket.php?part_id=321&status=E&cat=FS';
$host='localhost';
$user='dsuAdmin';
$pass='drive$ystem';
$db='dsu';
$datasource='sql';
$table=array('Customer','Orders');
$relationships=array('`Customer`.`customer_id` = `Orders`.`order_id`');
$tables_filters='';
$fields=array('dba','customer_number','address','city','state','zip','phone1','fax','email','discount','tax_rate');
$fields2=array('dba','customer_number','address','city','state','zip','phone1','fax','email','discount','tax_rate');
$labels=$labels = 'a:11:{s:3:"dba";s:3:"DBA";s:15:"customer_number";s:5:"Cust#";s:7:"address";s:4:"Addr";s:4:"city";s:4:"City";s:5:"state";s:2:"ST";s:3:"zip";s:3:"Zip";s:6:"phone1";s:5:"Phone";s:3:"fax";s:3:"Fax";s:5:"email";s:5:"email";s:8:"discount";s:1:"%";s:8:"tax_rate";s:3:"Tax";}';;
$group_by=array();
$sort_by=array();
$layout='AlignLeft2';
$style_name='GreyScale';
$Forget_password='';
$security='';
$members='';
$sec_Username='';
$sec_pass='';
$sec_table='';
$sec_Username_Field='';
$sec_pass_Field='';
$sec_email='';
$sec_email_field='';
$title='Sales by Customer Detail';
$date_created='29-Oct-2013 17:43:23';
$header='Drive Systems USA INC.';
$footer='';
$file_name='salesbyCustomerDetail';
$records_per_page='10';
$chkSearch='';
$is_mobile='';
$sql='select * from Customer';
?>
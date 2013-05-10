<?php
$FTP_server= "iraceph-prod.cloudapp.net";
$FTP_Username= "daniel";
$FTP_Pass= "lagazo";
$conn_id=ftp_connect($FTP_server,21);
$file=$_FILES["userfile"]["name"];
$file_path=$_FILES["userfile"]["tmp_name"];
//$reg_id = $_POST[reg_id];
if(@ftp_login($conn_id,$FTP_Username,$FTP_Pass)) {

ftp_chdir($conn_id,"/var/www/images/races");
if(@ftp_put($conn_id,$file,$file_path,FTP_BINARY))//upload file
{
ftp_chmod($conn_id,0644,$file);

ftp_close($conn_id);

}
} else { echo "Connection failure. Check Username and Password";
}
mysql_connect('localhost','root','');

mysql_select_db('irace') or die("Unable to select database");

$query="UPDATE registration SET reg_image ='".$file."' WHERE reg_id =".$reg_id."";
$result=mysql_query($query);
mysql_close();

exit ;
?>

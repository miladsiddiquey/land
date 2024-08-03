<?php
include '../admin/config.php';
$obj = new Database();

if($obj){
  echo 'database okay';

}else{
  echo 'db not okay';
}
?>
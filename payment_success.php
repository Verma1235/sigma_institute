<?php
if(isset($_GET['txn_id'])){
   echo $txn_id=$_GET['txn_id'];
  echo   $clint_txn_id=$_GET['clint_txn_id'];
}else{
    echo "not redirect txn id";
}

?>
<?php
session_start();
echo $_SESSION['DBMS_ADM_STATUS'];

if($_SERVER['REQUEST_METHOD']==='POST' || isset($_SESSION['DBMS_ADM_STATUS'])){
    $call_back_url="https://operates-rv-goal-reel.trycloudflare.com/sigma/payment_success.php";
    $api_url="https://api.ekqr.in/api/create_order";
    $clint_id="UPI_TXT_".rand(000000,999999);
    $payload_data= array(
        'key'=>"5579fab1-f3b9-45d0-83ce-e8ccd794376a",
        'clint_txn_id'=> "$clint_id",
        'p_info'=>'Admission fee',
        'amount'=>'1',
        'customer_name'=>'Dinesh kumar verma',
        'customber_mobile'=>'9693490785',
        'redierect_url'=>"$call_back_url"
    );
    $jsonPayloadData =json_encode($payload_data);
    $curl =curl_init();

    curl_setopt_array($curl,array(
        CURLOPT_URL=>"$api_url",
        CURLOPT_RETURNTRANSFER=>true,
        CURLOPT_ENCODING=>'',
        CURLOPT_MAXREDIRS=>10,
        CURLOPT_TIMEOUT=> 0,
        CURLOPT_FOLLOWLOCATION=>true,
        CURLOPT_HTTP_VERSION=>CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST=>'POST',
        CURLOPT_POSTFIELDS=>$jsonPayloadData,
        CURLOPT_HTTPHEADER=> array(
            "Content-type:application/json"
        ),
    ));


    $response=curl_exec($curl);
    $err=curl_error($curl);
    curl_close($curl);

    if($err){
        echo "cURL Error #:". $err;
    }else{
        $res =json_decode($response);
        if(isset($res->status)){
            $order_id=$res->data->order_id;
            $payUrl=$res->data->payment_url;
            $upi_hash=$res->data->upi_id_hash;  
        }
        
    }
}else{
    echo "page not foumd !";
}




?>
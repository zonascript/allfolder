<?php 
include_once('../common.php');
page_protect();
if(!isset($_SESSION['user_id']))
{
    header("location:logout.php");
}
$user_session = $_SESSION['user_session'];
$errorsend = array();
$transactionList = array();

$user_current_balance = 0;
$reciever_address= "";
$coin_amount = 0;
$trans_desc ="";
$spendingpassword = "";
$user_current_balance2 = 0;
$client = "";
if(_LIVE_)
{
    $client = new Client($rpc_host, $rpc_port, $rpc_user, $rpc_pass);
    if(isset($client))
    {
        $user_current_balance = $client->getBalance($user_session) - $fee;
        $user_current_balance2 = $user_current_balance;
    }
}

if(isset($_POST['btncontact']))
{
    //  var_dump($_POST);
    $coin_amount = $_POST['txtChar'];
    $reciever_address = $_POST['btcaddress'];
    $trans_desc = $_POST['discription'];
    $spendingpassword = $_POST['spendingpassword'];
    $user_current_balance = 0;
    
    if(_LIVE_)
    {
        $client = new Client($rpc_host, $rpc_port, $rpc_user, $rpc_pass);
        if(isset($client))
        {
            $user_current_balance = $client->getBalance($user_session) - $fee;
        }
    }
    if (empty($reciever_address))
    {
        $errorsend['reciever_addressError'] = "Please Provide valid Address";
    }   
    
    if (empty($coin_amount))
    {
        $errorsend['txtCharError'] = "Please Provide valid Amount";
    }   
    if(empty($spendingpassword))
    {
        $errorsend['spendingpasswordError'] = "Please Provide valid Spending Password";
    }   
    if ($coin_amount > $user_current_balance)
    {
        $errorsend['txtCharError'] = "Withdrawal amount exceeds your wallet balance";
    }
    if(!empty($spendingpassword))
    {
        $qstring = "select coalesce(id,0) as id,coalesce(transcation_password,'') as transcation_password ";
        $qstring .= "from users WHERE encrypt_username = '" . hash('sha256',$user_session) . "'";
        
        $spendingpassword_value = hash('sha256',addslashes(strip_tags($spendingpassword)));
    
        $result = $mysqli->query($qstring);
        $user = $result->fetch_assoc();
        $transcation_password_v = $user['transcation_password'];
    
        if ($user['id']> 0 && ($transcation_password_v != $spendingpassword_value))
        {
            $errorsend['spendingpasswordError'] = "Please provide valid Spending Password.";
        }
    }
    
    if(empty($errorsend))
    {
        $withdraw_message = 'ssss';
        if(_LIVE_)
        {
            $withdraw_message = $client->withdraw($user_session, $reciever_address, (float)$coin_amount);
            //$withdraw_message = $client->payment($reciever_address,$coin_amount,'from $user_session');
        }
        header("Location:dashboard.php?m=".$withdraw_message);
    }   
}
?>


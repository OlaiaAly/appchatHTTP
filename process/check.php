<?php
include("connection/connect.php");


// function timing ($time)
// {

//     $time = time() - $time; // to get the time since that moment
//     $time = ($time<1) ? 1 : $time;
//     $tokens = array (
//         31536000 => 'ano',
//         2592000 => 'mês',
//         604800 => 'semana',
//         86400 => 'dia',
//         3600 => 'hora',
//         60 => 'minuto',
//         1 => 'segundo'
//     );
// }


function debug($pam){
    echo"<pre>";
        print_r($pam);
    echo "</pre>">
    exit;
}

if(isset($_COOKIE['ID']) && isset($_COOKIE['TOKEN']) && isset($_COOKIE['SECURE'])){

    $id = $_COOKIE['ID'];
    $token = $_COOKIE['TOKEN'];
    $secure = $_COOKIE['SECURE'];

    $stmt = $conn->prepare("SELECT `ID`, `USERNAME`, `PICTURE`, `ONLINE`, `CREATION` FROM `USER` 
    WHERE (`ID` = ? AND `TOKEN` LIKE ? AND `SECURE` LIKE ?) LIMIT 1");

    $stmt->bind_param("isi", $id, $token, $secure);
    $stmt->execute();

    $me = $stmt->get_result()->fetch_assoc();


    if(!$me){
        die("<script> location.href = 'auth.html'; </script>");
    }
    else{
        $uid = $me['ID'];
        $username = $me['USERNAME'];
        $user_picture = $me['PICTURE'];
        $user_online = strtotime($me['ONLINE']);
        $user_creation = date('d-m-Y', strtotime($me['CREATION']));
        
        //ACTULIZADO A TABELA PARA O STATUS ON LINE
        $stmt = $conn->prepare("UPDATE `USER` SET `ONLINE` = NOW() WHERE `ID` = ?");
        $stmt->bind_param('i', $uid);
        $stmt->execute();

    }
} 
else{
    die("<script> location.href = 'auth.html'; </script>");
}

?>
<?php

include('check.php');

$stmt = $conn->prepare("SELECT * FROM `CONVERSATIONS` WHERE (`MAINUSER` = ?) ORDER BY `MODIFICATION` DESC");
$stmt->bind_param('i', $uid);
$stmt->execute();
$result = $stmt->get_result();
$count = $result->num_rows;


if($count < 1){
    echo "<div class='empty'><p>Pesquise um utilizador e comece um chat!</p></div>";
}
else{
    while($inbox = $result->fetch_assoc()){
        $stmt = $conn->prepare("SELECT `ID`, `USERNAME`, `PICTURE` FROM `USER` WHERE (`ID` = ?) LIMIT 1");
        $stmt->bind_param('i', $inbox['OtherUser']);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $count = $result->num_rows;

        if($user){
            ?>

                <div class="chat <?php ($inbox['Unread'] == 'y') ? 'new': ''; ?> " 
                    onclick="chat('<?php echo $user['ID']; ?>') ">
                    <img src="profilepics/<?php echo $user['PICTURE']; ?>" />
                    <p><?php echo $user['USERNAME']; ?></p>
                </div>

            <?php
        }
    }
}

?>
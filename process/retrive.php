<?php 
    include('check.php');

    if(isset($_GET['id'])){
        $user_id = $_GET['id'];

        $stmt = $conn->prepare("SELECT `sender`, `message`, `image`  FROM `chat` 
                                WHERE (`sender` = ? AND `reciever` = ?) OR (`reciever` = ? AND `sender` = ?) ORDER BY `id`");
        $stmt->bind_param('iiii', $user_id, $uid, $user_id, $uid);
        $stmt->execute();
        $result = $stmt->get_result();
        $count = $result->num_rows;

       

        $getUserName = $conn->prepare("SELECT `username` FROM `user` WHERE (`id` = ?) LIMIT 1");
        $getUserName->bind_param('i', $user_id);
        $getUserName->execute();
        $user = $getUserName->get_result()->fetch_assoc();


        if( $count < 1){
            echo "<p class='info'> Envie a sua primeira messagem para ".$user['username']."</p>";
        }
        else{
            while( $mesage = $result->fetch_assoc()){
                if($mesage['sender'] == $uid && $mesage['image']){
                    ?>
                        <div class="row sent"> 
                            <img src="uploads/<?php echo $mesage['image']; ?>">
                        </div>
                    <?php
                }
                elseif($mesage['sender'] == $uid){
                    ?>
                        <div class="row sent"> 
                            <p><?php echo $mesage['message']; ?> </p>
                        </div>
                     <?php
                }
                elseif($mesage['image'] != ""){//A outra pessoa enviou imagem
                    ?>
                        <div class="row recieved"> 
                            <img src="uploads/<?php echo $mesage['image']; ?>">
                        </div>
                    <?php
                }
                else{
                    ?>
                        <div class="row recieved"> 
                            <p><?php echo $mesage['message']; ?> </p>
                        </div>
                    <?php
                }
            
            }
        }
    }
?>
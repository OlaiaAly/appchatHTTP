<?php
    include('check.php');

    if(isset($_GET['term'])){
       $username =  mysqli_real_escape_string($conn, $_GET['term'] );

       $stmt = $conn->prepare("SELECT `ID`, `USERNAME`, `PICTURE` FROM `USER`  
       WHERE (`USERNAME` LIKE '%$username%')  ORDER BY `USERNAME` LIMIT 20");
       $stmt-> execute();
       $result = $stmt->get_result();
       $count = $result->num_rows;
       if($count < 1){
            echo "<p class='noResults'>Sem Resultados</p>";
       }
       else{
            while($user = $result->fetch_assoc()){
                ?>
                    <div class="row" onclick="$('#searchContainer').hide(); chat('<?php echo $user['ID']; ?>') ">
                        <img src="profilepics/<?php echo $user['PICTURE']; ?>" />
                        <p><?php echo $user['USERNAME']; ?></p>
                    </div>
                <?php
            }
       }

    }

?>
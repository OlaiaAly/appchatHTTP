<?php
 include('check.php');

 function timing ($time)
 {

     $time = time() - $time; // to get the time since that moment
     $time = ($time<1) ? 1 : $time;
     $tokens = array (
         31536000 => 'ano',
         2592000 => 'mês',
         604800 => 'semana',
         86400 => 'dia',
         3600 => 'hora',
         60 => 'minuto',
         1 => 'segundo'
     );

     foreach ($tokens as $unit => $text) {
         if ($time < $unit) continue;
         $numberOfUnits = floor($time / $unit);
         if ($text == "segundo") {
             return "agora mesmo";
         }
         return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
     }

 }

if(isset($_GET['id']))
    $id = $_GET['id'];
else
    die(header("HTTP/1.0 401 Falta de parametro!"));


if($id == 0){
    $id = $uid;
    ?>
        <form method='POST' enctype='multipart/form-data' id='uploadPic'>
            <input type='file' name ='imgInp' accept="image/x-png, image/jpeg" id="imgInp" style="opacity: 0%;">
            <div class="pictureContainer">
                <img id="userImg" src="profilepics/<?php echo $user_picture; ?>"/>
                <label for="imgInp"></label>
            </div>
        </form>

    <?php
}
else{

    $stmt = $conn->prepare("SELECT `ID`, `USERNAME`, `PICTURE`, `ONLINE`, `CREATION` FROM `USER` 
    WHERE (`ID` = ?)  LIMIT 1");

    $stmt->bind_param("i", $id);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if(!$user){
        die(header("HTTP/1.0 401 ERro ao colocar os dados do perfil do utilizador!"));
    }
    else{
        $username = $user['USERNAME'];
        $user_picture = $user['PICTURE'];
        $user_online = strtotime($user['ONLINE']);
        $user_creation = date('d-m-Y', strtotime($user['CREATION']));
    }
    ?>
        <div class="pictureContainer">
            <img id="userImg" src="profilepics/<?php echo $user_picture; ?>"/>
        </div>

    <?php

}
?>

<p class="name"> <?php echo $username; ?></p>
<p class="row"> <?php echo timing($user_online); ?></p>
<p class="row"> Membro desde <?php echo $user_creation; ?></p>


<script>
    function previewUpload(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#userImg').attr('src', e.target.result);
                var formData = new FormData($("#uploadPic")[0]);
                $.ajax({
                    type: 'post',
                    url: 'process/updateProfile.php',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    error: function (error) {
                        Swal.fire({
                            title: 'Imagem não alterada!',
                            text: error.statusText,
                            icon: 'error',
                            confirmButtonText: 'Tentar novamente'
                        })
                    }
                });
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#imgInp").change(function() {
        previewUpload(this);
    });
</script>
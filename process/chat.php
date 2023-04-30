<?php 
    include('check.php');

    if(isset($_GET['id']) && $_GET['id'] > 0){
        $userId = $_GET['id'];

        $getUserName = $conn->prepare("SELECT `username` FROM `user` WHERE (`id` = ?) LIMIT 1");
        $getUserName->bind_param('i', $userId);
        $getUserName->execute();
        $user = $getUserName->get_result()->fetch_assoc();
        
        
        if(!$user)
             die(header("HTTP/1.0 401 Usuario nao encotrado!"));

        ?>
            <div class="topMenu">
                <img src="img/close.png" onclick="chat()" />
                <p class="title" ><?php echo $user['username']; ?></p>
            </div>

            <div class="innerContainer"></div>

            <div class="sendMessage">
                <form method='POST' enctype='multipart/form-data' id='sendMessage'>
                    <input type="number" name = "id" value=<?php echo $userId; ?> hidden/>
                    <input type="text" name = "message" maxlength="500" placeholder="Escreva a sua messagem" id="messageInput">
                    <label for="sendImage"><img src="img/image.png" /></label>
                    <input type='file' name ='image' accept="image/x-png, image/jpeg" id="sendImage" style="opacity: 0%;">
                   
                </form>
            </div>

            <script>
                function sendMessage(){
                    
                    var formData = new FormData($('#sendMessage')[0]);
                    $.ajax({
                        type: 'post',
                        url: 'process/send.php',
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(){
                            $('#sendMessage')[0].reset();
                        },
                        error: function (error) {
                            Swal.fire({
                                title: 'Erro ao enviar a mensagem!',
                                text: error.statusText,
                                icon: 'error',
                                confirmButtonText: 'Tentar novamente'
                            })
                        }
                    });
                }
                    
                $('#messageInput').on('keyup', function(e){
                    //Se o cogigo da tecla for ENTER e compo nao estiver vasio
                    if(e.keyCode === 13  && ($('#messageInput').val().length > 0))
                        sendMessage(); 
                });

                $('#sendImage').change(function(){
                    sendMessage();
                });
                
                setInterval(()=>{
                    $.ajax({
                        url: 'process/retrive.php?id=<?php echo $userId; ?>',
                        success: function(data){
                            $('#chat .innerContainer').html(data);
                            // fazendo o scroll ate ao fundo da div
                            $('#chat .innerContainer').scrollTop($('#chat .innerContainer').prop('scrollHeight'));
                        },
                        error: function (error) {
                            Swal.fire({
                                title: 'Erro de chat!',
                                text: error.statusText,
                                icon: 'error',
                                confirmButtonText: 'Tentar novamente'
                            });
                        }
                    })
                }, 1500);

            </script>
        <?php
    }
    else{
        ?>
            <div class="empty"> 
                <img src="img/empty-chat.png"> 
                <p>Selecionae umaconverca para socializar com esse tilizador!</p>
            </div>
        <?php
    }
?>

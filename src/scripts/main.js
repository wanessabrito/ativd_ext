let menu = document.querySelector('.fa-bars');
let navbar = document.querySelector('.navbar');

menu.addEventListener('click',function(){
    menu.classList.toggle('fa-times');
    navbar.classList.toggle('nav-toggle');
});

window.addEventListener('scroll', () =>{
    menu.classList.remove('fa-times');
    navbar.classList.remove('nav-toggle');
});

$(document).ready(function() {
    $("#contactForm").submit(function(event) {
        event.preventDefault();  // Impede o envio normal do formulário

        var formData = $(this).serialize();  // Serializa os dados do formulário

        $.ajax({
            url: 'db.php',  // O arquivo PHP que vai processar os dados
            type: 'POST',
            data: formData,
            dataType: 'json',  // Espera um retorno em formato JSON
            success: function(response) {
                // Exibe a resposta do PHP
                $("#response").html(response.message);

                // Exibe um alerta baseado no status da resposta
                if (response.status === "success") {
                    alert(response.message);  // Alerta de sucesso
                } else {
                    alert(response.message);  // Alerta de erro
                }
            },
            error: function() {
                $("#response").html("Erro ao enviar a mensagem.");
                alert("Erro ao enviar a mensagem.");
            }
        });
    });
});

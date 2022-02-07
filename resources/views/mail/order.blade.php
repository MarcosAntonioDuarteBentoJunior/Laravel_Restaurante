
<h2>Olá, {{ $user->nome }}.</h2>
<h5>Obrigado por fazer seu pedido no Restaurante!</h5>
<hr>

<p>
    Esta é uma aplicação de teste que simula o gerenciamento de um restaurante com sistema de entregas.
    Encontrou algum bug? Responda esta mensagem e me ajude a melhorar meus projetos.
</p>

<hr>
<p>
    Email enviado em {{ date('d/m/Y H:i:s') }} para {{ $user->email }}.
</p>
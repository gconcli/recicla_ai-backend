<?php 
// Inclui o arquivo class.phpmailer.php localizado na mesma pasta do arquivo php 
include ('PHPMailer-master/PHPMailerAutoload.php'); 
include("./phpmailer/class.phpmailer.php"); 
include("./phpmailer/class.smtp.php");
include ('recebe.php');
 
// Inicia a classe PHPMailer 
$mail = new PHPMailer(); 
$recebe = new Recebe();
 
// Método de envio 
$mail->IsSMTP(); 
 
// Enviar por SMTP 
$mail->Host = "eduardopereiramoreira1995+senac@gmail.com"; 
 
// Você pode alterar este parametro para o endereço de SMTP do seu provedor 
$mail->Port = 587; 
 
 
// Usar autenticação SMTP (obrigatório) 
$mail->SMTPAuth = true; 
 
// Usuário do servidor SMTP (endereço de email) 
// obs: Use a mesma senha da sua conta de email 
$mail->Username = 'nathaliapereirasarmento@gmail.com'; 
$mail->Password = ''; 
 
// Configurações de compatibilidade para autenticação em TLS 
$mail->SMTPOptions = array( 'ssl' => array( 'verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true ) ); 
 
// Você pode habilitar esta opção caso tenha problemas. Assim pode identificar mensagens de erro. 
// $mail->SMTPDebug = 2; 
 
// Define o remetente 
// Seu e-mail 
$mail->From = "nathaliapereirasarmento@gmail.com"; 
 
// Seu nome 
$mail->FromName = "Nathália"; 
 
// Define o(s) destinatário(s), como no exemplo
$mail->AddAddress('$mail', '$nomeUsuario'); 
 
// Opcional: mais de um destinatário
 
// Opcionais: CC e BCC
// $mail->AddCC('joana@provedor.com', 'Joana'); 
// $mail->AddBCC('roberto@gmail.com', 'Roberto'); 
 
// Definir se o e-mail é em formato HTML ou texto plano 
// Formato HTML . Use "false" para enviar em formato texto simples ou "true" para HTML.
$mail->IsHTML(true); 
 
// Charset (opcional) 
$mail->CharSet = 'UTF-8'; 
 
// Assunto da mensagem 
$mail->Subject = "Assunto da mensagem"; 
 
// Corpo do email 
$mail->Body = 'Aqui entra o conteudo texto do email'; 
 
// Opcional: Anexos 
// $mail->AddAttachment("/home/usuario/public_html/documento.pdf", "documento.pdf"); 
 
// Envia o e-mail 
$enviado = $mail->Send(); 
 
// Exibe uma mensagem de resultado 
if ($enviado) 
{ 
    echo "Seu email foi enviado com sucesso!"; 
} else { 
    echo "Houve um erro enviando o email: ".$mail->ErrorInfo; 
} 
?>
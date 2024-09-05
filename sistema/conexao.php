<?php

$banco = 'u948216641_studio';
$usuario = 'u948216641_studio';
$senha = '512912Fm@#';
$servidor = 'localhost';

// Definindo a URL do sistema
$url_sistema = "http://$_SERVER[HTTP_HOST]/";
$url = explode("//", $url_sistema);

if ($url[1] == 'localhost/') {
	$url_sistema = "http://$_SERVER[HTTP_HOST]/barbearia/";
}

// Definindo o fuso horário
date_default_timezone_set('America/Sao_Paulo');

// Tentando conectar ao banco de dados com PDO
try {
	$pdo = new PDO("mysql:host=$servidor;dbname=$banco;charset=utf8", $usuario, $senha);
	// Configurando o modo de erro do PDO para exceções
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	// Mensagem de erro genérica
	die('Não foi possível conectar ao banco de dados. Por favor, tente mais tarde.');
}

// Variáveis do sistema
$nome_sistema = 'Barbearia Teste';
$email_sistema = 'teste@teste.com';
$whatsapp_sistema = '(35) 99746-8375';

// Consultando a tabela de configurações
$query = $pdo->query("SELECT * FROM config");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

// Verifica se a tabela está vazia
if (count($res) == 0) {
	// Inserindo os valores iniciais na tabela config usando consulta preparada
	$stmt = $pdo->prepare("INSERT INTO config 
        (nome, email, telefone_whatsapp, logo, icone, logo_rel, tipo_rel, tipo_comissao, texto_rodape, img_banner_index, quantidade_cartoes, texto_agendamento, msg_agendamento) 
        VALUES (:nome, :email, :telefone_whatsapp, 'logo.png', 'favicon.ico', 'logo_rel.jpg', 'pdf', 'Porcentagem', 'Edite este texto nas configurações do painel administrador', 'hero-bg.jpg', 10, 'Selecionar Prestador de Serviço', 'Sim')");

	$stmt->bindValue(':nome', $nome_sistema);
	$stmt->bindValue(':email', $email_sistema);
	$stmt->bindValue(':telefone_whatsapp', $whatsapp_sistema);
	$stmt->execute();
} else {
	// Carregar os dados do banco para as variáveis do sistema
	$nome_sistema = $res[0]['nome'];
	$email_sistema = $res[0]['email'];
	$whatsapp_sistema = $res[0]['telefone_whatsapp'];
	$tipo_rel = $res[0]['tipo_rel'];
	$telefone_fixo_sistema = $res[0]['telefone_fixo'];
	$endereco_sistema = $res[0]['endereco'];
	$logo_rel = $res[0]['logo_rel'];
	$logo_sistema = $res[0]['logo'];
	$icone_sistema = $res[0]['icone'];
	$instagram_sistema = $res[0]['instagram'];
	$tipo_comissao = $res[0]['tipo_comissao'];
	$texto_rodape = $res[0]['texto_rodape'];
	$img_banner_index = $res[0]['img_banner_index'];
	$icone_site = $res[0]['icone_site'];
	$texto_sobre = $res[0]['texto_sobre'];
	$imagem_sobre = $res[0]['imagem_sobre'];
	$mapa = $res[0]['mapa'];
	$quantidade_cartoes = $res[0]['quantidade_cartoes'];
	$texto_fidelidade = $res[0]['texto_fidelidade'];
	$texto_agendamento = $res[0]['texto_agendamento'];
	$msg_agendamento = $res[0]['msg_agendamento'];

	// Preparar o número de telefone para WhatsApp
	$tel_whatsapp = '55' . preg_replace('/[ ()-]+/', '', $whatsapp_sistema);
}

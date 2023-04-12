<?php
//
header('Access-Control-Allow-Origin: *');

//conexão com o Banco de Dados do administrador da página
$connect = new PDO("mysql:host=localhost;dbname=id20421037_game", "id20421037_monicafalqueto", "Aa111111--Bb");

$received_data = json_decode(file_get_contents("php://input"));

//Cria uma variável e a define como vazia, preparando-a para armazenar valores posteriormente durante a execução do programa.
$data = array();

//solicita informações ou consulta o banco de dados
if($received_data->query != '')
{
	$query = "
	SELECT * FROM fatec_professores 
	WHERE name LIKE '%".$received_data->query."%' 
	OR curso LIKE '%".$received_data->query."%' 
	ORDER BY salario DESC
	";
}
else
{
	$query = "
	SELECT * FROM fatec_professores 
	ORDER BY id DESC
	";
}

//Prepara uma consulta SQL que será executada em um banco de dados usando uma conexão estabelecida anteriormente, armazenando o resultado na variável "$statement" para posterior manipulação dos resultados
$statement = $connect->prepare($query);

//executa uma consulta SQL que foi previamente preparada em um objeto "$statement". Ele envia a consulta para o BD e armazena o resultado na variavel "$statement", que pode ser acessada posteriormente pelo programador usando métodos disponíveis no objeto.
$statement->execute();

while($row = $statement->fetch(PDO::FETCH_ASSOC))
{
	$data[] = $row;
}

echo json_encode($data);

?>
<?php
header('Access-Control-Allow-Origin: *');

//conexão com o banco de dados com os dados do admin
$connect = new PDO("mysql:host=localhost;dbname=id20421037_game", "id20421037_monicafalqueto", "Aa111111--Bb");
$received_data = json_decode(file_get_contents("php://input"));
$data = array();

//verifica se a variável "$received_data->action" é igual a 'fetchall', se for verdadeira o que está dentro de {} será executado
if ($received_data->action == 'fetchall') {
    $query = "
 SELECT * FROM fatec_professores 
 ORDER BY id DESC
 ";
    $statement = $connect->prepare($query);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
    //é usado para retornar uma resposta em formato JSON a partir de um script PHP. a função converte o valor da variável "$data" em uma string JSON válida, que é enviada ao cliente através do comando "echo"
    echo json_encode($data);
}
if ($received_data->action == 'insert') {
    $data = array(
        ':name' => $received_data->name,
        ':end' => $received_data->end,
        ':curso' => $received_data->curso,
        ':salario' => $received_data->salario
    );

    $query = "
 INSERT INTO fatec_professores 
 (name, end, curso, salario) 
 VALUES (:name, :end, :curso, :salario)
 ";

    $statement = $connect->prepare($query);

    $statement->execute($data);

    $output = array(
        'message' => 'Professor Adicionado'
    );

    echo json_encode($output);
}
if ($received_data->action == 'fetchSingle') {
    $query = "
 SELECT * FROM fatec_professores
 WHERE id = '" . $received_data->id . "'
 ";

    $statement = $connect->prepare($query);

    $statement->execute();

    $result = $statement->fetchAll();

    //é utilizado para percorrer um conjunto de dados usando um loop. a variável "result" é fonte dos dados a serem iterados e a variável "row" é usada como um ponteiro para o elemento atual.
    foreach ($result as $row) {
        $data['id'] = $row['id'];
        $data['name'] = $row['name'];
        $data['end'] = $row['end'];
        $data['curso'] = $row['curso'];
        $data['salario'] = $row['salario'];
    }

    echo json_encode($data);
}
if ($received_data->action == 'update') {
    $data = array(
        ':name' => $received_data->name,
        ':end' => $received_data->end,
        ':curso' => $received_data->curso,
        ':salario' => $received_data->salario,
        ':id' => $received_data->hiddenId
    );

    //faz uma instrução para executar essa consulta no banco de dados 
    $query = "
 UPDATE fatec_professores 
 SET name = :name, 
 end = :end
 curso = :curso
 salario = :salario
 WHERE id = :id
 ";

    $statement = $connect->prepare($query);

    $statement->execute($data);

    $output = array(
        'message' => 'Professor Atualizado'
    );

    echo json_encode($output);
}

if ($received_data->action == 'delete') {
    $query = "
 DELETE FROM fatec_professores 
 WHERE id = '" . $received_data->id . "'
 ";

    $statement = $connect->prepare($query);

    $statement->execute();

    $output = array(
        'message' => 'Professor Deletado'
    );

    echo json_encode($output);
}

?>
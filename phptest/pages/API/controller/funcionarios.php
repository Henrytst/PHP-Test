<?php

session_start();

if (!isset($_SESSION["login"])) {
    header("location: ../../../index.php");
    exit;
}

require_once('../model/funcionarios.php');

if ($_POST) {

    if (
        isset($_POST["nome"]) && !empty($_POST["nome"])
        && isset($_POST["cpf"]) && !empty($_POST["cpf"])
        && isset($_POST["email"]) && !empty($_POST["email"])
        && isset($_POST["id_empresa"]) && !empty($_POST["id_empresa"])
    )
     {
        // Inserção dos dados nas variáveis
        $nome = filter_input(INPUT_POST, "nome", FILTER_SANITIZE_STRING);
        $cpf = filter_input(INPUT_POST, "cpf", FILTER_SANITIZE_STRING);
        $rg = filter_input(INPUT_POST, "rg", FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
        $id_empresa = filter_input(INPUT_POST, "id_empresa", FILTER_SANITIZE_NUMBER_INT);

        if (isset($_POST["id_funcionario"]) && !empty($_POST["id_funcionario"])) {
            $id_funcionario = filter_input(INPUT_POST, "id_funcionario", FILTER_SANITIZE_NUMBER_INT);

            $editarFuncionario = new Funcionarios();
            $resposta = $editarFuncionario->editarFuncionario(
                $id_funcionario,
                $nome,
                $cpf,
                $rg,
                $email,
                $id_empresa
            );

            if ($resposta === 1) header('location: ../../funcionarios.php?mensagem=sucesso');
            else header('location: ../views/funcionarios.php?mensagem=erro');
        } else {
            // Verificação de CPF existente
            $listar = new Funcionarios();
            if ($retorno = $listar->listarTodosFuncionarios()) {
                $dados = json_decode($retorno);
                foreach ($dados as $value) {
                    if ($value->cpf === $_POST['cpf']) {
                        die('CPF já cadastrado!');
                    }
                }
            }

            $adicionarFuncionario = new Funcionarios();
            $resposta = $adicionarFuncionario->adicionarFuncionario(
                $nome,
                $cpf,
                $rg,
                $email,
                $id_empresa
            );
            if ($resposta === 1) header('location: ../../funcionarios.php?mensagem=sucesso');
            else header('location: ../views/funcionarios.php?mensagem=erro');
        }
    } else {
        echo "Campos obrigatórios não preenchidos!!!";
    }
} elseif ($_GET["acao"]) {
    if (isset($_GET["id_funcionario"]) && !empty($_GET["id_funcionario"]) && isset($_GET["acao"]) && !empty($_GET["acao"])) {
        $id_funcionario = filter_input(INPUT_GET, "id_funcionario", FILTER_SANITIZE_NUMBER_INT);
        $acao = filter_input(INPUT_GET, "acao", FILTER_DEFAULT);

        if ($acao === "excluir") {
            $buscarFuncionario = new Funcionarios();
            $resposta = $buscarFuncionario->excluirFuncionario($id_funcionario);
            if ($resposta > 0) {
                header('location: ../../funcionarios.php?mensagem=sucesso');
            } else {
                header('location: ../../funcionarios.php?mensagem=erro');
            }
        }
    }
}
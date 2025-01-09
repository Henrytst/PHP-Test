<?php

session_start();

if (!isset($_SESSION["login"])) {
    header("location: ../../../index.php");
    exit;
}

require_once('../model/empresa.php'); // Model ajustado para empresas

if ($_POST) {
    if (
        isset($_POST["nome"]) && !empty($_POST["nome"])
    ) {
        date_default_timezone_set('America/Sao_Paulo');

        // Sanitização dos inputs
        $nome = filter_input(INPUT_POST, "nome", FILTER_SANITIZE_STRING);

        // Verifica se é uma edição
        if (isset($_POST["id_empresa"]) && !empty($_POST["id_empresa"])) {
            $id_empresa = filter_input(INPUT_POST, "id_empresa", FILTER_SANITIZE_NUMBER_INT);

            $editarEmpresa = new Empresa();
            $resposta = $editarEmpresa->editarEmpresa($id_empresa, $nome);
            if ($resposta == 1) {
                header('location: ../../empresa.php?mensagem=sucesso');
            } else {
                header('location: ../views/empresa.php?mensagem=erro');
            }
        } else {
            // Cadastro de uma nova empresa
            $adicionarEmpresa = new Empresa();
            $resposta = $adicionarEmpresa->adicionarEmpresa($nome);
            if ($resposta == 1) {
                header('location: ../../empresa.php?mensagem=sucesso');
            } else {
                header('location: ../views/empresa.php?mensagem=erro');
            }
        }
    } else {
        echo "Campos obrigatórios não preenchidos!!!";
    }
} elseif ($_GET) {
    if (
        isset($_GET["id_empresa"]) && !empty($_GET["id_empresa"]) &&
        isset($_GET["acao"]) && !empty($_GET["acao"])
    ) {
        $id_empresa = filter_input(INPUT_GET, "id_empresa", FILTER_SANITIZE_NUMBER_INT);
        $acao = filter_input(INPUT_GET, "acao", FILTER_SANITIZE_STRING);

        if ($acao === "excluir") {
            $excluirEmpresa = new Empresa();
            $resposta = $excluirEmpresa->excluirEmpresa($id_empresa);
            if ($resposta > 0) {
                header('location: ../../empresa.php?mensagem=sucesso');
            } else {
                header('location: ../../empresa.php?mensagem=erro');
            }
        }
    }
}

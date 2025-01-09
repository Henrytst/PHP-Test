<?php
include_once("../../.././pages/functions/php/functions.php");
require_once("../model/funcionarios.php"); // Classe para gerenciar funcionários
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php
    headFormulario();
    ?>
</head>

<body>
    <?php
    menu();
    ?>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                &nbsp;
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?php

                if (!$_GET) {
                    echo "<h3>Cadastrar Funcionário</h3>";
                    $dadosPadrao = json_encode(
                        array(
                            0 => array(
                                "id" => "",
                                "nome" => "",
                                "email" => "",
                                "cpf" => "",
                                "rg" => "",
                                "id_empresa" => ""
                            )
                        )
                    );
                    $dados = json_decode($dadosPadrao);
                } else {
                    if (isset($_GET["id_funcionario"]) && !empty($_GET["id_funcionario"])) {
                        echo "<h3>Editar Funcionário</h3>";
                        $id_funcionario = filter_input(INPUT_GET, "id_funcionario", FILTER_DEFAULT);
                        $buscarFuncionario = new Funcionarios();
                        $resposta = $buscarFuncionario->listarTodosFuncionarios($id_funcionario);
                        $dados = json_decode($resposta);
                    }
                }

                // Obter empresas para o dropdown
                class Empresas
                {
                    private $conectar;

                    public function __construct()
                    {
                        try {
                            $this->conectar = new PDO("mysql:host=localhost;dbname=banco_de_dados", "root", "");
                            $this->conectar->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        } catch (PDOException $e) {
                            echo 'Erro de conexão: ' . $e->getMessage();
                        }
                    }

                    public function listarTodasEmpresas()
                    {
                        try {
                            $stmt = $this->conectar->prepare('SELECT * FROM tbl_empresa ORDER BY nome ASC');
                            $stmt->execute();
                            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            return json_encode($results);
                        } catch (PDOException $e) {
                            echo 'Erro ao listar empresas: ' . $e->getMessage();
                        }
                    }
                }

                $listarEmpresas = new Empresas(); // Classe para empresas
                $empresas = $listarEmpresas->listarTodasEmpresas();
                $listaEmpresas = json_decode($empresas);
                ?>
            </div>
        </div>
        <div class="row">
            <?php
            foreach ($dados as $key => $value)
            ?>
            <form enctype="multipart/form-data" action="../controller/funcionarios.php" method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nome</label>
                            <input type="text" class="form-control" name="nome" id="nome" value="<?= $value->nome; ?>" required>
                        </div>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>CPF</label>
                            <input type="text" class="form-control cpf" name="cpf" id="cpf" value="<?= $value->cpf; ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>RG</label>
                            <input type="text" class="form-control rg" name="rg" id="rg" value="<?= $value->rg; ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                <div class="col-md-6">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" id="email" value="<?= $value->email; ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Empresa</label>
                            <select class="form-control" name="id_empresa" id="id_empresa" required>
                                <option value="" disabled selected>Selecione uma empresa</option>
                                <?php foreach ($listaEmpresas as $empresa) { ?>
                                    <option value="<?= $empresa->id_empresa; ?>" <?= $empresa->id_empresa == $value->id_empresa ? 'selected' : ''; ?>>
                                        <?= $empresa->nome; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <?php
                        if (isset($value->id_funcionario)) {
                        ?>
                            <input type="hidden" class="form-control" name="id_funcionario" id="id_funcionario" value="<?= $value->id_funcionario; ?>">
                            <button type="submit" class="btn btn-success">Editar</button>
                        <?php
                        } else {
                        ?>
                            <button type="submit" class="btn btn-success">Cadastrar</button>
                            <button type="reset" class="btn btn-warning">Limpar</button>
                        <?php
                        }
                        ?>
                        <a href="../../funcionarios.php" class="btn btn-danger">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php
    rodapeFormulario();
    ?>
</body>

</html>
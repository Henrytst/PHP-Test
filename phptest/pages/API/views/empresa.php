<?php
include_once("../../.././pages/functions/php/functions.php");
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
                if (!isset($_GET["id_empresa"]) || empty($_GET["id_empresa"])) {
                    // Modo cadastro
                    echo "<h3>Cadastrar Empresa</h3>";
                    $dadosPadrao = [
                        (object)[
                            "id_empresa" => "",
                            "nome" => "",
                        ]
                    ];
                    $dados = $dadosPadrao; // Usar array de objeto padrão
                } else {
                    // Modo edição
                    echo "<h3>Editar Empresa</h3>";
                    require_once("../model/empresa.php");
                    $id_empresa = filter_input(INPUT_GET, "id_empresa", FILTER_VALIDATE_INT);
                    if ($id_empresa) {
                        $buscarEmpresa = new Empresa();
                        $resposta = $buscarEmpresa->carregarEmpresa($id_empresa);

                        // Verificar se a resposta é válida
                        if ($resposta) {
                            $dados = json_decode($resposta);
                        } else {
                            echo "<p>Erro: Não foi possível carregar os dados da empresa.</p>";
                            $dados = [];
                        }
                    } else {
                        echo "<p>Erro: ID da empresa inválido.</p>";
                        $dados = [];
                    }
                }
                ?>
            </div>
        </div>
        <div class="row">
            <?php
            if (!empty($dados)) {
                foreach ($dados as $key => $value) { ?>
                    <div class="col-sm-12">
                        <form action="../controller/empresa.php" method="POST">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nome da Empresa</label>
                                        <input type="text" class="form-control" name="nome" id="nome" value="<?= htmlspecialchars($value->nome); ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    &nbsp;
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <?php
                                    if (!empty($value->id_empresa)) {
                                    ?>
                                        <input type="hidden" class="form-control" name="id_empresa" id="id_empresa" value="<?= $value->id_empresa; ?>">
                                        <button type="submit" class="btn btn-success">Editar</button>
                                    <?php
                                    } else {
                                    ?>
                                        <button type="submit" class="btn btn-success">Cadastrar</button>
                                        <button type="reset" class="btn btn-warning">Limpar</button>
                                    <?php
                                    }
                                    ?>
                                    <a href="../../empresa.php" class="btn btn-danger">Cancelar</a>
                                    <footer>
                                    </footer>
                                </div>
                            </div>
                        </form>
                    </div>
                <?php
                }
            } else {
                echo "<p>Erro: Não há dados para exibir.</p>";
            }
            ?>
        </div>
    </div>
    <?php
    rodapeFormulario();
    ?>
</body>

</html>

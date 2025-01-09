<?php

class Empresa
{
    private $id_empresa, $nome;
    public $conectar;

    public function __construct()
    {
        try {
            $this->conectar = new PDO("mysql:host=localhost;dbname=banco_de_dados", "root", "");
            $this->conectar->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Redirecionar para página de erro ou migrations, se necessário
            header('location: /phptest/pages/migrations/index.php');
        }
    }

    // Adicionar empresa
    public function adicionarEmpresa($nome)
    {
        $this->setDadosCadastrar($nome);

        try {
            $stmt = $this->conectar->prepare(
                'INSERT INTO tbl_empresa (nome) VALUES (:NOME)'
            );
            $stmt->execute(
                array(
                    ":NOME" => $this->getNome()
                )
            );
            return $stmt->rowCount();
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return 0;
        }
    }

    public function editarEmpresa($id_empresa, $nome)
    {
        $this->setIdEmpresa($id_empresa);
        $this->setNome($nome);

        try {
            // Verifica se há mudanças antes de atualizar
            $stmtVerifica = $this->conectar->prepare('SELECT nome FROM tbl_empresa WHERE id_empresa = :ID');
            $stmtVerifica->execute([":ID" => $this->id_empresa]);
            $dados = $stmtVerifica->fetch(PDO::FETCH_ASSOC);

            // Se os dados são os mesmos, retorna como sucesso (1)
            if ($dados && $dados["nome"] === $this->nome) {
                return 1;
            }

            // Atualiza apenas se houver mudanças
            $stmt = $this->conectar->prepare('UPDATE tbl_empresa SET nome = :NOME WHERE id_empresa = :ID');
            $stmt->execute([
                ":NOME" => $this->nome,
                ":ID" => $this->id_empresa
            ]);
            return $stmt->rowCount(); // Retorna o número de linhas afetadas
        } catch (PDOException $e) {
            echo 'Erro: ' . $e->getMessage();
            return 0; // Retorna erro
        }
    }

    // Excluir empresa
    public function excluirEmpresa($id_empresa)
    {
        $this->setIdEmpresa($id_empresa);

        try {
            $stmt = $this->conectar->prepare('DELETE FROM tbl_empresa WHERE id_empresa = :ID_EMPRESA');
            $stmt->execute(array(":ID_EMPRESA" => $this->getIdEmpresa()));
            return $stmt->rowCount();
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return 0;
        }
    }

    // Listar todas as empresas
    public function listarTodasEmpresas()
    {
        try {
            $stmt = $this->conectar->prepare('SELECT * FROM tbl_empresa ORDER BY nome ASC');
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return json_encode($results);
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return json_encode([]);
        }
    }

    // Carregar empresa específica
    public function carregarEmpresa($id_empresa)
    {
        $this->setIdEmpresa($id_empresa);

        try {
            $stmt = $this->conectar->prepare('SELECT * FROM tbl_empresa WHERE id_empresa = :ID_EMPRESA');
            $stmt->execute(array(":ID_EMPRESA" => $this->getIdEmpresa()));
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return json_encode($results);
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return json_encode([]);
        }
    }

    // Métodos para popular atributos
    private function setDadosCadastrar($nome)
    {
        $this->setNome($nome);
    }

    private function setDadosEditar($nome)
    {
        $this->setNome($nome);
    }

    // Métodos getters e setters
    private function setIdEmpresa($id_empresa)
    {
        $this->id_empresa = $id_empresa;
    }

    private function setNome($nome)
    {
        $this->nome = $nome;
    }
    public function getIdEmpresa()
    {
        return $this->id_empresa;
    }

    public function getNome()
    {
        return $this->nome;
    }
}

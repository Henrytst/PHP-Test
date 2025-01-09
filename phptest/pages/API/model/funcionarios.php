<?php

class Funcionarios
{
    private $id_funcionario,
        $nome,
        $cpf,
        $rg,
        $email,
        $id_empresa;

    public $conectar;

    public function __construct()
    {
        try {
            $this->conectar = new PDO("mysql:host=localhost;dbname=banco_de_dados", "root", "");
            $this->conectar->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Erro de conexão: ' . $e->getMessage());
        }
    }

    // Adicionar funcionário
    public function adicionarFuncionario($nome, $cpf, $rg, $email, $id_empresa)
    {
        $this->setDados($nome, $cpf, $rg, $email, $id_empresa);
        try {
            $stmt = $this->conectar->prepare(
                'INSERT INTO tbl_funcionario (nome, cpf, rg, email, id_empresa) 
                 VALUES (:NOME, :CPF, :RG, :EMAIL, :ID_EMPRESA)'
            );
            $stmt->execute([
                ":NOME" => $this->getNome(),
                ":CPF" => $this->getCpf(),
                ":RG" => $this->getRg(),
                ":EMAIL" => $this->getEmail(),
                ":ID_EMPRESA" => $this->getIdEmpresa()
            ]);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            echo 'Erro ao adicionar funcionário: ' . $e->getMessage();
        }
    }

    public function editarFuncionario($id_funcionario, $nome, $cpf, $rg, $email, $id_empresa)
    {
        $this->setIdFuncionario($id_funcionario);
        $this->setDados($nome, $cpf, $rg, $email, $id_empresa);

        try {
            // Verifica se há mudanças antes de atualizar
            $stmtVerifica = $this->conectar->prepare(
                'SELECT nome, cpf, rg, email, id_empresa 
             FROM tbl_funcionario 
             WHERE id_funcionario = :ID_FUNCIONARIO'
            );
            $stmtVerifica->execute([":ID_FUNCIONARIO" => $this->id_funcionario]);
            $dados = $stmtVerifica->fetch(PDO::FETCH_ASSOC);

            // Se os dados são os mesmos, retorna como sucesso (1)
            if (
                $dados &&
                $dados["nome"] === $this->nome &&
                $dados["cpf"] === $this->cpf &&
                $dados["rg"] === $this->rg &&
                $dados["email"] === $this->email &&
                $dados["id_empresa"] == $this->id_empresa
            ) {
                return 1;
            }

            // Atualiza apenas se houver mudanças
            $stmt = $this->conectar->prepare(
                'UPDATE tbl_funcionario 
             SET nome = :NOME, cpf = :CPF, rg = :RG, email = :EMAIL, id_empresa = :ID_EMPRESA 
             WHERE id_funcionario = :ID_FUNCIONARIO'
            );
            $stmt->execute([
                ":ID_FUNCIONARIO" => $this->getIdFuncionario(),
                ":NOME" => $this->getNome(),
                ":CPF" => $this->getCpf(),
                ":RG" => $this->getRg(),
                ":EMAIL" => $this->getEmail(),
                ":ID_EMPRESA" => $this->getIdEmpresa()
            ]);

            return $stmt->rowCount(); // Retorna o número de linhas afetadas
        } catch (PDOException $e) {
            echo 'Erro ao editar funcionário: ' . $e->getMessage();
            return 0; // Retorna erro
        }
    }

    // Excluir funcionário
    public function excluirFuncionario($id_funcionario)
    {
        $this->setIdFuncionario($id_funcionario);
        try {
            $stmt = $this->conectar->prepare('DELETE FROM tbl_funcionario WHERE id_funcionario = :ID_FUNCIONARIO');
            $stmt->execute([
                ":ID_FUNCIONARIO" => $this->getIdFuncionario()
            ]);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            echo 'Erro ao excluir funcionário: ' . $e->getMessage();
        }
    }

    // Listar todos os funcionários
    public function listarTodosFuncionarios()
    {
        try {
            $stmt = $this->conectar->prepare('SELECT * FROM tbl_funcionario ORDER BY nome ASC');
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return json_encode($results);
        } catch (PDOException $e) {
            echo 'Erro ao listar funcionários: ' . $e->getMessage();
        }
    }

    // Carregar funcionário por ID
    public function carregarFuncionario($id_funcionario)
    {
        $this->setIdFuncionario($id_funcionario);
        try {
            $stmt = $this->conectar->prepare('SELECT * FROM tbl_funcionario WHERE id_funcionario = :ID_FUNCIONARIO');
            $stmt->execute([
                ":ID_FUNCIONARIO" => $this->getIdFuncionario()
            ]);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return json_encode($results);
        } catch (PDOException $e) {
            echo 'Erro ao carregar funcionário: ' . $e->getMessage();
        }
    }

    // Métodos setters
    private function setIdFuncionario($id_funcionario)
    {
        $this->id_funcionario = $id_funcionario;
    }

    private function setDados($nome, $cpf, $rg, $email, $id_empresa)
    {
        $this->nome = $nome;
        $this->cpf = $cpf;
        $this->rg = $rg;
        $this->email = $email;
        $this->id_empresa = $id_empresa;
    }

    // Métodos getters
    private function getIdFuncionario()
    {
        return $this->id_funcionario;
    }

    private function getNome()
    {
        return $this->nome;
    }

    private function getCpf()
    {
        return $this->cpf;
    }

    private function getRg()
    {
        return $this->rg;
    }

    private function getEmail()
    {
        return $this->email;
    }

    private function getIdEmpresa()
    {
        return $this->id_empresa;
    }
}

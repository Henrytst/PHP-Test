# Sistema de Gestão de Empresas e Funcionários

## Descrição do Projeto
Este projeto é uma aplicação web para a gestão de empresas e funcionários, permitindo o cadastro, edição, exclusão e visualização de dados. A aplicação utiliza PHP e MySQL como backend, seguindo o padrão MVC (Model-View-Controller) para organização do código.

### Funcionalidades

1. **Gerenciamento de Empresas:**
   - Cadastro de novas empresas.
   - Edição de informações de empresas existentes.
   - Exclusão de empresas.

2. **Gerenciamento de Funcionários:**
   - Cadastro de novos funcionários, vinculados a uma empresa.
   - Edição de informações de funcionários existentes.
   - Exclusão de funcionários.

3. **Validação de Dados:**
   - Validações no backend para evitar duplicação de informações, como CPF já existente.

4. **Interface Dinâmica:**
   - Listagem de empresas e funcionários com filtros e exibição clara das informações.

---

## Tecnologias Utilizadas

- **Frontend:** HTML, CSS, Bootstrap
- **Backend:** PHP 7+
- **Banco de Dados:** MySQL
- **Outras Bibliotecas:**
  - PDO (PHP Data Objects) para manipulação de banco de dados.
  - Máscaras de entrada para CPF e formatação de campos.

---

## Configuração e Execução

### Pré-requisitos

1. Servidor Web (exemplo: XAMPP ou WAMP).
2. PHP 7 ou superior.
3. Banco de Dados MySQL.

### Configuração

1. Clone este repositório:
   ```bash
   git clone https://github.com/seu-usuario/nome-do-repositorio.git
   ```

2. Configure o banco de dados:
   - Pegue o arquivo sql em `phptest/banco_de_dados.sql` e execute dentro do banco de dados.

4. Inicie o servidor:
   - Coloque o projeto na pasta `htdocs` do XAMPP ou equivalente.
   - Acesse `http://localhost/phptest/` no navegador.

---

## Rotas Principais

- **Listagem de Empresas:** `http://localhost/projeto/pages/empresa.php`
- **Listagem de Funcionários:** `http://localhost/projeto/pages/funcionarios.php`
- **Cadastro/Edição de Empresas:** `http://localhost/projeto/views/empresa.php`
- **Cadastro/Edição de Funcionários:** `http://localhost/projeto/views/funcionarios.php`

---

## Funcionalidades Futuros

- Relatórios gerenciais (PDF e gráficos).
- Sistema de autenticação com níveis de acesso.
- Integração com APIs externas para validação de CPF e CNPJ.

---

## Autor

- **Henrique Willian Testi**  
  Desenvolvedor Back-End e entusiasta por soluções eficientes em PHP.

---

Se encontrar algum problema ou tiver sugestões, não hesite em abrir uma **issue** neste repositório!

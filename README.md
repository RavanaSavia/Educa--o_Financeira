# Projeto MVC em PHP

Exemplo baseado na apostila revisada do professor Welison Brito.
Implementa listagem, detalhes e cadastro de usuários, com PDO, MySQL,
validação no servidor, proteção CSRF e Post/Redirect/Get.
Edição e exclusão são atividades de continuação.

## Requisitos

- PHP 8.0 ou superior, com pdo_mysql e mbstring.
- MySQL ou MariaDB.
- Apache 2.4 com mod_rewrite (opcional se usar php -S).

## 1. Banco

Execute database/database.sql uma vez em um banco novo no phpMyAdmin
ou no cliente MySQL. O arquivo cria meu_mvc, a tabela users e três usuários.
Bruno tem ID 2 e Carla tem ID 3 em um banco novo.

Se quiser a conta dedicada do exemplo, execute database/create_user.sql
com uma conta administrativa. Troque a senha de exemplo antes de executar.
Se a conta já existir, configure-a com a administração do laboratório.

## 2. Configuração

Copie config/database.example.php para config/database.php e preencha
host, name, user e pass com os dados da sua instalação.

Linux/macOS, a partir da raiz do projeto:

```bash
cp config/database.example.php config/database.php
```

No Windows, faça uma cópia do arquivo pelo explorador ou editor.
A configuração de exemplo usa meu_mvc_app e uma senha ilustrativa.
Se optar por root no laboratório, ajuste usuário e senha de acordo com seu MySQL.
config/database.php não deve ser enviado ao Git.

## 3. Executar

### Opção rápida com PHP

Abra o terminal na pasta projeto_mvc:

```bash
php -S localhost:8000 -t public public/router.php
```

Abra http://localhost:8000/user/index.
O servidor embutido é destinado a desenvolvimento e não lê .htaccess.
MySQL precisa estar iniciado separadamente.

### XAMPP em subpasta

Coloque projeto_mvc em htdocs, inicie Apache e MySQL e confirme que
mod_rewrite e AllowOverride estão habilitados.
Abra http://localhost/projeto_mvc/user/index, sem /public na URL.
Os dois arquivos .htaccess precisam estar presentes, inclusive o da raiz.
As diretivas Options também precisam estar autorizadas; confira o log em caso de 500.

### VirtualHost

Configure DocumentRoot para o caminho absoluto de projeto_mvc/public,
AllowOverride All e Require all granted para esse diretório.
Use um nome local como projeto-mvc.test associado a 127.0.0.1 no arquivo hosts.
Abra http://projeto-mvc.test/user/index.

## Rotas

| Método | Caminho | Resultado |
| --- | --- | --- |
| GET | / ou /user/index | Lista |
| GET | /user/show/2 | Detalhes do usuário 2 |
| GET | /user/create | Formulário |
| POST | /user/store | Validação e cadastro |

## Verificação manual

- Lista e detalhes: 200 com banco disponível.
- /user/show/abc: 400; /user/show/99999: 404.
- /user/show sem argumento: 404.
- /user/render e /user/show/2/extra: 404.
- GET /user/store: 405, com Allow: POST.
- POST sem token CSRF: 403.
- Cadastro inválido: 422 (use requisição manual para contornar validação HTML).
- Cadastro válido: redirecionamento 303 e nova listagem.
- E-mail duplicado: 422.
- Campos enviados como arrays são rejeitados sem erro de tipo.
- CSS e JS: confira respostas 200 na aba Rede do navegador.
- app e config: bloqueados em subpasta; fora da raiz pública no VirtualHost.

## Observações

A imagem logo.png é opcional e está comentada no layout.
O arquivo public/img/.gitkeep apenas mantém a pasta no Git.
A aplicação não possui autenticação ou autorização e usa dados fictícios.
O código PHP foi conferido quanto à correspondência com a apostila;
a execução integrada com PHP/Apache/MySQL não foi realizada no ambiente de geração.

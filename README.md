# Base Project

Este é um framework básico para desenvolvimento de aplicações web. A estrutura do projeto é organizada da seguinte forma:

## Versão Final com logger e envio de e-mail

**Melhorias Implementadas:**
- Sistema de Logs: Cada ação (Create, Read, Update, Delete) gera um log automático.
- Tabela logs: Armazena as interações no banco de dados.
- Classe Logger.php: Registra logs automaticamente sempre que operações no banco são feitas.
- Adição de Data e Hora: Os logs possuem timestamp.
- Configuração de SMTP via .env
- Gravação dos e-mails na tabela email_queue para envio futuro
- Script de envio via cron job
- Registro de logs no banco de dados e em arquivo
- Método construirMensagem() para personalizar os e-mails

## Estrutura de Diretórios

- **/base-project/**
    - **index.php**: Arquivo principal que contém a execução de testes dos métodos do CRUD.
    - **test-mail**: Arquivo contendo a execução de testes para adicionar e-mails em fila
    - **/src/**: Diretório contendo a lógica da aplicação.
        - **Database.php**: Arquivo da classe para conexão com o banco de dados.
        - **Model.php**: Arquivo da classe Model com os métodos do CRUD.
        - **Logger.php**: Arquivo da classe Logger para criação de log em banco de dados e arquivo.
        - **Email.php**: Arquivo da classe Email e métodos para execução dos disparos.
    - **/cron/**: Diretório contendo a lógica para tarefas de automatização
        - **processa_emails.php**: Arquivo para ser inserido como crontab em servidor.
        - **cron.txt**: Contém comando para criação da crontab.
    - **.env**: Arquivos de configuração.
    - **/logs/**: Diretório que contém registro dos logs do CRUD no arquivo db.log
    - **/vendor/**: Dependências do projeto gerenciadas pelo Composer.
    - **/sql-examples/**: scripts para inclusão de tabelas modelos no banco de dados.
    

## Como Usar

1. Clone o repositório para o seu ambiente de desenvolvimento.
2. Configure o servidor web para apontar para o diretório `/base-project`.
3. Execute o arquivo `index.php` para testar os métodos do CRUD.

## Requisitos

- PHP 7.4 ou superior
- Composer

## Instalação

1. Clone o repositório:
        ```sh
        git clone https://github.com/vitorlousil/base-project.git
        ```
2. Instale as dependências:
        ```sh
        composer install
        ```

## Testes

Para executar os testes dos métodos do CRUD, acesse o arquivo `index.php` no seu navegador ou via linha de comando:
```sh
php index.php
```

## Contribuição

Sinta-se à vontade para contribuir com este projeto. Faça um fork do repositório, crie uma branch para suas alterações e envie um pull request.

## Licença

Este projeto está licenciado sob a MIT License. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.

# Base Project

Este é um framework básico para desenvolvimento de aplicações web. A estrutura do projeto é organizada da seguinte forma:

##
Versão com Logger automático em banco de dados e arquivo.

## Estrutura de Diretórios

- **/base-project/**
    - **index.php**: Arquivo principal que contém a execução de testes dos métodos do CRUD.
    - **/src/**: Diretório contendo a lógica da aplicação.
        - **Database.php**: Arquivo da Classe para conexão com o banco de dados.
        - **Model.php**: Arquivo da classe Model com os métodos do CRUD.
        - **Logger.php**: Arquivo da classe Logger para criação de log em banco de dados e arquivo.
    - **.env**: Arquivos de configuração.
    - **/logs/**: Diretório que contém registro dos logs do CRUD no arquivo db.log
    - **/vendor/**: Dependências do projeto gerenciadas pelo Composer.

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

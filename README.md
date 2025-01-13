# PetService

![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/laravel-%23FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=white)
![MySQL](https://img.shields.io/badge/mysql-4479A1.svg?style=for-the-badge&logo=mysql&logoColor=white)
![Docker](https://img.shields.io/badge/docker-%230db7ed.svg?style=for-the-badge&logo=docker&logoColor=white)
![Swagger](https://img.shields.io/badge/-Swagger-%23Clojure?style=for-the-badge&logo=swagger&logoColor=white)
![JavaScript](https://img.shields.io/badge/javascript-%23323330.svg?style=for-the-badge&logo=javascript&logoColor=%23F7DF1E)

Back-end: API construída com PHP/Laravel e o banco de dados MySQL. A API está documentada com Swagger. Acesse */api/doc* para ver.

Front-end: HTML, CSS e JS puro.

## Como usar o projeto

Instale o Docker, caso não possuir em sua máquina

### Clone o Repositório
```sh
git clone https://github.com/Hiago-Laureano/user-management.git .
```

### Acesse a pasta backend

```sh
cd backend
```

### Crie o arquivo .env

Dentro da pasta backend execute o comando

```sh
cp .env.example .env
```

### Dê o nome que desejar ao seu app, banco de dados e senha do banco de dados, alterando as variáveis do arquivo .env
```dosini
APP_NAME=Laravel
DB_DATABASE=laravel
DB_PASSWORD=12345
```

### Rodar o projeto com Docker

Dentro da pasta backend execute o comando

```sh
docker compose up -d
```

### Acesse o container da API para poder usar os comandos do Laravel

Dentro da pasta backend execute o comando

```sh
docker compose exec app bash
```

### Instale as dependências do projeto
```sh
composer install
```

### Gere a key do projeto Laravel
```sh
php artisan key:generate
```

### Faça a migração de dados
```sh
php artisan migrate
```

### Gere a documentação da API
```sh
php artisan l5-swagger:generate
```

### Acessar a API

A API estará rodando no http://localhost

### Documentação da API
Para acessar as informações de endpoints e as regras de negócio:

[http://localhost/api/doc](http://localhost/api/doc)

### Acessar o front-end

[http://localhost:8080](http://localhost:8080)
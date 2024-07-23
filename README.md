# Meu Campeonato


### Tarefas feitas no projeto

- [x] Deve ser possível inserir os oito times participantes do campeonato.
- [x] Não deve ser possível simular um campeonato com mais ou menos de oito times.
- [x] A aplicação deve fazer o chaveamento do campeonato.
- [x] A aplicação deve simular o resultado de cada partida.
- [x] A aplicação deve calcular a pontuação de cada time;
- [x] A aplicação deve simular o time vencedor do campeonato;
- [x] Deve ser possível recuperar as informações de campeonatos anteriores.

## 💻 Pré-requisitos

Requisitos para iniciar o projeto na sua maquina:

- Para rodar na sua máquina tenha `<PHP 8.2 / Composer / MySQL>`
- Para rodar com o Sail, tenha o Docker instalado na máquina, se for no windows o WSL

## 🚀 Instalando <Meu Campeonato>

Para instalar o Projeto, siga estas etapas:


```
<Clone o projeto com git clone https://github.com/Ygor-Machado/Meu-Campeonato.git>
```

```
<Depois de clonar o projeto use o projeto com o docker instalado na sua máquina entre na pasta do projeto e execute o comando>
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs 
```

```
 Agora de o ./vendor/bin/sail up -d para iniciar os container da aplicação.
```

```
 Depois de subir os container use o comando ./vendor/bin/sail composer install para instalar
as depêndencias da aplicação ou sail composer install se tiver o alias
```

```
Dê o comando cp .env.example .env e configure seu .env dessa forma por exemplo
    DB_CONNECTION=mysql
    DB_HOST=mysql
    DB_PORT=3306
    DB_DATABASE=laravel
    DB_USERNAME=sail
    DB_PASSWORD=password
```

```
Execute as migration com o comando sail art migrate ou ./vendor/bin/sail artisan migrate
```

## ☕ Usando <Meu Campeonato>

Para usar o Projeto, siga estas etapas:

```
Depois de iniciar a aplicação abra o insomnia/postman ou alguma outra ferramenta para testar Api
```

```
Primeiro você ira inserir um campeonato na rota

http://localhost/api/campeonatos
{
    "nome": "Meu Campeonato"
}
```

```
Depois insira os times passando o id do campeonato no corpo da requisição
Mas se preferir pode executar o Seeder para a criação dos 8 times

sail art db:seed

http://localhost/api/times
{
    "nome": "Time 1",
    "campeonato_id": 1
}
```

```
Para simular as partidas do campeonato apenas passe o ID do campeonato na rota com o método POST

http://localhost/api/campeonatos/1/simular-partidas.

Dessa forma irá retornar os resultados dos jogos e quem foi o campeão
```

```
Para buscar o resultado de algum campeonato só passar o ID do campeonato na rota

http://localhost/api/campeonatos/1/resultado
```

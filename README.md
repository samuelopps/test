## Api Laravel utilizando Docker com testes unitários utilizando PHPUNIT e documentação utilizando L5 Swagger Annotations.

## Containers
  * PHP version  8.0
  * Nginx version latest
  * MySql version latest  
 
## Vamos começar
 * Clone o projeto -> git clone https://github.com/samuelopps/test.git
 
 * Acessar a pasta -> cd test
 
 * Copiar o arquivo ENV de Exemplo -> cp .env-example .env
 
 * Executar a instalaçao dos containers -> docker-compose build
 
 * Após a instalação, iniciar os containers -> docker-compose up -d
 
 * Acessar o container php-fpm -> docker-compose exec php-fpm /bin/bash
 
 * Acessar a pasta da api -> cd api-transfer
 
 * Aplicar os seguintes comandos => [
    - Instalar as dependencias da api => composer install,
    - Gerar chave da aplicação => php artisan key:generate,
    - Criar as tabelas e inserir os dados pré-definidos => php artisan migrate --seed,
    - Gerar a documentação => php artisan l5-swagger:generate   
 ]
 
## Para acessar
  * Caso utilize Windows será necessário adicionar o url da api no arquivo Hosts
  URL: http://api.test/
  
  * Acessar a documentação da Api
  URL: http://api.test/api/documentation
  
  * Rodar os testes
    executar o comando composer 
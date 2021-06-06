### This is my application submission to Travaux.com

git clone https://github.com/NFLorD/travaux_com \
cd travaux_com/infra

docker-compose build \
docker-compose up -d

#### Tests
docker exec -ti infra_php_1 sh -c "php ./vendor/bin/phpunit tests"

#### Base script
docker exec -ti infra_php_1 sh -c "php index.php"

<br>

### Special note
I added some more changes after submitting. \
You can find the original version here: \
https://github.com/NFLorD/travaux_com/releases/tag/v1

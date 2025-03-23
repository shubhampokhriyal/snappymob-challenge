FROM php:8.2-cli
WORKDIR /app
COPY challengeB.php .
ENTRYPOINT ["php", "challengeB.php", "/app/input.txt"]
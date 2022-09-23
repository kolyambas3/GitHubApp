# GitHubApp
1. Run: cp .env.test .env
2. Run: docker-compose build
3. Run: docker-compose up
4. Run: docker exec -it git_php bin/sh php bin/console doctrine:migrations:migrate

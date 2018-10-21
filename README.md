# blog

## This repository is experimental !!!

### Install
```bash
cp .env.dist .env
nano .env

docker-compose build
docker-compose up -d

docker exec -it app_php composer update
docker exec -it app_php bin/console do:sc:up --force
docker exec -it app_php bin/console app:create-admin-user

docker exec -it app_yarn yarn
docker exec -it app_yarn yarn run build
```

### Todo
- Configuration for custom fields
- Documentation
- Meta tags
- Open graph
- Copy to clipboard for code html tag
- Test
- Auto installer
- Log management
- Deployment
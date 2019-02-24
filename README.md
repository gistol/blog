# blog

## This project is experimental !!!

### Install
```bash
cp .env.dist .env
nano .env

docker-compose up -d

docker-compose exec php composer update
docker-compose exec php bin/console do:sc:up -f
docker-compose exec php bin/console app:install
docker-compose exec php bin/console ckeditor:install

docker-compose exec yarn yarn
docker-compose exec yarn yarn run build
```

### Todo
- [x] Configuration for custom fields (site name, google analytics id)
- [ ] Documentation
- [ ] Meta tags
- [ ] Open graph
- [ ] Copy to clipboard for code html tag
- [ ] Auto installer (regenerate app secret, composer, yarn, admin user)
- [ ] Log management
- [ ] Deployment
- [ ] Test

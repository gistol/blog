# blog

## This repository is experimental !!!

### Install
```bash
cp .env.dist .env
nano .env

docker-compose up -d

docker exec -it app_php composer update
docker exec -it app_php bin/console do:sc:up -f
docker exec -it app_php bin/console app:install

docker exec -it app_yarn yarn
docker exec -it app_yarn yarn run build

docker exec -it app_php bin/console ckeditor:install

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

# Greenquest api

## SETUP
```shell
docker compose up -d
sudo chown -R $USER ./ ## for mac users
docker exec symfony_docker composer install
```

EXECUTE ALL COMMANDS FOR SYMFONY INSIDE CONTAINER PLEASE :
```shell
docker exec -it symfony_docker bash
cd greenquest
```

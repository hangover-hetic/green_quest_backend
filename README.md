# Greenquest api

[Adminer](https://localhost:8080/?pgsql=db&username=greenquest_admin&db=greenquest&ns=public)

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

Generate the SSL keys
```shell
php bin/console lexik:jwt:generate-keypair
```

[UML](./UML.md)



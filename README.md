# CGRD - Coding challenge

## Purpose
The purpose of this coding challenge is to create a relatively simply web-service cappable of:
- log in/ log out the user
- creation/modification/deletion of news articles

## Limitations
This service can not rely on already existing PHP or JS libraries.
!The only currently used dev dependency is `symfony/var-dumper` to use the development process.

### How to start
Assuming you're in the app's root directory, execute two php scripts to create and seed the database:

```php
php .\database\db.php migrate:fresh 
php .\database\db.php seed 
```

Assuming the app is running on `localhost:8000`, you can access the api through:
```
http://localhost:8000/api/v1/{endpoint}
```

List of currently implemented endpoints:
- [POST] `/api/v1/auth`
- [DELETE] `/api/v1/auth`
- [GET] `/api/v1/articles`
- [POST] `/api/v1/articles`
- [PATCH] `/api/v1/articles/{id}`
- [DELETE] `/api/v1/articles{id}`
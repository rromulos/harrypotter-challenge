## How to set up laradock

1. Create a folder named app 
2. Access the app folder
```
3. git clone https://github.com/Laradock/laradock.git
```
4. Open laradock if some text editor
5. Locate and open the .env file
```
    5.1 - Locate the entry COMPOSE_PROJECT_NAME and set this variable to "hp"
    5.2 - Locate the entry PHP_VERSION and set it to 7.4
```
6. Locate the folder **nginx/sites** and open the file **default.conf**
```
    6.1 - In the server block set the root folder to root /var/www/app/public;
```    
7. Open the terminal and access the **laradock** folder
```
    7.1 - type on terminal => docker-compose up -d nginx mysql
```    
    
## How to set up the application

1. Access the app folder
```
2. git clone https://github.com/rromulos/harrypotter-challenge.git
```
3. Make sure to have composer installed
```
4. composer update
5. cp .env.example .env
```
6. open the .env file
```
    6.1 - DB_CONNECTION=mysql
    6.2 - DB_HOST=mysql
    6.3 - DB_PORT=3306
    6.4 - DB_DATABASE=default
    6.5 - DB_USERNAME=default
    6.5 - DB_PASSWORD=secret
```    
7. Go to https://www.potterapi.com/ and get a key
8. Still in the .env file add those 3 new keys    
```
    8.1 - POTTERAPI_KEY=put_your_key_here
    8.2 - POTTERAPI_BASE_URL=https://www.potterapi.com/v1/
    8.3 - URL_LOCAL_API=http://192.168.0.3/api/characters/ **in order to avoid issue with cURL set your local ip to this variable**
```    
9. On the terminal access the application folder "app" and type
```
php artisan key:generate
```
10. Running migration (Option 1)
```
    10.1 - Option 1 > php artisan migrate
```    
11. Running migration (Option 2)
```
    11.1 Go to the laradock folder
    11.2 type > docker exec -it hp_workspace_1 /bin/bash
    11.3 type > su laradock
    11.4 type > cd app
    11.5 type > php artisan migrate
```    
12. Go to the browser and type
``` 
http://localhost
```
12.1 Laravel home page must be load

## How to consume the API

1. **Create a new character**
``` 
POST > http://localhost/api/characters

{
    "name": "Harry Potter 5",
    "role": "student",
    "school": "Hogwarts School of Witchcraft and Wizardry",
    "house": "5a05e2b252f721a3cf2ea33f",
    "patronus": "stag"
}
``` 
2. **Update a character**
``` 
PUT > http://localhost/api/characters/1

{
    "name": "Character updated",
    "role": "student",
    "school": "Hogwarts School of Witchcraft and Wizardry",
    "house": "5a05e2b252f721a3cf2ea33f",
    "patronus": "stag"
}
``` 
3. **Delete a character**
``` 
DELETE > http://localhost/api/characters/1
``` 
4. **Get all characters**
``` 
GET > http://localhost/api/characters
``` 
5. **Get character by id**
``` 
GET > htt//localhost/api/characters/2
``` 
6. **Filter - Get all characters that belonga to the informed house**
``` 
GET > http://localhost/api/characters?house=5a05e2b252f721a3cf2ea33f
``` 

## API Validations

1. **Create**
``` 
'name'       => 'min:3|max:50',
'role'       => 'min:3|max:50',
'school'     => 'min:3|max:100',
'patronus'   => 'min:1|max:50'

house        => must be valid on https://www.potterapi.com/ > Route => houses/{houseId}
``` 
2. **Update**
``` 
'name'       => 'min:3|max:50',
'role'       => 'min:3|max:50',
'school'     => 'min:3|max:100',
'patronus'   => 'min:1|max:50'

house        => must be valid on https://www.potterapi.com/ > Route => houses/{houseId}
id           => validates if the parameter "id" is a valid one
``` 

3. **Delete**
``` 
id           => validates if the parameter "id" is a valid one
``` 

4. **Get By Id**
``` 
id           => validates if the parameter "id" is a valid one
``` 

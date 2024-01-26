# Initialisation de l'API
- Déplacer vous dans le projet avec le terminal
- Executer la commande

```sh
composer install 
```

- Puis ouvrer votre gestionnaire de DATABASE (exmple: MySQl) et créer une base de données avec pour nom "planning"
- Configurer le .env par rapport à la votre
  
```sh
DATABASE_URL="mysql://root:@127.0.0.1:3306/planning"
```

- Executer dans le terminal la commande pour migrer les tables dans votre DB suivant : 

```sh
php bin/console d:m:m
```

Enfin executer le serveur 
```sh
 symfony server:start --port=8000
```

Ce microservice sera alors executer sur le port (127.0.0.1:8000)

# Informations
 - La collection Postman est disponible à la racine du projet "GestionPlanningAPI.postman_collection.json"
 - Un fichier SQL est disponible à la racine du projet "planning.sql" pour avoir une base de donnée avec des données de test
 - Un fichier markdown est disponible à la racine du projet "taskTeam.markdown" pour connaitre les tâches de chacun

# Cours (Lesson)
Un cours est composé d'un professeur, d'un nom, d'une description, d'une date de début, d'une date de fin et d'un lieu.
```
{
    id: integer
    idTeacher: integer
    name: string
    description: text
    dateBegin: datetime
    dateEnd: datetime
    place: string
}
```
# classStudents
Une classe d'étudiants est composée d'un cours et d'un ou plusieurs étudiants.
```
{
    id: integer
    idLesson: integer (relation(lesson, oneToOne))
    idUsers: Array[integer] (relation(user, manyToMany))
}
```

**GET /lessons**
----
  Retourne un ou des cours
* **Data Params** 
  * *Allowed:* `id=[integer]`
  * *Allowed:* `idTeacher=[integer]`
  * *Allowed:* `name=[string]`
  * *Allowed:* `place=[string]`
  * *Allowed:* `date="d-m-Y"`

  **Example:** 
  ```-
  /lessons?id=1&idTeacher=1&name=API REST&place=salle 1
  ```
* **Headers**  
  Content-Type: application/json  
* **Success Response:**  
* **Code:** 200  
  **Content:**  
```-
[
  1:
    {
        "id" : 1,
        "idTeacher" : 1,
        "name" : "API REST",
        "description" : "Fait des cours de Web",
        "dateBegin" : 15/12/2023 8:00,
        "dateEnd" : 15/12/2023 10:00,
        "place" : "Bâtiment 1, salle 1"
    },
  2:
    {
        "id" : 2,
        "idTeacher" : 1,
        "name" : "API REST",
        "description" : "Fait des cours de Web",
        "dateBegin" : 15/12/2023 10:00,
        "dateEnd" : 15/12/2023 12:00,
        "place" : "Bâtiment 1, salle 1"
    }
]
```
**GET /classStudents**
----
  Retourne un ou des classes d'étudiants
* **Data Params**  
  * *Allowed:* `id=[integer]`
  * *Allowed:* `idLesson=[integer]`
  * *Allowed:* `idUser=[integer]`

  **Example:** 
  ```-
  /classStudents?id=1&idLesson=1&idUser=2
  ```
* **Headers**  
  Content-Type: application/json  
* **Success Response:**  
* **Code:** 200  
  **Content:** 
```
[
  1:
    {
      "id": 1,
      "idLesson": 1,
      "idUsers": [
        1,
        2,
        3
      ]
    },
  2:
    {
      "id": 2,
      "idLesson": 2,
      "idUsers": [
        1,
        2,
        3
      ]
    }
]
```

**POST /lessons**
----
  Créer un nouveau cours
* **URL Params**  
  None
* **Headers**  
  Content-Type: application/json  
* **Data Params**  
```
  {
    "idTeacher" : 1,
    "name" : "Docker",
    "description" : "FCours de Docker",
    "dateBegin" : 15/12/2023 14:00,
    "dateEnd" : 15/12/2023 16:00,
    "place" : "Bâtiment 2, salle 1"
  }
```
* **Success Response:**  
* **Code:** 200  
  **Content:**  `{ <lesson_object> }` 

**POST /classStudents**
----
  Créer une nouvelle classe
* **URL Params**  
  None
* **Headers**  
  Content-Type: application/json  
* **Data Params**  
```
  {
    "idLesson": 1,
    "idUsers": [
      1,
      2,
      3
    ]
  }
```
* **Success Response:**  
* **Code:** 200  
  **Content:**  `{ <classStudents_object> }` 

**PUT /lessons**
----
  Met à jour un cours spécifié et renvoie l'objet mis à jour.
* **Data Params**  
  *Required:* `id=[integer]`
```
  {
    "id" : 1,
    "idTeacher" : 2,
    "name" : "API REST",
    "description" : "Fait des cours de Web",
    "dateBegin" : 15/12/2023 8:00,
    "dateEnd" : 15/12/2023 10:00,
    "place" : "Bâtiment 1, salle 1"
  }
```
* **Headers**  
  Content-Type: application/json  
* **Success Response:** 
* **Code:** 200  
  **Content:**  `{ <lessons_object> }`  
* **Error Response:**  
  * **Code:** 404  
  **Content:** `{ error : "Le cours n'existe pas" }`  
  OR  
  * **Code:** 401  
  **Content:** `{ error : error : "Vous n'êtes pas autorisé à utiliser cette request" }`

**PUT /classStudents**
----
  Met à jour un étudiant de la classe et renvoie l'objet mis à jour.
* **Data Params**  
  *Required:* `id=[integer]`
```
  {
  	"id": 1,
    "idLesson": 2,
    "idUsers": [
      1,
      2,
      3
    ] 
  }
```
* **Headers**  
  Content-Type: application/json  
* **Success Response:** 
* **Code:** 200  
  **Content:**  `{ <lessons_object> }`  
* **Error Response:**  
  * **Code:** 404  
  **Content:** `{ error : "Le cours n'existe pas" }`  
  OR  
  * **Code:** 401  
  **Content:** `{ error : error : "Vous n'êtes pas autorisé à utiliser cette request" }`

**PATCH /lessons**
----
  Met à jour un ou des champs du cours spécifié et renvoie l'objet mis à jour.
* **Data Params**  
  *Required:* `id=[integer]`

  Example: Change name
```
  {
    "id" : 1,
    "name" : "Cloud Computing",
  }
```
* **Headers**  
  Content-Type: application/json  
* **Success Response:** 
```
  {
    "id" : 1,
    "idTeacher" : 2,
    "name" : "Cloud Computing",
    "description" : "Fait des cours de Web",
    "dateBegin" : 15/12/2023 8:00,
    "dateEnd" : 15/12/2023 10:00,
    "place" : "Bâtiment 1, salle 1"
  }
```
* **Code:** 200  
  **Content:**  `{ <lessons_object> }`  
* **Error Response:**  
  * **Code:** 404  
  **Content:** `{ error : "Le cours n'existe pas" }`  
  OR  
  * **Code:** 401  
  **Content:** `{ error : error : "Vous n'êtes pas autorisé à utiliser cette request" }`

**PATCH /classStudents**
----
  Met à jour une ou des informations d'une classe et renvoie l'objet mis à jour.
* **Data Params**  
  *Required:* `id=[integer]`

  Example: Add user
```
  {
  	"id": 1,
    "idUsers": [
      1,
      2,
      3, 
      4, 
      5
    ] 
  }
```
* **Headers**  
  Content-Type: application/json  
* **Success Response:** 
```
  {
  	"id": 1,
    "idLesson": 2,
    "idUsers": [
      1,
      2,
      3, 
      4, 
      5
    ] 
  }
```
* **Code:** 200  
  **Content:**  `{ <lessons_object> }`  
* **Error Response:**  
  * **Code:** 404  
  **Content:** `{ error : "Le cours n'existe pas" }`  
  OR  
  * **Code:** 401  
  **Content:** `{ error : error : "Vous n'êtes pas autorisé à utiliser cette request" }`


**DELETE /lessons**
----
  Supprime un cours
* **URL Params**  
  *Required:* `id=[integer]`
* **Data Params**  
  None
* **Headers**  
  Content-Type: application/json  
* **Success Response:** 
  * **Code:** 204 
  * **Content:**
  `{ "message" => "Le cours a bien été supprimée" }`
* **Error Response:**  
  * **Code:** 404  
  **Content:** `{ error : "Le cours n'existe pas" }`  
  OR  
  * **Code:** 401  
  **Content:** `{ error : error : "Vous n'êtes pas autorisé à utiliser cette request" }`

**DELETE /classStudents**
----
  Supprime une classe
* **Data Params**  
  *Required:* `id=[integer]`
* **Headers**  
  Content-Type: application/json  
* **Success Response:** 
  * **Code:** 204 
  * **Content:**
  `{ "message" => "La classe a bien été supprimée"}`
* **Error Response:**  
  * **Code:** 404  
  **Content:** `{ error : "La classe n'existe pas" }`  
  OR  
  * **Code:** 401  
  **Content:** `{ error : error : "Vous n'êtes pas autorisé à utiliser cette request" }`


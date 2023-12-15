# Cours (Lesson)
```
{
    id: integer
    name: string
    description: text
    dateBegin: datetime
    dateEnd: datetime
    place: string
}
```
# Planning
```
{
    id: integer
    user: relation(user, oneToOne)
    lessons: relation(lesson, manyToMany)
}
```

**GET /lessons**
----
  Retourne tous les cours
* **URL Params**  
  None
* **Data Params**  
  None
* **Headers**  
  Content-Type: application/json  
* **Success Response:**  
* **Code:** 200  
  **Content:**  
```
[
    [
        "id",
        "name",
        "description",
        "dateBegin",
        "dateEnd",
        "place"
    ],
    [
        "id",
        "name",
        "description",
        "dateBegin",
        "dateEnd",
        "place"
    ]
]
```
**GET /planning**
----
  Retourne tous les planning
* **URL Params**  
  None
* **Data Params**  
  None
* **Headers**  
  Content-Type: application/json  
* **Success Response:**  
* **Code:** 200  
  **Content:** 
```
[
    [
        "id"
        "user" <user_Object> ,
        "lessons" [ <lessons_Object> ]
    ],
    [
        "id"
        "user" <user_Object> ,
        "lessons" [ <lessons_Object> ]
    ]
]
```

**GET /lessons/:id**
----
  Retourne un cours précis
* **URL Params**  
  *Required:* `id=[integer]`
* **Data Params**  
  None
* **Headers**  
  Content-Type: application/json  
  Authorization: Bearer `<OAuth Token>`
* **Success Response:** 
* **Code:** 200  
  **Content:**  `{ <lessons_Object> }` 
    ```
  [
        "id",
        "nom",
        "description",
        "dateDebut",
        "dateFin",
        "lieu"
    ]
  ```
* **Error Response:**  
  * **Code:** 404  
  **Content:** `{ error : "Le cours n'existe pas" }`  
  OR  
  * **Code:** 401  
  **Content:** `{ error : error : "Vous n'êtes pas autorisé à utiliser cette request" }`

**GET /lessons/user/:id**
----
  Retourne la liste des cours d'un utilisateur
* **URL Params**  
  *Required:* `id=[integer]`
* **Data Params**  
  None
* **Headers**  
  Content-Type: application/json  
  Authorization: Bearer `<OAuth Token>`
* **Success Response:** 
* **Code:** 200  
  **Content:**  `{ <lessons_Object> }` 
    ```
  [
    [
        "id",
        "nom",
        "description",
        "dateDebut",
        "dateFin",
        "lieu"
    ],
    [
        "id",
        "nom",
        "description",
        "dateDebut",
        "dateFin",
        "lieu"
    ]
  ]
  ```
* **Error Response:**  
  * **Code:** 404  
  **Content:** `{ error : "L'utilisateur n'a aucun cours affilié'" }`  
  OR  
  * **Code:** 401  
  **Content:** `{ error : error : "Vous n'êtes pas autorisé à utiliser cette request" }`

**GET /planning/:id**
----
  Retourne un planning précis
* **URL Params**  
  *Required:* `id=[integer]`
* **Data Params**  
  None
* **Headers**  
  Content-Type: application/json  
  Authorization: Bearer `<OAuth Token>`
* **Success Response:** 
* **Code:** 200  
  **Content:**  `{ <lessons_Object> }` 
    ```
  [
        "id"
        "user" <user_Object> ,
        "lessons" <lessons_Object> 
    ]
  ```
* **Error Response:**  
  * **Code:** 404  
  **Content:** `{ error : "Le planning n'existe pas" }`  
  OR  
  * **Code:** 401  
  **Content:** `{ error : error : "Vous n'êtes pas autorisé à utiliser cette request" }`

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
    "name" : string,
    "description" : text,
    "dateBegin" : datetime,
    "dateEnd": datetime,
    "place" : string
  }
```
* **Success Response:**  
* **Code:** 200  
  **Content:**  `{ <lesson_object> }` 

**POST /planning**
----
  Créer un nouveau planning d'un utilisateur
* **URL Params**  
  None
* **Headers**  
  Content-Type: application/json  
* **Data Params**  
```
  {
    "user":<user_Object> ,
    "lessons": <lessons_Object> 
  }
```
* **Success Response:**  
* **Code:** 200  
  **Content:**  `{ <planning_object> }` 

**PUT /lessons/:id**
----
  Met à jour les champs du cours spécifié et renvoie l'objet mis à jour.
* **URL Params**  
  *Required:* `id=[integer]`
* **Data Params**  
```
  {
  	"name" : string,
    "description" : text,
    "dateBegin" : datetime,
    "dateEnd": datetime,
    "place" : string
  }
```
* **Headers**  
  Content-Type: application/json  
  Authorization: Bearer `<OAuth Token>`
* **Success Response:** 
* **Code:** 200  
  **Content:**  `{ <lessons_object> }`  
* **Error Response:**  
  * **Code:** 404  
  **Content:** `{ error : "Le cours n'existe pas" }`  
  OR  
  * **Code:** 401  
  **Content:** `{ error : error : "Vous n'êtes pas autorisé à utiliser cette request" }`

**PUT /planning/:id**
----
  Met à jour les champs du cours spécifié et renvoie l'objet mis à jour.
  Permet d'ajouter et retirer un cours à un planning
* **URL Params**  
  *Required:* `id=[integer]`
* **Data Params**  
```
  {
  	"user": <user_id> ,
    "lessons": <lessons_Object> 
  }
```
* **Headers**  
  Content-Type: application/json  
  Authorization: Bearer `<OAuth Token>`
* **Success Response:** 
* **Code:** 200  
  **Content:**  `{ <lessons_object> }`  
* **Error Response:**  
  * **Code:** 404  
  **Content:** `{ error : "Le cours n'existe pas" }`  
  OR  
  * **Code:** 401  
  **Content:** `{ error : error : "Vous n'êtes pas autorisé à utiliser cette request" }`

**DELETE /lessons/:id**
----
  Supprime un cours
* **URL Params**  
  *Required:* `id=[integer]`
* **Data Params**  
  None
* **Headers**  
  Content-Type: application/json  
  Authorization: Bearer `<OAuth Token>`
* **Success Response:** 
  * **Code:** 204 
* **Error Response:**  
  * **Code:** 404  
  **Content:** `{ error : "Le cours n'existe pas" }`  
  OR  
  * **Code:** 401  
  **Content:** `{ error : error : "Vous n'êtes pas autorisé à utiliser cette request" }`

**DELETE /lessons/user/:id**
----
  Supprime un cours d'un utilisateur
* **URL Params**  
  *Required:* `id=[integer]`
* **Data Params**  
  None
* **Headers**  
  Content-Type: application/json  
  Authorization: Bearer `<OAuth Token>`
* **Success Response:** 
  * **Code:** 204 
* **Error Response:**  
  * **Code:** 404  
  **Content:** `{ error : "Le cours n'existe pas pour cette utilisateur" }`  
  OR  
  * **Code:** 401  
  **Content:** `{ error : error : "Vous n'êtes pas autorisé à utiliser cette request" }`

**DELETE /planning/:id**
----
  Supprime un planning
* **URL Params**  
  *Required:* `id=[integer]`
* **Data Params**  
  None
* **Headers**  
  Content-Type: application/json  
  Authorization: Bearer `<OAuth Token>`
* **Success Response:** 
  * **Code:** 204 
* **Error Response:**  
  * **Code:** 404  
  **Content:** `{ error : "Le planning n'existe pas" }`  
  OR  
  * **Code:** 401  
  **Content:** `{ error : error : "Vous n'êtes pas autorisé à utiliser cette request" }`


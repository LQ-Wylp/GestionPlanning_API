# Cours (Lesson)
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
# ClassStudent
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
**GET /ClassStudent**
----
  Retourne un ou des classes d'étudiants
* **Data Params**  
  * *Allowed:* `id=[integer]`
  * *Allowed:* `idLesson=[integer]`
  * *Allowed:* `idUser=[integer]`

  **Example:** 
  ```-
  /ClassStudent?id=1&idLesson=1&idUser=2
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

**POST /classStudent**
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
  **Content:**  `{ <classStudent_object> }` 

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

**PUT /ClassStudent**
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

**PATCH /ClassStudent**
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
  *Required:* `idLesson=[integer]`
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

**DELETE /ClassStudent**
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


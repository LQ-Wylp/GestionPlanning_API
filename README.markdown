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
  Retourne tous les classes d'étudiants
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
  1:
    {
      "id": 1
      "idLesson": 1 
      "idUsers": [
        1,
        2,
        3
      ]
    },
  2:
    {
      "id": 2
      "idLesson": 2 
      "idUsers": [
        1,
        2,
        3
      ]
    }
]
```

**GET /lessons/:id**
----
  Retourne un cours précis
* **URL Params**  
  *Required:* `idLesson=[integer]`
* **Data Params**  
  None
* **Headers**  
  Content-Type: application/json  
  Authorization: Bearer `<OAuth Token>`
* **Success Response:** 
* **Code:** 200  
  **Content:**  `{ <lessons_Object> }` 
    ```
  {
    "id" : 1,
    "idTeacher" : 1,
    "name" : "API REST",
    "description" : "Fait des cours de Web",
    "dateBegin" : 15/12/2023 8:00,
    "dateEnd" : 15/12/2023 10:00,
    "place" : "Bâtiment 1, salle 1"
  }
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
  *Required:* `idUser=[integer]`
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
* **Error Response:**  
  * **Code:** 404  
  **Content:** `{ error : "L'utilisateur n'a aucun cours affilié'" }`  
  OR  
  * **Code:** 401  
  **Content:** `{ error : error : "Vous n'êtes pas autorisé à utiliser cette request" }`

**GET /classStudent/:id**
----
  Retourne les membres d'une classe
* **URL Params**  
  *Required:* `idClassStudent=[integer]`
* **Data Params**  
  None
* **Headers**  
  Content-Type: application/json  
  Authorization: Bearer `<OAuth Token>`
* **Success Response:** 
* **Code:** 200  
  **Content:**  `{ <lessons_Object> }` 
    ```
  {
      "id": 1
      "idLesson": 1 
      "idUsers": [
        1,
        2,
        3
      ]
    }
  ```
* **Error Response:**  
  * **Code:** 404  
  **Content:** `{ error : "La classe n'existe pas" }`  
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
    "idLesson": 1 
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

**PUT /lessons/:id**
----
  Met à jour les champs du cours spécifié et renvoie l'objet mis à jour.
* **URL Params**  
  *Required:* `idLesson=[integer]`
* **Data Params**  
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

**PUT /ClassStudent/:id**
----
  Met à jour les étudiants de la classe et renvoie l'objet mis à jour.
* **URL Params**  
  *Required:* `idClassStudent=[integer]`
* **Data Params**  
```
  {
  	"id": 1
    "idLesson": 2 
    "idUsers": [
      1,
      2,
      3
    ] 
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
  *Required:* `idLesson=[integer]`
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
  *Required:* `idUser=[integer]`
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

**DELETE /ClassStudent/:id**
----
  Supprime une classe d'étudiant
* **URL Params**  
  *Required:* `idClasStudent=[integer]`
* **Data Params**  
  None
* **Headers**  
  Content-Type: application/json  
  Authorization: Bearer `<OAuth Token>`
* **Success Response:** 
  * **Code:** 204 
* **Error Response:**  
  * **Code:** 404  
  **Content:** `{ error : "La classe n'existe pas" }`  
  OR  
  * **Code:** 401  
  **Content:** `{ error : error : "Vous n'êtes pas autorisé à utiliser cette request" }`


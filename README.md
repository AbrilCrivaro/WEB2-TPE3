# WEB2-TPE3 - Trabajo Practico Especial WEB 2

## Integrantes

- Nicolás Ledesma
- Abril Crivaro

En este repositorio subiremos todos los archivos correspondientes con el Trabajo Práctico Especial (TPE) tercera entrega.

## Descripción

Este proyecto forma parte de la tercera entrega del Trabajo Práctico Especial (TPE) de la carrera TUDAI. Es un servicio web de tipo RESTFul de una base de datos con las tablas de Canciones (songs) y artistas (artists) las cuales tienen una relacion de 1 a N 
que es representada con un artista que tiene varias canciones.

Se cumplen los siguientes requerimientos obligatorios y opcionales:

- La API Rest es RESTful
- tiene 2 servicios que listan (GET) una colección entera de entidades (GetArtists que lista todos los artistas y GetSongs que lista todas las canciones). ambos servicios pueden ordenarse por cualquiera de sus campos tanto ascencente como descendente.
- Ambas listas tienen un servicio que liste (GET) por ID una entidad determinada.
- Tiene 2 servicios para agregar, modificar y eliminar datos (POST PUT y DELETE) de cualquiera de las tablas mencionadas.
- La API Rest maneja de manera adecuada los siguientes códigos de error (200, 201, 400 y 404).
- Consta de paginacion sobre todos los servicios que listen una coleccion entera de entidades, tambien ambos servicios de listado de colecciones pueden filtrarse, canciones puede ser filtrado por su artista, y artistas puede ser filtrado por su nacionalidad.
- Todo el sistema usa el patrón MVC.
- Se incluye el SQL para la instalación de la base de datos.


## Tablas

### La tabla `songs` contiene:
- `id_song`: clave primaria (autoincremental)
- `song_name`: nombre de la canción
- `release_date`: fecha de lanzamiento
- `views`: número de vistas
- `id_artist`: clave foránea que referencia la tabla de artistas
- `lyrics_song`: letra de la canción

### La tabla `artists` contiene:
- `id_artist`: clave primaria (autoincremental)
- `artist_name`: nombre del artista
- `artist_nationality`: nacionalidad del artista
- `img_artist`: imagen del artista
- `description`: breve descripcion del artista

# Endpoints

## Songs

- GET `<<BaseUrl>>/api/songs` Lista la coleccion entera de "songs".
- GET `<<BaseUrl>>/api/songs/:ID` Muestra una entidad determinada por ID.
- POST `<<BaseUrl>>/api/songs` Publica una nueva cancion en "songs".
- PUT `<<BaseUrl>>/api/songs/:ID` Modifica una entidad existente determinada por ID.
- DELETE `<<BaseUrl>>/api/songs/:ID` Elimina una entidad existente determinada por ID.

## Artists

- GET `<<BaseUrl>>/api/artists` Lista la coleccion entera de "artists".
- GET `<<BaseUrl>>/api/artists/:ID` Muestra una entidad determinada por ID.
- POST `<<BaseUrl>>/api/artists` Publica un nuevo artista en "artists".
- PUT `<<BaseUrl>>/api/artists/:ID` Modifica una entidad existente determinada por ID.
- DELETE `<<BaseUrl>>/api/artists/:ID` Elimina una entidad existente determinada por ID.

## Canciones (songs)

- ### GET `<<BaseUrl>>/api/songs`

  -  ### Descripción:
Lista la coleccion entera "songs" disponibles en la base de datos, permitiendo aplicar tanto filtros, ordenamiento y paginado de la lista resultante.

  - #### Ejemplo:

Para obtener toda la coleccion de la tabla "songs":

```http
GET <<BaseUrl>>/api/songs
```

  - ### Query Params:

### Ordenamiento:

  - **sort**: Campo por el que se desea ordenar los resultados. Los campos válidos pueden incluir:
    
    - `song_name`: Ordena por el titulo de la cancion.
    - `views`: Ordena por la cantidad de reproducciones.
    - `release_date`: Ordena por la fecha de lanzamiento.
    - `lyrics_songs`: Ordena por la primera letra de las lyrics de la cancion.
    - `id_song`: Ordena por el ID de la cancion.
    - `id_artist`: Ordena por el ID del artista.

  - **order**: Dirección de ordenamiento para el campo especificado en **sort**. Puede ser:
    - **asc** : Orden ascendente (por defecto).
    - **desc** : Orden descendente.
        
#### Ejemplo de Ordenamiento:
Para obtener todos las canciones ordenados por reproducciones en orden descendente:

```http
GET <<BaseUrl>>/api/songs?sort=views&order=desc
```

Para obtener todas las canciones ordenados por reproducciones en orden por defecto:

```http
GET <<BaseUrl>>/api/songs?sort=views
```

### filtro:

  - **filter**: Campo por el que se desea filtrar los resultados. tiene un solo campo valido el cual es:
    
    - `id_artist`: filtra las canciones de un artista determinado por su ID.

####  Ejemplo de Filtrado:
Para obtener las canciones de un artista cuya ID es 4:

```http
GET <<BaseUrl>>/api/songs?filter=4
```

### Paginación:
La paginación permite dividir los resultados en páginas más pequeñas, mejorando la experiencia del usuario y optimizando el rendimiento de la aplicación.

- page: Número de la página solicitada. Si no se especifica, se muestran todas las canciones.
- limit: Número de canciones por página. Si no se especifica, se aplica el valor por defecto de 10 como límite.

#### Ejemplo de paginado:
Devolver página 3 con 10 resultados por página:

```http
GET <<BaseUrl>>/api/songs?page=3
```

Devolver página 4 con 5 resultados por página:

```http
GET <<BaseUrl>>/api/songs?page=3&limit=5
```

#### Ejemplo de una conbinacion entre filtro, ordenamiento y paginacion:

Para obtener la página 2 (páginas con 2 elementos) del listado de canciones(songs) ordenados por cantidad de reproducciones en orden ascendente de un determinado artista cuya id sea 8:

```http
GET <<BaseUrl>>/api/songs?sort=views&order=asc&filter=8&page=2&limit=2
```


- ## GET `<<BaseUrl>>/api/songs/:ID`

Muestra una entidad determinada por id_song solicitado.

### Crear una nueva Cancion

```http
POST <<BaseUrl>>/api/songs
```

Crea una nueva cancion con la información proporcionada en formato JSON en el body de la petición. Luego de insertar se devuelve UN JSON con los datos de la cancion desde la base de datos. Debe notarse que para poder crear una nueva cancion e insertarlo en la base de datos tiene que existir el artista al cual se le quiere asignar dicha cancion.

#### Campos Requeridos:

- `song_name`: Titulo de la cancion.
- `releace_date`: Fecha de lanzamiento de la cancion.
- `views`: Cantidad de reproducciones de la cancion.
- `id_artist`: Artista de la cancion.
- `lyrics_song`: lyrics de la cancion.

#### Ejemplo de JSON:

```json
 {{
    "song_name": "nombre de la cancion",
    "date": "2020-03-20",
    "views": 10000000,
    "artist_id": 15,
    "lyrics": "lyrics de la cancion"
}

```

#### Nota Importante:

El campo `id_song` se genera automáticamente y no debe incluirse en el JSON.

- ## PUT `<<BaseUrl>>/api/songs/:ID`

Modifica una entidad determinada por id_song solicitado, los datos a solicitar son los mismos que para publicar una cancion.

- ## DELETE `<<BaseUrl>>/api/songs/:ID`

Elimina una entidad determinada por id_song solicitado.

## artistas (artists)

- ### GET `<<BaseUrl>>/api/artists`

  -  ### Descripción:
Lista la coleccion entera "artists" disponibles en la base de datos, permitiendo aplicar tanto filtros, ordenamiento y paginado de la lista resultante.

  - #### Ejemplo:

Para obtener toda la coleccion de la tabla "artists":

```http
GET <<BaseUrl>>/api/artists
```

  - ### Query Params:

### Ordenamiento:

  - **sort**: Campo por el que se desea ordenar los resultados. Los campos válidos pueden incluir:
    
    - `artist_name`: Ordena por el nombre del artista.
    - `artist_nationality`: Ordena por la nacionalidad del artista.

  - **order**: Dirección de ordenamiento para el campo especificado en **sort**. Puede ser:
    - **asc** : Orden ascendente (por defecto).
    - **desc** : Orden descendente.
        
#### Ejemplo de Ordenamiento:
Para obtener todos las artista ordenados por su nacionaldad en orden descendente:

```http
GET <<BaseUrl>>/api/artists?sort=artist_nationality&order=desc
```

Para obtener todos los artistas ordenados por nacionalidad en orden por defecto:

```http
GET <<BaseUrl>>/api/artists?sort=artist_nationality
```

### filtro:

  - **filter**: Campo por el que se desea filtrar los resultados. tiene un solo campo valido el cual es:
    
    - `artist_nationality`: filtra a los artistas por su nacionalidad.

####  Ejemplo de Filtrado:
Para obtener los artistas cuya nacionalidad es USA:

```http
GET <<BaseUrl>>/api/artists?filter=USA
```

### Paginación:
La paginación permite dividir los resultados en páginas más pequeñas, mejorando la experiencia del usuario y optimizando el rendimiento de la aplicación.

- page: Número de la página solicitada. Si no se especifica, se muestran todos los artistas.
- limit: Número de artistas por página. Si no se especifica, se aplica el valor por defecto de 10 como límite.

#### Ejemplo de paginado:
Devolver página 3 con 10 resultados por página:

```http
GET <<BaseUrl>>/api/artists?page=3
```

Devolver página 4 con 5 resultados por página:

```http
GET <<BaseUrl>>/api/artists?page=4&limit=5
```

#### Ejemplo de una conbinacion entre filtro, ordenamiento y paginacion:

Para obtener la página 2 (páginas con 2 elementos) del listado de artistas(artists) ordenados por su nombre en orden descendente de una determinada nacionalidad en este caso USA :

```http
GET <<BaseUrl>>/api/artists?sort=artist_name&order=desc&filter=USA&page=2&limit=2
```


- ## GET `<<BaseUrl>>/api/artists/:ID`

Muestra una entidad determinada por id_artist solicitado.

### Crear un nuevo artista

```http
POST <<BaseUrl>>/api/artists
```

Crea un nuevo artista con la información proporcionada en formato JSON en el body de la petición. Luego de insertar se devuelve UN JSON con los datos del artista desde la base de datos

#### Campos Requeridos:

- `artist_name`: Nombre del artista.
- `artist_nationality`: Nacionalidad del artista.
- `img_artists`: imagen del artista.
- `description`: breve descripcion del artista.

#### Ejemplo de JSON:

```json
 {{
    "artist_name": "nombre del artista",
    "artist_nationality": "nacionalidad del artista",
    "img_artist": "URL de la imagen",
    "description": "breve descripcion",
}

```

#### Nota Importante:

El campo `id_artist` se genera automáticamente y no debe incluirse en el JSON.

- ## PUT `<<BaseUrl>>/api/artists/:ID`

Modifica una entidad determinada por id_artist solicitado, los datos a solicitar son los mismos que para publicar un artista.

- ## DELETE `<<BaseUrl>>/api/artists/:ID`

Elimina una entidad determinada por id_artist solicitado.



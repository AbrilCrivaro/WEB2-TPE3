# WEB2-TPE3 - Trabajo Practico Especial WEB 2

## Integrantes

- Nicolás Ledesma
- Abril Crivaro

En este repositorio subiremos todos los archivos correspondientes con el Trabajo Práctico Especial (TPE) tercera entrega.

## Descripción

Este proyecto forma parte de la tercera entrega del Trabajo Práctico Especial (TPE) de la carrera TUDAI. Es un servicio web de tipo RESTFul de una base de datos con las tablas de Canciones (songs) y artistas (artists) las cuales tienen una relacion de 1 a N 
que es reprensentada con un artista que tiene varias canciones.

Se cumplen los siguientes requerimientos obligatorios y opcionales:

- La API Rest es RESTful
- tiene 2 servicios que listan (GET) una colección entera de entidades (GetArtists que lista todos los artistas y GetSongs que lista todas las canciones). ambos servicios pueden ordenarce por cualquiera de sus campos tanto ascencente como descendente.
- Ambas listas tienen un servicio que liste (GET) por ID una entidad determinada.
- Tiene 2 servicios para agregar modificar y eliminar datos (POST PUT y DELETE) de cualquiera de las tablas mencionadas.
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

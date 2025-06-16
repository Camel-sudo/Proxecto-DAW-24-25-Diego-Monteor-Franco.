
# Proxecto fin de ciclo

- [Proxecto fin de ciclo](#proxecto-fin-de-ciclo)
  - [Taboleiro do proxecto](#taboleiro-do-proxecto)
  - [Descrición](#descrición)
  - [Instalación / Posta en marcha](#instalación--posta-en-marcha)
  - [Uso](#uso)
  - [Sobre o autor](#sobre-o-autor)
  - [Licenza](#licenza)
  - [Índice](#índice)
  - [Guía de contribución](#guía-de-contribución)
  - [Links](#links)

## Taboleiro do proxecto

En desenvolvemento

## Descrición

NutriPro é unha aplicación web que permite aos usuarios facer o seguimento de distintos valores nutricionais da súa dieta, facilitando o seu uso tanto para deportistas profesionais como non profesionais. Ademais, tamén permitirá aos nutricionistas pautar opcións de dieta para os seus clientes, de xeito que estes, dende a súa app, poidan elixir entre esas opcións e alcanzar os seus requirimentos nutricionais. Todo isto feito nunha base de JavaScript, PHP e MySQL.

## Instalación / Posta en marcha

É necesario ter instalada unha versión mínima de **Docker 20.10.24**.  
Proporcionarase unha máquina virtual con Docker instalado no seguinte enlace: [maquina](/codigo/sql/nutripro.sql).

1. Descargar a carpeta [app](/codigo/app/).  
2. Configurar a base de datos: importar o ficheiro SQL facilitado en [sql](/codigo/sql/nutripro(pruebas).sql).  
3. Iniciar a aplicación co seguinte comando:

   ```bash
   sudo docker-compose up
   ```
4. Acceso mediante navegador en `localhost`.

## Uso

NutriPro úsase para a monitorización da túa alimentación. Isto permite a usuarios normais monitorizar a súa dieta e aos nutricionistas, monitorizar os seus clientes.

## Sobre o autor

O creador de NutriPro é un estudante de DAW, está familiarizado con distintas tecnoloxías de backend e frontend, como poden ser: JS, WP, CSS, HTML, SQL, PHP... Sendo esta última coa que máis familiarizado está.

O meu correo de contacto é diegomonterofranco@gmail.com

## Licenza

[LICENSE](LICENSE.md)

## Índice

1. [Anteproyecto](doc/templates/1_Anteproxecto.md)  
2. [Análise](doc/templates/2_Analise.md)  
3. [Deseño](doc/templates/3_Deseño.md)  
4. [Codificación e probas](doc/templates/4_Codificacion_e_probas.md)  
5. [Implantación](doc/templates/5_Implantación.md)  
6. [Referencias](doc/templates/6_Referencias.md)  
7. [Incidencias](doc/templates/7_Incidencias.md)

## Guía de contribución

NutriPro é un proxecto de software libre. Se estás interesado en contribuír a este, podes empezar creando funcionalidades como o desenvolvemento do rol de administrador, funcionalidades extra para nutricionistas, entre outras. O máis destacable que diría que se podería facer por agora sería a creación de paneis de usuarios.

## Links

[PHP](https://www.php.net/docs.php)  
[SweetAlert2](https://sweetalert2.github.io/)  
[JavaScript](https://developer.mozilla.org/en-US/docs/Web/JavaScript)

## Fontes de interese

[w3schools](https://www.w3schools.com/css/default.asp)  
[Stack Overflow](https://stackoverflow.com/questions)  

## Inspiración styles

[pictoaplicaciones](https://labs.pictoaplicaciones.com/pictoaprende2025/)

## Sitios oficiais do software utilizado

[api_comida](https://world.openfoodfacts.org/)

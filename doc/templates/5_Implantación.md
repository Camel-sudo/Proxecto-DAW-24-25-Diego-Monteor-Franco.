# FASE DE IMPLANTACIÓN

- [FASE DE IMPLANTACIÓN](#fase-de-implantación)
  - [1- Manual técnico](#1--manual-técnico)
    - [1.1- Instalación](#11--instalación)
    - [1.2- Administración do sistema](#12--administración-do-sistema)
  - [2- Manual de usuario](#2--manual-de-usuario)
  - [3- Melloras futuras](#3--melloras-futuras)

## 1- Manual técnico

### 1.1- Instalación

## Requirimentos de Software

É necesario ter instalada unha versión mínima de **Docker 20.10.24**.

## Instrucións de Instalación

1. Descargar a carpeta [app](/codigo/app/).
2. Configurar a base de datos: importar o ficheiro SQL facilitado en [sql](/codigo/sql/nutripro.sql).
3. Iniciar a aplicación co seguinte comando:

   ```bash
   sudo docker-compose up

### 1.2- Administración do sistema

Será preciso crear copias periódicas da base de datos, dado que manexamos información importante sobre o traballo doutras persoas. A perda da base de datos podería implicar a perda do traballo realizado ata o momento polos nosos clientes.

## 2- Manual de usuario

> *EXPLICACIÓN:* Neste apartado fara
>
> - Indicar se será necesario formar ós usuarios. En caso afirmativo planificar.
> - Manual de usuario, FAQ ou outro xeito que sexa o máis adecuado para que os usuarios saiban usar a nosa aplicación informática.
>
> Todo esto se a aplicación require de manual de usuario.

## 3- Melloras futuras

> *EXPLICACIÓN:* Neste apartado incluiranse as posibilidades de mellora da aplicación no futuro.
>
[**<-Anterior**](../../README.md)

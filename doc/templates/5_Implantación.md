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
Proporcionarase unha maquina virtual con docoker instalado no siguiente enlace:[maquina](/codigo/sql/nutripro.sql).

## Instrucións de Instalación

1. Descargar a carpeta [app](/codigo/app/).
2. Configurar a base de datos: importar o ficheiro SQL facilitado en [sql](/codigo/sql/nutripro(pruebas).sql).
3. Iniciar a aplicación co seguinte comando:

   ```bash
   sudo docker-compose up

### 1.2- Administración do sistema

Será preciso crear copias periódicas da base de datos, dado que manexamos información importante sobre o traballo doutras persoas. A perda da base de datos podería implicar a perda do traballo realizado ata o momento polos nosos clientes.

## 2- Manual de usuario
## Usuarios de proba dispoñibles

Para a proba da aplicación, xa están creados os seguintes usuarios:

- **Usuario base 1:**  
  `base2@base2.com`  
  `base2`

- **Usuario base 2:**  
  `base3@base3.com`  
  `base3`

- **Usuario nutricionista:**  
  `nutricion@nutricion.org`  
  `nutricion`

Tamén podes crear novos usuarios base accedendo á opción **"Rexistrarse"** na pantalla de inicio.

---

## Usuarios base

Se accedes cun **usuario base**, terás acceso unicamente á sección:

### "As miñas dietas"

Aquí podes:
- Crear dietas
- Eliminar dietas
- Buscar dietas
- Filtrar dietas por nome
- Engadir e modificar alimentos en cada dieta

Esta funcionalidade está dividida en dúas páxinas:
1. Buscar alimentos
2. Visualización da dieta

---

## Usuario nutricionista

Se accedes cun **usuario nutricionista**, terás acceso á sección:

### "Os meus pacientes"

Poderás:
- Engadir pacientes
- Eliminar pacientes
- Modificar os seus datos
- Consultar información dos clientes

Ademais, ao seleccionar un paciente e premer en "Dietas", accederás a unha páxina onde poderás modificar a súa dieta personalizada.

## 3- Melloras futuras
- Creación dun usuario **administrador** e dun usuario **premium**, cada un coas súas funcións específicas e avanzadas.

- Desenvolvemento de funcións adicionais para facilitar o traballo do nutricionista.

- Implementación dun sistema de solicitudes entre nutricionistas e clientes para mellorar a comunicación e xestión.

[**<-Anterior**](../../README.md)

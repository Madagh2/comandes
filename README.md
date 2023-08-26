# comandes
Gestió de comandes per a centres educatius.
## Necessitats prèvies
- Servidor del centre amb PHP 8 o superior i MySQL
- Creació d'una carpeta al servidor per copiar els fitxers de l'aplicació a travès del panell de control o d'un compte FTP
- Creació d'una base de dades amb un usuari i contrasenya que s'han de proporcionar quan s'inicia l'aplicació per primera vegada
## Característiques
- Gestió d'usuaris
- Gestió de permisos
- Gestió de l'oferta educativa
- Importació de professorat i departaments des del fitxer XML del Gestib
- Gestió de logotips, dades del centre i signatures per als vals de compra
- Gestió de les taules de la base de dades
- Gestió de còpies de seguretat
- Ajuda en pantalla editable
- Sol·licitud de comandes per part del personal del centre
- Possibilitat d'adjuntar fulls de comanda en PDF
- Doble autorització de comandes per part del/de la cap de departament i el/la administrador/a del centre
- Impressió de vals de compra
## Instal·lació
- Copiar els fitxers en la carpeta creada al servidor
- Entrar a l'aplicació web amb un navegador
- Introduir els paràmetres corresponents a la base de dades: host, nom, usuari i contrasenya
- L'aplicació es connecta per primera vegada a la base de dades i crea les primeres taules necessaries
- Entrar a l'aplicació amb usuari **admin** i contrasenya **admin**. Per seguretat aquesta contrasenya s'ha de canviar
- Configurar els paràmetres del centre al menú **Configuració**
  - Oferta educativa
  - Signatures. Escanejades en format PNG amb transparència
  - Dades del centre
- El curs acadèmic es calcula automàticament, prenent com a referència per al canvi de curs el mes d'agost. Comprovar que el curs és correcte
- Entrar al menú **Base de dades** i generar les taules de comandes del curs actual
- Opcionalment, es pot pujar al servidor el fitxer XML generat pel Gestib i importar el professorat i els departaments. En cas contrari, l'aplicació utilitza la taula usuaris
## Recursos externs
- [Materialize](https://materializecss.com/). Front-end framework responsivo basado en Material Dessign
- [MyPHP-Backup](https://github.com/daniloaz/myphp-backup). Creació de còpies de seguretat de bases de dades per Daniel López
## Contacte
Manuel Almonacid,
[manuelalmonacid@gmail.com](mailto:manuelalmonacid@gmail.com)


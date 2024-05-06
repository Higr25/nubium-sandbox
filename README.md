Obecné zadání
=================
- Vytvořte jednoduchou PHP + Nette + MySQL aplikaci vyvíjenou pomoci Dockeru.
- Hotový úkol odevzdejte jako jeden GIT repositář na github.com.
- Docker Compose by měl být zpracovaný tak, aby aplikace byla po nastartování funkční.
  
Požadavky na virtuální stroj
-----------------
- ke spuštění použít Docker Compose nebo Kubernetes
- Nginx
  - name-based vhost pojemenovaný "nubium-sandbox.test"
  - veřejné porty: 80 HTTP a 443 HTTPS
- PHP 7.4 nebo vyšší
- MySQL 5.7 nebo vyšší
  - sql-mode musí obsahovat STRICT_ALL_TABLES
  - veřejný port 3306

Požadavky na PHP aplikaci
-----------
- Nette 3.0
- SQL layer Dibi nebo Nette database
- všechny použité PHP knihovny instalovat pomoci Composeru

Aplikace musí umožňovat:
- registraci, přihlášení a změnu hesla uživatele
- výpis "článků" umožňující
  - stránkování
  - řazení podle data vložení, nadpisu, hodnocení
  - omezení zobrazení jednotlivých článků pouze přihlášeným
  - přihlášený může hodnotit tlačítkem like/dislike (+1/-1) bez reloadu celé stránky
  - bez administrace (stačí SQL soubor pro počáteční naplnění)
- minimální DB struktura
  - uživatel: login, heslo, informace o registraci
  - článek: nadpis, perex, datum vystavení, informace o viditelnosti a hodnocení
- uložené informace musí umožnit smazat hodnocení provedená nepoctivým uživatelem
- vzhled a JavaScripty musí fungovat v posledních verzích IE, Edge, Chrome, Firefox.

Požadavky
------------

- Nainstalovaný Docker desktop


Spuštení
------------

Do hosts souboru přidat
> 127.0.0.1 nubium-sandbox.test
> 


V rootu projektu spustit:
> docker-compose up --build
> 


V prohlížeči přejít na 
> http://nubium-sandbox.test
>
>

MySQL nabíhá asi o minutu déle než web server a php kvůli plnění databáze

K dokončení
------------
 - Ke kompletní funkci HTTPS už chybí jen certifikáty, ty se mi nepodařilo zacvaknout. Nginx je ale na HTTPS nakonfigurovaný správně.

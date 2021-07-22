Nette Docker Aplikace
=================


Požadavky
------------

- Nainstalovaný Docker desktop


Spuštení
------------

V rootu projektu spustit:
> docker-compose up --build

Do hosts souboru přidat
> 127.0.0.1 nubium-sandbox.test

V prohlížeči přejít na 
> http://nubium-sandbox.test

První deprecated warning stačí jednou přeskočit v Tracy.

K dokončení
------------
 - Ke kompletní funkci HTTPS už chybí jen certifikáty, ty se mi nepodařilo zacvaknout. Nginx je ale na HTTPS nakonfigurovaný správně.

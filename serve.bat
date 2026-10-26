@echo off
title Serveur BTP Maroc
echo ========================================================
echo  DEMARRAGE DU SERVEUR DE DEVELOPPEMENT BTP MAROC
echo  Application Web - Gestion des Achats & Pointage
echo ========================================================
echo.
echo URL d'acces : http://127.0.0.1:8000
echo.
echo Identifiants de demonstration :
echo  - Direction Generale : direction@btpmaroc.ma / password
echo  - Conducteur Travaux : conducteur@btpmaroc.ma / password
echo  - Chef Tanger        : chef.tanger@btpmaroc.ma / password
echo  - Responsable Achats : achats@btpmaroc.ma / password
echo  - Responsable RH     : rh@btpmaroc.ma / password
echo.
echo Appuyez sur Ctrl+C pour arreter le serveur.
echo ========================================================
C:\xampp82\php.exe artisan serve --host=127.0.0.1 --port=8000
pause

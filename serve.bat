@echo off
title WarshaLink BTP - Serveur de Developpement
echo ========================================================
echo  WARSHALINK BTP - Gestion Achats & Pointage Chantiers
echo  La passerelle intelligente entre terrain et direction
echo ========================================================
echo.
echo URL d'acces : http://127.0.0.1:8000
echo.
echo Identifiants de demonstration :
echo  - Direction Generale : direction@warshalink.ma / password
echo  - Conducteur Travaux : conducteur@warshalink.ma / password
echo  - Chef Tanger        : chef.tanger@warshalink.ma / password
echo  - Responsable Achats : achats@warshalink.ma / password
echo  - Responsable RH     : rh@warshalink.ma / password
echo.
echo Appuyez sur Ctrl+C pour arreter le serveur.
echo ========================================================
C:\xampp82\php.exe artisan serve --host=127.0.0.1 --port=8000
pause

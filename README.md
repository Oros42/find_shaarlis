Où sont les shaarlis ?
======================
  
Fichier JSON qui liste les annuaires de shaarlis.  
https://raw.githubusercontent.com/Oros42/find_shaarlis/master/annuaires.json  
ou  
https://ecirtam.net/find_shaarlis/annuaires.json  
  
Format
======
```
{
"<URL>" : {"type":"<TYPE>", "is_active":<IS_ACTIVE>},
...
}
```
URL : URL de l'annuaire  
TYPE : river | river-api | shaarlo | shaarlimages | shaarli-tv | annuaire  
IS_ACTIVE : 0 | 1  
  
Générer la liste des shaarlis
=============================
```
php find.php
```
Cela va créer 2-3 fichiers dans ./out/ avec la liste de tout les shaarlis trouvés :  
- shaarlis.json  
- shaarlis.opml 
- shaarlis_HS.json si des shaarlis HS sont trouvés  
  
Ajout, modification ou suppression ?
====================================

Envoyez un mail à shaarli [ at ] ecirtam.net  
  
  
Oros le 16/05/2015

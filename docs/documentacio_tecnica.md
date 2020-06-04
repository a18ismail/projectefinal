# Documentació tècnica - Projecte Final

### Llistat de programari necessari per desenvolupar aquest projecte

Aquests son els programes o paquets necessaris per arrancar aquesta web (preferiblement Linux)

- Pila LAMP (PHP 7.3, Apache2, MySQL Server)
- PhpMyAdmin (preferible per visualitzar millor la BD)
- Symfony 
- Composer
- Node (consulta el FAQ per instruccions detallades sobre la versió)
- Yarn (prereiblement, ja que NPM dona problemes en alguns casos amb Webpack Encore)

Executa l'ordre `symfony check:requirements` al directori del projecte per comprobar que està preparat per continuar.

### Arrancar en local

Aquest projecte ha sigut desenvolupat utilitzant:
- Symfony Web Server, aprofitant la seva facilitat d'ús
- Webpack Encore per carregar els assets necessaris 
- Composer i Yarn per gestionar els paquets de PHP i JS respectivament

Per arrancar el projecte has de seguir aquestes instruccions amb el següent ordre:

1. Instal·lar dependencies PHP/Symfony: `composer install`
2. Instal·lar dependencies JS/Webpack Encore: `npm install` / `yarn install`
3. Crear el fitxer `.env.local` amb al mateix contingut que el fitxer `.env`, però modificant la URL de connexió a la Base de Dades amb l'usuari/contrasenya/nom de la BD corresponents
4. Executar l'ordre `php bin/console doctrine:migrations:migrate` per migrar l'estructura de la BD a la teva BD local
5. Executar l'ordre `php bin/console doctrine:fixtures:load` per carregar les dades de prova en aquestes taules
6. Generació de assets per visualitzar l'aplicació: `npm run dev` / `yarn encore dev` (cal carregar els assets després de cada canvi, o usar `yarn encore dev --watch`)
7. Finalment pots executar l'ordre `symfony server:start` per iniciar el servidor web en local

### Desplegament en un servidor 

Aquest projecte està preparat per ser desplagat en servidors Apache2. La configuració per defecte es troba al fitxer `public/.htaccess` i es pot modificar segons les teves preferencies.

Per desplegar en un servidor Apache cal seguir les següents instruccions:

1. Git clone `git clone https://github.com/a18ismail/projectefinal.git`
2. Instal·lar dependencies i paquets: `composer install` i `yarn install` (o `npm install`)
3. Modificar la URL de connexió a la BD de producció al fitxer `.env`
4. Modificar la configuració del Webpack Encore al fitxer `webpack.config.js` seguint les instruccions al mateix fitxer
4. Omplir la BD utilitzant les ordres `php bin/console doctrine:migrations:migrate` i `php bin/console doctrine:fixtures:load`
5. Generar els assets per producció executant `yarn encore production` (o `npm run build`)


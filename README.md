# Projecte Final

Aquesta aplicació ofereix una plataforma de gestió de tasques/operatives dirigida a empleats temporals d'una empresa internacional.
Idea basada en un repte ofert pel concurs Metropolis FPLabs
Projecte Final de DAW realitzat per Sonia Vargas i Ismail Ait.

[En aquest fitxer trobaras la documentació completa d'aquest projecte](docs/documentacio_tecnica.md)

# Instal·lació

Per instal·lar aquest projecte en local:

1. Instal·lació de dependencies PHP/Symfony: `composer install`
2. Instal·lació de dependencies JS/Webpack Encore: `npm install` / `yarn install`
3. Generació de assets per visualitzar l'aplicació: `npm run dev` / `yarn encore dev`

Consulta la documentació per instruccions detallades.

## Instruccions per desplegar

Aquest projecte está preparat per ser desplegat en servidors Apache. La configuració referent al servidor es troba a `/public/.htaccess`.

1. Descarregar repositori: `git clone https://github.com/a18ismail/projectefinal.git`
2. Executar `composer install` i `npm install` (preferiblement utilitzar yarn i fer `yarn install`)
3. Modificar URL de connexió MySql al fitxer `.env`
4. Modificar el fitxer `webpack.config.js` amb el directori on es desplegará la web
5. Executar `npm run build` (o `yarn encore build`) per generar els assets/recursos de la web

## Tecnologies usades
Aquest projecte utilitza el framework **Symfony** com a backend, aprofitant un conjunt de complements que faciliten el desenvolupament i ofereixen un patró de disseny extens.
Pel desenvolupament frontend utilitzem **Webpack Encore** per gestionar el conjunt de recursos necessaris i oferir funcionalitats útils, com ara la minimització de codi i importació de plugins.


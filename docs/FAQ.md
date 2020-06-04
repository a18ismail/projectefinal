# FAQ & Troubleshooting

En aquest document es troben llistats els problemes comuns que poden apareixer durant el desenvolupament d'aquest projecte.

- Vull instal·lar la ultima versió de Node:

En la majoria dels casos (sistemes Linux) la forma més senzilla és instal·lant Node utilitzant la opció de global de NPM.

Pots fer-ho facilment executant les seguents ordres:

    - `sudo apt install npm`
    - `sudo apt install node`
    - `sudo npm install npm@latest -g`
    - `sudo npm cache clean -f`
    - `sudo npm install -g n`
    - `sudo n stable`

- Les ordres `php bin/console` no funcionen/donen error:

Solució: Utilitza sudo a l'executar aquestes ordres. Acostuma a ser un problema de permisos, o si PHP no s'ha instal·lat correctament.

- Els scripts per carregar els assets amb Webpack Encore no carreguen/no funcionen:

Solució: Si estas utilitzant Yarn haurás d'utilitzar sudo sempre que vulguis executar scripts, si estàs utilitzant NPM probablament hauràs de fer el mateix.


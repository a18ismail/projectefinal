var Encore = require('@symfony/webpack-encore');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore

    // Aquest es el directori on es generen els assets
    .setOutputPath('public/build/')

    // Aquest es el directori public on es publiquen els assets generats pel navegador/servidor web
    .setPublicPath('/build')


    //PER DESPLEGAR AN UN SERVIDOR WEB
    //En la majoria del casos l'aplicació será desplagada en un subdirectori d'un servidor (per exemple /var/www/html)
    //En aquest cas cal sobrescriure la ruta del directori public, on es troben tots els assets

    //Per aquesta configuració cal descomentar les següents dues linies, comentar la configuració anterior de setPublicPath()
    // i descomentar el bloc de codi al final d'aquest fitxer, que defineix una configuració d'enrutació per defecte

    //.setPublicPath('build')
    //.setManifestKeyPrefix('build/')


    /*
     * ENTRY CONFIG
     *
     * Add 1 entry for each "page" of your app
     * (including one that's included on every page - e.g. "app")
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if your JavaScript imports CSS.
     */

    //Aquests son els punts d'entrada dels assets, defineixen els fitxers que es fan servir
    .addEntry('app', './assets/js/app.js')
    .addEntry('profile', './assets/js/profile.js')
    .addEntry('operations', './assets/js/operations.js')
    .addEntry('calendarOperations', './assets/js/calendarOperations.js')
    .addEntry('calendarAvailability', './assets/js/calendarAvailability.js')
    .addEntry('settings', './assets/js/settings.js')
    .addEntry('landing', './assets/js/landing.js')
    .addEntry('reports', './assets/js/reports.js')
    .addEntry('mail', './assets/js/mail.js')
    .addEntry('landing2', './assets/js/landing2.js')
    .addEntry('signin', './assets/js/signin.js')
    .addEntry('signup', './assets/js/signup.js')

    // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
    .splitEntryChunks()

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .enableSingleRuntimeChunk()

    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .cleanupOutputBeforeBuild()
    //.enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // enables @babel/preset-env polyfills
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = 3;
    })

    // enables Sass/SCSS support
    .enableSassLoader()

    // uncomment if you use TypeScript
    //.enableTypeScriptLoader()

    // uncomment to get integrity="..." attributes on your script & link tags
    // requires WebpackEncoreBundle 1.4 or higher
    //.enableIntegrityHashes(Encore.isProduction())

    // uncomment if you're having problems with a jQuery plugin
    .autoProvidejQuery()

    // uncomment if you use API Platform Admin (composer req api-admin)
    //.enableReactPreset()
    //.addEntry('admin', './assets/js/admin.js')

;

module.exports = Encore.getWebpackConfig();

/*
var config = Encore.getWebpackConfig();
config.module.rules[3].options.publicPath = './';

module.exports = config;
*/
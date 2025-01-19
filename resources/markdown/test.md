Le fichier `AppServiceProvider` est souvent vu comme un simple bout de code qu'on configure au début d'un projet,
puis qu'on oublie. Pourtant, c'est un des fichiers les plus importants pour gérer correctement une application Laravel.
Si tu veux organiser ton code, centraliser certaines configurations, ou même ajouter des fonctionnalités globales, c'est
ici que tout se passe.

Dans cet article, je vais te montrer pourquoi l'`AppServiceProvider` mérite plus d'attention, et comment tu peux vraiment
l'exploiter pour rendre ton application plus propre et performante.

# Comprendre le rôle de l'AppServiceProvider

L’`AppServiceProvider` est un fichier généré par défaut quand tu crées un projet Laravel. Il se trouve dans le répertoire
`app/Providers` et contient deux méthodes principales : `register` et `boot`. Ces deux méthodes sont utilisées pour
initialiser les services ou configurer des aspects globaux de l’application.

## La méthode `register()`

La méthode `register` est utilisée pour enregistrer des services dans le conteneur d’injection de dépendances. C’est ici
que tu ajoutes des bindings ou singleton que tu veux rendre accessibles partout dans ton application.

Voici un exemple :

```php
public function register(): void
{
    $this->app->singleton(MyAwesomeService::class, function ($app) {
        return new MyAwesomeService();
    });
}
```

Ici, on enregistre une classe `MyAwesomeService` comme un singleton. Ça veut dire que Laravel va créer
une **seule instance de cette classe**, et la partager partout où elle est injectée.

## La méthode `boot()`

La méthode `boot`, quant à elle, est appelée après que tous les services aient été enregistrés. C’est ici que tu peux
exécuter des actions nécessitant que tout soit déjà chargé, comme définir des règles de validation personnalisées,
configurer des vues ou encore écouter des événements.

Voici un exemple :

```php
use Illuminate\Support\Facades\Schema;

public function boot(): void
{
    Schema::defaultStringLength(191);
}
```

Dans cet exemple, si vous utilisez MySQL et que vous rencontrez des problèmes avec
les longueurs de chaînes, vous pouvez définir une longueur par défaut.

# Protéger contre les Commandes Destructrices

Lorsque vous travaillez sur une application, il est essentiel de protéger votre base de données, surtout en production.
Avec l'option `APP_ENV=production`, cette protection empêche les commandes dangereuses de s'exécuter et de risquer
d'endommager vos données. En revanche, pendant le développement, il n'y a aucune raison de vous en soucier,
car des commandes comme `db:wipe`, `migrate:fresh`, `migrate:refresh` ou `migrate:reset` sont souvent utilisées pour
tester, réinitialiser ou nettoyer la base de données.

## Logique métier

Laravel nous offre une **Facade** nommée `Illuminate\Support\Facades\DB`, qui contient une méthode statique appelée
`prohibitDestructiveCommands()`. Cette méthode prend un paramètre de type **boolean**. Heureusement, notre
**AppServiceProvider** hérite de **AppServiceProvider**, ce qui nous permet d'accéder à `$app`, une référence à l'application.
Cela nous permet d'utiliser `isProduction()` pour savoir si nous sommes en environnement de production.

Voici comment vous pouvez l'intégrer dans votre **AppServiceProvider** :

```php
$this->app->isProduction() // return: true or false
```

Une fois cette logique en place, il suffit de passer la valeur retournée par `isProduction()` dans
`DB::prohibitDestructiveCommands()`. Ainsi, en production, les commandes dangereuses seront bloquées.

Dans le `boot()` de votre AppServiceProvider, appelez la méthode `configureCommands()` comme suit :

```php
use Illuminate\Support\Facades\DB;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureCommands();
    }

    /**
    * Configure the application's commands.
    */
    private function configureCommands(): void
    {
        DB::prohibitDestructiveCommands(
            $this->app->isProduction()
        );
    }
}
```

Avec cette configuration, vous êtes désormais protégé contre les commandes destructrices, et vous pouvez poursuivre
avec la configuration des dates !

# Rendre les Dates Immuables

Lorsqu'on travaille avec des dates dans Laravel, on utilise souvent la librairie [Carbon](https://carbon.nesbot.com/), qui peut poser un problème
silencieux. En effet, après quelques tests, il semble que les dates soient par défaut
[mutables](https://stackoverflow.com/questions/67536245/datetimeimmutable-vs-datetime) dans Laravel, ce qui peut
entraîner des comportements inattendus.

> Ce n’est que mon avis, bien sûr. Vous n'êtes pas obligé d’adopter cette approche, mais personnellement, je pense que
les dates dans Laravel devraient être immuables par défaut.

## Exemple du Problème

Prenons un modèle avec deux colonnes `starts_at` et `ends_at`, toutes deux instanciées en `Carbon\Carbon`. Imaginons
qu'on définisse une variable `$now`, qui contient la date et l'heure actuelles, et qu'on ajoute sept jours pour `ends_at`.

```php
$now = now();

$data = [
    'starts_at' => $now,
    'ends_at' => $now->addDays(7),
];

dd(
    $data['starts_at']->format('d-m-Y'), // 24-01-2025
    $data['ends_at']->format('d-m-Y'), // 24-01-2025
);
```

Lorsque vous utilisez `dd()` pour afficher `$data`, vous remarquerez un petit problème : les deux dates, `starts_at` et
`ends_at`, affichent exactement la même date (+7 jours), ce qui n'est pas ce qu'on attendait. En revanche, votre
modèle aura les bonnes données.

## Solution

Pour corriger ce problème, nous pouvons utiliser la **Facade** `Illuminate\Support\Facades\Date` et lui
indiquer de toujours utiliser `CarbonImmutable::class` par défaut, une version immuable de Carbon.

Voici comment faire dans votre **AppServiceProvider** :

```php
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureDates();
    }

    /**
    * Configure the application's dates.
    */
    private function configureDates(): void
    {
        Date::use(CarbonImmutable::class);
    }
}
```

Maintenant, si vous retournez dans votre `dd()`, vous verrez que les dates sont correctement

```php
dd(
    $data['starts_at']->format('d-m-Y'), // 17-01-2025
    $data['ends_at']->format('d-m-Y'), // 24-01-2025
);
```

Avec ça, vous êtes prêt à passer à la configuration des modèles !

# Models

Je sais que certains ne seront pas d'accord avec moi sur ce point, mais après plusieurs années à
travailler avec Laravel, je ne jure plus par le fameux `$fillables = [];` que Laravel recommande par défaut.
Pour moi, c'est un vrai gain de temps de ne plus avoir à le gérer à chaque nouvelle application.
Bien sûr, vous êtes libre de passer cette étape si vous ne souhaitez pas désactiver le `$fillables = [];`
et ne pas avoir à ajouter `$guarded = [];` dans chaque modèle.

## Should be Strict!

Dans mon approche, les modèles doivent être stricts par défaut. Voici un exemple concret :

```php
$user = User::find(1);
$user->propertyDoesntExist;
```

Si vous utilisez l'implémentation standard de Laravel, il va lancer une exception pour vous indiquer que la propriété
`propertyDoesntExist` n'existe pas dans le modèle `User`. C'est un bon moyen de détecter les erreurs rapidement !

Pour forcer cette approche dans votre application, vous pouvez ajouter ce bout de code dans votre **AppServiceProvider** :

```php
use Illuminate\Database\Eloquent\Model;

Model::shouldBeStrict(! $this->app->isProduction());
```

## Désactiver le Mass Assignment

Je veux maintenant parler de la gestion du [Mass Assignment](https://laravel.com/docs/11.x/eloquent#mass-assignment) dans Laravel, qui est super pour les
débutants, mais qui peut devenir un peu contraignant lorsque l'on est déjà bien rodé avec le
framework. Après six ans de pratique, j'ai trouvé que c'était plus un frein qu'autre chose
pour travailler vite et efficacement.

> Si vous ne souhaitez pas appliquer cette fonctionnalité, vous pouvez passer cette étape.

Voici comment désactiver le mécanisme de **Mass Assignment** :

```php
use Illuminate\Database\Eloquent\Model;

Model::unguard();
```

Il suffit de retirer celui que vous ne voulez pas utiliser.

## Mettre les deux en place

Si vous voulez appliquer à la fois les modèles stricts et désactiver le **Mass Assignment**,
vous pouvez configurer cela dans votre **AppServiceProvider** :

```php
use Illuminate\Database\Eloquent\Model;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureModels();
    }

    /**
    * Configure the application's models.
    */
    private function configureModels(): void
    {
        Model::shouldBeStrict(! $this->app->isProduction());
        Model::unguard();
    }
}
```

Maintenant, vous êtes prêt à passer à la configuration des mots de passe !

# Validation des Mots de Passe

La validation des mots de passe est un élément que je configure très souvent dans mes projets.
Par défaut, Laravel propose une règle de mot de passe assez basique, qui peut ne pas suffire à
garantir la sécurité des utilisateurs dans des applications plus sérieuses. En fonction du
contexte de votre application, je préfère qu'ils soient plus robustes.

## Pourquoi c'est important ?

Pour moi, selon l'environnement de l'application, il est important de configurer des
règles strictes sur les mots de passe en production, tout en gardant une certaine
souplesse en développement. En production, l'objectif est de garantir qu'aucun mot
de passe faible ou compromis ne puisse être utilisé, tandis qu'en développement,
la rigueur peut être réduite pour faciliter les tests.

## Logique métier

Voici comment j'implémente cela dans mon **AppServiceProvider**. J'utilise la
**Facade** `Illuminate\Validation\Rules\Password` pour définir la règle de validation
des mots de passe, et je fais en sorte que cette règle soit conditionnée par
l'environnement de l'application (production ou développement).

```php
use Illuminate\Validation\Rules\Password;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configurePasswordValidation();
    }

    /**
    * Configure the application's password validation.
    */
    private function configurePasswordValidation(): void
    {
        Password::defaults(
            fn () => $this->app->isProduction()
                ? Password::min(8)->uncompromised()
                : null
        );
    }
}
```

Vous êtes maintenant prêt à passer à la configuration du schéma HTTPS !

# Forcer le Schéma HTTPS

Pour moi, le HTTPS est une nécessité absolue, même en local. Travailler exclusivement
avec le HTTPS est devenu une habitude, car cela simplifie les choses et assure une
certaine cohérence dans les environnements de développement et de production.
J’utilise principalement [Laravel Herd](https://herd.laravel.com/windows) en local, ce qui me permet d'activer facilement
le HTTPS sur mes projets sans avoir à me soucier de configurations supplémentaires.

Dans la logique de sécuriser toutes les connexions, que ce soit pour les utilisateurs
ou pour l’application elle-même, je m’assure toujours de forcer l'utilisation du schéma
HTTPS, même dans mon environnement de développement. Cela permet d'éviter toute confusion
et garantit que toutes les communications sont cryptées dès le début.

## Logique métier

Voici comment je configure cela dans mon **AppServiceProvider** pour forcer l'utilisation
du schéma HTTPS dans toute l'application, quel que soit l'environnement (local ou production) :

```php
use Illuminate\Support\Facades\URL;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureUrls();
    }

    /**
    * Configure the application's URLs.
    */
    private function configureUrls(): void
    {
        URL::forceScheme('https');
    }
}
```

Cela garantit que votre application est prête pour un environnement sécurisé
dès le départ. Vous êtes maintenant prêt à passer à la configuration de Vite pour vos assets !

# Utiliser le Prefetching Aggressive pour Vite

Laravel 11 a introduit une fonctionnalité très intéressante : __la possibilité de
simplifier vos assets en un seul fichier grâce à Vite__. Cette nouvelle fonctionnalité
peut grandement améliorer les performances de votre application, notamment en
réduisant le nombre de requêtes HTTP nécessaires pour charger vos assets.

## Logique métier

Voici comment activer cette fonctionnalité dans votre application Laravel :

```php
use Illuminate\Support\Facades\Vite;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureVite();
    }

    /**
    * Configure the application's Vite.
    */
    private function configureVite(): void
    {
        Vite::useAggressivePrefetching();
    }
}
```

Merci d'avoir suivi cet article jusqu'au bout.

# Votre AppServiceProvider désormais

Voici le fichier complet avec toutes les configurations réunies. Il permet
de configurer l'application avec les bonnes pratiques que nous avons
abordées dans l'article :

```php
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Vite;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rules\Password;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureCommands();
        $this->configureDates();
        $this->configureModels();
        $this->configurePasswordValidation();
        $this->configureUrls();
        $this->configureVite();
    }

    /**
    * Configure the application's commands.
    */
    private function configureCommands(): void
    {
        DB::prohibitDestructiveCommands(
            $this->app->isProduction()
        );
    }

    /**
    * Configure the application's dates.
    */
    private function configureDates(): void
    {
        Date::use(CarbonImmutable::class);
    }

    /**
    * Configure the application's models.
    */
    private function configureModels(): void
    {
        Model::shouldBeStrict(! $this->app->isProduction());
        Model::unguard();
    }

    /**
    * Configure the application's password validation.
    */
    private function configurePasswordValidation(): void
    {
        Password::defaults(
            fn () => $this->app->isProduction()
                ? Password::min(8)->uncompromised()
                : null
        );
    }

    /**
    * Configure the application's URLs.
    */
    private function configureUrls(): void
    {
        URL::forceScheme('https');
    }

    /**
    * Configure the application's Vite.
    */
    private function configureVite(): void
    {
        Vite::useAggressivePrefetching();
    }
}
```

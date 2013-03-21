XabenForumBundle
================

Basic Symfony2 Forum Bundle.

This is not a working forum bundle yet!

Installation
------------

Download XabenForumBundle and its dependencies to the ``vendor`` directory. You
can use Composer for the automated process:

```console
php composer.phar require xaben/forum-bundle --no-update
php composer.phar update
```

Next, be sure to enable the bundle in your AppKernel.php file:

```php
// app/AppKernel.php
public function registerBundles()
{
    return array(
        // ...
        new Xaben\ForumBundle\XabenForumBundle(),
        // ...
    );
}
```

Now, install the assets from the bundle:

```console
php app/console assets:install web
```

Import the forum routes into your routing file:

```yaml
# app/config/routing.yml
xaben_forum:
    resource: "@XabenForumBundle/Resources/config/routing.yml"
    prefix:   /forum
```

Usually when installing new bundles it's good practice to also delete your cache:

```console
php app/console cache:clear
```

Enable assetic for the forum bunlde:
```yaml
assetic:
    # ....
    bundles:        [ XabenForumBundle ]
```


Configure FOSUserBundle then link your user entity to the user interface:
```yaml
# app/config/config.yml
doctrine:
    # ....
    orm:
        # ....
        resolve_target_entities:
            FOS\UserBundle\Model\UserInterface: Acme\AppBundle\Entity\User
```

Now create or update database schema:

```console
php app/console doctrine:schema:update
```
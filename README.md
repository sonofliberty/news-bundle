# news-bundle

Symfony bundle with simple blog / publishing features

## Installation

1. Install via composer
    
    `composer require sonofliberty/news-bundle`

2. Enable bundle

    ```php
    // app/AppKernel.php
 
    public function registerBundles()
    {
        return array(
            // ...
            new SonOfLiberty\NewsBundle\SonOfLibertyNewsBundle(),
            new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(), // needed for translations
            // ...
        );
    }
    ```

3. Configuration

    ```yml
    # app/config/config.yml
    
    son_of_liberty_news:
        author:
            class: Acme\AcmeBundle\Entity\User # optional
    ```
    
4. Import routing

    ```yml
    # app/config/routing.yml
    
    son_of_liberty_news:
        prefix: /news
        resource: '@SonOfLibertyNewsBundle/Resources/config/routing.yaml'
    ```
# B-SHOP 
## What's B-SHOP?
It's a project with my friend Peter for a competition named SOČ.  
It's written using PHP framework **Symfony** and templating framework named **Twig**.



<h2>Reset/Update of database</h2>
<ol>
    <li>
    <code>
    php bin/console doctrine:database:drop --force
    </code>
    </li>
    <li>
    <code>
    php bin/console doctrine:database:create
    </code>
    </li>
    <li>
    <code>
    php bin/console doctrine:schema:update --force
    </code>
    </li>
    <li>
    <code>
    php bin/console doctrine:fixtures:load --group=main1 --group=main2 --group=main3 --append
    </code>
    </li>
    <li>
    <code>
    php bin/console doctrine:fixtures:load --group=second --append
    </code>
    </li>
</ol>
        

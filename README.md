#Eshop Temp by Brano&Peter
<h3>
Návod na použitie git:</h3>
Predtým než začneš upravovať sa uisti že si v branchy develop <code>git checkout develop</code>
<ol>
    <li><code>git pull origin develop</code></li>
    <li>*Ak nastane merge conflict:<br>
        <code>Auto-merging readme.txt<br>
        CONFLICT (content): Merge conflict in readme.txt<br>
        Automatic merge failed; fix conflicts and then commit the result.
        </code><br>
        &emsp;Potom musíš vojsť do daného súboru a tam si upravíš čo chceš nechať a čo nie. <br>
        &emsp;Tieto rozdiely sú oddelené pomocou <<<<<<< ďalej rozdiel je oddelený ====== a koniec <br> 
        &emsp;zmeny je >>>>>>> tam si vyber čo chceš ponechať a potom tie šípky a rovnása vymaž.<br>
    </li>
    <li>
    Ak nenastane môžeš začať upravovať
    </li>
    <li>Potom musíš pridať zmeny: <code>git add .</code></li>
    <li>Potom spravíš commit s odkazom: <code>git commit -m"Sprava sprava spravicka"</code></li>
    <li>Následne pushnes zmeny do repozitára: <code>git push origin develop</code></li>
</ol>
<h2>Reset db</h2>
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
        
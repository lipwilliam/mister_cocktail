<h1>Cocktails Page</h1>

<?php if ($user = Session::getLogged()) : ?>
    <?= $user['name'] . ' a accès aux fonctionnalités d\'ajout de cocktails : ' ?>
    <a href="index.php?page=add_cocktail" class="btn btn-info">Ajouter un cocktail</a>
<?php endif; ?>

<!-- Afficher la liste des cocktails présent en bdd -->
<div class="row">
    <?php foreach ($params as $cocktail) : ?>
        <div class="card" style="width: 18rem;">
            <img src="templates/www/img/<?= $cocktail['picture'] ?>" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title"><?= ucfirst($cocktail['name']) ?></h5>
                <p class="card-text"><?= $cocktail['content'] ?></p>
            </div>
            <div class="card-body">
                <a href="#" class="card-link">See More</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>
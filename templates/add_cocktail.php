<h1>Cocktails Page d'ajout</h1>

<?php if ($user = Session::getLogged()) : ?>
    <?= ucfirst($user['name']) . ' peut ajouter un cocktail' ?>
    <!-- ucfirst met le premier caractère en majuscule -->
<?php endif; ?>

<!-- Afficher la liste des cocktails présent en bdd -->
Formulaire d'ajout de Cocktail

<!-- un nom, un alcohol, 2-3 ingrédients -->
<form action="index.php?page=add_cocktail" method='post' enctype="multipart/form-data">
    <?php if (isset($params['error'])) : ?>
        <p class="alert alert-danger">
            <?= $params['error'] ?>
        </p>
    <?php endif; ?>
    <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Nom du cocktail</label>
        <input type="text" class="form-control" id="exampleFormControlInput1" name='name' placeholder="Nom du cocktail">
    </div>
    <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">Description - Origine</label>
        <textarea class="form-control" id="exampleFormControlTextarea1" name='content' rows="3"></textarea>
    </div>
    <div class="mb-3">
        <label for="formFile" class="form-label">Choisir une photo du cocktail (format : png, jpeg, jpg)</label>
        <input class="form-control" type="file" name='picture' id="formFile">
    </div>

    <!-- Autre champs de la table cocktail -->
    <select name="alcohol_id" class="form-select" aria-label="Default select example">
        <option selected>Choisissez l'alcool principal</option>
        <?php foreach ($params['alcohols'] as $alcohol) : ?>
            <option value="<?= $alcohol['id'] ?>"><?= $alcohol['name'] ?></option>
        <?php endforeach; ?>
    </select>

    <div class="row">
        Liste des ingrédients :
        <?php foreach ($params['ingredients'] as $ingredient) : ?>
            <div class="form-check form-check-inline">
                <input class="form-check-input" name='ingredients[]' type="checkbox" id="inlineCheckbox1" value="<?= $ingredient['id'] ?>">
                <label class="form-check-label" for="inlineCheckbox1"><?= $ingredient['name'] ?></label>
            </div>
        <?php endforeach; ?>
    </div>

    <input type="submit" class='btn btn-primary' value="Ajout">
</form>
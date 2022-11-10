<h1>Formulaire d'ajout d'un ingrédient</h1>

<form action="index.php?page=add_ingredient" method="post">
    <?php if (isset($params['error'])) : ?>
        <p class="alert alert-danger">
            <?= $params['error'] ?>
        </p>
    <?php endif; ?>
    <label for="ingredient">Nom d'Ingrédient</label>
    <input type="text" name='ingredient' id="ingredient">
    <button>Enregistrer</button>
</form>
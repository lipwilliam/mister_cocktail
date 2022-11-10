<h1>Formulaire d'ajout d'un alcool</h1>

<form action="index.php?page=add_alcohol" method="post">
    <?php if (isset($params['error'])) : ?>
        <p class="alert alert-danger">
            <?= $params['error'] ?>
        </p>
    <?php endif; ?>
    <label for="alcohol">Alcohol Name</label>
    <input type="text" name='alcohol' id="alcohol">
    <button>Enregistrer</button>
</form>
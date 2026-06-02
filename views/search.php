<!DOCTYPE html>
<html>
<head>
    <title>Recherche Médecin</title>
</head>
<body>

<h2>Rechercher un médecin</h2>

<form method="GET">
    <input type="text" name="search" placeholder="Nom ou spécialité">
    <button type="submit">Rechercher</button>
</form>

<?php if(!empty($medecins)): ?>

    <h3>Résultats :</h3>

    <?php foreach($medecins as $medecin): ?>

        <p>
            <?= $medecin['name'] ?>
            -
            <?= $medecin['nom'] ?>
        </p>

    <?php endforeach; ?>

<?php endif; ?>

</body>
</html>
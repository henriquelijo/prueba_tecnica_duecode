<?php
$teamId = $_GET['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Equipo</title>
    <link rel="stylesheet" href="./team_view.css">
</head>
<body>
    <header class="container_details_title">
        <h1>Detalles del Equipo</h1>
    </header>
    <main class="main-content">
        <section class="team-details">
            <h2><?php echo $team->getName(); ?></h2>
            <p><strong>Ciudad:</strong> <?php echo $team->getCity(); ?></p>
            <p><strong>Deporte:</strong> <?php echo $team->getSport(); ?></p>
            <p><strong>Descripción:</strong> <?php echo $team->getDescription(); ?></p>
            <p><strong>Fecha de Fundación:</strong> <?php echo $team->getDateFundation(); ?></p>
            <p><strong>Fecha de Creación:</strong> <?php echo $team->getDateCreated(); ?></p>
            <p><strong>Fecha de Actualización:</strong> <?php echo $team->getDateUpdated(); ?></p>
        </section>
    </main>
</body>
</html>
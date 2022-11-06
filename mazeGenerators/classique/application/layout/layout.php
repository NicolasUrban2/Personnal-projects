<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="css/w3.css">
        <title>Maze generator</title>
    </head>
    <body>
        <header class="w3-container w3-blue">
            <?php include "application/view/backHome.php"; ?>
            <div class="w3-row">
                <h1 class=" w3-container w3-wide">Maze generator</h1>
                <h4 class="w3-container w3-opacity">By Nicolas Urban</h4>
            </div>
        </header>
        <article>
            <section class="w3-row">
                <div class="w3-third w3-card w3-container">
                    <?php include 'application/view/formulaire.php' ?>
                </div>
                <div class="w3-twothird w3-card w3-container w3-display-container">
                    <?php include $template_view; ?>
                </div>
            </section>
        </article>
    </body>
</html>
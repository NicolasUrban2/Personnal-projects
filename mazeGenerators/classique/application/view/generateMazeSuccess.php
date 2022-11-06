<?php
    $file = fopen("mazeSoluceOn.svg", "w");
    fwrite($file, $context->maze->buildSVG(true));
    fclose($file);
    $file = fopen("mazeSoluceOff.svg", "w");
    fwrite($file, $context->maze->buildSVG(false));
    fclose($file);
?>
<div class="w3-container">
    <?php include 'application/view/showMaze.php'; ?>
</div>


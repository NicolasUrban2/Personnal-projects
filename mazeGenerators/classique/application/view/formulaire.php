<form action="" method="post">
    <div>
        <div>
        <label class="w3-margin">Width :</label>
        <input class="w3-input" type="text" name="tailleX"><br>
        </div>
        <div>
        <label class="w3-margin">Height :</label>
        <input class="w3-input" type="text" name="tailleY"><br>
        </div>
        <div>
        <label class="w3-margin">Stages number :</label>
        <input class="w3-input" type="text" name="tailleZ"><br>
        </div>
        <div>
        <label class="w3-margin">Entry coordinates X :</label>
        <input class="w3-input" type="text" name="coordX"><br>
        </div>
        <div>
        <label class="w3-margin">Entry coordinates Y :</label>
        <input class="w3-input" type="text" name="coordY"><br>
        </div>
        <div>
        <label class="w3-margin">Entry coordinates Z :</label>
        <input class="w3-input" type="text" name="coordZ"><br>
        </div>
        <div>
        <label class="w3-margin">Cell sizes in pixels (between 10 and 100):</label>
        <input placeholder="80" class="w3-input" type="text" name="cellSize"><br>
        </div>
    </div>
    <div class="w3-container"> 
        <button class="w3-center w3-button" type="submit" name="action" value="generateMaze">Generate</button>
    </div>
</form>
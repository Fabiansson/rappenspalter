<div>

        <?php if(isset($_SESSION['error'])){
            echo '<div class="alert alert-danger">';
            echo $error;
            echo '</div>';
        }
        if(($_SESSION['user']->mntlAusgaben) == 0 || ($_SESSION['user']->mntlEinnahmen) == 0){
            echo '<div class="alert alert-success schrift text-center">Willkommen! Um loszulegen, gehen Sie ins <a href="/haushalt/Menu">Menu</a> um Ihre fixen Ein- und Ausgaben einzutragen!</div>';
        }

        ?>

    <div>
        <div id="guthaben">
            <p><?= $guthaben ?> CHF</p>
        </div>
        <div class="schrift">
            <p> Tagesbudget: <?= $tagesbudget ?></p>
        </div>
        <div class="schrift">
            <p> Verlauf: </p>
            <?php echo '<p>';
            echo $verlauf;
            echo '</p>'; ?>
        </div>
        <form method="post" action="/haushalt/add">
            <div class="row">
                <div class="col-md-4 form-check">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="auswahl" value="ausgaben" onclick="showDropdown();" required>Ausgaben
                    </label>
                </div>
                <div class="col form-check">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="auswahl" value="einnahmen" onclick="hideDropdown();">Einnahmen
                    </label>
                </div>

                <div>
                    <div>
                        <input type="text" class="form-control" name="wert" placeholder="CHF" required>
                    </div>
                    <div class="form-group" id="statusForm">
                        <select class="form-control" id="exampleSelect1" name="kategorie">
                            <option value="1">Sonstiges</option>
                            <option value="2">Essen & Trinken</option>
                            <option value="3">Transport</option>
                            <option value="4">Bekleidung</option>
                            <option value="5">Freizeit</option>
                        </select>
                    </div>
                    <div>
                        <input id="add" name="add" type="submit" class="btn btn-normal" value="+">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

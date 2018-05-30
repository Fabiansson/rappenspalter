<div>

        <?php if(isset($_SESSION['error'])){
            echo '<div class="alert alert-danger">';
            echo $error;
            echo '</div>';
        }?>

    <div>
        <div id="guthaben">
            <p>
                <?= $guthaben ?> CHF
            </p>
        </div>
        <div class="schrift">
            <p> Budget für Heute: <?= $tagesbudget ?></p>
        </div>
        <div class="schrift">
            <p> Letzte Ausgaben: </p>
        </div>
        <form method="post" action="/haushalt/add">
            <div class="row">
                <div class="col-md-4 form-check">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="auswahl" value="ausgaben">Ausgaben
                    </label>
                </div>
                <div class="col form-check">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="auswahl" value="einnahmen">Einnahmen
                    </label>
                </div>

                <div>
                    <div>
                        <input type="text" class="form-control" name="wert" value="CHF">
                    </div>
                    <div class="form-group">
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

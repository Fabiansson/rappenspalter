<div>
    <div>

        <h1> Willkommen <?= $name ?><br></h1>

        <p>
            Guthaben: <?= $guthaben ?>
        </p>
    </div>
<<<<<<< HEAD

    <div>

        <div>
            <p> Budget für Heute: <?= $tagesbudget ?></p>
        </div>
        <div>
            <p> Letzte Ausgaben: </p>
        </div>
        <form method="post" action="">
            <div class="row">
                <div class="col-md-4 form-check">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="auswahl">Ausgaben
                    </label>
                </div>
                <div class="col form-check">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="auswahl" value="einnahmen">Einnahmen
                    </label>
                </div>
=======
    <div class="row">
        <p> Letzte Ausgaben: </p>
    </div>
    <form method="post" action="">
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
        </div>

        <div class="row">
            <div class="col-md-3">
                <input type="text" name="wert" placeholder="CHF">
            </div>
            <div class="col-md-3 dropdown" >
                <button class="btn dropdown-toggle" type="button" data-toggle="dropdown" id="kategorie">Kategorie
                    <span class="caret"></span></button>
                <ul class="dropdown-menu">
                    <li><a href="#">Sonstiges</a></li>
                    <li><a href="#">Essen & Trinken</a></li>
                    <li><a href="#">Transport</a></li>
                    <li><a href="#">Bekleidung</a></li>
                    <li><a href="#">Freizeit</a></li>
                    <li><a href="#">Geschenke</a></li>
                </ul>
>>>>>>> bdad243b43244ea803e79cdf2b1fcc49bb8f7c44
            </div>

            <div >
                <div>
                            <input type="text" class="form-control" name="chf" value="CHF">
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
                        <div >
                            <input id="add" name="add" type="submit" class="btn" value="+">
                        </div>
                    </div>
                </form>
            </div>
</div>

<!--
            <div class="row">
                <div class="col-md-3">
                    <input type="text" name="ausgabe" placeholder="CHF">
                </div>
                <div class="col-md-3 dropdown">
                    <button class="btn dropdown-toggle" type="button" data-toggle="dropdown" id="kategorie">Kategorie
                        <span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <li><a href="#">Sonstiges</a></li>
                        <li><a href="#">Essen & Trinken</a></li>
                        <li><a href="#">Transport</a></li>
                        <li><a href="#">Bekleidung</a></li>
                        <li><a href="#">Freizeit</a></li>
                        <li><a href="#">Geschenke</a></li>
                    </ul>
                </div>
                <div class="col">
                    <input id="add" name="add" type="submit" class="btn" value="+">
                </div>
            </div>
    </div>

    </form>
</div>
</div>
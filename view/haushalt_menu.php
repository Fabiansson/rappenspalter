<div>
    <?php if(isset($_SESSION['error'])){
        echo '<div class="alert alert-danger">';
        echo $error;
        echo '</div>';
        $_SESSION['error'] = "";
    }?>
</div>

<div>
    <form method="post" action="/haushalt/setFinance">
        <div>
            <div>
                <label for="username">Fixe Einnahme</label>
                <input type="number" class="form-control" name="fixE" value="<?= $mntlEinnahmen ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Fixe Ausgaben</label>
                <input type="number" class="form-control" name="fixA" value="<?= $mntlAusgaben ?>" required>
            </div>
            <div>
                <input type="submit" name="menuSubmit" value="OK" class="btn btn-normal">
            </div>
        </div>
    </form>
<form method="post" action="/haushalt/delete">
    <input type="submit" name="delete" value="Account Löschen" class="btn btn-danger" onclick="return confirm('Alle Ihre Daten werden gelöscht, sind Sie sicher?');">
</form>

</div>

</div>


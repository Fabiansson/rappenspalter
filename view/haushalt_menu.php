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
<div id="deleteButton">
    <a href="/haushalt/delete" class="btn btn-danger">Account Löschen</a>
</div>

</div>


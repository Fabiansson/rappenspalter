<div>
    <form method="post" action="/haushalt/setFinance">
        <div>
            <div>
                <label for="username">Fixe Einnahme</label>
                <input type="text" class="form-control" name="fixE" value="<?= $mntlEinnahmen ?>">
            </div>
            <div class="form-group">
                <label for="password">Fixe Ausgaben</label>
                <input type="text" class="form-control" name="fixA" value="<?= $mntlAusgaben ?>">
            </div>
            <div>
                <input type="submit" name="menuSubmit" value="OK" class="btn btn-normal">
            </div>
        </div>
    </form>
<div id="deleteButton">
    <a href="/user/delete" class="btn btn-danger">Account Löschen</a>
</div>

</div>


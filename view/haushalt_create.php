<div>
    <?php if(isset($_SESSION['error'])){
        echo '<div class="alert alert-danger">';
        echo $error;
        echo '</div>';
        $_SESSION['error'] = "";
    }?>
</div>
<div>
    <form method="post" action="/haushalt/doCreate">
        <div>
            <div>
                <div>
                    <label for="username">Haushalt</label>
                    <input type="text" class="form-control" name="username" placeholder="Name" required>
                </div>
                <div>
                    <label for="email">Mail</label>
                    <input type="email" class="form-control" name="mail" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <label for="password">Passwort</label>
                    <input type="password" class="form-control" name="password" placeholder="PW" required>
                </div>
                <div>
                    <input type="submit" name="signup" value="Erstelllen" class="btn btn-normal">
                    <div class="g-recaptcha" data-sitekey="6LdRS1wUAAAAAOlNJoIH77JXW2kv0txiqAy43gVp"></div>
                </div>
            </div>
        </div>
    </form>

    <div class="abstand">
        <a href="/haushalt">Zurück</a>
    </div>
</div>

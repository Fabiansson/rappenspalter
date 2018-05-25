<div>
    <!-- Main Form -->
    <div>
        <form method="post" action="/haushalt/login">
            <div>
                <div>
                    <div>
                        <label for="username">Haushalt</label>
                        <input type="text" class="form-control" name="username" placeholder="Name" required>
                    </div>
                    <div>
                        <label for="password">Passwort</label>
                        <input type="password" class="form-control" name="password" placeholder="PW" required>
                    </div>
                    <div>
                        <input type="submit" name="login" value="Log in!" class="btn btn-normal">
                    </div>
                </div>
            </div>
        </form>
        <div class="abstand">
            <p><a href="#">Passwort vergessen?</a></p>
            <p><a href="/haushalt/create">Neuer Haushalt?</a></p>
        </div>
    </div>

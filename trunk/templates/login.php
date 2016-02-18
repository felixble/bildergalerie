<div class="container">

    <form class="form-signin" action="" method="post">
        <h2 class="form-signin-heading">Bitte anmelden</h2>
        <label for="inputUser" class="sr-only">Benutzername</label>
        <input type="text" id="inputUser" name="inputUser" class="form-control" placeholder="Benutzername" required autofocus />
        <label for="inputPassword" class="sr-only">Passwort</label>
        <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Passwort" required />
        <!--<div class="checkbox">
            <label>
                <input type="checkbox" value="remember-me"> Logindaten 4 Wochen merken
            </label>
        </div>-->
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit_login">Anmelden</button>
        <a href="<?php echo $this->url(); ?>" class="btn btn-lg btn-danger btn-block">Abbrechen</a>
    </form>

</div>

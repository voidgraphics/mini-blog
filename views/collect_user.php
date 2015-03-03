<form action="index.php?a=check&e=users" method="POST">
    <div>
        <label for="username">Nom d'utilisateur</label>
        <input type="text" id="username" name="username"/>
        <label for="password">Mot de passe</label>
        <input type="password" id="password" name="password"/>

        <input type="hidden" name="a" value="check"/>
        <input type="hidden" name="e" value="users"/>

        <input type="submit"/>
    </div>
</form>
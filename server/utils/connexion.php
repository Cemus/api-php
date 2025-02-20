<?php

/**
 * @return PDO
 */
function connexion(): PDO
{
    return new PDO(
        'mysql:host=' . URL_BDD . ';dbname=' . NAME_BDD,
        LOGIN_BDD,
        PASSWORD_BDD,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
}

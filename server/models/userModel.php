<?php

class UserModel{
    function addUser(PDO $bdd, array $user): void {
        try{
            $requete = "INSERT INTO user(alias, email, `password`)
            VALUE(?,?,?)";
            $req = $bdd->prepare($requete);
            $req->bindParam(1,$user["alias"], PDO::PARAM_STR);
            $req->bindParam(2,$user["email"], PDO::PARAM_STR);
            $req->bindParam(3,$user["password"], PDO::PARAM_STR);
            $req->execute();
        }
        catch(Exception $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }

    function getUserByEmail(PDO $bdd, string $email): array|null {
        try {
            $requete = "SELECT id_user, alias, email FROM user
            WHERE email = ?";
            $req = $bdd->prepare($requete);
            $req->bindParam(1,$email, PDO::PARAM_STR);
            $req->execute();
            $data = $req->fetch(PDO::FETCH_ASSOC);
            if (!$data){
                return null;
            }
            return $data;
        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
            return null;
        }
    }

    function getAllUsers(PDO $bdd): ?array{
        try {
            $requete = "SELECT id_user, alias, email FROM user";
            $req = $bdd->prepare($requete);
            $req->execute();
            $data = $req->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }
    
}


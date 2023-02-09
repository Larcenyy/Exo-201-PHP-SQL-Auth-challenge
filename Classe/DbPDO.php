<?php

class DbPDO
{
    private static string $server = 'localhost';
    private static string $username = 'root';
    private static string $password = '';
    private static string $database = 'test';
    private static ?PDO $db = null;

    public static function connect(): ?PDO {
        if (self::$db == null){
            try {
                self::$db = new PDO("mysql:host=".self::$server.";dbname=".self::$database, self::$username, self::$password);
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch (PDOException $e) {
                echo "Erreur de la connexion à la dn : " . $e->getMessage();
                die();
            }
        }
        return self::$db;
    }

    public static function showClient() {
        $request = self::$db->prepare("SELECT * FROM hiking ORDER BY id ASC");
        $check = $request->execute();
        if ($check){
            foreach ($request as $item){
                echo "<a href='./update.php?id=" . $item['id'] . "'>Nom : " . $item['name'] . "</a> " . 'ID : ' . $item['id'] . "     <a href='../delete.php?deleteId=" . $item["id"] . "' >❌  Supprimé</a>" . "<br>";
            }
        }
        else{
            echo "Une erreur est survenu..";
        }
    }

    public static function addRando() {
        $request = self::$db->prepare(" INSERT INTO hiking (name, difficulty, duration, height_difference)
        VALUES (:name, :difficulty, :duration, :height_difference)");

        $request->bindParam(":name", $_POST['name']);
        $request->bindParam(":difficulty", $_POST['difficulty']);
        $request->bindParam(":duration", $_POST['duration']);
        $request->bindParam(":height_difference", $_POST['height_difference']);

        $check = $request->execute();
        if ($check){
            echo "<div style='background: green; color: white; font-size: 20px'>Un randonneur à était ajouté avec succès</div>";
        }
    }

    public static function updateRando(): void
    {
        $request = self::$db->prepare("UPDATE hiking SET name = :name, difficulty = :difficulty, duration = :duration, height_difference = :height_difference WHERE id = :idRando");
        $request->bindParam(":name", $_POST['name']);
        $request->bindParam(":difficulty", $_POST['difficulty']);
        $request->bindParam(":duration", $_POST['duration']);
        $request->bindParam(":height_difference", $_POST['height_difference']);
        $request->bindParam(":idRando", $_GET['id']);

        $check = $request->execute();
        if ($check){
            echo "<div style='background: green; color: white; font-size: 20px'>Ce randonneur à était modifié avec succès</div>";
        }
    }


    public static function getHikerById($id) {
        $request = self::$db->prepare("SELECT * FROM hiking WHERE id = :id");
        $request->execute(['id' => $id]);
        $hiker = $request->fetch();
        if ($hiker) {
            return $hiker;
        } else {
            return false;
        }
    }

    public static function deleteHiker($id){
        $request = self::$db->prepare("DELETE FROM hiking WHERE id = :id");
        $request->execute(['id' => $id]);
        $hiker = $request->fetch();
        if ($hiker){
            return $hiker;
        }
        else {
            return false;
        }
    }


    public static function checkLogin(): void
    {
        $req = self::$db->prepare('SELECT password FROM user WHERE username = :username');

        $username = $_POST['username'] ?? '';
        $pass_form = $_POST['password'] ?? ''; // Récupère le mot de passe entré dans le formulaire

        $req->bindParam(':username', $username);

        password_hash($pass_form, PASSWORD_BCRYPT); // Step 2 on le fitlre
        //echo $password;

        if ($username && $pass_form){ // Check si les champs ont était trouver
            if($req->execute()) {
                $userData = $req->fetch(); // Met notre $req en tableaux assosiatif
                if (!empty($userData)){ // Va check si c'est vrai
                    if(password_verify($pass_form, $userData['password'])) { // Check si le mot de passe en clair > filtrer et égal aux mot de passe enregistrer dans la bdd
                        session_start(); // Démarrage de la session
                        $_SESSION["authentified"] = true;
                        $_SESSION['user_id'] = $username;
                        header('Location: ./bienvenue.php');

                    }
                    else {
                        echo ("Mot de passe incorrect pour l'utilisateur: " . $username);
                    }
                } else{
                    echo "Aucun utilisateur trouvé avec le nom d'utilisateur: " . $username;
                }
            }
            else {
                echo "Aucun compte associé à ce nom d'utilisateur";
            }
        }
        else {
            echo "Aucun champs trouver..";
        }
    }
}
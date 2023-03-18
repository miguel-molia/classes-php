
<?php
session_start();

class Userpdo
{

    private $id;
    public $login;
    private $password;
    public $email;
    public $firstname;
    public $lastname;

    protected $bdd;

    public function __construct()
    {
        $servername = 'localhost';
        $username = 'root';
        $password = 'root';

        try {
            $this->bdd = new PDO("mysql:host=$servername;dbname=classes", $username, $password);

            $this->bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo 'Connexion réussie';
        } catch (PDOException $e) {
            // echo "Erreur : " . $e->getMessage();
        }
    }

    public function register($login, $password, $email, $firstname, $lastname)
    {
        $insertUser = $this->bdd->prepare("INSERT INTO utilisateurs(login,password,email,firstname,lastname)VALUES(?,?,?,?,?)");
        $insertUser->execute([$login, $password, $email, $firstname, $lastname]);

        $recupUser = $this->bdd->prepare("SELECT * FROM utilisateurs WHERE login = ?");
        $recupUser->execute([$_SESSION['login']]);
        $result = $recupUser->fetchAll(PDO::FETCH_ASSOC);
        var_dump($result);
        return $result;
    }

    public function connect($login, $password)
    {
        $recupUser = $this->bdd->prepare("SELECT login,password FROM utilisateurs WHERE login = ? AND password = ?");
        $recupUser->execute([$login, $password]);

        if ($recupUser->rowCount() > 0) {
            echo 'utilisateurs trouvé<br>';
            $_SESSION['login'] = $login;
            $_SESSION['password'] = $password;
            // return $login = $this->login;
            // $password = $this->password;
        } else {
            echo "Inconnu";
        }
    }

    public function disconnect()
    {
        session_destroy();
    }

    public function delete()
    {
        $deleteUser = $this->bdd->prepare("DELETE FROM utilisateurs WHERE login = ?");
        $deleteUser->execute([$_SESSION['login']]);
        session_destroy();
        echo 'utilisateurs supprimés';
    }

    public function update($login, $password, $email, $firstname, $lastname)
    {
        $updateUser = $this->bdd->prepare("UPDATE utilisateurs SET login=?, password=?, email=?, firstname=?, lastname=? WHERE login = ?");
        $updateUser->execute([$login, $password, $email, $firstname, $lastname, $_SESSION['login']]);
    }

    public function isConnected()
    {
        if (isset($_SESSION['login'])) {
            // echo "Bonjour " . $_SESSION['login'];
            return true;
        } else {
            return false;
        }
    }

    public function getAllinfos()
    {
        $recupUser = $this->bdd->prepare("SELECT * FROM utilisateurs WHERE login = ?");
        $recupUser->execute([$_SESSION['login']]);
        $result = $recupUser->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function getLogin()
    {

        $recupUser = $this->bdd->prepare("SELECT login FROM utilisateurs WHERE login = ?");
        $recupUser->execute([$_SESSION['login']]);
        $result = $recupUser->fetchAll(PDO::FETCH_ASSOC);
        var_dump($result);

        return $result;
    }

    public function getEmail()
    {
        $recupUser = $this->bdd->prepare("SELECT email FROM utilisateurs WHERE login = ?");
        $recupUser->execute([$_SESSION['login']]);
        $result = $recupUser->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    public function getFirstname()
    {
        $recupUser = $this->bdd->prepare("SELECT firstname FROM utilisateurs WHERE login = ?");
        $recupUser->execute([$_SESSION['login']]);
        $result = $recupUser->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    public function getLastname()
    {
        $recupUser = $this->bdd->prepare("SELECT lastname FROM utilisateurs WHERE login = ?");
        $recupUser->execute([$_SESSION['login']]);
        $result = $recupUser->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
}
$newUser = new Userpdo();

// $newUser->register("admin", "mdp", "admin@admin.com", "Prenom", "Nom");
$newUser->connect("Update", "Update");
$newUser->disconnect();
// $newUser->delete();
// $newUser->update('Update', "Update", $test, $test, $test);
// $newUser->isConnected();
// $newUser->getAllinfos();
$newUser->getLogin();
// $newUser->getEmail();
// $newUser->getFirstname();
// $newUser->getLastname();
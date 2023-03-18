<?php
session_start();

class User
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

        // Variables declarée 
        $host = "localhost";
        $user_name = "root";
        $password_bdd = "";
        $database = "classes";

        // this fais référence à l'objet courant
        $this->bdd = new mysqli("$host", "$user_name", "$password_bdd", "$database");
        if (!$this->bdd) {
            die("Connexion lost");
            $message = "Connexion non trouvées";
        } else {
            $message = "Connexion établie a la bdd";
        }
        echo "<p>$message</p>";
    }

    // FUNCTION //

    // register
    public function register($login, $password, $email, $firstname, $lastname)
    {
        $insertUser = $this->bdd->query("INSERT INTO `utilisateurs` (`login`,`password`, `email`, `firstname`, `lastname`) VALUES ('$login','$password','$email','$firstname' ,'$lastname')");

        $recuptUser = $this->bdd->query("SELECT * FROM utilisateurs WHERE login = '" . $_SESSION['login'] . "'");
        $result = $recuptUser->fetch_all(MYSQLI_ASSOC);
        return $result;
    }
    // connect
    public function connect($login, $password)
    {
        $RecupUser = $this->bdd->query("SELECT * FROM utilisateurs WHERE login = '" . $login . "' AND password = '" . $password . "'");

        if (mysqli_num_rows($RecupUser) == 0) {
            $message = "Le login ou le mot de passe est incorrect, le compte n'a pas été trouvé";
        } 
        
        else {
            $_SESSION['login'] = $login;
            $_SESSION['password'] = $password;
        }
    }
    // disconnect
    public function disconnect()
    {
        session_unset();
        session_destroy();
    }
    // delete
    public function delete()
    {
        $this->bdd->query("DELETE FROM utilisateurs WHERE login = '" . $_SESSION['login'] . "'");
        session_destroy();
        echo "utilisateur supprimé";
    }
    // update
    public function update($login, $password, $email, $firstname, $lastname)
    {
        $this->bdd->query("UPDATE utilisateurs SET login = '$login', password='$password', email='$email' , firstname='$firstname' ,lastname='$lastname' WHERE login='" . $_SESSION["login"] . "'");
        echo "utilisateur a été modifé";
    }
    // isConnected ?
    public function isConnected()
    {
        if (isset($_SESSION['login'])) {
            echo "Vous étes connecté";
            return true;
        } else {
            echo "Vous étes pas connecté";
            return false;
        }
    }
    // getAllInfos
    public function getAllInfos()
    {
        $RecupUser = $this->bdd->query("SELECT * FROM utilisateurs WHERE login = '" . $_SESSION['login'] . "'");
        $result = $RecupUser->fetch_all(MYSQLI_ASSOC);
        return $result;
    }
    public function getLogin()
    {
        $RecupUser = $this->bdd->query("SELECT login FROM utilisateurs WHERE login = '" . $_SESSION['login'] . "'");
        $result = $RecupUser->fetch_all(MYSQLI_ASSOC);
        return $result;
    }
    public function getEmail()
    {
        $RecupUser = $this->bdd->query("SELECT email FROM utilisateurs WHERE login = '" . $_SESSION['login'] . "'");
        $result = $RecupUser->fetch_all(MYSQLI_ASSOC);
        return $result;
    }
    public function getFirstname()
    {
        $RecupUser = $this->bdd->query("SELECT firstname FROM utilisateurs WHERE login = '" . $_SESSION['login'] . "'");
        $result = $RecupUser->fetch_all(MYSQLI_ASSOC);
        return $result;
    }
    public function getLastname()
    {
        $RecupUser = $this->bdd->query("SELECT lastname FROM utilisateurs WHERE login = '" . $_SESSION['login'] . "'");
        $result = $RecupUser->fetch_all(MYSQLI_ASSOC);
        return $result;
    }
}

$newUser = new User();


?>
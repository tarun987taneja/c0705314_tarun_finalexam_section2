<?php

namespace view;

require_once("src/view/MessageView.php");

class LoginView {
    private $model;
    private $messages;

    public function __construct(\model\LoginModel $model)
    {
        $this->model = $model;
        $this->messages = new \view\MessageView();
    }

    // Checks if the user has pressed the login button.
    public function onClickLogin() {
        if(isset($_POST["loginButton"]))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    // Checks if the user has pressed the logout button.
    public function onClickLogout() {
        if(isset($_GET['logout']))
        {
          return true;
        }
        else
        {
            return false;
        }
    }

    // Function for retrieving current time, date and year in Swedish.
    public function getTime() {
        setlocale(LC_ALL,"sv_SE.UTF8");
        return strftime("%A, den %d %B år %Y. Klockan är [%X].");
    }

    public function sessionCheck() {
        if ($_SESSION["httpAgent"] != $_SERVER["HTTP_USER_AGENT"])
        {
            return false;
        }

        return true;
    }

    // Renders the page according to the user being logged in or not.
    public function showPage() {

        if($this->model->getLoginStatus() === false || $this->sessionCheck() === false)
        {
            $username = isset($_POST["username"]) ? $_POST["username"] : "";
            return "
           <center> <h1><mark>PHPLogin</mark></h1>
            <h3>login first to proceed</h3>
            <form action='?login' method='post' name='loginForm'>
                <fieldset>
                    <legend><b><i><u>Login - please enter username and password </b></i></u></legend><p>"
                    . $this->messages->load() . "</p>
                    <label><strong><mark>Username: </mark></strong></label>
                    <input type='text' name='username' value='$username' />
                    <label><strong><mark>Password: </mark></strong></label>
                    <input type='password' name='password' value='' /><br><br>
                    <label><strong><h2>Want to remain logged in: <h2></strong></label>
                    <input type='checkbox' name='stayLoggedIn' /><br><br>
                    <input type='submit' value='sign in' name='loginButton' />
                 </fieldset>
                 </center>
            </form>

            <p>" . $this->getTime() . "</p>";
        }
        else
        {
            return "<h1>hello!</h1>
                    <h3>" . $this->model->retriveUsername() . "  logged in</h3>
                    <p>" . $this->messages->load() . "</p>
                    <a href='?logout'>Log out</a>
                    <p>" . $this->getTime() . "</p>";
        }
    }
}
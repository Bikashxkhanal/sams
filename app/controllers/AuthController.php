<?php
class AuthController extends Controller {

    public function login() {

        // Already logged in → redirect
        if (Auth::check()) {
            header("Location: /");
            exit;
        }
          $error = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $email = Validator::clean($_POST['email']);
            $password = $_POST['password'];

            $user = (new User())->login($email, $password);

            if ($user) {
                $_SESSION['user'] = $user;
                header("Location: /"); // ENTRY POINT decides dashboard
                exit;
            }

            $error = "Invalid email or password";
        }

       
    $this->view("auth/login", compact('error')); 
    }

    public function logout() {
        session_destroy();
        header("Location: /login");
        exit;
    }
}

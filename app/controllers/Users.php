<?php

class Users extends Controller
{
    public function __construct()
    {

        $this->userModel = $this->model('User');
    }

    public function register()
    {
        if (isLoggedIn()) {

            redirect('posts/');
        }
        //check for post
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //process form
            //sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            //init data
            $data = [
                'title_page' => 'REGISTER PAGE',
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => '',
            ];

            //validate name
            if (empty($data['name'])) {
                $data['name_err'] = 'Please enter an name';
            }

            //validate email
            if (empty($data['email'])) {
                $data['email_err'] = "Please enter an email";
            } else {
                if ($this->userModel->findUserByEmail($data['email'])) {
                    $data['email_err'] = "Email is already registered";
                }
            }

            //validate password
            if (empty($data['password'])) {
                $data['password_err'] = "Please enter a password";
            } elseif (strlen($data['password']) < 6) {
                $data['password_err'] = "Password must be atleast 6 characters";
            }

            //validate confirm password
            if (empty($data['confirm_password'])) {
                $data['confirm_password_err'] = "Please confirm password";
            } else {
                if ($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_err'] = "Passwords do not match";
                }
            }

            if (empty($data['name_err']) && empty($data['email_err']) && empty($data['password_err'])
                && empty($data['confirm_password_err'])) {
                //validated

                //hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                //register user
                if ($this->userModel->register($data)) {

                    flash('register_success', 'Registered Sucessfully');
                    redirect('users/login');

                } else {
                    die('Database error');
                }

                //die('Success');
            } else {

                $this->view('/users/register', $data);
            }

        } else {

            //init data
            $data = [
                'title_page' => 'REGISTER PAGE',
                'name' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => '',
            ];

            //load views
            $this->view('/users/register', $data);
        }
    }

    public function login()
    {

        if (isLoggedIn()) {
            redirect('posts/');
        }

        //check for post
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            //init data
            $data = [
                'title_page' => 'LOGIN PAGE',
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'password_err' => '',

            ];

            //validate email
            if (empty($data['email'])) {
                $data['email_err'] = "Please enter an email";
            }

            //validate password
            if (empty($data['password'])) {
                $data['password_err'] = "Please enter a password";
            }

            //check email
            if (!$this->userModel->findUserByEmail($data['email'])) {
                $data['email_err'] = 'User is not found';
            }

            if (empty($data['email_err']) && empty($data['password_err'])) {
                //validated
                // check and set logged in user
                $loggedInUser = $this->userModel->login($data['email'], $data['password']);

                if ($loggedInUser) {

                    $this->createUserSession($loggedInUser);
                } else {
                    $data['password_err'] = 'Password is Incorrect';
                    $this->view('/users/login', $data);
                }

            } else {

                $this->view('/users/login', $data);
            }

        } else {

            //init data
            $data = [
                'title_page' => 'LOGIN PAGE',
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => '',

            ];

            //load views
            $this->view('/users/login', $data);
        }
    }

    public function createUserSession($user)
    {

        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->name;
        redirect('pages/index');
    }

    //logout
    public function logout()
    {

        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        session_destroy();
        redirect('users/login');
    }

    //get user by id for SHOW VIEWS
    public function getUserByid($id)
    {

        $this->db->query("SELECT * FROM users WHERE id = :id");
        $this->db->bind(':id', $id);
        $row = $this->db->single();

        return $row;
    }

}

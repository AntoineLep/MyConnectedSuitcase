<?php
    class UserController extends Controller {

        public function __construct(){
            parent::__construct('administration');
            $this->loadModel('UserModel');
        }

        public function index($user = null, $errors = null, $success = null){
            $this->loadView('user/user');
            $this->render();
        }

        public function doChangeUserInfo($action){
            $possibleActions = ['updateemail', 'changepassword', 'deleteaccount'];
        }

        public function login($user = null, $errors = null){
            $this->template = 'default';
            $this->loadView('user/login', compact('user', 'errors'));
            $this->render();
        }

        public function signup($user = null, $errors = null, $success = null){
            $this->template = 'default';
            $this->loadView('user/signup', compact('user', 'errors', 'success'));
            $this->render();
        }

        public function activate($id, $activationKey){
            $this->template = 'default';
            $dbUser = $this->UserModel->getUserById($id);
            if($dbUser != null){
                if($dbUser['activation_key'] == $activationKey){
                    $this->UserModel->activateUserWithId($id);
                    $this->UserModel->regenerateActivationKey($id);
                    $success = 'Your account is now activated! <a href=' . url('/user/login') . '>Log in</a>';
                    $this->loadView('user/activation', compact('success'));
                    $this->render();
                    return;
                }
            }

            $error = 'An error occured when trying to activate your account. Please contact an administrator.';
            $this->loadView('user/activation', compact('error'));
            $this->render();
            return;
        }

        public function resendemail($user = null, $errors = null, $success = null){
            $this->template = 'default';
            $this->loadView('user/resendemail', compact('user', 'errors', 'success'));
            $this->render();
        }

        public function doResendemail(){
            $formResult = ['email' => (isset($_POST['email']) && !empty(trim($_POST['email']))) ? $_POST['email'] : ''];

            $errors = [];

            //email
            if($formResult['email'] == '')
                $errors['email'] = 'E-mail required';

            $dbUser = $this->UserModel->getUserWithEmail($formResult['email']);
            if($dbUser == null)
                $errors['other'] = 'This user account doesn\'t exists';
            elseif($dbUser['status'] != 0)
                $errors['other'] = 'This user account is already activated. <a href=' . url('user/login') . '>Log In</a>';

            if(count($errors) > 0)
                return $this->resendemail($formResult, $errors);

            if(sendValidationEmail($dbUser)){
                $success = 'An E-mail has been resent to validate your registration';
                return $this->resendemail(null, null, $success);
            }

            $errors['other'] = 'An error occurs when sending the validation E-mail, please contact an administrator';
            return $this->resendemail($formResult, $errors);
        }

        public function forgotPassword($user = null, $errors = null, $success = null){
            $this->template = 'default';
            $this->loadView('user/forgotpassword', compact('user', 'errors', 'success'));
            $this->render();
        }

        public function doForgotPassword(){
            $formResult = ['email' => (isset($_POST['email']) && !empty(trim($_POST['email']))) ? $_POST['email'] : '',
                           'username' => (isset($_POST['username']) && !empty(trim($_POST['username']))) ? $_POST['username'] : ''];

            $errors = [];

            //email
            if($formResult['email'] == '')
                $errors['email'] = 'E-mail required';

            //username
            if($formResult['username'] == '')
                $errors['username'] = 'Username required';

            $dbUser = $this->UserModel->getUserWithEmailAndUsername($formResult);
            if($dbUser == null)
                $errors['other'] = 'This user account doesn\'t exists';

            if(count($errors) > 0)
                return $this->forgotPassword($formResult, $errors);

            if(sendForgottenPasswordEmail($dbUser)){
                $success = 'An E-mail has been to reset your password';
                return $this->forgotPassword(null, null, $success);
            }

            $errors['other'] = 'An error occurs when sending the E-mail to reset your password, please contact an administrator';
            return $this->forgotPassword($formResult, $errors);
        }

        public function resetPassword($id, $activationKey){
            $this->template = 'default';
            $dbUser = $this->UserModel->getUserById($id);
            if($dbUser != null){
                if($dbUser['activation_key'] == $activationKey){
                    return $this->displayResetPasswordForm($dbUser);
                }
            }

            $errors['other'] = 'An error occured. Please contact an administrator.';
            return $this->displayResetPasswordForm(null, $errors);
        }

        private function displayResetPasswordForm($user = null, $errors = null, $success = null){
            $this->template = 'default';
            $this->loadView('user/resetpassword', compact('user', 'errors', 'success'));
            $this->render();
        }

        public function doResetPassword(){
            $formResult = ['activation_key' => (isset($_POST['token_act']) && !empty(trim($_POST['token_act']))) ? $_POST['token_act'] : '',
                           'id' => (isset($_POST['token_id']) && !empty(trim($_POST['token_id']))) ? $_POST['token_id'] : ''];

            $errors = [];

            if($formResult['activation_key'] == '' || $formResult['id'] == ''){
                $errors['other'] = 'An error occured, please contact an administrator.';
                return $this->displayResetPasswordForm(null, $errors);
            }

            $formResult['password1'] = (isset($_POST['password1']) && !empty(trim($_POST['password1']))) ? $_POST['password1'] : '';
            $formResult['password2'] = (isset($_POST['password2']) && !empty(trim($_POST['password2']))) ? $_POST['password2'] : '';

            if($formResult['password1'] == '')
                $errors['password1'] = 'Password is required an cannot be empty';

            if($formResult['password2'] == '')
                $errors['password2'] = 'Password confirmation is required an cannot be empty';

            if(count($errors) > 0){
                unset($formResult['password1']);
                unset($formResult['password2']);
                return $this->displayResetPasswordForm($formResult, $errors);
            }

            if($formResult['password1'] != $formResult['password2'])
                $errors['password2'] = 'Password confirmation is different from password';

            if(count($errors) > 0){
                unset($formResult['password1']);
                unset($formResult['password2']);
                return $this->displayResetPasswordForm($formResult, $errors);
            }         
            
            $this->UserModel->updatePasswordWithIdAndToken($formResult);

            session_destroy();
            unset($_COOKIE['rememberMe']);

            $success = 'You password has been changed! <a href=' . url('user/login') . '>Log In</a>';
            return $this->displayResetPasswordForm(null, null, $success);
        }

        public function doLogin(){
            $formResult = ['email' => (isset($_POST['email']) && !empty(trim($_POST['email']))) ? $_POST['email'] : '',
                           'password' => (isset($_POST['password']) && !empty(trim($_POST['password']))) ? $_POST['password'] : '',
                           'remember'=> (isset($_POST['remember']) && $_POST['remember'] == true) ? true : false];

            $errors = [];

            //email
            if($formResult['email'] == '')
                $errors['email'] = 'E-mail required';

            //password
            if($formResult['password'] == '')
                $errors['password'] = 'Password required';

            if(count($errors) > 0)
                return $this->login($formResult, $errors);
            
            $dbUser = $this->UserModel->getUserWithEmail($formResult['email']);
            if($dbUser == null)
                $errors['other'] = 'This user account doesn\'t exists. <a href=' . url('user/signup') . '>Sign up</a>';
            elseif ($dbUser['status'] == 0) 
                $errors['other'] = 'This user account is not active yet. <a href=' . url('user/resendemail') . '>Resend validation email</a>';
            elseif (!password_verify($formResult['password'], $dbUser['password']))
                $errors['password'] = 'The password is incorrect. <a href=' . url('user/forgotpassword') . '>Forgot your password ?</a>';

            if(count($errors) > 0)
                return $this->login($formResult, $errors);

            //conect the user
            $_SESSION['idUser'] = $dbUser['id'];

            if($formResult['remember'] == true){
                $cookieValue = $dbUser['email'] . '____' . $dbUser['activation_key'];
                setcookie('rememberMe', $cookieValue, time() + 60 * 60 * 24 * 365); //set cookie for 1 year
            }

            header('location: ' . cleanUrl('/trip'));
        }

        public function doSignup(){
            $formResult = ['email' => (isset($_POST['email']) && !empty(trim($_POST['email']))) ? $_POST['email'] : '',
                           'username' => (isset($_POST['username']) && !empty(trim($_POST['username']))) ? $_POST['username'] : '',
                           'password1' => (isset($_POST['password1']) && !empty(trim($_POST['password1']))) ? $_POST['password1'] : '',
                           'password2' => (isset($_POST['password2']) && !empty(trim($_POST['password2']))) ? $_POST['password2'] : '',
                           'terms'=> (isset($_POST['terms']) && $_POST['terms'] == true) ? true : false];

            $errors = [];

             //email
            if($formResult['email'] == '')
                $errors['email'] = 'E-mail required';
            elseif(!(filter_var($formResult['email'], FILTER_VALIDATE_EMAIL) && preg_match('/@.+\./', $formResult['email'])))
                $errors['email'] = 'E-mail not valid';

            //username
            if($formResult['username'] == '')
                $errors['username'] = 'Username required';

            //password 1
            if($formResult['password1'] == '')
                $errors['password1'] = 'Password required';

            //password 2
            if($formResult['password2'] == '')
                $errors['password2'] = 'Password confirmation required';

            //password 1 & pasword 2
            if($formResult['password1'] != $formResult['password2'])
                $errors['password2'] = 'Password confirmation is different from password';

            //Terms
            if($formResult['terms'] == false)
                $errors['terms'] = 'You must reed and agree with terms and conditions';

            if(count($errors) > 0)
                return $this->signup($formResult, $errors);

            $dbUser = $this->UserModel->getUserWithEmail($formResult['email']);
            if($dbUser != null){
                $errors['email'] = 'This email is already used. <a href=' . url('/user/resetPasswordEmail/' . $dbUser['username']) . '>Forgot your password ?</a>';
                return $this->signup($formResult, $errors);
            }

            $dbUser = $this->UserModel->getUserWithUsername($formResult['username']);
            if($dbUser != null){
                $errors['username'] = 'This username is already used, please enter something else';
                return $this->signup($formResult, $errors);
            }

            $formResult['id'] = -1;
            $retId = $this->UserModel->addOrUpdate($formResult);
            if($retId > 0){
                $success = 'User account created ! An E-mail has been sent to validate your registration';
                return $this->signup(null, null, $success);
            }
            else {
                $errors['other'] = 'An error occured while registring the user account, please contact an administrator';
                return $this->signup($formResult, $errors);
            }
        }

        public function logout(){
            session_destroy();
            unset($_COOKIE['rememberMe']);
            header('location: ' . cleanUrl('/'));
            return;
        }
    }

?>
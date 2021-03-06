<?php

/**
 * Класс контроллера Index
 * @author Anton Kritsky <admin@delca.ru>
 */
class IndexController extends Controller
{
    /**
     * Экшен профиля
     * если не авторизован - рендерим форму авторизации
     */
    public function indexAction()
    {
        if ($this->auth->isAuth()) {
            $this->view->set('user', $this->auth->getUser());
            $this->view->render('index.php', true);
        } else {
            $this->view->render('login.php', true);
        }
    }

    /**
     * Экшен авторизации
     */
    public function loginAction()
    {
        if (isset($_POST['password']) and isset($_POST['email'])) {
            $login = trim($_POST['email']);
            $password = md5(trim($_POST['password']));

            if ($this->auth->doAuth($login, $password)) {
                // Если авторизация прошла редиректим на главную
                header('Location: /');
            } else {
                $this->view->set('error', $_SESSION['error']);
                unset($_SESSION['error']);
            }

        }
        $this->view->render('login.php', true);
    }

    /**
     * Экшен выхода пользователя из профиля
     */
    public function logoutAction()
    {
        $this->auth->out();
        header('Location: /');
    }

    /**
     * Экшен уведомления о успешной регистрации
     */
    public function registration_successAction()
    {
        $this->view->render('registration_success.php', true);
    }

    /**
     * Экшен регистрации
     */
    public function registrationAction()
    {
        $errors = [];

        if (isset($_POST['password']) or isset($_POST['email'])) {
            $name = trim($_POST['name']);
            $login = trim($_POST['email']);
            $password = trim($_POST['password']);
            $password_again = trim($_POST['password_again']);

            $mail_pattern = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/";
            if (!preg_match($mail_pattern, $login)) {
                $errors['email'] = _("Please enter a valid email address.");
            }

            $min_message = _("Please enter no more than {0} characters.");
            $max_message = _("Please enter at least {0} characters.");

            // Валидация имени
            $name_length = mb_strlen($name);
            if ($name_length < 3) {
                $errors['name'] = str_replace('{0}', 3, $max_message);
            }
            if ($name_length > 15) {
                $errors['name'] = str_replace('{0}', 15, $min_message);
            }

            // Валидация пароля
            $pas_length = mb_strlen($password);
            if ($pas_length < 3) {
                $errors['password'] = str_replace('{0}', 3, $max_message);
            }
            if ($pas_length > 15) {
                $errors['password'] = str_replace('{0}', 15, $min_message);
            }

            // Валидация повтора пароля
            $pas_length = mb_strlen($password_again);
            if ($pas_length < 3) {
                $errors['password_again'] = str_replace('{0}', 3, $max_message);
            }
            if ($pas_length > 15) {
                $errors['password_again'] = str_replace('{0}', 15, $min_message);
            }
            if ($password_again != $password) {
                $errors['password_again'] = _("Please enter the same value again.");
            }

            // Валидация загружаемого файла
            // Если файл отправлен без ожибки
            $ext = '';
            $valid_image = false;
            if ($_FILES["file"]["size"] and $_FILES["file"]["error"] == 0) {
                $fname = $_FILES["file"]["name"];
                $tmp_name = $_FILES["file"]["tmp_name"];

                // Если файл нужного расширения
                $ext = strtolower(end(explode('.', $fname)));
                if (!in_array($ext, ['gif', 'jpg', 'png'])) {
                    $errors['file'] = _("Available extensions - gif,jpg,png");
                } else $valid_image = true;

            }

            if (count($errors) == 0) {
                $user = new User();
                if ($id = $user->add($login, md5($password), $name, $ext)) {
                    if ($valid_image) {
                        move_uploaded_file($tmp_name, UPLOAD_DIR . "$id.$ext");
                    }
                    header('Location: /registration_success');
                }
            }

        }
        $this->view->set('errors', $errors);
        $this->view->render('register.php', true);
    }


}
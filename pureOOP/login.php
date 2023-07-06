<?php
require_once 'init.php';

if (Input::exists()) {
    if (Token::check(Input::getItem('token'))) {
        $validation = new Validation();

        $validation->check($_POST, [
            'email' => [
                'required' => true,
                'email' => true,
            ],
            'password' => [
                'required' => true,
            ]
        ]);

        if ($validation->passed()) {
            $user = new User();
            $remember = (Input::getItem('remember')) === 'on';
            $login = $user->login(Input::getItem('email'), Input::getItem('password'), $remember);

            if ($login) {
                Session::put('enter', 'Вы авторизовались');
                Redirect::to('index.php');
            } else {
                Session::put('login_failed', 'Не верный логин или пароль');
            }
        } else {
            foreach ($validation->getErrors() as $error) {
                echo "<p style='color: brown'>{$error}</p>";
            }
        }
    }
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
</head>
<body>
<?php if (Session::exists('login_failed')) :?>
    <p style='color: brown'><?= Session::flash('login_failed')?></p>
<?php endif;?>
<form action="" method="post">
    <label>Email:
        <input type="text" name="email" value="<?= Input::getItem('email')?>">
    </label>
    <label>Password:
        <input type="text" name="password">
    </label>
    <div>
        <input type="checkbox" name="remember">
        <label>Remember me
        </label>
    </div>
    <input type="hidden" name="token" value="<?php echo Token::generate()?>">
    <button type="submit">send</button>
</form>
</body>
</html>

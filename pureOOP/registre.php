<?php
require_once 'init.php';

if (Input::exists()) {
    if (Token::check(Input::getItem('token'))) {
        $validation = new Validation();

        $validation = $validation->check($_POST, [
            'name' => [
                'required' => true,
                'min' => 2,
                'max' => 32,
            ],
            'email' => [
                'required' => true,
                'min' => 6,
                'max' => 90,
                'unique' => 'marlin_users',
                'email' => true,
            ],
            'password' => [
                'required' => true,
                'min' => 8,
            ],
            'password_confirm' => [
                'required' => true,
                'matched' => 'password_confirm',
            ],
        ]);
        if ($validation->passed()) {
            $user = new User;
            $user->create(
                [
                    'name' => Input::getItem('name'),
                    'email' => Input::getItem('email'),
                    'password' => password_hash(Input::getItem('password'), PASSWORD_DEFAULT),
                ]
            );
            Session::flash('success', 'Вы успешно вошли в профиль');
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
    <title>Registration</title>
</head>
<body>
<?php if (Session::exists('success')) :?>
    <p style="color: lightgreen"><?= Session::flash('success')?></p>
<?php endif;?>
<form action="<?= $_SERVER['PHP_SELF']?>" method="post">
    <label>Name:
        <input type="text" name="name" value="<?= Input::getItem('name')?>">
    </label>
    <label>Email:
        <input type="text" name="email" value="<?= Input::getItem('email')?>">
    </label>
    <label>Password:
        <input type="text" name="password">
    </label>
    <label>Repeat password:
        <input type="text" name="password_confirm">
    </label>

    <input type="hidden" name="token" value="<?php echo Token::generate()?>">
    <button type="submit">send</button>
</form>
</body>
</html>

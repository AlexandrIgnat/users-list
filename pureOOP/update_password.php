<?php
require_once 'init.php';

$user = new User();

if (Input::exists()) {
    if (Token::check(Input::getItem('token'))) {
        $validation = new Validation();

        $validation->check($_POST, [
            'current_password' => [
                'required' => true,
            ],
            'new_password' => [
                'required' => true,
                'min' => 4,
            ],
            'new_password_confirm' => [
                'required' => true,
                'min' => 4,
                'matched' => 'new_password'
            ],
        ]);

        if ($validation->passed()) {
            if (password_verify(Input::getItem('current_password'), $user->getData()->password)) {
               $user->update(['password' => password_hash(Input::getItem('new_password'), PASSWORD_DEFAULT)]);
               Session::flash('change_password', 'The password was changed');
               Redirect::to('index.php');
            } else {
                echo 'Current password is invalid ';
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
    <title>Update user name</title>
</head>
<body>
<form action="" method="post">
    <label>Current password:
        <input type="password" name="current_password">
    </label>
    <label>New password:
        <input type="password" name="new_password">
    </label>
    <label>Repeat password:
        <input type="password" name="new_password_confirm">
    </label>
    <input type="hidden" name="token" value="<?php echo Token::generate()?>">
    <button type="submit">send</button>
</form>
</body>
</html>
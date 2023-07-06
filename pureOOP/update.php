<?php
require_once 'init.php';

$user = new User();

if (Input::exists()) {
    if (Token::check(Input::getItem('token'))) {
        $validation = new Validation();

        $validation->check($_POST, [
            'username' => [
                'required' => true,
                'min' => 3,
            ],
        ]);

        if ($validation->passed()) {
            $user->update(['name' => Input::getItem('username')]);
            Redirect::to('update.php');
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
    <label>Username:
        <input type="text" name="username" value="<?= $user->getData()->name?>">
    </label>
    <input type="hidden" name="token" value="<?php echo Token::generate()?>">
    <button type="submit">send</button>
</form>
</body>
</html>
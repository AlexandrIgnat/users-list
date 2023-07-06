<?php
namespace App\controllers;

use App\QueryBuilder;
use Faker\Factory;
use Exception;
use League\Plates\Engine;
use function Tamtamchik\SimpleFlash\flash;
use SimpleMail;

class HomeController {
    private $db;
    private $vars = [];
    private $templates;
    private $auth;

    public function __construct()
    {
        $this->db = new QueryBuilder();
        $this->templates = new Engine($_SERVER['DOCUMENT_ROOT'] . '/app/view');
        $this->auth = new \Delight\Auth\Auth(DbConnection::getPdo());
    }

    public function index($vars)
    {
        $this->vars = $vars;

        echo  $this->templates->render('home', $this->vars);
    }

    public function about($vars)
    {
        try {
            $userId = $this->auth->register('ale11x.ignat@mail.ru', '1000', 'alex', function ($selector, $token) {
                $this->email_verification($selector, $token);
            });

            echo 'We have signed up a new user with the ID ' . $userId . PHP_EOL;
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            die('Invalid email address');
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            die('Invalid password');
        }
        catch (\Delight\Auth\UserAlreadyExistsException $e) {
            die('User already exists');
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        }
//        $this->vars = $vars;
//
//        try {
//            $this->withdrow($vars);
//        } catch (Exception $e) {
//            flash()->error($e->getMessage());
//        }
//
//        echo $this->templates->render('about', $this->vars);
    }

    public function email_verification($selector, $token)
    {
        try {
            $this->auth->confirmEmail($selector, $token);

            echo 'Email address has been verified' . PHP_EOL;

//            $this->login();
        }
        catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
            die('Invalid token');
        }
        catch (\Delight\Auth\TokenExpiredException $e) {
            die('Token expired');
        }
        catch (\Delight\Auth\UserAlreadyExistsException $e) {
            die('Email address already exists');
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        }
    }

    public function login()
    {
        try {
            $this->auth->login('ale11x.ignat@mail.ru', '1000');

            echo 'User is logged in' . PHP_EOL;
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            die('Wrong email address');
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            die('Wrong password');
        }
        catch (\Delight\Auth\EmailNotVerifiedException $e) {
            die('Email not verified');
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        }

        if ($this->auth->isLoggedIn()) {
            echo 'User is signed in';
            $userId = $this->auth->getUserId();
            $this->auth->admin()->addRoleForUserById($userId, \Delight\Auth\Role::ADMIN);
        } else {
            echo 'User is not signed in yet';
        }
    }

    public function logout()
    {
        if (!$this->auth->isLoggedIn()) return;

        try {
            $userId = $this->auth->getUserId();
            $this->auth->admin()->removeRoleForUserById($userId, \Delight\Auth\Role::ADMIN);
            $this->auth->logOut();
            $this->auth->destroySession();
        }
        catch (\Delight\Auth\NotLoggedInException $e) {
            die('Not logged in');
        }
    }

    /**
     * @throws Exception
     */
    public function withdrow($amount)
    {
        $total = 10;

        if ($total < $amount) {
            throw new Exception('Недостаточно средств');
        }
    }

    public function send_mail()
    {
       var_dump( SimpleMail::make()
           ->setTo('ignatyevaleksandr.1992@gmail.com', 'Alex')
           ->setSubject('News')
           ->setMessage('You are the best developer of the world')
           ->send());
    }

    public function createPosts()
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $this->db->insert('posts', [
                'title' => $faker->words(3, true),
                'preview' => $faker->text,
                'description' => $faker->words(30, true),
                'thumbnail' => $faker->image($dir, $width = 640, $height = 480, 'cats', false),
            ]);
        }
    }
}

//use \Tamtamchik\SimpleFlash\Flash;
//use function Tamtamchik\SimpleFlash\flash;

//flash()->message('Hot!');
//echo flash()->display();

//$result = $db->getAll();

//$db->insert('roles_group' ,['name' => 'guest', 'permissions' => '{"guest"} : 1']);

//$db->update('roles_group', ['name' => 'Guest2'], ['column' => 'id', 'value' => 3]);

//$db->findOne();

//$templates = new League\Plates\Engine('../app/view');


//echo $templates->render('home', ['name' => 'Home']);

//d([123]);



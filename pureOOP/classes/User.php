<?php

class User
{
    private $db;
    private $data;
    private $session_name;
    private $cookie_name;
    private $isLoggedIn;

    public function __construct($user = null)
    {
        $this->db = Database::getInstance();
        $this->session_name = Config::get('session.user_session');
        $this->cookie_name = Config::get('cookie.name');

        if (!$user) {
            if (Session::exists($this->session_name)) {
                $user = Session::get($this->session_name);

                if ($this->find($user)) {
                    $this->isLoggedIn = true;
                }
            }
        } else {
            $this->find($user);
        }
    }

    public function create($fields = [])
    {
        $this->db->insert('marlin_users', $fields);
    }

    public function login($email = null, $password = null, $remember = false): bool
    {
        if (!$email && !$password && $this->exists()) {
            Session::put($this->session_name, $this->getData()->id);
        } else {
            $user = $this->find($email);

            if ($user) {
                if (password_verify($password, $this->getData()->password)) {
                    Session::put($this->session_name, $this->getData()->id);

                    if ($remember) {
                        $hashCheck = $this->db->get('user_hash', ['user_id', '=', $this->getData()->id]);

                        if (!$hashCheck->getCount()) {
                            $hash = hash('sha256', uniqid());

                            $this->db->insert('user_hash', [
                                'user_id' => $this->getData()->id,
                                'hash'    => $hash,
                            ]);
                        } else {
                            $hash = $hashCheck->first()->hash;
                        }

                        Cookie::put($this->cookie_name, $hash, Config::get('cookie.life_time'));
                    }

                    return true;
                }
            }
        }

        return false;
    }

    public function find($value = null): bool
    {
        if ($value) {
            if (is_numeric($value)) {
                $this->data = $this->db->get('marlin_users', ['id', '=', $value])->first();
            } else {
                $this->data = $this->db->get('marlin_users', ['email', '=', $value])->first();
            }

            if ($this->data) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    public function isLoggedIn()
    {
        return $this->isLoggedIn;
    }

    public function logout()
    {
        $this->db->delete('user_hash', ['user_id', '=', $this->getData()->id]);
        Cookie::delete($this->cookie_name);
        Session::delete($this->session_name);
    }

    public function update($field = [], $id = null): bool
    {
        if (!$id && $this->isLoggedIn()) $id = $this->getData()->id;

        if ($this->db->update('marlin_users', $id, $field)) return true;

        return false;
    }

    public function exists()
    {
        return !empty($this->getData());
    }

    public function hasPermission($key = null)
    {
        if ($key) {
            $group = $this->db->get('roles_group', ['id', '=', $this->getData()->group_id]);

            if ($group->getCount()) {
                $permission = $group->first()->permissions;
                $permission = json_decode($permission, true);

                if ($permission[$key]) return true;
            }
        }
        return false;
    }

}
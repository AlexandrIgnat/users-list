<?php

class QueryBuilder
{
    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll($table) {
        $pdo = $this->pdo;
        $statement = $pdo->prepare("SELECT * FROM {$table}");
        $statement->execute();
        $posts = $statement->fetchAll(PDO::FETCH_ASSOC);
    
        return $posts;
    }

    public function create($table, $data) 
    {
        $keys = implode(', ', array_keys($data));
        $value = ':' . implode(', :', array_keys($data));

        $query = "INSERT INTO {$table} ({$keys}) VALUES ({$value})";

        $statement = $this->pdo->prepare($query);
        $statement->execute($data);

        header('Location: /create.post.php');
    }

    public function update($table, $data, $id)
    {
        $keys = array_keys($data);

        $str = '';

        foreach ($keys as $key) {
            $str .= $key . '=:' . $key . ',';
        }

        $str = rtrim($str, ',');

        $data['id'] = $id;

        $sql = "UPDATE {$table} SET {$str} WHERE id=:id";
        
        $statement = $this->pdo->prepare($sql);
        
        $statement->execute($data);

        header("Location: /post/edit.php?id={$id}");
    }

    public function getOne($table, $id)
    {
        $sql = "SELECT * FROM {$table} WHERE id = :id";

        $statement = $this->pdo->prepare($sql);

        $statement->bindValue(':id', $id);

        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($table, $id)
    {
        $sql = "DELETE FROM {$table} WHERE id=:id";

        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();

        header("Location: /index.php");
    }
}
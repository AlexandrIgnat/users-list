<?php

namespace App;

use App\controllers\DbConnection;
use Aura\SqlQuery\QueryFactory;
use PDO;

class QueryBuilder
{
    private $pdo;
    private $queryFactory;

    public function __construct()
    {
        $this->pdo = DbConnection::getPdo();
        $this->queryFactory = new QueryFactory('mysql');
    }

    public function getAll()
    {
        $select = $this->queryFactory->newSelect();

        $select->cols([
            'id',
            'title',
            'preview'
        ])
            ->from('posts');

        $sth = $this->pdo->prepare($select->getStatement());

        $sth->execute($select->getBindValues());

        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert($table, $data)
    {
        $insert = $this->queryFactory->newInsert();

        $insert
            ->into($table)
            ->cols($data);

        $sth = $this->pdo->prepare($insert->getStatement());

        $sth->execute($insert->getBindValues());
    }

    public function update($table, $data, $where = [])
    {
        $update = $this->queryFactory->newUpdate();


        $update->table($table)           // update this table
            ->cols($data)
            ->where("{$where['column']}  = :{$where['column']}")
            ->bindValue("{$where['column']}", $where['value']);

        $sth = $this->pdo->prepare($update->getStatement());

        $sth->execute($update->getBindValues());
    }

    public function delete($table,$where = [])
    {
        $delete = $this->queryFactory->newDelete();

        $delete
            ->from($table)                   // FROM this table
            ->where("{$where['column']}  = :{$where['column']}")
            ->bindValue("{$where['column']}", $where['value']);
    }

    public function findOne()
    {
        return $this->getAll()[0];
    }
}
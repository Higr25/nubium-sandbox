<?php

namespace App\Models;

use App\Models\BaseModel;

class PostModel extends BaseModel {

    /**
     * Returns posts from database.
     * @param int $page
     * @param int $private
     * @param string $order
     * @return object
     */
    public function getPosts($paginator, $isLoggedIn, $order, $order_type, $idUser = null) {
        $orders = ['created_at', 'header', 'rating'];

        $_order = array_key_exists($order, $orders) ? $orders[$order] : reset($orders);
        $_order_type = boolval($order_type);

        if ($isLoggedIn) {
            $sql = $this->getSqlLogged();
            $count = $this->getSqlLogged('count');

            $rows = $this->db->query($sql, $idUser, [$_order => $_order_type], $paginator->getOffset(), $paginator->getLength())->fetchAll();
            $rowsCount = $this->db->query($count)->getRowCount();
        } else {
            $sql = $this->getSqlNotLogged();
            $count_not_logged = $this->getSqlNotLogged('count');

            $rows = $this->db->query($sql, [$_order => boolval($_order_type)], $paginator->getOffset(), $paginator->getLength())->fetchAll();
            $rowsCount = $this->db->query($count_not_logged)->getRowCount();
        }

        return ['data' => $rows,
            'count' => $rowsCount];
    }

    private function getSqlLogged($count = null) {
        $sql = <<<EOSQL
            SELECT p.*,
            COALESCE( COUNT(distinct(vu.id)), 0 ) AS upvotes,
            COALESCE( COUNT(distinct(vd.id)), 0 ) AS downvotes,
            (COUNT(distinct(vu.id)) - COUNT(distinct(vd.id))) AS rating,
            COALESCE( COUNT(distinct(v.id)), 0 ) AS voted,
            v.up AS voted_up
                
            FROM t_post p
                
            LEFT JOIN (
                SELECT id, id_post, count(*) AS COUNT
                FROM t_vote vu
                WHERE up = 1 AND active = 1
                GROUP BY id
            ) vu ON p.id = vu.id_post
            
            LEFT JOIN (
                SELECT id, id_post, count(*) AS COUNT
                FROM t_vote vd
                WHERE up = 0 AND active = 1
                GROUP BY id
            ) vd ON p.id = vd.id_post	
           
            LEFT JOIN (
                SELECT id, id_post, up
                FROM t_vote v
                WHERE id_user = ? AND active = 1
            ) v ON p.id = v.id_post
            
            WHERE active = 1
            GROUP BY p.id, v.up
            ORDER BY ?
            LIMIT ?, ?					
EOSQL;

        $sql_count = <<<EOSQL
            SELECT p.id
            FROM t_post p
            WHERE active = 1						
EOSQL;

        if ($count) {
            return $sql_count;
        }

        return $sql;
    }

    private function getSqlNotLogged($count = null) {
        $sql = <<<EOSQL
            SELECT p.*,
            COALESCE( COUNT(distinct(vu.id)), 0 ) AS upvotes,
            COALESCE( COUNT(distinct(vd.id)), 0 ) AS downvotes,
            (COUNT(distinct(vu.id)) - COUNT(distinct(vd.id))) AS rating
            
            FROM t_post p

            LEFT JOIN (
                SELECT id, id_post, count(*) AS COUNT
                FROM t_vote vu
                WHERE up = 1 AND active = 1
                GROUP BY id
            ) vu ON p.id = vu.id_post
            
            LEFT JOIN (
                SELECT id, id_post, count(*) AS COUNT
                FROM t_vote vd
                WHERE up = 0 AND active = 1
                GROUP BY id
            ) vd ON p.id = vd.id_post				
            
            WHERE active = 1 AND private = 0			
            GROUP BY p.id
            ORDER BY ?
            LIMIT ?, ?					
EOSQL;

        $sql_count = <<<EOSQL
            SELECT p.id
            FROM t_post p
            WHERE active = 1 AND private = 0	
EOSQL;

        if ($count) {
            return $sql_count;
        }

        return $sql;
    }

    public function insertVote($idPost, $up, $idUser, $created_ip) {
        $this->db->table('t_vote')
                ->insert([
                    'id_post' => $idPost,
                    'up' => $up,
                    'id_user' => $idUser,
                    'created_ip' => $created_ip,
                    'created_at' => new \Nette\Utils\DateTime,
                    'active' => 1
        ]);
    }

    public function getVote($idPost, $userId) {
        return $this->db->table('t_vote')
                        ->where(['id_post' => $idPost, 'id_user' => $userId, 'active' => 1])
                        ->fetch();
    }

    public function deleteVote($idVote) {
        $this->db->table('t_vote')
                ->where('id', $idVote)
                ->update([
                    'active' => 0
        ]);
    }

}

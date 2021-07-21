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
    public function getPosts($paginator, $isLoggedIn, $order, $order_type) {								
								$base = <<<EOSQL
												SELECT p.*,
																COALESCE( COUNT(distinct(vu.id)), 0 ) AS upvotes,
																COALESCE( COUNT(distinct(vd.id)), 0 ) AS downvotes,
																(COUNT(distinct(vu.id)) - COUNT(distinct(vd.id))) AS rating
												FROM t_post p

												LEFT JOIN (SELECT id, id_post, count(*) AS COUNT
																FROM t_vote vu
																WHERE up = 1 AND active = 1
																GROUP BY id) vu ON p.id = vu.id_post

												LEFT JOIN (SELECT id, id_post, count(*) AS COUNT
																FROM t_vote vd
																WHERE up = 0 AND active = 1
																GROUP BY id) vd ON p.id = vd.id_post
												
												WHERE active = 1                
EOSQL;
								
								$count = <<<EOSQL
												SELECT p.id
												FROM t_post p
												WHERE active = 1				
EOSQL;
				
								$not_logged = <<<EOSQL
												AND private = 0
EOSQL;
								
								$end = <<<EOSQL
												GROUP BY p.id
												ORDER BY ?
												LIMIT ?, ?				
EOSQL;
																
								$order_types = ['created_at', 'header', 'rating'];
								
								$_order = array_key_exists($order,	$order_types) ? $order_types[$order] : reset($order_types);
								$_order_type = boolval($order_type);
								
																
								if ($isLoggedIn) {
												$rows = $this->db->query($base . ' ' . $end, [$_order => $_order_type], $paginator->getOffset(), $paginator->getLength())->fetchAll();
												$rowsCount = $this->db->query($count)->getRowCount();
								} else {
												$rows = $this->db->query($base . ' ' . $not_logged . ' ' . $end, [$_order => boolval($_order_type)], $paginator->getOffset(), $paginator->getLength())->fetchAll();
												$rowsCount = $this->db->query($count . ' ' . $not_logged)->getRowCount();
								}
        
        return ['data' => $rows,
												    'count' => $rowsCount];
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

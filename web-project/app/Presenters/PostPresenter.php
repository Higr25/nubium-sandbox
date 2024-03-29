<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use App\Models\PostModel;

class PostPresenter extends Nette\Application\UI\Presenter {

    /** @var PostModel @inject */
    public $model;
    
    /** @persistent */
    public $page = 1;
    
    /** @persistent */
    public $order = 0;
    
    /** @persistent */
    public $order_type = 1;

    public function renderDefault() {
        $isLoggedIn = $this->getUser()->isLoggedIn();

        $userId = null;
        if ($isLoggedIn) {
            $userId = $this->getUser()->identity->id;
        }

        $paginator = new Nette\Utils\Paginator;
        $paginator->setPage($this->page);
        $paginator->setItemsPerPage(4);

        $posts = $this->model->getPosts($paginator, $isLoggedIn, $this->order, $this->order_type, $userId);

        $paginator->setItemCount($posts['count']);

        $this->template->posts = $posts['data'];
        $this->template->paginator = $paginator;
        $this->template->order = $this->order;
        $this->template->order_type = $this->order_type;
    }

    public function handleVote($idPost, $up) {
        $u = $this->getUser();

        if (!$u->isLoggedIn()) {
            return;
        }

        $vote = $this->model->getVote($idPost, $u->identity->id);

        if ($vote && $vote->up == $up) {
            return;
        } else if ($vote) {
            $this->model->deleteVote($vote->id);
        }

        $this->model->insertVote($idPost, $up, $u->identity->id, $this->getHttpRequest()->remoteAddress);

        $this->redrawControl('posts');
    }

    public function handleRefresh(string $key, int $value) {
        if ($key != 'order' && $key != 'order_type' && $key != 'page') {
            return;
        }
        
        $this->$key = $value;

        if ($key != 'page') {
            $this->page = 1;
        }

        $this->redrawControl();
    }

}

<?php

namespace Kanboard\Plugin\Backlog\Controller;

use Kanboard\Controller\BaseController;

/**
 * Backlog Board
 *
 * @package controller
 * @author  creecros
 */
class BacklogBoardController extends BaseController {

    public function set() {
        $project = $this->getProject();

        $this->projectUsesBacklogBoardModel->setBacklogBoard($project['id']);

        $this->flash->success(t('Backlog Board now activated.'));

        $this->response->redirect($this->helper->url->to('BoardAjaxController', 'renderBoard', array('project_id' => $project['id'])), true);
    }

    public function unset() {
        $project = $this->getProject();

        $this->projectUsesBacklogBoardModel->unsetBacklogBoard($project['id']);

        $this->flash->success(t('Backlog Board now deactivated.'));

        $this->response->redirect($this->helper->url->to('BoardAjaxController', 'renderBoard', array('project_id' => $project['id'])), true);
    }

}

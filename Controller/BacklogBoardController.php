<?php

namespace Kanboard\Plugin\Backlog\Controller;

use Kanboard\Controller\BaseController;
use Kanboard\Model\ProjectModel;
use Kanboard\Model\SwimlaneModel;


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
        $this->backlogSwimlane($project['id']);

        $this->flash->success(t('Backlog Board now activated.'));

        $this->response->redirect($this->helper->url->to('BoardAjaxController', 'renderBoard', array('project_id' => $project['id'])), true);
    }

    public function unset() {
        $project = $this->getProject();

        $this->projectUsesBacklogBoardModel->unsetBacklogBoard($project['id']);
        $this->removeBacklogSwimlane($project['id'], 0);

        $this->flash->success(t('Backlog Board now deactivated.'));

        $this->response->redirect($this->helper->url->to('BoardAjaxController', 'renderBoard', array('project_id' => $project['id'])), true);
    }
    
    public function backlogSwimlane($projectId) {
        if ($this->projectModel->exists($projectId)) {
           
          return $this->db->table(self::TABLE)->persist(array(
            'project_id'  => $projectId,
            'name'        => 'BacklogBoard_Swimlane',
            'description' => 'Temporary Swimlane for Backlog Board',
            'position'    => 0,
            'is_active'   => 1,
          ));
            
        }
    }
    
    public function removeBacklogSwimlane($projecId, $swimlaneId) {
        $this->db->startTransaction();
        if ($this->db->table(TaskModel::TABLE)->eq('swimlane_id', $swimlaneId)->exists()) {
            $this->db->cancelTransaction();
            return false;
        }
        if (! $this->db->table(self::TABLE)->eq('id', $swimlaneId)->remove()) {
            $this->db->cancelTransaction();
            return false;
        }
        $this->swimlaneModel->updatePositions($projecId);
        $this->db->closeTransaction();
        return true;
    }

}

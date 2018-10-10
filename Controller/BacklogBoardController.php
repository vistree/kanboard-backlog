<?php

namespace Kanboard\Plugin\Backlog\Controller;

use Kanboard\Controller\BaseController;
use Kanboard\Model\ProjectModel;
use Kanboard\Model\SwimlaneModel;
use Kanboard\Model\ColumnModel;


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
        $this->backlogColumn($project['id']);

        $this->flash->success(t('Backlog Board now activated.'));

        $this->response->redirect($this->helper->url->to('BoardAjaxController', 'renderBoard', array('project_id' => $project['id'])), true);
    }

    public function unset() {
        $project = $this->getProject();

        $this->projectUsesBacklogBoardModel->unsetBacklogBoard($project['id']);
        $this->removeBacklogSwimlane($project['id'], 0);
        $this->removeBacklogColumn($project['id'], 1);

        $this->flash->success(t('Backlog Board now deactivated.'));

        $this->response->redirect($this->helper->url->to('BoardAjaxController', 'renderBoard', array('project_id' => $project['id'])), true);
    }
    
    public function backlogSwimlane($projectId) {
          $this->swimlaneModel->create($projectId, 'Backlog_Swimlane', 'Temporary Swimlane for Backlog Board');  
          $this->swimlaneModel->changePosition($projectId, $this->swimlaneModel->getByName($projectId, 'Backlog_Swimlane'), 0);
    }
    
    public function removeBacklogSwimlane($projecId) {
          $this->swimlaneModel->remove($projecId, $this->swimlaneModel->getByName($projectId, 'Backlog_Swimlane'));
    }
    
    
    public function backlogColumn($projectId) {
          $this->columnModel->create($projectId, 'Backlog_Board', 0, 'Main Column for Backlog Board', 0);
          $this->columnModel->changePosition($project_id, $this->columnModel->getColumnIdByTitle($projectId, 'Backlog_Board'), 0);
    }
    
    public function removeBacklogColumn($projectId, $swimlane) {
        foreach ($swimlane['columns'] as $column) {
            if ($column['title'] === 'Backlog_Board') { 
                foreach ($column['tasks'] as $task) { $this->taskPostitionModel->movePosition($projectId, $task['id'], $column['id'], 0, $swimlane_id = 0, $fire_events = true, $onlyOpen = true); }
            }
        }
          $this->columnModel->remove($this->columnModel->getColumnIdByTitle($projectId, 'Backlog_Board'));
    }

}

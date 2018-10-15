<?php

namespace Kanboard\Plugin\Backlog\Controller;

use Kanboard\Controller\BaseController;
use Kanboard\Model\ProjectModel;
use Kanboard\Model\SwimlaneModel;
use Kanboard\Model\ColumnModel;
use Kanboard\Model\TaskPositionModel;


/**
 * @plugin Backlog
 *
 * @package Controller
 * @author  creecros
 */
class BacklogBoardController extends BaseController {

/**
 * sets the board by creating swimlane and column
 */
    public function backlogSet() {
        $projectId = $this->request->getIntegerParam('project_id');

        $this->projectUsesBacklogBoardModel->setBacklogBoard($projectId);
        $this->backlogSwimlane($projectId);
        $this->backlogColumn($projectId);

        $this->flash->success(t('Backlog Board now activated.'));

        $this->response->redirect($this->helper->url->to('BoardViewController', 'show', array('project_id' => $projectId), true));
    }

/**
 * unsets the board by moving tasks out of created column/swimlane to next column/swimlane, then removes created column/swimlane
 */
    
    public function backlogUnset() {
        $projectId = $this->request->getIntegerParam('project_id');

        $this->projectUsesBacklogBoardModel->unsetBacklogBoard($projectId);
        $this->moveTasksOut($projectId);
        $this->removeBacklogSwimlane($projectId);
        $this->removeBacklogColumn($projectId);

        $this->flash->success(t('Backlog Board now deactivated.'));

        $this->response->redirect($this->helper->url->to('BoardViewController', 'show', array('project_id' => $projectId), true));
    }
    
/**
 * creates the swimlane 'Backlog_Swimlane'
 */
    
    public function backlogSwimlane($projectId) {
          $this->swimlaneModel->create($projectId, 'Backlog_Swimlane', 'Temporary Swimlane for Backlog Board');  
          $this->swimlaneModel->changePosition($projectId, $this->swimlaneModel->getIdByName($projectId, 'Backlog_Swimlane'), 1);
    }
    
/**
 * removes the swimlane 'Backlog_Swimlane'
 */
    
    public function removeBacklogSwimlane($projectId) {
          $this->swimlaneModel->remove($projectId, $this->swimlaneModel->getIdByName($projectId, 'Backlog_Swimlane'));
    }
    
/**
 * creates the column 'Backlog_Board'
 */
    
    public function backlogColumn($projectId) {
          $this->columnModel->create($projectId, 'Backlog_Board', 0, 'Main Column for Backlog Board', 0);
          $this->columnModel->changePosition($projectId, $this->columnModel->getColumnIdByTitle($projectId, 'Backlog_Board'), 1);
    }
    
/**
 * removes the column 'Backlog_Board'
 */
    
    public function removeBacklogColumn($projectId) {
          $this->columnModel->remove($this->columnModel->getColumnIdByTitle($projectId, 'Backlog_Board'));
    }
    
/**
 * moves tasks out of column/swimlane
 */
    
    public function moveTasksOut($projectId) {
          $columnId = $this->columnModel->getColumnIdByTitle($projectId, 'Backlog_Board');
          $allColumns = $this->columnModel->getAll($projectId);
          foreach ($allColumns as $column) { if ($column['position'] == 2) { $column_to = $column['id']; } }
          $allSwimlanes = $this->swimlaneModel->getAll($projectId);
          foreach ($allSwimlanes as $swimlane) { if ($swimlane['position'] == 2) { $swimlane_to = $swimlane['id']; } } 
          $tasksInColumn = $this->projectUsesBacklogBoardModel->getTasksInColumn($projectId, $columnId);
          foreach ($tasksInColumn as $task) { $this->taskPositionModel->movePosition($projectId, $task['id'], $column_to, 1, $swimlane_to, true, false); }
    }

}

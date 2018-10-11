<?php

namespace Kanboard\Plugin\Backlog\Model;

use Kanboard\Model\ProjectFileModel;
use Kanboard\Model\ProjectMetadataModel;
use Kanboard\Model\TaskModel;
use Kanboard\Core\Base;

class ProjectUsesBacklogBoardModel extends Base {

    public function setBacklogBoard($project_id) {
        $this->projectMetadataModel->save($project_id, array('uses_backlogboard' => 'set'));
    }
    
    public function unsetBacklogBoard($project_id) {
    
        $this->projectMetadataModel->remove($project_id, 'uses_backlogboard');
    }
    
    public function isset($project_id) {
        return $this->projectMetadataModel->exists($project_id, 'uses_backlogboard');   
    }
    
    public function getTasksInColumn($project_id, $column_id)
    {
        return $this->db
                    ->table(TaskModel::TABLE)
                    ->eq('project_id', $project_id)
                    ->eq('column_id', $column_id)
                    ->findAll();
    }

    
}

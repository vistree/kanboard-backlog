<?php

namespace Kanboard\Plugin\Backlog\Model;

use Kanboard\Model\ProjectFileModel;
use Kanboard\Model\ProjectMetadataModel;
use Kanboard\Model\TaskModel;
use Kanboard\Core\Base;

/**
 * @plugin Backlog
 *
 * @package Model
 * @author  creecros
 */

class ProjectUsesBacklogBoardModel extends Base {
    
/**
 * sets the property 'uses_backlogboard' in project metadata
 */

    public function setBacklogBoard($project_id) {
        $this->projectMetadataModel->save($project_id, array('uses_backlogboard' => 'set'));
    }
    
/**
 * removes the property 'uses_backlogboard' in project metadata
 */
    
    public function unsetBacklogBoard($project_id) {
    
        $this->projectMetadataModel->remove($project_id, 'uses_backlogboard');
    }
    
/**
 * returns true if the property 'uses_backlogboard' in project metadata is set
 */
    
    public function backlogIsset($project_id) {
        return $this->projectMetadataModel->exists($project_id, 'uses_backlogboard');   
    }
    
/**
 * gets all the tasks in 'Backlog_Board' column
 */
    
    public function getTasksInColumn($project_id, $column_id)
    {
        return $this->db
                    ->table(TaskModel::TABLE)
                    ->eq('project_id', $project_id)
                    ->eq('column_id', $column_id)
                    ->findAll();
    }

    
}

<?php

namespace Kanboard\Plugin\Backlog\Model;

use Kanboard\Model\ProjectFileModel;

class ProjectUsesBacklogBoardModel {

    public function setBacklogBoard($project_id) {
        $this->projectMetadataModel->save($project_id, array('uses_backlogboard' => 'set'));
    }
    
    public function unsetBacklogBoard($project_id) {
    
        $this->projectMetadataModel->remove($project_id, 'uses_backlogboard');
    }
    
    public function getCoverimage($project_id) {
    
        $set = $this->projectMetadataModel->get($project_id, 'uses_backlogboard');
        if (!$set)
          return(null);
        return true;
    }
}

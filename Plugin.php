<?php

namespace Kanboard\Plugin\Backlog;

use DateTime;
use Kanboard\Core\Plugin\Base;
use Kanboard\Model\ProjectModel;
use Kanboard\Plugin\Backlog\Model\ProjectUsesBacklogBoardModel;
use Kanboard\Model\ColumnModel;
use Kanboard\Model\SwimlaneModel;
use Kanboard\Model\TaskPositionModel;
use Kanboard\Core\Translator;
use Kanboard\Core\Security\Role;

class Plugin extends Base
{
    public function initialize()
    {
        
        $this->template->setTemplateOverride('board/table_container','backlog:board/table_container');
        $this->template->setTemplateOverride('column/index','backlog:column/index');
        $this->template->setTemplateOverride('swimlane/table','backlog:swimlane/table');
        $this->hook->on('template:layout:js', array('template' => 'plugins/Backlog/Assets/backlog.js'));
        $this->hook->on('template:layout:css', array('template' => 'plugins/Backlog/Assets/backlog.css'));
        $this->template->hook->attach('template:project:dropdown', 'backlog:board/menu');
        
        //CONFIG HOOK
        $this->template->hook->attach('template:config:board', 'backlog:config/board_name');    
        
        $projects = $this->projectModel->getAllByStatus(1); //get all projects that are active
        foreach ($projects as $project) {
            if ($this->projectUsesBacklogBoardModel->backlogIsset($project['id'])) {
               $columnId = $this->columnModel->getColumnIdByTitle($project['id'], 'Backlog_Board');
               $tasksInColumn = $this->projectUsesBacklogBoardModel->getTasksInColumn($project['id'], $columnId);
               foreach($tasksInColumn as $task) {
                     $swimlane = $this->swimlaneModel->getById($task['swimlane_id']);
                     if ($swimlane['position'] !== 1) {
                         $this->taskPositionModel->movePosition($project['id'], $task['id'], $columnId , 1, $this->swimlaneModel->getByName($project['id'], "Backlog_swimlane")['id'], true, false); 
                     }
                }
            }
        }
    }

    public function onStartup()
    {
        Translator::load($this->languageModel->getCurrentLanguage(), __DIR__.'/Locale');
    }

    public function getClasses() {
        return array(
            'Plugin\Backlog\Model' => array(
                'ProjectUsesBacklogBoardModel',
            )
        );
    }
    
    public function getPluginName()
    {
        return 'Backlog';
    }
    
    public function getPluginDescription()
    {
        return t('Plugin to add a backlog column with full height to project board');
    }
    
    public function getPluginAuthor()
    {
        return 'vistree + creecros';
    }
    
    public function getPluginVersion()
    {
        return '1.0.5';
    }
    
    public function getPluginHomepage()
    {
        return 'https://github.com/vistree/kanboard-backlog';
    }
    
    public function getCompatibleVersion()
    {
        return '>=1.0.45';
    }
}

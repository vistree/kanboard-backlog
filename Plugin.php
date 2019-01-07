<?php
namespace Kanboard\Plugin\Backlog;
use DateTime;
use Kanboard\Core\Plugin\Base;
use Kanboard\Core\Translator;
use Kanboard\Core\Security\Role;
class Plugin extends Base
{
    public function initialize()
    {
        if (file_exists('plugins/Bigboard')) {
            $this->template->setTemplateOverride('bigboard:board/view','backlog:board/view');
            $this->template->setTemplateOverride('bigboard:board/table_container','backlog:board/bb_table_container');
            $this->template->setTemplateOverride('board/table_container','backlog:board/bb_table_container');
        } else {
            $this->template->setTemplateOverride('board/table_container','backlog:board/table_container');
        }
        $this->template->setTemplateOverride('column/index','backlog:column/index');
        $this->template->setTemplateOverride('swimlane/table','backlog:swimlane/table');
        $this->hook->on('template:layout:js', array('template' => 'plugins/Backlog/Assets/backlog.js'));
        $this->hook->on('template:layout:css', array('template' => 'plugins/Backlog/Assets/backlog.css'));
        $this->template->hook->attach('template:project:dropdown', 'backlog:board/menu');
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
        return '1.0.3';
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

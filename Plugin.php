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
      $this->template->setTemplateOverride('board/table_container','backlog:board/table_container');     
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
        return 'vistree';
    }
    public function getPluginVersion()
    {
        return '0.0.1';
    }
    public function getPluginHomepage()
    {
        return 'https://github.com/vistree/kanboard-backlog';
    }
    public function getCompatibleVersion()
    {
        return '>=1.2.4';
    }
}

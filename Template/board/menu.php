<?php if ($this->user->hasProjectAccess('ProjectEditController', 'show', $project['id'])): ?>
    <?php if ($this->task->projectUsesBacklogBoardModel->backlogIsset($project['id'])): ?>
        <li>
            <i class="fa fa-plus-square-o fa-fw"></i>
            <?= $this->url->link(t('Change to Normal Board'), 'BacklogBoardController', 'backlogUnset', ['plugin' => 'backlog', 'project_id' => $project['id']]) ?>
        </li>
    <?php else: ?>
        <li>
            <i class="fa fa-plus-square-o fa-fw"></i>
            <?= $this->url->link(t('Change to Backlog Board'), 'BacklogBoardController', 'backlogSet', ['plugin' => 'backlog', 'project_id' => $project['id']]) ?>
        </li>
    <?php endif ?>
<?php endif ?>
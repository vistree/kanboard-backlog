<?php if ($this->projectMetadataModel->exists($project['id'], 'uses_backlogboard')): ?>
        <li>
        <i class="fa fa-plus-square-o fa-fw"></i>
        <?= $this->url->link(t('Change to Backlog Board'), 'BacklogBoardController', 'set', ['plugin' => 'backlog']) ?>
        </li>
<?php else: ?>
        <li>
        <i class="fa fa-plus-square-o fa-fw"></i>
        <?= $this->url->link(t('Change to Normal Board'), 'BacklogBoardController', 'unset', ['plugin' => 'backlog']) ?>
        </li>
<?php endif ?>

<?php // ADDED BY FL

$backloglane = $swimlanes[0];
// $backloglane['columns'][0]['title'] = 'Backlog';
$backloglane['columns'][0]['title'] = $this->task->configModel->get('backlog_board_title', 'Backlog');
$backlogcolumn = $backloglane['columns'][0];
$backloglane['columns'] = array();
$backloglane['columns'][] = $backlogcolumn;
$UseBacklog = FALSE;
$backlogwidth = 100 / $backloglane['nb_columns'];
$board_class = '';
?>
<?php if ($this->task->projectUsesBacklogBoardModel->backlogIsset($project['id'])) {
    $UseBacklog = TRUE;
    $board_class = ' backlog-enabled';
} ?>

<div id="board-container">
    <?php if (empty($swimlanes) || empty($swimlanes[0]['nb_columns'])): ?>
        <p class="alert alert-error"><?= t('There is no column or swimlane activated in your project!') ?></p>
    <?php else: ?>

    <?php if (isset($not_editable)): ?>
    <table id="board" class="board-project-<?= $project['id'] ?><?= $board_class ?>">
        <?php else: ?>
        <table id="board"
               class="board-project-<?= $project['id'] ?><?= $board_class ?>"
               data-project-id="<?= $project['id'] ?>"
               data-check-interval="<?= $board_private_refresh_interval ?>"
               data-save-url="<?= $this->url->href('BoardAjaxController', 'save', array('project_id' => $project['id'])) ?>"
               data-reload-url="<?= $this->url->href('BoardAjaxController', 'reload', array('project_id' => $project['id'])) ?>"
               data-check-url="<?= $this->url->href('BoardAjaxController', 'check', array('project_id' => $project['id'], 'timestamp' => time())) ?>"
               data-task-creation-url="<?= $this->url->href('TaskCreationController', 'show', array('project_id' => $project['id'])) ?>"
        >
            <?php endif ?>

            <?php if ($UseBacklog === TRUE): ?>
            <tbody>
            <tr>
                <td id="kanboard-column" style="min-width:240px; width:<?php print $backlogwidth; ?>%;" data-nb_columns="<?php print $backloglane['nb_columns']; ?>">
                    <table id="backlog-board">

                        <?= $this->render('board/table_column', array(
                            'swimlane' => $backloglane,
                            'not_editable' => isset($not_editable),
                        )) ?>
                        <?= $this->render('board/table_tasks', array(
                            'project' => $project,
                            'swimlane' => $backloglane,
                            'not_editable' => isset($not_editable),
                            'board_highlight_period' => $board_highlight_period,
                        )) ?>

                    </table>
                </td>
                <td>
                    <table id="main-board">

                        <?php array_shift($swimlanes); ?>
                        <?php endif ?>
                        <?php // END ADDED ?>




                        <?php foreach ($swimlanes as $index => $swimlane): ?>

                            <?php // ADDED BY FL ?>
                            <?php if ($UseBacklog === TRUE): ?>
                                <?php
                                unset($swimlane['columns'][0]);
                                $swimlane['nb_columns'] = $swimlane['nb_columns'] - 1;
                                ?>
                            <?php endif ?>
                            <?php // END ADDED ?>

                            <?php if (!($swimlane['nb_tasks'] === 0 && isset($not_editable))): ?>

                                <!-- Note: Do not show swimlane row on the top otherwise we can't collapse columns -->
                                <?php if ($index > 0 && $swimlane['nb_swimlanes'] > 1): ?>
                                    <?= $this->render('board/table_swimlane', array(
                                        'project' => $project,
                                        'swimlane' => $swimlane,
                                        'not_editable' => isset($not_editable),
                                    )) ?>
                                <?php endif ?>

                                <?= $this->render('board/table_column', array(
                                    'swimlane' => $swimlane,
                                    'not_editable' => isset($not_editable),
                                )) ?>

                                <?php if ($index === 0 && $swimlane['nb_swimlanes'] > 1): ?>
                                    <?= $this->render('board/table_swimlane', array(
                                        'project' => $project,
                                        'swimlane' => $swimlane,
                                        'not_editable' => isset($not_editable),
                                    )) ?>
                                <?php endif ?>

                                <?= $this->render('board/table_tasks', array(
                                    'project' => $project,
                                    'swimlane' => $swimlane,
                                    'not_editable' => isset($not_editable),
                                    'board_highlight_period' => $board_highlight_period,
                                )) ?>

                            <?php endif ?>
                        <?php endforeach ?>

                        <?php // ADDED BY FL ?>
                        <?php if ($UseBacklog === TRUE): ?>
                    </table>
                </td>
            </tr>
            </tbody>
        <?php endif ?>
            <?php // END ADDED BY FL ?>

        </table>

        <?php endif ?>
</div>

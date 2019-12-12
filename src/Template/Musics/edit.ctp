<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Music $music
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $music->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $music->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Musics'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="musics form large-9 medium-8 columns content">
    <?= $this->Form->create($music) ?>
    <fieldset>
        <legend><?= __('Edit Music') ?></legend>
        <?php
            echo $this->Form->control('title');
            echo $this->Form->control('category');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>

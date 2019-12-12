<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Music $music
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Music'), ['action' => 'edit', $music->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Music'), ['action' => 'delete', $music->id], ['confirm' => __('Are you sure you want to delete # {0}?', $music->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Musics'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Music'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="musics view large-9 medium-8 columns content">
    <h3><?= h($music->title) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Title') ?></th>
            <td><?= h($music->title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Category') ?></th>
            <td><?= h($music->category) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($music->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($music->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($music->modified) ?></td>
        </tr>
    </table>
</div>

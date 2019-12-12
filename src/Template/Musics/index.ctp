<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Music[]|\Cake\Collection\CollectionInterface $musics
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Music'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="musics index large-9 medium-8 columns content">
    <h3><?= __('Musics') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('title') ?></th>
                <th scope="col"><?= $this->Paginator->sort('category') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($musics as $music): ?>
            <tr>
                <td><?= $this->Number->format($music->id) ?></td>
                <td><?= h($music->title) ?></td>
                <td><?= h($music->category) ?></td>
                <td><?= h($music->created) ?></td>
                <td><?= h($music->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $music->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $music->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $music->id], ['confirm' => __('Are you sure you want to delete # {0}?', $music->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>

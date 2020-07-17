
<h1>Tags</h1>
<?= $this->Html->link('Add Tag', ['action' => 'add']) ?>
<table>
    <tr>
        <th>Title</th>
        <th>Created</th>
        <th>Action</th>
    </tr>

    <!-- Here is where we iterate through our $articles query object, printing out article info -->

    <?php foreach ($tags as $tag): ?>
    <tr>
        <td>
            <?= $this->Html->link($tag->title, ['action' => 'view', $tag->id]) ?>
        </td>
        <td>
            <?= $tag->created->format(DATE_RFC850) ?>
        </td>
        <td>
            <?= $this->Html->link('Edit', ['action' => 'edit', $tag->id]) ?> | 
            <?= $this->Form->postLink(
                'Delete',
                ['action' => 'delete', $tag->id],
                ['confirm' => 'Are you sure?'])
            ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
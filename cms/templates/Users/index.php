
<h1>Users</h1>
<?= $this->Html->link('Add User', ['action' => 'add']) ?>
<table>
    <tr>
        <th>Email</th>
        <th>Is Admin</th>
        <th>Action</th>
    </tr>

    <!-- Here is where we iterate through our $articles query object, printing out article info -->

    <?php foreach ($users as $user): ?>
    <tr>
        <td>
            <?= $this->Html->link($user->email, ['action' => 'view', $user->id]) ?>
        </td>
        <td>
            <?= ($user->is_admin) ? "True" : "False" ?>
        </td>
        <td>
            <?= $this->Html->link('Edit', ['action' => 'edit', $user->id]) ?> | 
            <?= $this->Form->postLink(
                'Delete',
                ['action' => 'delete', $user->id],
                ['confirm' => 'Are you sure?'])
            ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<h1><?= h($user->email) ?></h1>
<p>Is Admin: <?= ($user->is_admin) ? "True": "False" ?></p>
<p><small>Created: <?= $user->created->format(DATE_RFC850) ?></small></p>
<p><?= $this->Html->link('Edit', ['action' => 'edit', $user->id]) ?></p>
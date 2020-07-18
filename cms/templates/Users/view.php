<h1><?= h($user->email) ?></h1>
<p><small>Is Admin: <?= ($user->is_admin) ? "True": "False" ?></small></p>
<p><small>Created: <?= $user->created->format(DATE_RFC850) ?></small></p> <br />
<p><?= $this->Html->link('Edit', ['action' => 'edit', $user->id]) ?></p>
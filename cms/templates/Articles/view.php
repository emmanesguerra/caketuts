<h1><?= h($article->title) ?></h1>
<div style="width: 100%; float: left; margin-bottom: 15px;">
    <p><?= $article->body ?></p>
</div>
<p><small><b>Tags:</b> <?= h($article->tag_string) ?></small></p>
<p><small>Created: <?= $article->created->format(DATE_RFC850) ?></small></p>
<p><small>By: <?= $article->user->email ?></small></p><br />
<p><?= $this->Html->link('Edit', ['action' => 'edit', $article->slug]) ?></p>
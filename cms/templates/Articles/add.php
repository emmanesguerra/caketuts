<h1>Add Article</h1>
<?php
    echo $this->Form->create($article);
    echo $this->Form->control('title');
    echo $this->Form->control('tags._ids', ['options' => $tags, 'style' => 'height: 100px']);
    echo $this->Form->control('body', ['rows' => '3', 'id'=>'ckeditor']);
    echo $this->Form->button(__('Save Article'), ['style' => 'margin-top: 15px']);
    echo $this->Form->end();
?>
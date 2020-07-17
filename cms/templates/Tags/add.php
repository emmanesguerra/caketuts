<h1>Add Tag</h1>
<?php
    echo $this->Form->create($tag);
    // Hard code the user for now.
    echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => 1]);
    echo $this->Form->control('title');
    echo $this->Form->button(__('Save Tag'));
    echo $this->Form->end();
?>
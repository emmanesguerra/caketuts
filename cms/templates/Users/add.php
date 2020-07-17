<h1>Add User</h1>
<?php
    echo $this->Form->create($user);
    // Hard code the user for now.
    echo $this->Form->control('email');
    echo $this->Form->control('password');
    echo $this->Form->radio('is_admin',
            [
                ['value' => '1', 'text' => ' Admin'],
                ['value' => '0', 'text' => ' Normal User']
            ]);
    echo $this->Form->button(__('Save User'));
    echo $this->Form->end();
?>
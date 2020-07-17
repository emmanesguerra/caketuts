<h1>Edit User</h1>
<?php
    echo $this->Form->create($user);
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
<?php
declare(strict_types=1);

use Migrations\AbstractSeed;
use Cake\Auth\DefaultPasswordHasher;

/**
 * Users seed.
 */
class UsersSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     *
     * @return void
     */
    public function run()
    {
        $hasher = new DefaultPasswordHasher();
        
        $data = [
            [
                'email' => 'emman.admin@gmail.com',
                'password' => $hasher->hash('emman'),
                'is_admin' => true,
                'created' => '2020-07-17 15:41:00',
                'modified' => '2020-07-17 15:41:00'
            ],
            [
                'email' => 'emman.nu@gmail.com',
                'password' => $hasher->hash('emman'),
                'is_admin' => false,
                'created' => '2020-07-17 15:41:00',
                'modified' => '2020-07-17 15:41:00'
            ],
            [
                'email' => 'kath.nu@gmail.com',
                'password' => $hasher->hash('kath'),
                'is_admin' => false,
                'created' => '2020-07-17 15:41:00',
                'modified' => '2020-07-17 15:41:00'
            ],
            [
                'email' => 'bin.nu@gmail.com',
                'password' => $hasher->hash('bin'),
                'is_admin' => false,
                'created' => '2020-07-17 15:41:00',
                'modified' => '2020-07-17 15:41:00'
            ]
        ];

        $table = $this->table('users');
        $table->insert($data)->save();
    }
}

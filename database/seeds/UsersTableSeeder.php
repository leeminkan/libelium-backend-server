<?php

use Illuminate\Database\Seeder;
use App\Repositories\Interfaces\UserRepository;

class UsersTableSeeder extends Seeder
{
    
    /**
     * @var UserRepository
     */
    private $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        try {
            $credentials = [
                'name' => 'admin',
                'email' => 'admin@localhost',
                'password' => bcrypt('admin'),
            ];

            $this->user->create($credentials);
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
        }
    }
}

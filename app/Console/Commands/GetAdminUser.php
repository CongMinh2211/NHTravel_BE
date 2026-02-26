<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GetAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-admin-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get user data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = \App\Models\NguoiDung::all();
        foreach ($users as $u) {
            $this->info($u->email . ' - ' . $u->password);
        }
    }
}

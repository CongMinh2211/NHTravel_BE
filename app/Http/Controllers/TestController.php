<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class TestController extends Controller
{
    public function seedDb()
    {
        try {
            Artisan::call('migrate:fresh', [
                '--seed' => true,
                '--force' => true
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Database migrated and seeded successfully. All default data should now exist.',
                'output' => Artisan::output()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error executing seeder: ' . $e->getMessage()
            ], 500);
        }
    }
}

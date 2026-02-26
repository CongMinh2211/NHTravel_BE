<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class TestController extends Controller
{
    public function seedDb()
    {
        try {
            Artisan::call('db:seed', [
                '--class' => 'NguoiDungSeeder',
                '--force' => true
            ]);
            return response()->json([
                'status' => true,
                'message' => 'NguoiDungSeeder executed successfully. Admin account should now exist.',
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

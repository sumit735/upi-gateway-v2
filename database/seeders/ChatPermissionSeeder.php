<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChatPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Get or create Chat page
        $chatPage = DB::table('pages')->where('route_pattern', 'admin.chat.*')->first();
        
        if (!$chatPage) {
            $chatPageId = DB::table('pages')->insertGetId([
                'name' => 'Chat',
                'route_pattern' => 'admin.chat.*',
                'description' => 'Chat with support team',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $chatPageId = $chatPage->id;
        }
        
        // Get view action
        $viewAction = DB::table('actions')->where('slug', 'view')->first();
        
        // Get roles
        $adminRole = DB::table('roles')->where('name', 'Admin')->first();
        $userRole = DB::table('roles')->where('name', 'User')->first();
        
        // Add permissions for admin (all scope)
        if ($adminRole && !DB::table('role_permissions')
            ->where('role_id', $adminRole->id)
            ->where('page_id', $chatPageId)
            ->where('action_id', $viewAction->id)
            ->exists()) {
            
            DB::table('role_permissions')->insert([
                'role_id' => $adminRole->id,
                'page_id' => $chatPageId,
                'action_id' => $viewAction->id,
                'scope' => 'all',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        // Add permissions for user (self scope)
        if ($userRole && !DB::table('role_permissions')
            ->where('role_id', $userRole->id)
            ->where('page_id', $chatPageId)
            ->where('action_id', $viewAction->id)
            ->exists()) {
            
            DB::table('role_permissions')->insert([
                'role_id' => $userRole->id,
                'page_id' => $chatPageId,
                'action_id' => $viewAction->id,
                'scope' => 'self',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        $this->command->info('Chat permissions seeded successfully!');
    }
}

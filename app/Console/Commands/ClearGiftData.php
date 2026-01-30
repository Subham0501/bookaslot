<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ClearGiftData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gifts:clear {--force : Force the operation without confirmation} {--check : Check what gifts exist before clearing}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all gift, addon, and order data from database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Check option - show what exists
        if ($this->option('check')) {
            if (Schema::hasTable('gifts')) {
                $gifts = DB::table('gifts')->select('id', 'name', 'price')->get();
                $this->info('Current gifts in database:');
                if ($gifts->count() > 0) {
                    foreach ($gifts as $gift) {
                        $this->line("  - ID: {$gift->id}, Name: {$gift->name}, Price: {$gift->price}");
                    }
                } else {
                    $this->info('  No gifts found.');
                }
            }
            return 0;
        }
        
        if ($this->option('force') || $this->confirm('This will delete all gifts, addons, and orders. Are you sure?')) {
            try {
                // Disable foreign key checks
                if (config('database.default') === 'mysql') {
                    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                } elseif (config('database.default') === 'sqlite') {
                    DB::statement('PRAGMA foreign_keys = OFF;');
                }
                
                // Delete in correct order - foreign keys are already disabled
                // Delete orders first
                if (Schema::hasTable('orders')) {
                    $orderCount = DB::table('orders')->count();
                    if ($orderCount > 0) {
                        DB::statement('DELETE FROM orders');
                        $this->info("Deleted {$orderCount} order(s).");
                    }
                }
                
                // Delete addons second
                if (Schema::hasTable('gift_addons')) {
                    $addonCount = DB::table('gift_addons')->count();
                    if ($addonCount > 0) {
                        DB::statement('DELETE FROM gift_addons');
                        $this->info("Deleted {$addonCount} addon(s).");
                    }
                }
                
                // Delete gifts last
                if (Schema::hasTable('gifts')) {
                    $allGifts = DB::table('gifts')->get();
                    $count = $allGifts->count();
                    
                    if ($count > 0) {
                        $this->info("Found {$count} gift(s) in database:");
                        foreach ($allGifts as $gift) {
                            $this->line("  - ID: {$gift->id}, Name: {$gift->name}, Price: {$gift->price}");
                        }
                        
                        // Use raw SQL DELETE - most reliable
                        DB::statement('DELETE FROM gifts');
                        $this->info("Deleted {$count} gift(s) using raw SQL DELETE.");
                        
                        // Verify deletion
                        $remaining = DB::table('gifts')->count();
                        if ($remaining > 0) {
                            $this->warn("Warning: {$remaining} gift(s) still remain. Trying again...");
                            DB::statement('DELETE FROM gifts');
                            $remaining = DB::table('gifts')->count();
                            if ($remaining > 0) {
                                $this->error("ERROR: {$remaining} gift(s) still remain after multiple attempts!");
                            } else {
                                $this->info("✓ All gifts deleted on second attempt.");
                            }
                        } else {
                            $this->info("✓ All gifts successfully deleted. Database is now empty.");
                        }
                    } else {
                        $this->info("Database is already empty - no gifts found.");
                    }
                }
                
                // Re-enable foreign key checks
                if (config('database.default') === 'mysql') {
                    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
                } elseif (config('database.default') === 'sqlite') {
                    DB::statement('PRAGMA foreign_keys = ON;');
                }
                
                $this->info('All gift data cleared successfully!');
                $this->info('You can now run: php artisan db:seed --class=GiftSeeder');
            } catch (\Exception $e) {
                $this->error('Error clearing data: ' . $e->getMessage());
                $this->error('Stack trace: ' . $e->getTraceAsString());
                
                // Try simple delete as fallback
                try {
                    $this->info('Trying simple delete method...');
                    DB::table('gift_addons')->delete();
                    DB::table('orders')->delete();
                    $deleted = DB::table('gifts')->delete();
                    $this->info("Deleted {$deleted} gifts using simple method.");
                } catch (\Exception $e2) {
                    $this->error('Simple method also failed: ' . $e2->getMessage());
                    return 1;
                }
            }
            
            return 0;
        }
        
        $this->info('Operation cancelled.');
        return 0;
    }
}

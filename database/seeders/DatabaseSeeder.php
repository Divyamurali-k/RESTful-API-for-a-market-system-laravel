<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Schema::disableForeignKeyConstraints();
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        User::truncate();
        Category::truncate();
        Product::truncate();
        Transaction::truncate();
        DB::table('category_product')->truncate();

        // User::flushEventListeners();
        // Category::flushEventListeners();
        // Product::flushEventListeners();
        // Transaction::flushEventListeners();

        $usersQuantity = 1000;
        $categoriesQuantity = 30;
        $productsQuantity = 500;
        $transactionsQuantity = 1000;


        // Create Users
        User::factory($usersQuantity)->create();

        // Create Categories
        Category::factory($categoriesQuantity)->create();

        // Create Products and attach categories
        Product::factory($productsQuantity)
            ->create()
            ->each(function ($product) {
                $categories = Category::all()->random(mt_rand(1, 5))->pluck('id');
                $product->categories()->attach($categories);
            });

        // Create Transactions
        Transaction::factory($transactionsQuantity)->create();


        // Passport::client()->forceCreate([
        //     'user_id' => null,
        //     'name' => '',
        //     'secret' => 'secret',
        //     'redirect' => '',
        //     'personal_access_client' => true,
        //     'password_client' => true,
        //     'revoked' => false,
        // ]);

        // $personalClient = Passport::client()->forceCreate([
        //     'user_id' => null,
        //     'name' => '',
        //     'secret' => 'secret',
        //     'redirect' => '',
        //     'personal_access_client' => true,
        //     'password_client' => false,
        //     'revoked' => false,
        // ]);

        // Passport::personalAccessClient()->forceCreate([
        //     'client_id' => $personalClient->id,
        // ]);

        // Schema::enableForeignKeyConstraints();
    }
}

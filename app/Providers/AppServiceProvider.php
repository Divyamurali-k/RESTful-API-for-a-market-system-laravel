<?php

namespace App\Providers;

use App\Mail\UserCreated;
use App\Mail\UserMailChanged;
use App\Models\Buyer;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use App\Models\Passport\PersonalAccessClient;
use App\Models\Passport\RefreshToken;
use App\Models\Passport\Token;
use App\Models\Seller;
use App\Models\Transaction;
use App\Policies\BuyerPolicy;
use App\Policies\ProductPolicy;
use App\Policies\SellerPolicy;
use App\Policies\TransactionPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{

    protected $policies = [
        Buyer::class => BuyerPolicy::class,
        Product::class=>ProductPolicy::class,
        Seller::class => SellerPolicy::class,
        Transaction::class => TransactionPolicy::class,
        User::class => UserPolicy::class,
        
    ];
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Gate::policy(Buyer::class, BuyerPolicy::class);
        // Gate::policy(Seller::class, SellerPolicy::class);
        // Gate::policy(User::class, UserPolicy::class);
        // Gate::policy(Transaction::class, TransactionPolicy::class);
        Gate::define('admin-action', function ($user) {
            return $user->isAdmin();
        });

        Schema::defaultStringLength(191);
        // Passport::loadKeysFrom(__DIR__.'../../storage');
        // Passport::routes();
        // Passport::useTokenModel(Token::class);
        // Passport::useRefreshTokenModel(RefreshToken::class);
        // Passport::useAuthCodeModel(AuthCode::class);

        Passport::enableImplicitGrant();
        Passport::enablePasswordGrant();
        Passport::tokensCan([
            'purchase-product' => 'Create a new transaction for a specific product',
            'manage-products' => 'Create, read, update, and delete products (CRUD)',
            'manage-account' => 'Read your account data, id, name, email, if verified, and if admin (cannot read password). Modify your account data (email, and password). Cannot delete your account',
            'read-general' => 'Read general information like purchasing categories, purchased products, selling products, selling categories, your transactions (purchases and sales)',
        ]);
        Passport::tokensExpireIn(now()->addMinutes(30));
        Passport::refreshTokensExpireIn(now()->addDays(30));
        // Passport::personalAccessTokensExpireIn(now()->addMonths(6));


        User::created(function ($user) {

            retry(5, function () use ($user) {
                Mail::to($user)->send(new UserCreated($user));
            }, 100);
        });

        User::updated(function ($user) {
            if ($user->isDirty('email')) {
                retry(5, function () use ($user) {
                    Mail::to($user)->send(new UserMailChanged($user));
                }, 100);
            }
        });

        Product::updated(function ($product) {
            if ($product->quantity == 0 && $product->isAvailable()) {

                $product->status = Product::UNAVAILABLE_PRODUCT;
                $product->save();
            }
        });
    }
}

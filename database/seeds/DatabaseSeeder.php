<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        Model::unguard();
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $toTruncate=[
            'comment',
            'order_product',
            'order',
            'product_image',
            'tax',
            'price',
            'product',
            'category',
            'user'];

        foreach($toTruncate as $table){
            DB::table($table)->truncate();
        }

        $this->call(UserTableSeeder::class);

        $this->call(CategoryTableSeeder::class);

        $this->call(ProductTableSeeder::class);

        $this->call(ProductImageTableSeeder::class);

        $this->call(PriceTableSeeder::class);

        $this->call(TaxTableSeeder::class);

        $this->call(OrderTableSeeder::class);

        $this->call(OrderProductTableSeeder::class);

        $this->call(CommentTableSeeder::class);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Model::reguard();

    }
}

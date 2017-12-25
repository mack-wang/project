<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(AdminSeeder::class);
         $this->call(ArticleSeeder::class);
         $this->call(CatalogSeeder::class);
         $this->call(HeadlineSeeder::class);
         $this->call(SlideImageSeeder::class);
         $this->call(ContactSeeder::class);
         $this->call(WechatConfigSeeder::class);
         $this->call(CompanyInfoSeeder::class);
    }
}

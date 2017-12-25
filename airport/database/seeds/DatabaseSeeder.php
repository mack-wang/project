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
        $this->call(AdminsSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(ShopsSeeder::class);
        $this->call(ShopAreasSeeder::class);
        $this->call(ShopManagersSeeder::class);
        $this->call(UserAttrSeeder::class);
        $this->call(UserAddressSeeder::class);
        $this->call(ShopAddressSeeder::class);
        $this->call(ShopAttrSeeder::class);
        $this->call(UserWechatsSeeder::class);
        $this->call(UserWechatInfosSeeder::class);
        $this->call(UserInfosSeeder::class);
        $this->call(UserLevelNamesSeeder::class);
        $this->call(UserCigarettesSeeder::class);
        $this->call(SlideImageSeeder::class);
        $this->call(CigaretteLabelsSeeder::class);
        $this->call(ActivitiesSeeder::class);
        $this->call(ActivityAttrsSeeder::class);
        $this->call(ActivityPrizesSeeder::class);
        $this->call(ActivityRequiresSeeder::class);
        $this->call(ActivityShopsSeeder::class);
        $this->call(ArticlesSeeder::class);
        $this->call(ShopHeadimgsSeeder::class);
        $this->call(CigarettePricesSeeder::class);
        $this->call(GrassesSeeder::class);
        $this->call(GrassAttrsSeeder::class);
        $this->call(ActivityTasksSeeder::class);
        $this->call(ResultTasksSeeder::class);
        $this->call(ResultAppliesSeeder::class);
        $this->call(ResultQuestionsSeeder::class);
        $this->call(QuestionsSeeder::class);
        $this->call(ActivityQuestionsSeeder::class);
        $this->call(ActivityHeadimgsSeeder::class);
        $this->call(QrcodePrizesSeeder::class);
        $this->call(LotteriesSeeder::class);
    }
}

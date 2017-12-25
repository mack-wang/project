<?php

use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //管理员表填充
        //油
        DB::table('articles')->delete();
        DB::table('articles')->insert([
            'id' => 1,
            'catalog_id' => 1,
            'brand' => '金龙鱼',
            'image' => '/img/article/1.jpg',
            'title' => '金龙鱼黄金比例调和油',
            'brief' => '1:1:1黄金比例，营养专家的"吃油"诀窍',
            'content' => '<img class="fullwidth" src="'.asset('/img/article/1-1.jpg').'">',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('articles')->insert([
            'id' => 2,
            'catalog_id' => 1,
            'brand' => '金龙鱼',
            'image' => '/img/article/2.jpg',
            'title' => '金龙鱼阳光葵花籽油',
            'brief' => '阳光葵花籽油，把欧洲阳光带回家',
            'content' => '<img class="fullwidth" src="'.asset('/img/article/2-1.jpg').'">',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('articles')->insert([
            'id' => 3,
            'catalog_id' => 1,
            'brand' => '金龙鱼',
            'image' => '/img/article/3.jpg',
            'title' => '金龙鱼谷维多稻米油',
            'brief' => '谷维多稻米油，还原记忆中家的味道',
            'content' => '<img class="fullwidth" src="'.asset('/img/article/3-1.jpg').'">',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('articles')->insert([
            'id' => 4,
            'catalog_id' => 1,
            'brand' => '金龙鱼',
            'image' => '/img/article/4.jpg',
            'title' => '金龙鱼植物甾醇玉米油',
            'brief' => '植物甾醇玉米油，便民健康"心"管理',
            'content' => '<img class="fullwidth" src="'.asset('/img/article/4-1.jpg').'">',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('articles')->insert([
            'id' => 5,
            'catalog_id' => 1,
            'brand' => '金龙鱼',
            'image' => '/img/article/5.jpg',
            'title' => '金龙鱼特香花生油',
            'brief' => '三重蕴香工艺，美味更胜一筹',
            'content' => '<img class="fullwidth" src="'.asset('/img/article/5-1.jpg').'">',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('articles')->insert([
            'id' => 6,
            'catalog_id' => 1,
            'brand' => '金龙鱼',
            'image' => '/img/article/6.jpg',
            'title' => '金龙鱼大豆油',
            'brief' => '纯香维生素A，营养强化大豆油',
            'content' => '<img class="fullwidth" src="'.asset('/img/article/6-1.jpg').'">',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('articles')->insert([
            'id' => 7,
            'catalog_id' => 1,
            'brand' => '金龙鱼',
            'image' => '/img/article/7.jpg',
            'title' => '金龙鱼菜籽油',
            'brief' => '香味大升级，菜油香更浓',
            'content' => '<img class="fullwidth" src="'.asset('/img/article/7-1.jpg').'">',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('articles')->insert([
            'id' => 8,
            'catalog_id' => 1,
            'brand' => '金龙鱼',
            'image' => '/img/article/8.jpg',
            'title' => '金龙鱼油茶菜籽油',
            'brief' => '东方养生，中产阶级选择的茶油品牌',
            'content' => '<img class="fullwidth" src="'.asset('/img/article/8-1.jpg').'">',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('articles')->insert([
            'id' => 9,
            'catalog_id' => 1,
            'brand' => '金龙鱼',
            'image' => '/img/article/9.jpg',
            'title' => '金龙鱼胡麻油',
            'brief' => '精心甄选原料，100%纯正胡麻油',
            'content' => '<img class="fullwidth" src="'.asset('/img/article/9-1.jpg').'">',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('articles')->insert([
            'id' => 10,
            'catalog_id' => 1,
            'brand' => '金龙鱼',
            'image' => '/img/article/10.jpg',
            'title' => '金龙鱼外婆乡小榨菜籽油',
            'brief' => '堂深藏不住，寓情香更浓',
            'content' => '<img class="fullwidth" src="'.asset('/img/article/10-1.jpg').'">',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('articles')->insert([
            'id' => 11,
            'catalog_id' => 1,
            'brand' => '欧丽薇兰',
            'image' => '/img/article/11.jpg',
            'title' => '欧丽薇兰橄榄油',
            'brief' => '欧丽薇兰橄榄油，源自地中海的优良品牌',
            'content' => '<img class="fullwidth" src="'.asset('/img/article/11-1.jpg').'">',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('articles')->insert([
            'id' => 12,
            'catalog_id' => 1,
            'brand' => '欧丽薇兰',
            'image' => '/img/article/12.jpg',
            'title' => '欧丽薇兰特级初榨橄榄油',
            'brief' => '源自地中海的优良品牌',
            'content' => '<img class="fullwidth" src="'.asset('/img/article/12-1.jpg').'">',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('articles')->insert([
            'id' => 13,
            'catalog_id' => 1,
            'brand' => '欧丽薇兰',
            'image' => '/img/article/13.jpg',
            'title' => '欧丽薇兰高多酚特级初榨橄榄油',
            'brief' => '身与心的无上宠爱',
            'content' => '<img class="fullwidth" src="'.asset('/img/article/13-1.jpg').'">',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('articles')->insert([
            'id' => 14,
            'catalog_id' => 1,
            'brand' => '胡姬花',
            'image' => '/img/article/14.jpg',
            'title' => '胡姬花古法小榨花生油',
            'brief' => '传承近百年工艺精髓，胡姬花古法小榨花生油',
            'content' => '<img class="fullwidth" src="'.asset('/img/article/14-1.jpg').'">',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('articles')->insert([
            'id' => 15,
            'catalog_id' => 1,
            'brand' => '鲤鱼',
            'image' => '/img/article/15.jpg',
            'title' => '鲤鱼小榨浓香香菜籽油',
            'brief' => '鲤鱼小榨浓香菜籽油，25年只做菜籽油！',
            'content' => '<img class="fullwidth" src="'.asset('/img/article/15-1.jpg').'">',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('articles')->insert([
            'id' => 16,
            'catalog_id' => 1,
            'brand' => '香满园',
            'image' => '/img/article/16.jpg',
            'title' => '香满园系列食用油',
            'brief' => '自然美味，尽享舌尖香味',
            'content' => '<img class="fullwidth" src="'.asset('/img/article/16-1.jpg').'">',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('articles')->insert([
            'id' => 17,
            'catalog_id' => 1,
            'brand' => '其他',
            'image' => '/img/article/17.jpg',
            'title' => '其他众多优质品牌小包装油',
            'brief' => '世界500强旗下企业荣誉出品系列食用油',
            'content' => '<img class="fullwidth" src="'.asset('/img/article/17-1.jpg').'">',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        /*米*/
        DB::table('articles')->insert([
            'id' => 18,
            'catalog_id' => 2,
            'brand' => '金龙鱼',
            'image' => '/img/article/18.jpg',
            'title' => '金龙鱼稻米系列',
            'brief' => '选好米，有"稻"理',
            'content' => '<img class="fullwidth" src="'.asset('/img/article/18-1.jpg').'">',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('articles')->insert([
            'id' => 19,
            'catalog_id' => 2,
            'brand' => '金龙鱼',
            'image' => '/img/article/19.jpg',
            'title' => '金龙鱼大米礼盒系列',
            'brief' => '中国美食联合国申遗使用大米',
            'content' => '<img class="fullwidth" src="'.asset('/img/article/19-1.jpg').'">',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('articles')->insert([
            'id' => 20,
            'catalog_id' => 2,
            'brand' => '金龙鱼',
            'image' => '/img/article/20.jpg',
            'title' => '金龙鱼乳玉皇妃留胚凝香弱碱性糙米',
            'brief' => '轻脂，轻体，年经态',
            'content' => '<img class="fullwidth" src="'.asset('/img/article/20-1.jpg').'">',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('articles')->insert([
            'id' => 21,
            'catalog_id' => 2,
            'brand' => '金龙鱼',
            'image' => '/img/article/21.jpg',
            'title' => '金龙鱼乳玉皇妃香贡米',
            'brief' => '乳玉皇妃，香糯入魂',
            'content' => '<img class="fullwidth" src="'.asset('/img/article/21-1.jpg').'">',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('articles')->insert([
            'id' => 22,
            'catalog_id' => 2,
            'brand' => '金龙鱼',
            'image' => '/img/article/22.jpg',
            'title' => '金龙鱼糯米系列',
            'brief' => '饭粒软糯香滑，湿润滋养',
            'content' => '<img class="fullwidth" src="'.asset('/img/article/22-1.jpg').'">',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('articles')->insert([
            'id' => 23,
            'catalog_id' => 2,
            'brand' => '香满园',
            'image' => '/img/article/23.jpg',
            'title' => '香满园大米系列',
            'brief' => '香满园，就是香',
            'content' => '<img class="fullwidth" src="'.asset('/img/article/23-1.jpg').'">',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('articles')->insert([
            'id' => 24,
            'catalog_id' => 2,
            'brand' => '香纳兰',
            'image' => '/img/article/24.jpg',
            'title' => '香纳兰泰国茉莉香米',
            'brief' => '香纳兰泰米清莱府原装进口，茉莉香米，清甜可口',
            'content' => '<img class="fullwidth" src="'.asset('/img/article/24-1.jpg').'">',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        /*面粉*/
        DB::table('articles')->insert([
            'id' => 25,
            'catalog_id' => 3,
            'brand' => '金龙鱼',
            'image' => '/img/article/25.jpg',
            'title' => '金龙鱼麦芯粉系列',
            'brief' => '用"芯"造，真筋道',
            'content' => '<img class="fullwidth" src="'.asset('/img/article/25-1.jpg').'">',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('articles')->insert([
            'id' => 26,
            'catalog_id' => 3,
            'brand' => '金龙鱼',
            'image' => '/img/article/26.jpg',
            'title' => '金龙鱼蛋糕粉面包粉',
            'brief' => '绵软好口感，麦香味更浓',
            'content' => '<img class="fullwidth" src="'.asset('/img/article/26-1.jpg').'">',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('articles')->insert([
            'id' => 27,
            'catalog_id' => 3,
            'brand' => '金龙鱼',
            'image' => '/img/article/27.jpg',
            'title' => '金龙鱼预拌蛋糕粉面包粉',
            'brief' => '乐享美味，3步OK',
            'content' => '<img class="fullwidth" src="'.asset('/img/article/27-1.jpg').'">',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('articles')->insert([
            'id' => 28,
            'catalog_id' => 3,
            'brand' => '香满园',
            'image' => '/img/article/28.jpg',
            'title' => '香满园面粉系列',
            'brief' => '新鲜小麦，阳光麦香！',
            'content' => '<img class="fullwidth" src="'.asset('/img/article/28-1.jpg').'">',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        //挂面
        DB::table('articles')->insert([
            'id' => 29,
            'catalog_id' => 4,
            'brand' => '金龙鱼',
            'image' => '/img/article/29.jpg',
            'title' => '金龙鱼麦芯挂面系列',
            'brief' => '麦芯造，真筋道',
            'content' => '<img class="fullwidth" src="'.asset('/img/article/29-1.jpg').'">',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('articles')->insert([
            'id' =>30,
            'catalog_id' => 4,
            'brand' => '金龙鱼',
            'image' => '/img/article/30.jpg',
            'title' => '金龙鱼51优+荞麦挂面',
            'brief' => '神奇荞麦，健康之选，独特工艺，荞麦粉含量高',
            'content' => '<img class="fullwidth" src="'.asset('/img/article/30-1.jpg').'">',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        //调味品
        DB::table('articles')->insert([
            'id' => 31,
            'catalog_id' => 5,
            'brand' => '金龙鱼',
            'image' => '/img/article/31.jpg',
            'title' => '金龙鱼小磨香油',
            'brief' => '传承千年的制作工艺，慢工出细活的匠人本色',
            'content' => '<img class="fullwidth" src="'.asset('/img/article/31-1.jpg').'">',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('articles')->insert([
            'id' => 32,
            'catalog_id' => 5,
            'brand' => '金龙鱼',
            'image' => '/img/article/32.jpg',
            'title' => '金龙鱼芝麻油',
            'brief' => '100%原榨纯芝麻油：精心挑选每颗饱满优质的纯芝麻。',
            'content' => '<img class="fullwidth" src="'.asset('/img/article/32-1.jpg').'">',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('articles')->insert([
            'id' => 33,
            'catalog_id' => 5,
            'brand' => '金龙鱼',
            'image' => '/img/article/33.jpg',
            'title' => '金龙鱼花椒油',
            'brief' => '精心甄选原料，鲜采七八月汉源贡椒，传统工艺熬制。',
            'content' => '<img class="fullwidth" src="'.asset('/img/article/33-1.jpg').'">',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('articles')->insert([
            'id' => 34,
            'catalog_id' => 5,
            'brand' => '金龙鱼',
            'image' => '/img/article/34.jpg',
            'title' => '金龙鱼芝麻浓香调和油',
            'brief' => '满口芝麻香，凉拌好帮手',
            'content' => '<img class="fullwidth" src="'.asset('/img/article/34-1.jpg').'">',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        //食品饮料
        DB::table('articles')->insert([
            'id' => 35,
            'catalog_id' => 6,
            'brand' => '金龙鱼',
            'image' => '/img/article/35.jpg',
            'title' => '金龙鱼速食豆腐花',
            'brief' => '新鲜豆花冲出来，细腻嫩滑，随心搭配',
            'content' => '<img class="fullwidth" src="'.asset('/img/article/35-1.jpg').'">',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('articles')->insert([
            'id' => 36,
            'catalog_id' => 6,
            'brand' => '金龙鱼',
            'image' => '/img/article/36.jpg',
            'title' => '金龙鱼豆乳系列豆浆粉',
            'brief' => '现代工艺，传承古方',
            'content' => '<img class="fullwidth" src="'.asset('/img/article/36-1.jpg').'">',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('articles')->insert([
            'id' => 37,
            'catalog_id' => 6,
            'brand' => 'Morning-Cup',
            'image' => '/img/article/37.jpg',
            'title' => 'Morning-Cup营养豆乳',
            'brief' => '在最好的时光里，做最好的自己',
            'content' => '<img class="fullwidth" src="'.asset('/img/article/37-1.jpg').'">',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        //全球优品
        DB::table('articles')->insert([
            'id' => 38,
            'catalog_id' => 7,
            'brand' => '纽麦福',
            'image' => '/img/article/38.jpg',
            'title' => '纽麦福 新西兰纯牛奶',
            'brief' => '新西兰原装进口，销往全球25个国家，天然草场',
            'content' => '<img class="fullwidth" src="'.asset('/img/article/38-1.jpg').'">',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('articles')->insert([
            'id' => 39,
            'catalog_id' => 7,
            'brand' => '家乐氏',
            'image' => '/img/article/39.jpg',
            'title' => '家乐氏营养早餐系列',
            'brief' => '源起欧美，风靡百年的谷物',
            'content' => '<img class="fullwidth" src="'.asset('/img/article/39-1.jpg').'">',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('articles')->insert([
            'id' => 40,
            'catalog_id' => 7,
            'brand' => '切尔西',
            'image' => '/img/article/40.jpg',
            'title' => '切尔西黑糖',
            'brief' => '来自天然净土岛国新西兰；精益求精，专注制糖',
            'content' => '<img class="fullwidth" src="'.asset('/img/article/40-1.jpg').'">',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        //休闲食品
        DB::table('articles')->insert([
            'id' => 41,
            'catalog_id' => 8,
            'brand' => '品客',
            'image' => '/img/article/41.jpg',
            'title' => '品客薯片',
            'brief' => '美味劲爆来袭',
            'content' => '<img class="fullwidth" src="'.asset('/img/article/41-1.jpg').'">',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        //日化
        DB::table('articles')->insert([
            'id' => 42,
            'catalog_id' => 9,
            'brand' => '洁劲100',
            'image' => '/img/article/42.jpg',
            'title' => '洁劲100洗洁精',
            'brief' => '高效去油，易漂易洗，净味安全，无磷环保',
            'content' => '<img class="fullwidth" src="'.asset('/img/article/42-1.jpg').'">',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('articles')->insert([
            'id' => 43,
            'catalog_id' => 9,
            'brand' => '洁劲100',
            'image' => '/img/article/43.jpg',
            'title' => '洁劲100洗衣皂',
            'brief' => '超效洁净，皂服一夏',
            'content' => '<img class="fullwidth" src="'.asset('/img/article/43-1.jpg').'">',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('articles')->insert([
            'id' => 44,
            'catalog_id' => 9,
            'brand' => '绿涤',
            'image' => '/img/article/44.jpg',
            'title' => '绿涤系列',
            'brief' => '纯植物皂基，强效去污',
            'content' => '<img class="fullwidth" src="'.asset('/img/article/44-1.jpg').'">',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        //头条文章
        DB::table('articles')->insert([
            'id' => 45,
            'catalog_id' => 10,
            'brand' => '钜合',
            'image' => '/img/article/1.jpg',
            'title' => '企业团购福利，8折起，点击查看详情',
            'brief' => '活动时间：2017年6月30日。名额前100名下单享受。',
            'content' => '具体文章内容',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('articles')->insert([
            'id' => 46,
            'catalog_id' => 10,
            'brand' => '钜合',
            'image' => '/img/article/1.jpg',
            'title' => '新品推荐：金龙鱼最新款食用油',
            'brief' => '好油，给你最好的健康',
            'content' => '具体文章内容',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('articles')->insert([
            'id' => 47,
            'catalog_id' => 10,
            'brand' => '钜合',
            'image' => '/img/article/1.jpg',
            'title' => '七月暑期巨献，免费送饮料福利',
            'brief' => '活动时间：2017年8月1日-9月1日',
            'content' => '具体文章内容',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('articles')->insert([
            'id' => 48,
            'catalog_id' => 11,
            'brand' => '金龙鱼',
            'image' => '/img/article/9.jpg',
            'title' => '金龙鱼胡麻油',
            'brief' => '精心甄选原料，100%纯正胡麻油',
            'content' => '<img class="fullwidth" src="'.asset('/img/article/9-1.jpg').'">',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('articles')->insert([
            'id' => 49,
            'catalog_id' => 11,
            'brand' => '金龙鱼',
            'image' => '/img/article/10.jpg',
            'title' => '金龙鱼外婆乡小榨菜籽油',
            'brief' => '堂深藏不住，寓情香更浓',
            'content' => '<img class="fullwidth" src="'.asset('/img/article/10-1.jpg').'">',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('articles')->insert([
            'id' => 50,
            'catalog_id' => 11,
            'brand' => '欧丽薇兰',
            'image' => '/img/article/11.jpg',
            'title' => '欧丽薇兰橄榄油',
            'brief' => '欧丽薇兰橄榄油，源自地中海的优良品牌',
            'content' => '<img class="fullwidth" src="'.asset('/img/article/11-1.jpg').'">',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('articles')->insert([
            'id' => 51,
            'catalog_id' => 12,
            'brand' => '欧丽薇兰',
            'image' => '/img/article/12.jpg',
            'title' => '欧丽薇兰特级初榨橄榄油',
            'brief' => '源自地中海的优良品牌',
            'content' => '<img class="fullwidth" src="'.asset('/img/article/12-1.jpg').'">',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('articles')->insert([
            'id' => 52,
            'catalog_id' => 12,
            'brand' => '欧丽薇兰',
            'image' => '/img/article/13.jpg',
            'title' => '欧丽薇兰高多酚特级初榨橄榄油',
            'brief' => '身与心的无上宠爱',
            'content' => '<img class="fullwidth" src="'.asset('/img/article/13-1.jpg').'">',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('articles')->insert([
            'id' => 53,
            'catalog_id' => 12,
            'brand' => '胡姬花',
            'image' => '/img/article/14.jpg',
            'title' => '胡姬花古法小榨花生油',
            'brief' => '传承近百年工艺精髓，胡姬花古法小榨花生油',
            'content' => '<img class="fullwidth" src="'.asset('/img/article/14-1.jpg').'">',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('articles')->insert([
            'id' => 54,
            'catalog_id' => 13,
            'brand' => '钜合',
            'image' => '/img/company.png',
            'title' => '益海嘉里简介',
            'brief' => '益海嘉里是著名华侨郭鹤年、郭孔丰叔侄创办的新加坡丰益国际有限公司',
            'content' => '具体文章内容',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }
}

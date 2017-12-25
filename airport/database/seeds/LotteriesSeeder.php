<?php

use Illuminate\Database\Seeder;

class LotteriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('lotteries')->delete();
        DB::table('lotteries')->insert([
            'id' => 1,
            'prize_id' => 4,
            'start_num' => 1,
            'end_num' => 1000,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('lotteries')->insert([
            'id' => 2,
            'prize_id' => 5,
            'start_num' => 1001,
            'end_num' => 2000,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('lotteries')->insert([
            'id' => 3,
            'prize_id' => 6,
            'start_num' => 2001,
            'end_num' => 3000,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('lotteries')->insert([
            'id' => 4,
            'prize_id' => 7,
            'start_num' => 3001,
            'end_num' => 4000,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }
}

<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddWeekDays extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        DB::table('week_days')->truncate();

        DB::table('week_days')->insert([
            'week_day_number' => 1,
            'title_kz' => 'Дүйсенбі',
            'title_ru' => 'Понедельник',
            'title_en' => 'Monday',
            'color_type' => 'success',
        ]);

        DB::table('week_days')->insert([
            'week_day_number' => 2,
            'title_kz' => 'Сейсенбі',
            'title_ru' => 'Вторник',
            'title_en' => 'Tuesday',
            'color_type' => 'danger',
        ]);
        DB::table('week_days')->insert([
            'week_day_number' => 3,
            'title_kz' => 'Сәрсенбі',
            'title_ru' => 'Среда',
            'title_en' => 'Wednesday',
            'color_type' => 'warning',
        ]);
        DB::table('week_days')->insert([
            'week_day_number' => 4,
            'title_kz' => 'Бейсенбі',
            'title_ru' => 'Четверг',
            'title_en' => 'Thursday',
            'color_type' => 'primary',
        ]);
        DB::table('week_days')->insert([
            'week_day_number' => 5,
            'title_kz' => 'Жұма',
            'title_ru' => 'Пятница',
            'title_en' => 'Friday',
            'color_type' => 'dark',
        ]);
        DB::table('week_days')->insert([
            'week_day_number' => 6,
            'title_kz' => 'Сенбі',
            'title_ru' => 'Суббота',
            'title_en' => 'Saturday',
            'color_type' => 'info',
        ]);
        DB::table('week_days')->insert([
            'week_day_number' => 7,
            'title_kz' => 'Жексенбі',
            'title_ru' => 'Воскресенье',
            'title_en' => 'Sunday',
            'color_type' => 'secondary',
        ]);
    }
}

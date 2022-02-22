<?php

namespace Database\Seeders\Client;

use App\Models\Client\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            [
                'name'=>'انتقال وجه',
                'description'=>'سرویس انتقال وجه (داخلی، پایا و ساتنا) از حساب کلاینت به حساب دیگران: با استفاده از این سرویس می‌‌توانید از حساب مبدا خود در بانک به حساب مقصد موجود در همان بانک یا به شماره شبا سایر بانک‌ها پول واریز کنید.',
            ],
            [
                'name'=>'گزارش پایا',
                'description'=>'سرویس دریافت گزارش پایا حساب',
            ],
            [
                'name'=>'پیگیری تراکنش پایا',
                'description'=>' ‫ سرویس پیگیری تراکنش با دریافت trackId که در درخواست انتقال وجه ارسال شده, وضعیت تراکنش را استعلام می‌نماید. این سرویس برای بانک آینده فقط تا پایان همان روز اعتبار خواهد داشت و تمام تراکنش های داخلی و پایا را نیز استعلام می نماید. سرویس مذکور برای بانک پارسیان و کشاورزی فقط استعلام تراکنش پایا را برمی‌گرداند.',
            ],
            [
                'name'=>'پیگیری تراکنش داخلی',
                'description'=>'این سرویس با دریافت trackId که همراه درخواست انتقال وجه ارسال کرده‌اید وضعیت تراکنش را استعلام می‌کند. این سرویس در حال حاضر برای بانک آینده و پارسیان و کشاورزی در دسترس است.',
            ]
        ];

        foreach ($items as $item){
            Client::query()->create($item);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdateCustomerAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $updates = [
            ['id' => 1, 'CUST_ADDRESS_TH1' => '899/3 หมู่ที่ 9 ถนน- ตำบลสำโรงเหนือ', 'CUST_ADDRESS_TH2' => 'อำเภอเมืองสมุทรปราการ จังหวัดสมุทรปราการ'],
            ['id' => 2, 'CUST_ADDRESS_TH1' => '66  อาคารคิวเฮ้าส์ อโศก ชั้น 11 ถนนสุขุมวิท 21', 'CUST_ADDRESS_TH2' => 'แขวงคลองเตยเหนือ เขตวัฒนา กรุงเทพมหานคร'],
            ['id' => 3, 'CUST_ADDRESS_TH1' => '66  อาคารนวม ชั้น 11  ถนนสุขุมวิท 21', 'CUST_ADDRESS_TH2' => 'แขวงคลองเตยเหนือ เขตวัฒนา กรุงเทพมหานคร'],
            ['id' => 4, 'CUST_ADDRESS_TH1' => '66  อาคารนวม ชั้น 11 ห้องเลขที่ 1106  ถนนสุขุมวิท 21', 'CUST_ADDRESS_TH2' => 'แขวงคลองเตยเหนือ เขตวัฒนา กรุงเทพมหานคร'],
            ['id' => 5, 'CUST_ADDRESS_TH1' => '66 ชั้น 11 อาคารคิวเฮ้าส์ อโศก ถนนสุขุมวิท 21(อโศก)', 'CUST_ADDRESS_TH2' => 'แขวงคลองเตยเหนือ เขตวัฒนา กรุงเทพมหานคร'],
            ['id' => 6, 'CUST_ADDRESS_TH1' => '101/46  หมู่ 20  ถนนพหลโยธิน', 'CUST_ADDRESS_TH2' => 'ตำบลคลองหนึ่ง อำเภอคลองหลวง  จังหวัดปทุมธานี'],
            ['id' => 7, 'CUST_ADDRESS_TH1' => '66 ชั้น 12 ห้อง 1211 ซอย 21 (อโศก) ถนนสุขุมวิท 21', 'CUST_ADDRESS_TH2' => 'แขวงคลองเตยเหนือ เขตวัฒนา กรุงเทพมหานคร'],
            ['id' => 8, 'CUST_ADDRESS_TH1' => 'เลขที่ 66 ห้องเลขที่ 1212 ชั้น 12 ซ.21 (อโศก) ถนนสุขุมวิท', 'CUST_ADDRESS_TH2' => 'แขวงคลองเตยเหนือ เขตวัฒนา กรุงเทพมหานคร'],
            ['id' => 9, 'CUST_ADDRESS_TH1' => '66  ซ.สุขุมวิท 21 ถนนสุขุมวิท 21 (อโศก)', 'CUST_ADDRESS_TH2' => 'แขวงคลองเตยเหนือ เขตวัฒนา กรุงเทพมหานคร'],
            ['id' => 10, 'CUST_ADDRESS_TH1' => '66 อาคารนวม  ห้อง 1404 ชั้น 14 ถนนสุขุมวิท 21', 'CUST_ADDRESS_TH2' => 'แขวงคลองเตยเหนือ เขตวัฒนา กรุงเทพมหานคร'],
            ['id' => 11, 'CUST_ADDRESS_TH1' => '66  ถนนสุขุมวิท 21', 'CUST_ADDRESS_TH2' => 'แขวงคลองเตยเหนือ เขตวัฒนา กรุงเทพมหานคร'],
            ['id' => 12, 'CUST_ADDRESS_TH1' => '66,15th Floor,  Sukhumvit 21 (Asoke)  Rd.', 'CUST_ADDRESS_TH2' => 'North Klongtoey, Watthana, Bangkok'],
            ['id' => 13, 'CUST_ADDRESS_TH1' => '66 อาคารนวม  ชั้น 15 ห้อง 1508  ถนนสุขุมวิท 21 (อโศก)', 'CUST_ADDRESS_TH2' => 'แขวงคลองเตยเหนือ เขตวัฒนา กรุงเทพมหานคร'],
            ['id' => 14, 'CUST_ADDRESS_TH1' => '66  อาคารนวม ชั้น 15  ห้อง 1509-1510  ถนนอโศก (สุขุมวิท 21)', 'CUST_ADDRESS_TH2' => 'แขวงคลองเตยเหนือ เขตวัฒนา กรุงเทพมหานคร'],
            ['id' => 15, 'CUST_ADDRESS_TH1' => '66  ชั้นที่ 15  ถนนสุขุมวิท 21 (อโศก)', 'CUST_ADDRESS_TH2' => 'แขวงคลองเตยเหนือ เขตวัฒนา กรุงเทพมหานคร'],
            ['id' => 16, 'CUST_ADDRESS_TH1' => '80/1 ถนนอโศก (สุขุมวิท 21)', 'CUST_ADDRESS_TH2' => 'แขวงคลองเตยเหนือ เขตวัฒนา กรุงเทพมหานคร'],
            ['id' => 17, 'CUST_ADDRESS_TH1' => '66 อาคารนวม ชั้นที่ 18 ซอยอโศก ถนนสุขุมวิท 21', 'CUST_ADDRESS_TH2' => 'แขวงคลองเตยเหนือ เขตวัฒนา กรุงเทพมหานคร'],
            ['id' => 18, 'CUST_ADDRESS_TH1' => '66 อาคารนวม ชั้น B,M,12,14,18,20-23 ถ.สุขุมวิท 21(อโศก)', 'CUST_ADDRESS_TH2' => 'แขวงคลองเตยเหนือ เขตวัฒนา กรุงเทพมหานคร'],
            ['id' => 19, 'CUST_ADDRESS_TH1' => '66  ถนนสุขุมวิท 21  (อโศก)', 'CUST_ADDRESS_TH2' => 'แขวงคลองเตยเหนือ เขตวัฒนา กรุงเทพมหานคร'],
            ['id' => 20, 'CUST_ADDRESS_TH1' => '999 อาคารคอนคอร์ส เอ4-091เอ หมู่ที่ 1 ถนนบางนาตราด กม.15', 'CUST_ADDRESS_TH2' => 'ตำบลราชาเทวะ อำเภอบางพลี จังหวัดสมุทรปราการ'],
            ['id' => 21, 'CUST_ADDRESS_TH1' => '16TH FLOOR,Nuam Building, 66 SUKHUMVIT SOI 21', 'CUST_ADDRESS_TH2' => 'North Klongtoey, Watthana, Bangkok'],
            ['id' => 22, 'CUST_ADDRESS_TH1' => '18 อาคารทรูทาวเวอร์ ถนนรัชดาภิเษก', 'CUST_ADDRESS_TH2' => 'แขวงห้วยขวาง เขตห้วยขวาง กรุงเทพมหานคร'],
            ['id' => 23, 'CUST_ADDRESS_TH1' => '1291/1 ถนนพหลโยธิน', 'CUST_ADDRESS_TH2' => 'แขวงพญาไท เขตพญาไท กรุงเทพมหานคร'],
            ['id' => 24, 'CUST_ADDRESS_TH1' => '123 ซันทาวเวอร์ส อาคารบี ชั้น 35-36 ถนนวิภาวดีรังสิต', 'CUST_ADDRESS_TH2' => 'แขวงจอมพล เขตจตุจักร กรุงเทพมหานคร'],
            ['id' => 25, 'CUST_ADDRESS_TH1' => '18 อาคารทรู ทาวเวอร์ ถนนรัชดาภิเษก', 'CUST_ADDRESS_TH2' => 'แขวงห้วยขวาง เขตห้วยขวาง กรุงเทพมหานคร'],
            ['id' => 26, 'CUST_ADDRESS_TH1' => ' อาคารทีเอสทีทาวเวอร์ชั้นที่9 ถนนวิภาวดีรังสิต', 'CUST_ADDRESS_TH2' => 'แขวงจอมพล เขตจตุจักร กรุงเทพมหานคร'],
            ['id' => 27, 'CUST_ADDRESS_TH1' => '99 ถนนแจ้งวัฒนะ', 'CUST_ADDRESS_TH2' => 'แขวงทุ่งสองห้อง เขตหลักสี่ กรุงเทพมหานคร'],
            ['id' => 28, 'CUST_ADDRESS_TH1' => ' 200 ชั้น 7 ม.4 ถนนแจ้งวัฒนะ', 'CUST_ADDRESS_TH2' => 'ตำบลปากเกร็ด อำเภอปากเกร็ด นนทบุร'],
            ['id' => 29, 'CUST_ADDRESS_TH1' => '499 ถนนกำแพงเพชร 6', 'CUST_ADDRESS_TH2' => 'แขวงลาดยาว เขตจตุจักร กรุงเทพมหานคร'],
            ['id' => 30, 'CUST_ADDRESS_TH1' => '105 หมู่ 9', 'CUST_ADDRESS_TH2' => 'ตำบลบางวัว อำเภอบางปะกง จังหวัดฉะเชิงเทรา'],
            ['id' => 31, 'CUST_ADDRESS_TH1' => '952 อาคารรามาแลนด์ ชั้น 17 ถนนพระราม 4', 'CUST_ADDRESS_TH2' => 'แขวงสุริยวงศ์ เขตบางรัก กรุงเทพมหานคร'],
        ];
        foreach($updates as $update){
            Customer::where('id',$update['id'])
            ->update(['cust_address_th1'=> trim($update['CUST_ADDRESS_TH1']),
            'cust_address_th2' => trim($update['CUST_ADDRESS_TH2'])
            ]);
        }
    }
}

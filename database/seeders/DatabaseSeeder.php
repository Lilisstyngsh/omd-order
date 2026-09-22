<?php
namespace Database\Seeders;
use App\Models\Area;
use App\Models\NgType;
use App\Models\Product;
use App\Models\Target;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $areas = [];
        foreach ([['Unit','DC'],['Unit','MA'],['Unit','Sub-Assy'],['Unit','PPIC'],['Body','INJ'],['Body','PT'],['Body','Sub-Assy'],['Body','PPIC']] as [$category,$name]) {
            $areas[] = Area::firstOrCreate(['category'=>$category,'name'=>$name], ['is_active'=>true]);
        }
        foreach ([['P','NG Part'],['H','NG Holder'],['C','NG Cover']] as [$code,$name]) NgType::firstOrCreate(['code'=>$code], ['name'=>$name,'is_active'=>true]);
        foreach ([['HANDLE','HANDLE'],['FRAME-FR-R','FRAME FR R'],['FRAME-FR-L','FRAME FR L'],['FRAME-RR-R','FRAME RR R'],['FRAME-RR-L','FRAME RR L'],['CAP','CAP'],['GARNISH','GARNISH'],['PAD','PAD']] as [$code,$name]) { Product::firstOrCreate(['code'=>$code], ['name'=>$name,'is_active'=>true]); }
        $userArea = Area::where(['category'=>'Unit','name'=>'PPIC'])->first();
        User::updateOrCreate(['email'=>'user@omd.local'], ['name'=>'User PPIC','password'=>Hash::make('password'),'role'=>'user','area_id'=>$userArea?->id]);
        User::updateOrCreate(['email'=>'member@omd.local'], ['name'=>'OMD Member','password'=>Hash::make('password'),'role'=>'omd_member']);
        User::updateOrCreate(['email'=>'leader@omd.local'], ['name'=>'OMD Leader','password'=>Hash::make('password'),'role'=>'omd_leader']);
        $targets = [4=>950,5=>855,6=>855,7=>855,8=>855,9=>855];
        foreach ($targets as $m=>$qty) Target::updateOrCreate(['year'=>2026,'month'=>$m,'area_id'=>null], ['target_qty'=>$qty]);
    }
}

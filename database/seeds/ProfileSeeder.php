<?php
use Illuminate\Database\Seeder;

use App\Models\Profile;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Profile::create([
            'id' => '476766533',
            'hash' => 'Wismichu',
            'name' => 'Wismichu',
            'description' => 'Soy una falta de respeto con patas. Cuentame tu mierda y ofreceme tus billetes en: wismichu@youplanet.es',
            'created_at' => '2012-01-28 14:28:00',
            'master' => 1
        ]);
    }
}

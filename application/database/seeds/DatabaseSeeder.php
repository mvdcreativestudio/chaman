<?php

use Illuminate\Database\Seeder;
use App\Models\Franchise;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Franchise::create([
            'name' => 'Dolores',
            'address' => 'Carlos Puig 1248',
            'phone' => '092653005',
            'ruc' => '217410130017'
        ]);

        Franchise::create([
            'name' => 'Franquicia B y R',
            'address' => 'Paul Harriz M: E S: 14',
            'phone' => '094058403',
            'ruc' => '218522150018'

        ]);

        Franchise::create([
            'name' => 'Cardona',
            'address' => '25 de Agosto',
            'phone' => '',
            'ruc' => '180294000016'
        ]);

        Franchise::create([
            'name' => 'Costa de Oro',
            'address' => 'Cesar Mayo Gutierrez SN',
            'phone' => '095401391',
            'ruc' => '020609160014'
        ]);

        Franchise::create([
            'name' => 'Durazno',
            'address' => 'Lavalleja 860',
            'phone' => '099330309',
            'ruc' => '050160150015'
        ]);

        Franchise::create([
            'name' => 'Flores - Trinidad',
            'address' => 'Manuel Sanchez Echeverria 505',
            'phone' => '099860327',
            'ruc' => '219044290016'
        ]);

        Franchise::create([
            'name' => 'HP',
            'address' => 'Javier de Viana 2328',
            'phone' => '',
            'ruc' => '216159020017'
        ]);

        Franchise::create([
            'name' => 'Kentia',
            'address' => 'Tomas Diago 782/1',
            'phone' => '',
            'ruc' => '020591650015'
        ]);

        Franchise::create([
            'name' => 'Libertad',
            'address' => '25 de Agosto 959',
            'phone' => '099345705',
            'ruc' => '170315770012'
        ]);

        Franchise::create([
            'name' => 'Maldonado',
            'address' => 'Roosvelt y Acuña de Figueroa',
            'phone' => '094346200',
            'ruc' => '120396610014'
        ]);

        Franchise::create([
            'name' => 'Nueva Helvecia',
            'address' => 'Dr. Luis Alberto de Herrera 1251',
            'phone' => '098338120',
            'ruc' => '040532730010'
        ]);

        Franchise::create([
            'name' => 'Pando - Tres Cruces',
            'address' => 'Queguay 8062',
            'phone' => '095776977',
            'ruc' => '217410130017'
        ]);

        Franchise::create([
            'name' => 'Prado',
            'address' => 'Gabriel Pereira 3255',
            'phone' => '093855392',
            'ruc' => '150655690010'
        ]);

        Franchise::create([
            'name' => 'Tacuarembó',
            'address' => '25 de Mayo 354',
            'phone' => '098423080',
            'ruc' => '150655690010'
        ]);

        Franchise::create([
            'name' => 'Origen Cero',
            'address' => 'República 2190',
            'phone' => '093612229',
            'ruc' => '218276430013'
        ]);

    }
}

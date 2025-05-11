<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatesSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $states = [
            ['state' => 'Acre', 'UF' => 'AC'],
            ['state' => 'Alagoas', 'UF' => 'AL'],
            ['state' => 'Amapá', 'UF' => 'AP'],
            ['state' => 'Amazonas', 'UF' => 'AM'],
            ['state' => 'Bahia', 'UF' => 'BA'],
            ['state' => 'Ceará', 'UF' => 'CE'],
            ['state' => 'Distrito Federal', 'UF' => 'DF'],
            ['state' => 'Espírito Santo', 'UF' => 'ES'],
            ['state' => 'Goiás', 'UF' => 'GO'],
            ['state' => 'Maranhão', 'UF' => 'MA'],
            ['state' => 'Mato Grosso', 'UF' => 'MT'],
            ['state' => 'Mato Grosso do Sul', 'UF' => 'MS'],
            ['state' => 'Minas Gerais', 'UF' => 'MG'],
            ['state' => 'Pará', 'UF' => 'PA'],
            ['state' => 'Paraíba', 'UF' => 'PB'],
            ['state' => 'Paraná', 'UF' => 'PR'],
            ['state' => 'Pernambuco', 'UF' => 'PE'],
            ['state' => 'Piauí', 'UF' => 'PI'],
            ['state' => 'Rio de Janeiro', 'UF' => 'RJ'],
            ['state' => 'Rio Grande do Norte', 'UF' => 'RN'],
            ['state' => 'Rio Grande do Sul', 'UF' => 'RS'],
            ['state' => 'Rondônia', 'UF' => 'RO'],
            ['state' => 'Roraima', 'UF' => 'RR'],
            ['state' => 'Santa Catarina', 'UF' => 'SC'],
            ['state' => 'São Paulo', 'UF' => 'SP'],
            ['state' => 'Sergipe', 'UF' => 'SE'],
            ['state' => 'Tocantins', 'UF' => 'TO'],
        ];

        DB::table('states')->insert($states);
    }
}

<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CitiesSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $filePath = base_path('database/data/cidades.txt');

        if (!File::exists($filePath)) {
            $this->command->error('Arquivo cidades.txt não encontrado.');
            return;
        }

        $lines = File::lines($filePath);

        $states = State::pluck('id', 'uf')->toArray();
        $cities = [];
        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) continue;

            [$uf, $cidade] = explode(';', $line);
            $uf = trim($uf);
            $cidade = trim($cidade);

            if (!isset($states[$uf])) {
                $this->command->warn("UF '{$uf}' não encontrado. Ignorando cidade '{$cidade}'.");
                continue;
            }

            $cities[] = [
                'state_id' => $states[$uf],
                'city' => $cidade,
            ];
        }

        if (!empty($cities)) {
            DB::table('cities')->insert($cities);
            $this->command->info(count($cities) . ' cidades inseridas com sucesso.');
        } else {
            $this->command->warn('Nenhuma cidade foi inserida.');
        }
    }
}

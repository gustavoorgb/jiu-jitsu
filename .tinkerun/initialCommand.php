<?php

use App\Models\Academy;
use App\Models\User;
use App\Models\UserRole;

$user = User::create(['name' => 'Gustavo Gabry Orçay', 'email' => 'gustavogabry24@gmail.com', 'password' => 'gustavo2015',
    'belt' => 2, 'phone' => '22981194519',
]);

$academy = Academy::create(['name' => 'vector-jiu-jitsu', 'confederation' => 'IBJJF', 'description' => 'matriz']);

UserRole::create([
    'user_id' => 1,
    'academy_id' => 1,
    'role_id' => 1,
]);

<?php

use App\Models\Academy;
use App\Models\User;

$academy = Academy::find(1);

$lesson = $academy->lessons->first();

$schedules = $lesson->schedules->find(24);

$user = User::find(1);

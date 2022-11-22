<?php

namespace App\Observers;

use App\Models\CompleteLevel;

class CompleteLevelObserver
{
    public function deleted(CompleteLevel $completeLevel) {
        $completeLevel->name = time() . '::' . $completeLevel->name;
        $completeLevel->save();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
                            'userid',
                            'title',
                            'completed'
                        ];

    public function toggleCompleted($uid)
    {
        if($this->userid == $uid)
        {
            $this->completed = !$this->completed;
        }
        return $this;
    }
}

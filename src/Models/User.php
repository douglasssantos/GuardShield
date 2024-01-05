<?php

namespace Larakeeps\GuardShield\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Larakeeps\GuardShield\Traits\GuardShield;

class User extends Model
{
    use GuardShield, HasFactory;

    protected $table = 'users';

    protected $with = ['roles'];
    protected $guarded = ['id'];
  
}

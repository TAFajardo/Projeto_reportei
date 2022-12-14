<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commit extends Model
{
    use HasFactory;

    protected $fillable = [
        'github_commit_id',
        'github_repo_name',
        'github_user_name',
        'commit_date',
        
    ];
}

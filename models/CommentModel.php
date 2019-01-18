<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;

class CommentModel extends Model
{
    protected $db;
    protected $table = 'Projects';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function __construct($userId = 0, $projectId = 0, $body = "")
    {
        $this->userId = $userId;
        $this->projectId = $projectId;
        $this->body = $body;
    }
}

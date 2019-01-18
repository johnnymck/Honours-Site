<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;

class ProjectModel extends Model
{
    protected $db;
    protected $table = 'Projects';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function __construct($userId = 0, $title = "", $approved = 0, $body = "")
    {
        $this->userId = $userId;
        $this->title = $title;
        $this->approved = $approved;
        $this->body = $body;
        $this->revisionNumber = 0;
        $this->time = time();
    }
}

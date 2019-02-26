<?php

namespace Models;

use FormManager\Factory as F;
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

    public static function getProjectForm()
    {
        return F::form([
            'medicine' => F::checkbox("This is a medical/clinical study"),
            'humans' => F::checkbox("This study involves human participants"),
            'children' => F::checkbox("This study involves children"),
            'summary' => F::textarea("Please detail, in full, how this study will be carried out"),
            'confirm' => F::checkbox("I confirm that the above information is correct and in accordance with the university's ethical policy"),
            '' => F::submit("Submit"),
        ])->setAttributes([
            'action' => '/new-project',
            'method' => 'post',
        ]);
    }
}

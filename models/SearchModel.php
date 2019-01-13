<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;

class SearchModel extends Model {

    protected $table = 'Searches';
    protected $fillable = ['*'];
    protected $guarded = ['id', 'datetime'];
    public $timestamps = false;

    public function __construct($searchterm, $ipaddress, $username) {
        $this->searchterm = $searchterm;
        $this->ipaddress = $ipaddress;
        $this->username = $username;
    }
}
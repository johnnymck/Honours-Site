<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model {

    protected $db;
    protected $table = 'User';
    protected $fillable = ['*'];
    protected $guarded = ['id'];
    public $timestamps = false;

    // default values must be set
    public function __construct($username = "", $password = "", $firstname = "", $lastname = "", $is_admin = 0) {
        $this->username = $username;
        $this->password = password_hash($password, PASSWORD_DEFAULT);
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->is_admin = $is_admin;
    }
}
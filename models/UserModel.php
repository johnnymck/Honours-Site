<?php

namespace Models;

use FormManager\Factory as F;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{

    protected $db;
    protected $table = 'Users';
    protected $fillable = ['*'];
    protected $guarded = ['id'];
    public $timestamps = false;

    // default values must be set
    public function __construct($email = "", $password = "", $firstname = "", $lastname = "", $title = "", $address = "", $isAdmin = 0)
    {
        $this->email = $email;
        $this->password = password_hash($password, PASSWORD_DEFAULT);
        $this->firstName = $firstname;
        $this->lastName = $lastname;
        $this->isAdmin = $isAdmin;
        $this->workingAddress = $address;
        $this->title = $title;
        $this->isAdmin = $isAdmin;
    }

    public static function validateLogin($email, $password)
    {
        $user = UserModel::where('email', $email)->first();
        if ($user != null) {
            return (password_verify($password, $user->password));
        }
    }

    public static function getLoginForm()
    {
        return F::form([
            'email' => F::email('Email Address'),
            'password' => F::password('Password'),
            '' => F::submit('Login'),
        ])->setAttributes([
            'action' => '/login',
            'method' => 'post',
        ]);
    }
}

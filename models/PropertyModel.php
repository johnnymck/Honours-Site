<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;

class PropertyModel extends Model {

    protected $db;
    protected $table = 'Property';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function __construct($attributes = array()) {
        parent::__construct($attributes);
        if (isset($attributes['county'])) $this->thing = $attributes['county'];
        if (isset($attributes['country'])) $this->thing = $attributes['country'];
        if (isset($attributes['town'])) $this->thing = $attributes['town'];
        if (isset($attributes['postcode'])) $this->thing = $attributes['postcode'];
        if (isset($attributes['description'])) $this->thing = $attributes['description'];
        if (isset($attributes['displayable_address'])) $this->thing = $attributes['displayable_address'];
        if (isset($attributes['image'])) $this->thing = $attributes['image'];
        if (isset($attributes['no_rooms'])) $this->thing = $attributes['no_rooms'];
        if (isset($attributes['no_bathrooms'])) $this->thing = $attributes['no_bathrooms'];
        if (isset($attributes['price'])) $this->thing = $attributes['price'];
        if (isset($attributes['type'])) $this->thing = $attributes['type'];
        if (isset($attributes['sale'])) $this->thing = $attributes['sale'];
        if (isset($attributes['latitude'])) $this->thing = $attributes['latitude'];
        if (isset($attributes['longitude'])) $this->thing = $attributes['longitude'];
    }
}
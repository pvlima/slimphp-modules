<?php

namespace Modules\Authentication\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class AuthorityModel extends Model
{

	protected $table = 'authorities';

	/*protected $fillable = ['name', 'email', 'password', 'type', 'country_code', 'phone'];
	protected $hidden = ['password', 'deleted_at'];
	protected $dates = ['deleted_at'];*/

	

}
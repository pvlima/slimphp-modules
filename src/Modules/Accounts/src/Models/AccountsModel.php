<?php

namespace Modules\Accounts\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Plugins\Auth\Components\Bcrypt;

class AccountsModel extends Model
{

	use SoftDeletes;
	
	protected $table = 'accounts';

	protected $fillable = ['name', 'email', 'password', 'type', 'country_code', 'phone'];

	protected $hidden = ['password', 'deleted_at'];

	protected $dates = ['deleted_at'];

	protected function setPasswordAttribute($pass)
	{
		$this->attributes['password'] = Bcrypt::hash($pass);
	}

}
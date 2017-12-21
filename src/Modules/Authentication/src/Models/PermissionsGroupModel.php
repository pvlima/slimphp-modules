<?php

namespace Modules\Authentication\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class PermissionsGroupModel extends Model
{

	protected $table = 'permissions_groups';

	/*protected $fillable = ['name', 'email', 'password', 'type', 'country_code', 'phone'];
	protected $hidden = ['password', 'deleted_at'];
	protected $dates = ['deleted_at'];*/

}
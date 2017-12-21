<?php

namespace Modules\Authentication\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class PermissionsGroupsAuthorityModel extends Model
{

	protected $table = 'permissions_groups_authorities';

	/*protected $fillable = ['name', 'email', 'password', 'type', 'country_code', 'phone'];
	protected $hidden = ['password', 'deleted_at'];
	protected $dates = ['deleted_at'];*/


}
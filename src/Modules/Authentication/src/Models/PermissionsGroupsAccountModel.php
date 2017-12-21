<?php

namespace Modules\Authentication\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Modules\Accounts\Models\AccountsModel;

class PermissionsGroupsAccountModel extends Model
{

	protected $table = 'permissions_groups_accounts';

	/*protected $fillable = ['name', 'email', 'password', 'type', 'country_code', 'phone'];
	protected $hidden = ['password', 'deleted_at'];
	protected $dates = ['deleted_at'];*/

	public function account()
	{
		return $this->belongsTo(AccountsModel::class);
	}


}
<?php namespace App;

use App\HolidayRequest;
use Illuminate\Support\Str;
use Laracasts\Flash\Flash;
use \Exception as Exception;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	protected $appends = [
		'avatar_path',
		'avatar_thumbnail_path',
		'url',
		'department_name'
	];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password',
		'remember_token'
	];

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'first_name',
		'last_name',
		'slug',
		'role',
		'email',
		'password',
		'telephone',
		'extension',
		'skype_name',
		'department_id',
		'location_id',
		'super_user',
		'annual_holiday_allowance'
	];

	public $default_annual_holiday_alowance = 25;
	public $active_holiday_balance 			= 0;
	public $pending_holiday_balance 		= 0;
	public $approved_holiday_balance 		= 0;
	public $completed_holiday_balance 		= 0;
	public $available_holiday_balance 		= 0;
	public $unavailable_holiday_balance 	= 0;
	public $avatarPathAttribute;

	// Relationships
	public function department()
	{
		return $this->belongsTo('App\Department', 'department_id', 'id');
	}

	public function location()
	{
		return $this->belongsTo('App\Location', 'location_id', 'id');
	}

	public function avatar()
	{
		return $this->hasMany('App\Avatar');
	}

	/**
	 * Concatenate the First and Last name values
	 *
	 * @return string
	 */
	public function fullName()
	{
		return $this->first_name.' '.$this->last_name;
	}

	/**
	 * Is this user a Department Lead
	 *
	 * @return bool
	 * @param Department $department
	 */
	public function isDepartmentLead(Department $department)
	{
		return $department->lead_id == $this->id;
	}

	public function leadDepartment()
	{
		if ($this->isDepartmentLead($this->department)) {
			return $this->department;
		}

		return false;
	}

	/**
	 * Is this user regarded as a Super User
	 * This will generally be a user that can manage multiple Teams
	 *
	 * @return bool
	 */
	public function isSuperUser()
	{
		return $this->super_user == 1;
	}

	/**
	 * Does this user have the permissions to edit the details of the passed User
	 * This could be the actual user performing the test
	 *
	 * @param User $member
	 * @return bool
	 */
	public function hasEditUserPermissions(User $member)
	{
		if ($this->id == $member->id) {
			return true;
		}

		return $this->hasManageDepartmentPermission($member->department);
	}

	/**
	 * Can this User manage Departments
	 * Generally they will be a Department Lead but this may be extended to allow Team Leads to deputise
	 * There is possibly a Super User that can manage in the absence of relevant Department Lead
	 *
	 * @return bool
	 * @param Department $department
	 */
	public function hasManageDepartmentPermission(Department $department = null)
	{
		return $this->isSuperUser() || $this->isDepartmentLead($department);
	}

	/**
	 * Retrieve the avatar path for the user
	 * This can either be a locally uploaded image,
	 * or a remote service, such as Gravatar, linked to the email address.
	 *
	 * @param int $size
	 * @return string
	 */
	public function getAvatarPath($size = 150)
	{
		$avatar = $this->localAvatar();

		return is_null($avatar) ? $this->getRemoteAvatarPath($size) : $avatar->path;
	}

	/**
	 * Retrieve the avatar thumbnail path for the user
	 * This can either be a locally uploaded image,
	 * or a remote service, such as Gravatar, linked to the email address.
	 *
	 * @param int $size
	 * @return string
	 */
	public function getAvatarThumbnailPath($size = 50)
	{
		$avatar = $this->localAvatar();

		return is_null($avatar) ? $this->getRemoteAvatarPath($size) : $avatar->formattedPath();
	}

	/**
	 * Return the locally stored Avatar if available
	 *
	 * @return App/Avatar | false
	 */
	private function localAvatar()
	{
		return $this->avatar()->latest()->first();
	}

	/**
	 * Return path to the users's gravatar image
	 * If none has been set, the default image path will be returned
	 * A size can be specified if it is required to overwrite the default 200
	 *
	 * @return string
	 * @param int $size
	 * @param string $default
	 */
	public function getRemoteAvatarPath($size = 150, $default = 'mm')
	{
		$str = md5(trim(strtolower($this->email)));

		return 'http://www.gravatar.com/avatar/'.$str.'?s='.$size.'&d='.$default;
	}

	public function getAvatarPathAttribute($size = 150, $default = 'mm')
	{
		return $this->getAvatarPath($size);
	}

	public function getAvatarThumbnailPathAttribute($size = 150, $default = 'mm')
	{
		return $this->getAvatarThumbnailPath($size);
	}

	public function getUrlAttribute()
	{
		return '/member/'.$this->slug;
	}

	public function getDepartmentNameAttribute()
	{
		return $this->department->name;
	}

	public function sendConfirmationRequestEmail()
	{
		var_dump('Send a mail containing the token : '.$this->confirmation_token);
	}

	public function createSlug()
	{
		return Str::slug(join([$this->first_name, $this->last_name], ' '));
	}

	/**
	 * The user has successfully confirmed their account
	 * The confirmed flag is set to true
	 * The confirmation_flag is no longer needed so set to null
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function confirmAccount()
	{
		$this->confirmed 			= true;
		$this->confirmation_token 	= null;

		$this->save();
	}

}

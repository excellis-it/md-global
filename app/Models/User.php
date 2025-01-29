<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;
    // protected $guard_name = 'api';
    // protected $guard_name = 'web';
    use HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'profile_picture',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function doctorSpecializations()
    {
        return $this->hasMany(DoctorSpecialization::class, 'doctor_id');
    }

    // relationship with location
    public function locations()
    {
        return $this->hasOne(Location::class, 'user_id')->orderBy('id', 'desc');
    }

    // specialization
    public function specializations()
    {
        return $this->belongsToMany(Specialization::class, 'doctor_specializations', 'doctor_id', 'specialization_id');
    }

    public static function getDoctorSpecializations($id)
    {
        $specializations = DoctorSpecialization::where('doctor_id', $id)->get();
        $data = [];
        foreach ($specializations as $specialization) {
            $data[] = $specialization->specialization->name;
        }
        return implode(', ', $data);
    }

    public function getMembershipStatusAttribute()
    {
        $count = UserMembership::where('user_id', $this->id)->count();
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getMembershipExpireDateAttribute()
    {
        $membership = UserMembership::where('user_id', $this->id)->first();
        if ($membership) {
            return $membership->membership_expiry_date;
        } else {
            return null;
        }
    }

    public function clinicDetails()
    {
        return $this->hasMany(ClinicDetails::class, 'user_id', 'id');
    }

    public function friends()
    {
        return $this->hasMany(Friends::class, 'user_id');
    }

    public function friendsRequest()
    {
        return $this->hasMany(Friends::class, 'friend_id');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'user_id');
    }

    public function doctorAppointments()
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }



    public function zoomCredentials()
    {
        return $this->hasOne(ZoomCredential::class, 'user_id');
    }

    // public function rola(){
    //     return $this->hasMany(Role::class, "role_id");
    // }

    public function chatSender()
    {
        return $this->hasMany(Chat::class, 'sender_id');
    }
}

<?php

namespace App\Models;

use App\Services\MailService;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @SWG\Definition(
 *      definition="User",
 *      required={"email", "name", "sex", "mobile"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="email",
 *          description="email",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="password",
 *          description="password",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="name",
 *          description="name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="sex",
 *          description="sex",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="mobile",
 *          description="mobile",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="id_number",
 *          description="id_number",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="address",
 *          description="address",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="community_id",
 *          description="community_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="created_at",
 *          description="created_at",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="updated_at",
 *          description="updated_at",
 *          type="string",
 *          format="date-time"
 *      )
 * )
 */
class User extends Authenticatable
{
    use Notifiable;

    const CHECK_STATUS_OF_PASS=1;
    const CHECK_STATUS_OF_REFUSE=2;
    public $table = 'users';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'email',
        'password',
        'name',
        'avatar',
        'is_active',
        'confirmation_token',
    ];
    
    protected $hidden = [
                'password', 'remember_token'];
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'email' => 'string',
        'password' => 'string',
        'name' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'email' => 'email|unique:users',
        'name' => 'max:20',
    ];


    /**
     * send password reset email to user's email base on token.
     *
     * @param string $token
     */
    public function sendPasswordResetNotification($token)
    {
        $mail = new MailService();
        $mail->passwordReset($this->email, $token);
    }
}

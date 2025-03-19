<?php


namespace app\models;

use Yii;
use yii\base\Exception;
use yii\base\Model;

/**
 * RegisterForm is the model behind the registration form.
 *
 * @property-read User|null $user
 *
 */
class RegisterForm extends Model
{
    public $username;
    public $password;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
        ];
    }

    public function register()
    {
        if ($this->validate()) {
            $this->_user = new User();
            $this->_user->username = $this->username;
            $this->_user->password = $this->password;
            if ($this->_user->registerUser()) {
                return true;
            }
        }
        echo "gatya";
        exit();
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}

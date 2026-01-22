<?php
namespace app\models;namespace app\models\forms;
use yii\base\Model;

class PasswordChangeForm extends Model
{
    public $new_password;
    public $confirm_password;

    public function rules()
    {
        return [
            [['new_password', 'confirm_password'], 'required', 'message' => 'A mező kitöltése kötelező.'],
            ['new_password', 'string', 'min' => 6, 'message' => 'A jelszónak legalább 6 karakternek kell lennie.'],
            ['confirm_password', 'compare', 'compareAttribute' => 'new_password', 'message' => 'A két jelszó nem egyezik meg.'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'new_password' => 'Új jelszó',
            'confirm_password' => 'Új jelszó megerősítése',
        ];
    }
}
<?php
namespace frontend\models;

use yii\base\Model;
use common\models\UserModel;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $rePassword;
    public $verifyCode;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\UserModel', 'message' => 'This username has'.
                ' already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 16],
            ['username', 'match','pattern'=>'/^[A-Za-z0-9_\-\u4e00-\u9fa5]+$/u','message'=>'User names are made'.
                'up of numbers, Chinese or English characters or underscores.'],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\UserModel', 'message' => 'This email address has'.
                ' already been taken.'],

            [['password','rePassword'],'required'],
            [['password','rePassword'],'string', 'min' => 6],

            ['rePassword','compare','compareAttribute'=>'password','message'=>'Two times password input inconsistency'],

            ['verifyCode','captcha']
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
//    public function attributeLabels()
//    {
//        return[
//            'username'=>'用户名',
//            'email'=>'邮箱',
//            'password'=>'密码',
//            'rePassword'=>'重复密码',
//            'verifyCode'=>'验证码'
//        ];
//    }

    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new UserModel();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        
        return $user->save() ? $user : null;
    }
}

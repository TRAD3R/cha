<?php


namespace App\Models;


use App\Behaviors\Timestamp;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Class User
 * @package App\Models
 * 
 * @property int    $id                 [int(11)]
 * @property int    $date_created       [timestamp]
 * @property int    $date_updeated      [timestamp]
 * @property string $email              [varchar(255)]
 * @property string $password_hash      [varchar(255)]
 * @property string $auth_key           [varchar(32)]
 * @property int    $date_last_visit    [timestamp]
 */
class User extends ActiveRecord implements IdentityInterface
{
    public static function tableName()
    {
        return 'users';
    }
    
    public function behaviors()
    {
        return [
            Timestamp::class
        ];
    }
    
    public function rules()
    {
        return [
            [['email', 'password_hash'], 'required'],
            ['email', 'email'],
            ['email', 'unique'],
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     * @throws \yii\base\Exception
     */
    public function beforeSave($insert)
    {
        if(!parent::beforeSave($insert)) {
            return false;
        }
        
        if($insert) {
            $this->setAuthKey();
        }
        
        return true;
    }

    /**
     * @inheritDoc
     */
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    /**
     * @inheritDoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    /**
     * @inheritDoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @throws \yii\base\Exception
     */
    public function setAuthKey()
    {
        $this->auth_key = \Yii::$app->security->generateRandomString();
    }

    /**
     * @inheritDoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }
    
    public function setPasswordHash($password)
    {
        $this->password_hash = \Yii::$app->security->generatePasswordHash($password);
    }
    
    public function validatePassword($password)
    {
        return \Yii::$app->security->validatePassword($password, $this->password_hash);
    }
}
<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "usuarios".
 *
 * @property int $id
 * @property string $nombre
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string|null $auth_key
 * @property int $rol_id
 *
 * @property Roles $rol
 */
class Usuarios extends \yii\db\ActiveRecord implements IdentityInterface
{

    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    public $password_repeat;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'username', 'email'], 'required'],
            [['rol_id'], 'default', 'value' => 3],
            [['rol_id'], 'integer'],
            [['nombre', 'username', 'email', 'password', 'auth_key'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['username'], 'unique'],
            [['rol_id'], 'exist', 'skipOnError' => true, 'targetClass' => Roles::class, 'targetAttribute' => ['rol_id' => 'id']],
            [['password', 'password_repeat'], 'required', 'on' => [self::SCENARIO_CREATE]],
            [['password'], 'compare', 'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]],
            [['password_repeat'], 'safe', 'on' => [self::SCENARIO_UPDATE]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'username' => 'Nombre de usuario',
            'email' => 'Email',
            'password' => 'Contraseña',
            'password_repeat' => 'Repetir contraseña',
            'auth_key' => 'Auth Key',
            'rol' => 'Rol',
        ];
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), ['password']);
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
            
        if ($insert) {
            if ($this->scenario === self::SCENARIO_CREATE) {
                $this->auth_key = Yii::$app->security
                                    ->generateRandomString();
                goto salto;
            }
        } else {
            if ($this->scenario === self::SCENARIO_UPDATE) {
                if ($this->password === '') {
                    $this->password = $this->getOldAttribute('password');
                } else {
                    salto:
                    $this->password = Yii::$app->security
                    ->generatePasswordHash($this->password);
                }
            }
        }

        return true;
    }

    /**
     * Gets query for [[Rol]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRol()
    {
        return $this->hasOne(Roles::class, ['id' => 'rol_id'])->inverseOf('usuarios');
    }

    public function getEsAdmin()
    {
        $usuario = Usuarios::findOne(Yii::$app->user->id);
        return $usuario->rol->rol === 'admin';
    }

    public static function findByLogin($username)
    {
        return static::findOne(['username' => $username]);
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }
}

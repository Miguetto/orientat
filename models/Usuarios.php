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
 * @property string|null $token_confirm
 * @property string|null $created_at
 * @property int $rol_id
 *
 * @property Recursos[] $recursos
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
            [['de_baja'], 'default', 'value' => false],
            [['de_baja'], 'boolean'],
            [['created_at'], 'safe'],
            [['nombre', 'username', 'email', 'password', 'auth_key', 'token_confirm'], 'string', 'max' => 255],
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
            'token_confirm' => 'Token Confirm',
            'created_at' => 'Creado',
            'de_baja' => 'De baja',
            'rol_id' => 'Rol',
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
                    $this->token_confirm = Yii::$app->security->generateRandomString();
                }
            }
        }

        return true;
    }

    /**
    * Lista de usuarios
    * @return array con los usuarios
    */
    public static function lista()
    {
        return static::find()->select('username')
               ->indexBy('id')->column();
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

    /**
     * Gets query for [[Recursos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRecursos()
    {
        return $this->hasMany(Recursos::class, ['usuario_id' => 'id'])->inverseOf('usuario');
    }

    /**
     * Gets query for [[Propuestas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPropuestas()
    {
        return $this->hasMany(Propuestas::class, ['usuario_id' => 'id'])->inverseOf('usuario');
    }

    /**
     * Gets query for [[Likes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLikes()
    {
        return $this->hasMany(Likes::class, ['usuario_id' => 'id']);
    }

    /**
     * Comprueba que el usuario logueado es administrador
     *
     * @return bool
     */
    public function getEsAdmin()
    {
        $usuario = static::findOne(Yii::$app->user->id);
        return $usuario->rol->rol === 'admin';
    }

    public function getEsRevisor()
    {
        $usuario = static::findOne(Yii::$app->user->id);
        return $usuario->rol->rol === 'revisor';
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

<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Usuarios;

/**
 * UsuariosSearch represents the model behind the search form of `app\models\Usuarios`.
 */
class UsuariosSearch extends Usuarios
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'rol_id', 'notificacion_id'], 'integer'],
            [['rol.rol', 'nombre', 'username'], 'string'],
            [['nombre', 'username', 'email', 'password', 'rol.rol', 'de_baja', 'created_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }


    public function attributes()
    {
        return array_merge(parent::attributes(), ['rol.rol']);
    }


    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Usuarios::find()->joinWith('rol');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 3,
            ]
        ]);

        $dataProvider->sort->attributes['rol.rol'] = [
            'asc' => ['roles.rol' => SORT_ASC],
            'desc' => ['roles.rol' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'notificacion_id' => $this->notificacion_id,
        ]);

        $query->andFilterWhere(['ilike', 'nombre', $this->nombre])
            ->andFilterWhere(['ilike', 'username', $this->username])
            ->andFilterWhere(['ilike', 'email', $this->email])
            ->andFilterWhere(['ilike', 'password', $this->password])
            ->andFilterWhere(['ilike', 'roles.rol', $this->getAttribute('rol.rol')])
            ->andFilterWhere(['ilike', 'de_baja', $this->de_baja])
            ->andFilterWhere(['ilike', 'created_at', $this->created_at]);


        return $dataProvider;
    }
}

<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Notificaciones;
use Yii;

/**
 * NotificacionesSearch represents the model behind the search form of `app\models\Notificaciones`.
 */
class NotificacionesSearch extends Notificaciones
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'usuario_id', 'recurso_id'], 'integer'],
            [['visto'], 'boolean'],
            [['cuerpo'], 'safe'],
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

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        if(Yii::$app->user->identity->esAdmin === true){
            $query = Notificaciones::find();
        } else {
            $query = Notificaciones::find()
                                    ->where(['usuario_id' => Yii::$app->user->id])
                                    ->andWhere(['visto' => false])
                                    ->orderBy(['visto' => SORT_ASC]);    
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'usuario_id' => $this->usuario_id,
            'recurso_id' => $this->recurso_id,
            'visto' => $this->visto,
        ]);

        $query->andFilterWhere(['ilike', 'cuerpo', $this->cuerpo]);

        return $dataProvider;
    }
}

<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Respuestas;

/**
 * RespuestasSearch represents the model behind the search form of `app\models\Respuestas`.
 */
class RespuestasSearch extends Respuestas
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'comentario_id', 'usuario_id'], 'integer'],
            [['cuerpo', 'created_at'], 'safe'],
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
        $query = Respuestas::find();

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
            'created_at' => $this->created_at,
            'comentario_id' => $this->comentario_id,
            'usuario_id' => $this->usuario_id,
        ]);

        $query->andFilterWhere(['ilike', 'cuerpo', $this->cuerpo]);

        return $dataProvider;
    }
}

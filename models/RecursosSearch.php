<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Recursos;
use Yii;

/**
 * RecursosSearch represents the model behind the search form of `app\models\Recursos`.
 */
class RecursosSearch extends Recursos
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'usuario_id', 'categoria_id'], 'integer'],
            [['titulo', 'descripcion', 'contenido', 'created_at'], 'safe'],
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
        $query = Recursos::find()->where(['revisado' => true])->orderBy(['created_at' => SORT_DESC]);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageParam' => 'precurso',
                'pageSize' => 9,
            ]
        ]);

        $dataProvider->sort->attributes['usuario.usuario'] = [
            'asc' => ['usuarios.usuario' => SORT_ASC],
            'desc' => ['usuarios.usuario' => SORT_DESC],
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
            'created_at' => $this->created_at,
            'usuario_id' => $this->usuario_id,
            'categoria_id' => $this->categoria_id,
        ]);

        $query->andFilterWhere(['ilike', 'titulo', $this->titulo])
            ->andFilterWhere(['ilike', 'descripcion', $this->descripcion])
            ->andFilterWhere(['ilike', 'contenido', $this->contenido]);

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchHerramientas($params)
    {
        $query = Recursos::find()->joinWith('usuario');
    
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageParam' => 'precurso',
                'pageSize' => 3,
            ]
        ]);

        $dataProvider->sort->attributes['usuario.usuario'] = [
            'asc' => ['usuarios.usuario' => SORT_ASC],
            'desc' => ['usuarios.usuario' => SORT_DESC],
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
            'created_at' => $this->created_at,
            'usuario_id' => $this->usuario_id,
            'categoria_id' => $this->categoria_id,
        ]);

        $query->andFilterWhere(['ilike', 'titulo', $this->titulo])
            ->andFilterWhere(['ilike', 'descripcion', $this->descripcion])
            ->andFilterWhere(['ilike', 'contenido', $this->contenido]);

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchRecursosCategoria($params, $id)
    {
        $query = Recursos::find()->where(['categoria_id' => $id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageParam' => 'precurso',
                'pageSize' => 9,
            ]
        ]);

        $dataProvider->sort->attributes['usuario.usuario'] = [
            'asc' => ['usuarios.usuario' => SORT_ASC],
            'desc' => ['usuarios.usuario' => SORT_DESC],
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
            'created_at' => $this->created_at,
            'usuario_id' => $this->usuario_id,
            'categoria_id' => $this->categoria_id,
        ]);

        $query->andFilterWhere(['ilike', 'titulo', $this->titulo])
            ->andFilterWhere(['ilike', 'descripcion', $this->descripcion])
            ->andFilterWhere(['ilike', 'contenido', $this->contenido]);

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchRecursosImg($params, $id)
    {
        $query = Recursos::find()
                         ->where(['categoria_id' => $id])
                         ->andWhere(['not', ['imagen' => '']]);
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageParam' => 'precurso',
                'pageSize' => 9,
            ]
        ]);

        $dataProvider->sort->attributes['usuario.usuario'] = [
            'asc' => ['usuarios.usuario' => SORT_ASC],
            'desc' => ['usuarios.usuario' => SORT_DESC],
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
            'created_at' => $this->created_at,
            'usuario_id' => $this->usuario_id,
            'categoria_id' => $this->categoria_id,
        ]);

        $query->andFilterWhere(['ilike', 'titulo', $this->titulo])
            ->andFilterWhere(['ilike', 'descripcion', $this->descripcion])
            ->andFilterWhere(['ilike', 'contenido', $this->contenido]);

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchRecursosPdf($params, $id)
    {
        $query = Recursos::find()
                           ->where(['categoria_id' => $id])
                           ->andWhere(['not', ['pdf_pdf' => '']]);
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageParam' => 'precurso',
                'pageSize' => 9,
            ]
        ]);

        $dataProvider->sort->attributes['usuario.usuario'] = [
            'asc' => ['usuarios.usuario' => SORT_ASC],
            'desc' => ['usuarios.usuario' => SORT_DESC],
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
            'created_at' => $this->created_at,
            'usuario_id' => $this->usuario_id,
            'categoria_id' => $this->categoria_id,
        ]);

        $query->andFilterWhere(['ilike', 'titulo', $this->titulo])
            ->andFilterWhere(['ilike', 'descripcion', $this->descripcion])
            ->andFilterWhere(['ilike', 'contenido', $this->contenido]);

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchRecursosComp($params, $id)
    {
        $query = Recursos::find()
                           ->where(['categoria_id' => $id])
                           ->andWhere(['not', ['pdf_pdf' => '']])
                           ->andWhere(['not', ['imagen' => '']])
                           ->andWhere(['not', ['enlace' => '']]);
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageParam' => 'precurso',
                'pageSize' => 9,
            ]
        ]);

        $dataProvider->sort->attributes['usuario.usuario'] = [
            'asc' => ['usuarios.usuario' => SORT_ASC],
            'desc' => ['usuarios.usuario' => SORT_DESC],
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
            'created_at' => $this->created_at,
            'usuario_id' => $this->usuario_id,
            'categoria_id' => $this->categoria_id,
        ]);

        $query->andFilterWhere(['ilike', 'titulo', $this->titulo])
            ->andFilterWhere(['ilike', 'descripcion', $this->descripcion])
            ->andFilterWhere(['ilike', 'contenido', $this->contenido]);

        return $dataProvider;
    }


    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchSinRevisar($params)
    {
        $query = Recursos::find()->where(['revisado' => false])->orderBy(['created_at' => SORT_DESC]);
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageParam' => 'precurso',
                'pageSize' => 9,
            ]
        ]);

        $dataProvider->sort->attributes['usuario.usuario'] = [
            'asc' => ['usuarios.usuario' => SORT_ASC],
            'desc' => ['usuarios.usuario' => SORT_DESC],
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
            'created_at' => $this->created_at,
            'usuario_id' => $this->usuario_id,
            'categoria_id' => $this->categoria_id,
        ]);

        $query->andFilterWhere(['ilike', 'titulo', $this->titulo])
            ->andFilterWhere(['ilike', 'descripcion', $this->descripcion])
            ->andFilterWhere(['ilike', 'contenido', $this->contenido]);

        return $dataProvider;
    }
    
}

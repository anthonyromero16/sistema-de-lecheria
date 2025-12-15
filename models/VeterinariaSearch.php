<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Veterinaria;

/**
 * VeterinariaSearch represents the model behind the search form of `app\models\Veterinaria`.
 */
class VeterinariaSearch extends Veterinaria
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_animal'], 'integer'],
            [['tipo_evento', 'fecha', 'descripcion', 'fecha_creado', 'fecha_actualizado'], 'safe'],
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
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = Veterinaria::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_animal' => $this->id_animal,
            'fecha' => $this->fecha,
            'fecha_creado' => $this->fecha_creado,
            'fecha_actualizado' => $this->fecha_actualizado,
        ]);

        $query->andFilterWhere(['like', 'tipo_evento', $this->tipo_evento])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }
}

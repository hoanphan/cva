<?php

namespace backend\ModelSearch;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\SoLienLacDienTuLop;

/**
 * SoLienLacDienTuLopSearch represents the model behind the search form about `backend\models\SoLienLacDienTuLop`.
 */
class SoLienLacDienTuLopSearch extends SoLienLacDienTuLop
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MaTuan'], 'integer'],
            [['MaNam', 'MaLop', 'NoiDung'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = SoLienLacDienTuLop::find();

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
            'MaTuan' => $this->MaTuan,
        ]);

        $query->andFilterWhere(['like', 'MaNam', $this->MaNam])
            ->andFilterWhere(['like', 'MaLop', $this->MaLop])
            ->andFilterWhere(['like', 'NoiDung', $this->NoiDung]);

        return $dataProvider;
    }
}

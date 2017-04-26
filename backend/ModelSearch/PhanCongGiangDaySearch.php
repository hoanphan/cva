<?php

namespace backend\ModelSearch;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\PhanCongGiangDay;

/**
 * PhanCongGiangDaySearch represents the model behind the search form about `backend\models\PhanCongGiangDay`.
 */
class PhanCongGiangDaySearch extends PhanCongGiangDay
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MaNamHoc', 'MaHocKy', 'MaGiaoVien', 'MaMonHoc', 'MaLop'], 'safe'],
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
        $query = PhanCongGiangDay::find();

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
        $query->andFilterWhere(['like', 'MaNamHoc', $this->MaNamHoc])
            ->andFilterWhere(['like', 'MaHocKy', $this->MaHocKy])
            ->andFilterWhere(['like', 'MaGiaoVien', $this->MaGiaoVien])
            ->andFilterWhere(['like', 'MaMonHoc', $this->MaMonHoc])
            ->andFilterWhere(['like', 'MaLop', $this->MaLop]);

        return $dataProvider;
    }
}

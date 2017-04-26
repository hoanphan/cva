<?php

namespace app\ModelSearch;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use  backend\models\DsDiem;

/**
 * DsDiemSearch represents the model behind the search form about `app\common\models\Dsdiem`.
 */
class DsDiemSearch extends DsDiem
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MaHocSinh', 'MaNamHoc', 'MaHocKy', 'MaMonHoc', 'MaLoaiDiem', 'DiemCu'], 'safe'],
            [['STTDiem', 'ChoPhepDang', 'KhoaSo', 'ChoPhepSua'], 'integer'],
            [['Diem'], 'number'],
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
        $query = Dsdiem::find();

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
            'STTDiem' => $this->STTDiem,
            'Diem' => $this->Diem,
            'ChoPhepDang' => $this->ChoPhepDang,
            'KhoaSo' => $this->KhoaSo,
            'ChoPhepSua' => $this->ChoPhepSua,
        ]);

        $query->andFilterWhere(['like', 'MaHocSinh', $this->MaHocSinh])
            ->andFilterWhere(['like', 'MaNamHoc', $this->MaNamHoc])
            ->andFilterWhere(['like', 'MaHocKy', $this->MaHocKy])
            ->andFilterWhere(['like', 'MaMonHoc', $this->MaMonHoc])
            ->andFilterWhere(['like', 'MaLoaiDiem', $this->MaLoaiDiem])
            ->andFilterWhere(['like', 'DiemCu', $this->DiemCu]);

        return $dataProvider;
    }
}

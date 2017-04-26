<?php

namespace backend\ModelSearch;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\DsGvChuaNhapDiem;

/**
 * DsGvChuaNhapSearch represents the model behind the search form about `backend\models\DsGvChuaNhapDiem`.
 */
class DsGvChuaNhapSearch extends DsGvChuaNhapDiem
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['MaGiaoVien', 'TenGiaoVien', 'LopChuaNhap', 'LopDaNhap', 'sms', 'TuNgay', 'DenNgay', 'SDTGV'], 'safe'],
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
        $query = DsGvChuaNhapDiem::find();

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
            'TuNgay' => $this->TuNgay,
            'DenNgay' => $this->DenNgay,
        ]);

        $query->andFilterWhere(['like', 'MaGiaoVien', $this->MaGiaoVien])
            ->andFilterWhere(['like', 'TenGiaoVien', $this->TenGiaoVien])
            ->andFilterWhere(['like', 'LopChuaNhap', $this->LopChuaNhap])
            ->andFilterWhere(['like', 'LopDaNhap', $this->LopDaNhap])
            ->andFilterWhere(['like', 'sms', $this->sms])
            ->andFilterWhere(['like', 'SDTGV', $this->SDTGV]);

        return $dataProvider;
    }
}

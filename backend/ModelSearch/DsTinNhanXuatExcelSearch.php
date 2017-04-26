<?php

namespace backend\ModelSearch;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\DsTinNhanXuatExcel;

/**
 * DsTinNhanXuatExcelSearch represents the model behind the search form about `backend\models\DsTinNhanXuatExcel`.
 */
class DsTinNhanXuatExcelSearch extends DsTinNhanXuatExcel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'Thang'], 'integer'],
            [['MaHocSinh', 'TenHocSinh', 'Ky', 'SDT', 'NoiDung'], 'safe'],
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
        $query = DsTinNhanXuatExcel::find();

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
            'Thang' => $this->Thang,
        ]);

        $query->andFilterWhere(['like', 'MaHocSinh', $this->MaHocSinh])
            ->andFilterWhere(['like', 'TenHocSinh', $this->TenHocSinh])
            ->andFilterWhere(['like', 'Ky', $this->Ky])
            ->andFilterWhere(['like', 'SDT', $this->SDT])
            ->andFilterWhere(['like', 'NoiDung', $this->NoiDung]);

        return $dataProvider;
    }
}

<?php

namespace backend\ModelSearch;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\DSTongKetTheoKy;

/**
 * DsTongKetTheoKySearch represents the model behind the search form about `backend\models\DsTongKetTheoKy`.
 */
class DsTongKetTheoKySearch extends DSTongKetTheoKy
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MaNamHoc', 'MaHocKy', 'MaHocSinh', 'MaHanhKiem', 'MaDanhHieu', 'MaHocLuc', 'MaLenLop'], 'safe'],
            [['TrungBinhChung'], 'number'],
            [['soBuoiNghi'], 'integer'],
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
    public function search($params,$MaLop,$MaHocKy)
    {
        $query = DsTongKetTheoKy::find()->innerJoin('dshocsinhtheolop','dshocsinhtheolop.MaHocSinh=dstongkettheoky.MaHocSinh')->where(['MaLop'=>$MaLop,'MaHocKy'=>$MaHocKy]);

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
            'TrungBinhChung' => $this->TrungBinhChung,
            'soBuoiNghi' => $this->soBuoiNghi,
        ]);

        $query->andFilterWhere(['like', 'MaNamHoc', $this->MaNamHoc])
            ->andFilterWhere(['like', 'MaHocKy', $this->MaHocKy])
            ->andFilterWhere(['like', 'MaHocSinh', $this->MaHocSinh])
            ->andFilterWhere(['like', 'MaHanhKiem', $this->MaHanhKiem])
            ->andFilterWhere(['like', 'MaDanhHieu', $this->MaDanhHieu])
            ->andFilterWhere(['like', 'MaHocLuc', $this->MaHocLuc])
            ->andFilterWhere(['like', 'MaLenLop', $this->MaLenLop]);

        return $dataProvider;
    }
}

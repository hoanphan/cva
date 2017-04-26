<?php

namespace backend\ModelSearch;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use  backend\models\DsHocSinh;

/**
 * DsHocSinhSearch represents the model behind the search form about `app\common\models\Dshocsinh`.
 */
class DsHocSinhSearch extends DsHocSinh
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MaHocSinh', 'HoDem', 'Ten', 'TenThuongGoi', 'NgaySinh', 'NoiSinh', 'QueQuan', 'HoTenBo', 'NgheNghiepBo', 'HoTenMe', 'NgheNghiepMe', 'Anh', 'NgayVaoDoan', 'NoiVaoDoan', 'MatKhau', 'EmailPhuHuynh', 'SoDienThoaiPhuHuynh'], 'safe'],
            [['DaQuaLop', 'GioiTinh', 'MaDanToc', 'MaTonGiao', 'MaTinhTrangSucKhoe', 'DangKyDichVu'], 'integer'],
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
    public function search($params,$kt)
    {
        if($kt==false)
        $query = DsHocSinh::find();
        else
            $query = DsHocSinh::find()->where(['DangKyDichVu'=>1]);
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
            'DaQuaLop' => $this->DaQuaLop,
            'NgaySinh' => $this->NgaySinh,
            'GioiTinh' => $this->GioiTinh,
            'MaDanToc' => $this->MaDanToc,
            'MaTonGiao' => $this->MaTonGiao,
            'MaTinhTrangSucKhoe' => $this->MaTinhTrangSucKhoe,
            'NgayVaoDoan' => $this->NgayVaoDoan,
            'DangKyDichVu' => $this->DangKyDichVu,
        ]);

        $query->andFilterWhere(['like', 'MaHocSinh', $this->MaHocSinh])
            ->andFilterWhere(['like', 'HoDem', $this->HoDem])
            ->andFilterWhere(['like', 'Ten', $this->Ten])
            ->andFilterWhere(['like', 'TenThuongGoi', $this->TenThuongGoi])
            ->andFilterWhere(['like', 'NoiSinh', $this->NoiSinh])
            ->andFilterWhere(['like', 'QueQuan', $this->QueQuan])
            ->andFilterWhere(['like', 'HoTenBo', $this->HoTenBo])
            ->andFilterWhere(['like', 'NgheNghiepBo', $this->NgheNghiepBo])
            ->andFilterWhere(['like', 'HoTenMe', $this->HoTenMe])
            ->andFilterWhere(['like', 'NgheNghiepMe', $this->NgheNghiepMe])
            ->andFilterWhere(['like', 'Anh', $this->Anh])
            ->andFilterWhere(['like', 'NoiVaoDoan', $this->NoiVaoDoan])
            ->andFilterWhere(['like', 'MatKhau', $this->MatKhau])
            ->andFilterWhere(['like', 'EmailPhuHuynh', $this->EmailPhuHuynh])
            ->andFilterWhere(['like', 'SoDienThoaiPhuHuynh', $this->SoDienThoaiPhuHuynh]);

        return $dataProvider;
    }
}

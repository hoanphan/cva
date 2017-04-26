<?php

namespace app\ModelSearch;

use backend\models\DsHocSinh;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\SoLienLacDienTu;
use yii\db\Query;

/**
 * SoLienLacDienTuSearch represents the model behind the search form about `app\common\models\SoLienLacDienTu`.
 */
class SoLienLacDienTuSearch extends SoLienLacDienTu
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MaHocSinh', 'MaNamhoc', 'NoiDung'], 'safe'],
            [['MaTuan'], 'integer'],
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
    public function search($params,$idClass)
    {


        $query=new Query();
        $query->from('dshocsinh')->innerJoin('dshocsinhtheolop',['dshocsinh.MaHocSinh'=>'dshocsinhtheolop.MaHocSinh'])->all();
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



        return $dataProvider;
    }
}

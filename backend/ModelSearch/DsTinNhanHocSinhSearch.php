<?php

namespace backend\ModelSearch;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\DsTinNhanHocSinh;

/**
 * DsTinNhanHocSinhSearch represents the model behind the search form about `backend\models\DsTinNhanHocSinh`.
 */
class DsTinNhanHocSinhSearch extends DsTinNhanHocSinh
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'idSms', 'CacLanCoGangGui', 'Thang', 'TrangThai'], 'integer'],
            [['MaHocSinh', 'SddtPhuHuynh', 'NoiDung', 'LoiPhatSinh'], 'safe'],
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
    public function search($params,$month)
    {
        $query = DsTinNhanHocSinh::find()->where(['Thang'=>$month]);

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
            'idSms' => $this->idSms,
            'CacLanCoGangGui' => $this->CacLanCoGangGui,
            'Thang' => $this->Thang,
            'TrangThai' => $this->TrangThai,
        ]);

        $query->andFilterWhere(['like', 'MaHocSinh', $this->MaHocSinh])
            ->andFilterWhere(['like', 'SddtPhuHuynh', $this->SddtPhuHuynh])
            ->andFilterWhere(['like', 'NoiDung', $this->NoiDung])
            ->andFilterWhere(['like', 'LoiPhatSinh', $this->LoiPhatSinh]);

        return $dataProvider;
    }
}

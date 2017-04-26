<?php

namespace backend\ModelSearch;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\DsEmailSmsGuiToanBo;

/**
 * DsEmailSmsGuiToanBoSearch represents the model behind the search form about `backend\models\DsEmailSmsGuiToanBo`.
 */
class DsEmailSmsGuiToanBoSearch extends DsEmailSmsGuiToanBo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'DaGuiEmail', 'DaGuiSms'], 'integer'],
            [['MaHocSinh', 'EmailPhuHuynh', 'SoDienThoaiPhuHuynh', 'NoiDungEmail', 'NoidungSms', 'TieuDeEmail'], 'safe'],
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
        $query = DsEmailSmsGuiToanBo::find();

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
            'DaGuiEmail' => $this->DaGuiEmail,
            'DaGuiSms' => $this->DaGuiSms,
        ]);

        $query->andFilterWhere(['like', 'MaHocSinh', $this->MaHocSinh])
            ->andFilterWhere(['like', 'EmailPhuHuynh', $this->EmailPhuHuynh])
            ->andFilterWhere(['like', 'SoDienThoaiPhuHuynh', $this->SoDienThoaiPhuHuynh])
            ->andFilterWhere(['like', 'NoiDungEmail', $this->NoiDungEmail])
            ->andFilterWhere(['like', 'NoidungSms', $this->NoidungSms])
            ->andFilterWhere(['like', 'TieuDeEmail', $this->TieuDeEmail]);

        return $dataProvider;
    }
}

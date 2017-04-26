<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tieuchuandanhhieu".
 *
 * @property string $MaDanhHieu
 * @property string $MaHocLuc
 * @property string $MaHanhKiem
 */
class TieuChuanDanhHieu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tieuchuandanhhieu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MaDanhHieu', 'MaHocLuc', 'MaHanhKiem'], 'required'],
            [['MaDanhHieu', 'MaHocLuc', 'MaHanhKiem'], 'string', 'max' => 3],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'MaDanhHieu' => 'Ma Danh Hieu',
            'MaHocLuc' => 'Ma Hoc Luc',
            'MaHanhKiem' => 'Ma Hanh Kiem',
        ];
    }
}

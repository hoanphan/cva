<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "dshocsinhtheolop".
 *
 * @property string $MaNamHoc
 * @property string $MaHocSinh
 * @property string $MaLop
 * @property integer $STT
 */
class DSHocSinhTheoLop extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dshocsinhtheolop';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MaHocSinh', 'MaLop'], 'required'],
            [['STT'], 'integer'],
            [['MaNamHoc'], 'string', 'max' => 8],
            [['MaHocSinh'], 'string', 'max' => 7],
            [['MaLop'], 'string', 'max' => 4],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'MaNamHoc' => 'Ma Nam Hoc',
            'MaHocSinh' => 'Ma Hoc Sinh',
            'MaLop' => 'Ma Lop',
            'STT' => 'Stt',
        ];
    }
    public static function getListStudentFollowClass($id)
    {
        $idYearCurrentt=DSNamHoc::getCurrentYear();
        return DSHocSinhTheoLop::find()->where(['MaLop'=>$id,'MaNamHoc'=>$idYearCurrentt])
            ->andWhere(['not in','MaHocSinh',
                DsHocSinhChuyenTruong::find()->where(['MaNamHoc'=>$idYearCurrentt,'ChuyenDi'=>DsHocSinhChuyenTruong::IS_TRASFER])->select('MaHocSinh')])->orderBy(['STT'=>SORT_ASC])->all();
    }
    public static function getClassFollowClass($id)
    {
        $idYearCurrentt=DSNamHoc::getCurrentYear();
        return DSHocSinhTheoLop::findOne(['MaHocSinh'=>$id,'MaNamHoc'=>$idYearCurrentt])->MaLop;
    }
    public static function getClassFollowStudent($id)
    {
        $idYearCurrentt=DSNamHoc::getCurrentYear();
        return DSHocSinhTheoLop::findOne(['MaHocSinh'=>$id,'MaNamHoc'=>$idYearCurrentt])->MaLop;
    }
    public static function getListStudentFollowClassAsArray($id)
    {
        $idYearCurrentt=DSNamHoc::getCurrentYear();
        return DSHocSinhTheoLop::find()->where(['MaLop'=>$id,'MaNamHoc'=>$idYearCurrentt])->orderBy(['STT'=>SORT_ASC])->select(['MaHocSinh'])->asArray()->all();
    }
    public static function layTongSoHocSinhTheoHocLucKhongDanhGia($HocLuc,$MaMonHoc,$MaKhoi,$MaHocKy)
    {

        $idYear=DSNamHoc::getCurrentYear();

        $idDiemTomgHop=DsLoaiDiem::LoadLoaiDiemTongHop();
        $dmHocLuc=DmHocLuc::findOne(['MaHocLuc'=>$HocLuc]);
       $sl= DsDiem::find()->innerJoin('dshocsinhtheolop', 'dsdiem.MaHocSinh=dshocsinhtheolop.MaHocSinh')
            ->innerJoin('dslop', 'dslop.MaLop=dshocsinhtheolop.MaLop')->where(['dsdiem.MaNamHoc' => $idYear, 'dsdiem.MaHocKy' => $MaHocKy,
                'dsdiem.MaMonHoc' => $MaMonHoc, 'dslop.MaKhoi' => $MaKhoi,
                'dsdiem.MaLoaiDiem'=>$idDiemTomgHop,'dsdiem.STTDiem'=>1
            ])
            ->andWhere(['>=', 'dsdiem.Diem', $dmHocLuc->DiemMocDuoi])
            ->andWhere(['<', 'dsdiem.Diem',$dmHocLuc->DiemMocTren])->count();
      /*  foreach ($dsLop as $item)
        {
            $DsHocSinh=DSHocSinhTheoLop::getListStudentFollowClass($item->MaLop);
            foreach ($DsHocSinh as $record)
            {

                $sroses=DsDiem::getScoresFollowStudent($record->MaHocSinh,$idYear,$MaHocKy,$MaMonHoc,$idDiemTomgHop,1);
                if($sroses>=$dmHocLuc->DiemMocDuoi&&$sroses<$dmHocLuc->DiemMocTren)
                    $sl++;
            }
        }*/

        return $sl;
    }
    public static function layTongSoHocSinhTheoHocLucDanhGia($DiemanhGia,$MaMonHoc,$MaKhoi,$MaHocKy)
    {

        $idYear=DSNamHoc::getCurrentYear();

        $idDiemTomgHop=DsLoaiDiem::LoadLoaiDiemTongHop();

        $sl= DsDiem::find()->innerJoin('dshocsinhtheolop', 'dsdiem.MaHocSinh=dshocsinhtheolop.MaHocSinh')
            ->innerJoin('dslop', 'dslop.MaLop=dshocsinhtheolop.MaLop')->where(['dsdiem.MaNamHoc' => $idYear, 'dsdiem.MaHocKy' => $MaHocKy,
                'dsdiem.MaMonHoc' => $MaMonHoc, 'dslop.MaKhoi' => $MaKhoi,
                'dsdiem.MaLoaiDiem'=>$idDiemTomgHop,'dsdiem.STTDiem'=>1,'dsdiem.Diem'=>$DiemanhGia
            ])
          ->count();
        /*  foreach ($dsLop as $item)
          {
              $DsHocSinh=DSHocSinhTheoLop::getListStudentFollowClass($item->MaLop);
              foreach ($DsHocSinh as $record)
              {

                  $sroses=DsDiem::getScoresFollowStudent($record->MaHocSinh,$idYear,$MaHocKy,$MaMonHoc,$idDiemTomgHop,1);
                  if($sroses>=$dmHocLuc->DiemMocDuoi&&$sroses<$dmHocLuc->DiemMocTren)
                      $sl++;
              }
          }*/

        return $sl;
    }
    public static function TheoKhoiKhongDanhGia($HocLuc,$MaMonHoc,$MaHocKy,$dsKhoi)
    {
        $sl=0;
        $idYear=DSNamHoc::getCurrentYear();

        $idDiemTomgHop=DsLoaiDiem::LoadLoaiDiemTongHop();
        $dmHocLuc=DmHocLuc::findOne(['MaHocLuc'=>$HocLuc]);
        /*for($i=0;$i<count($dsKhoi);$i++) {
            $dsLop = DsLop::find()->where(['MaKhoi' => $dsKhoi[$i]->MaKhoi, 'MaNamHoc' => $idYear])->all();
            foreach ($dsLop as $item) {
                $DsHocSinh = DSHocSinhTheoLop::getListStudentFollowClass($item->MaLop);
                foreach ($DsHocSinh as $record) {

                    $sroses = DsDiem::getScoresFollowStudent($record->MaHocSinh, $idYear, $MaHocKy, $MaMonHoc, $idDiemTomgHop, 1);
                    if ($sroses >= $dmHocLuc->DiemMocDuoi && $sroses < $dmHocLuc->DiemMocTren)
                        $sl++;
                }
            }
        }*/
        for($i=0;$i<count($dsKhoi);$i++) {
            $sl += DsDiem::find()->innerJoin('dshocsinhtheolop', 'dsdiem.MaHocSinh=dshocsinhtheolop.MaHocSinh')
                ->innerJoin('dslop', 'dslop.MaLop=dshocsinhtheolop.MaLop')->where(['dsdiem.MaNamHoc' => $idYear, 'dsdiem.MaHocKy' => $MaHocKy,
                    'dsdiem.MaMonHoc' => $MaMonHoc, 'dslop.MaKhoi' => $dsKhoi[$i]->MaKhoi,
                    'dsdiem.MaLoaiDiem'=>$idDiemTomgHop,'dsdiem.STTDiem'=>1
                ])
                ->andWhere(['>=', 'dsdiem.Diem', $dmHocLuc->DiemMocDuoi])
                ->andWhere(['<', 'dsdiem.Diem',$dmHocLuc->DiemMocTren])->count();
        }
        return $sl;
    }
    public static function TheoKhoiDanhGia($DiemDanhGia,$MaMonHoc,$MaHocKy,$dsKhoi)
    {
        $sl=0;
        $idYear=DSNamHoc::getCurrentYear();

        $idDiemTomgHop=DsLoaiDiem::LoadLoaiDiemTongHop();
        /*for($i=0;$i<count($dsKhoi);$i++) {
            $dsLop = DsLop::find()->where(['MaKhoi' => $dsKhoi[$i]->MaKhoi, 'MaNamHoc' => $idYear])->all();
            foreach ($dsLop as $item) {
                $DsHocSinh = DSHocSinhTheoLop::getListStudentFollowClass($item->MaLop);
                foreach ($DsHocSinh as $record) {

                    $sroses = DsDiem::getScoresFollowStudent($record->MaHocSinh, $idYear, $MaHocKy, $MaMonHoc, $idDiemTomgHop, 1);
                    if ($sroses >= $dmHocLuc->DiemMocDuoi && $sroses < $dmHocLuc->DiemMocTren)
                        $sl++;
                }
            }
        }*/
        for($i=0;$i<count($dsKhoi);$i++) {
            $sl += DsDiem::find()->innerJoin('dshocsinhtheolop', 'dsdiem.MaHocSinh=dshocsinhtheolop.MaHocSinh')
                ->innerJoin('dslop', 'dslop.MaLop=dshocsinhtheolop.MaLop')->where(['dsdiem.MaNamHoc' => $idYear, 'dsdiem.MaHocKy' => $MaHocKy,
                    'dsdiem.MaMonHoc' => $MaMonHoc, 'dslop.MaKhoi' => $dsKhoi[$i]->MaKhoi,
                    'dsdiem.MaLoaiDiem'=>$idDiemTomgHop,'dsdiem.STTDiem'=>1,'dsdiem.Diem'=>$DiemDanhGia
                ])->count();
        }
        return $sl;
    }
}

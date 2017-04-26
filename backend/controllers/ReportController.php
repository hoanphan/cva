<?php
/**
 * Created by PhpStorm.
 * User: PHANHOANDHTB
 * Date: 11/3/2016
 * Time: 12:26 AM
 */

namespace backend\controllers;


use backend\BLL\DSCapBLL;
use backend\models\DmDanhHieu;
use backend\models\DMHanhKiem;
use backend\models\DSCap;
use backend\models\DSHocKy;
use backend\models\DSHocSinhTheoLop;
use backend\models\DSKhoi;
use backend\models\DsLop;
use backend\models\Report;
use DateTime;
use DateTimeZone;
use kartik\mpdf\Pdf;
use Yii;
use yii\web\Controller;

class ReportController extends Controller
{
    public function actionReport()
    {
        $semester = new DSHocKy();
        $gruop = new DSKhoi();
        $class = new DsLop();
        if ($semester->load(Yii::$app->request->post()) && $class->load(Yii::$app->request->post()) && $gruop->load(Yii::$app->request->post())) {
            return $this->render('report-class', ['semester' => $semester, 'class' => $class, 'gruop' => $gruop, 'idClass' => $class, 'idSemester' => $semester['TenHocKy'], 'idGroup' => $gruop['TenKhoi']]);

        } else
            return $this->render('report-class', ['semester' => $semester, 'class' => $class, 'gruop' => $gruop, 'idClass' => $class, 'idSemester' => $semester['TenHocKy'], 'idGroup' => $gruop['TenKhoi']]);
    }
    public function actionReportLevel()
    {
        $semester = new DSHocKy();
        $level=new DSCap();
        $idSemester=DSHocKy::getFistSemeter();
        $idLevel=DSCap::getLevelFist();
        if($semester->load(Yii::$app->request->post())&&$level->load(Yii::$app->request->post()))
        {
            $idLevel=$level['TenCap'];
            $idSemester=$semester['TenHocKy'];
        }
        return $this->render('report-level',['level'=>$level,'semester'=>$semester,'idSemester'=>$idSemester,'idLevel'=>$idLevel]);
    }
    public function actionReportGroup()
    {
        $semester = new DSHocKy();
        $gruop = new DSKhoi();
        $class = new DsLop();
        if ($semester->load(Yii::$app->request->post()) && $class->load(Yii::$app->request->post()) && $gruop->load(Yii::$app->request->post())) {
            return $this->render('report-group', ['semester' => $semester, 'class' => $class, 'gruop' => $gruop, 'idClass' => $class, 'idSemester' => $semester['TenHocKy'], 'idGroup' => $gruop['TenKhoi']]);

        } else
            return $this->render('report-group', ['semester' => $semester, 'class' => $class, 'gruop' => $gruop, 'idClass' => $class, 'idSemester' => $semester['TenHocKy'], 'idGroup' => $gruop['TenKhoi']]);
    }

    /**
     * @param $MaLop
     * @param $MaMonHoc
     * @param $MaHocKy
     * @return báo cáo theo môn học
     */
    public function actionReportScroses($MaLop, $MaMonHoc, $MaHocKy)
    {
        $date = new DateTime("now", new DateTimeZone('Asia/Ho_Chi_Minh') );
        $date=date_format($date,"d/m/Y H:i:s");
        $content = $this->renderPartial('index', ['idClass' => $MaLop, 'idSubject' => $MaMonHoc, 'idSemester' => $MaHocKy]);
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_ASIAN,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_LANDSCAPE,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            'marginTop'=>5,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px}',
            // set mPDF properties on the fly
            'options' => ['title' => 'Báo cáo điểm'],
            // call mPDF methods on the fly
            'methods' => [
                'SetFooter'=>["Trường TH, THCS, THPT Chu Văn An ".$date.'||{PAGENO}'],
            ]
        ]);
        return $pdf->render();
    }


    /**
     * @param $MaCap
     * @param $HocKy
     * @return Báo cáo theo môn học
     */
    public function actionReportHl($MaCap, $HocKy)
    {
        $content = $this->renderPartial('thong-ke-hoc-luc', ['MaCap' => $MaCap, 'idSemester' => $HocKy]);
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_ASIAN,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            'defaultFont'=>'Times New Roman',
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px}',
            // set mPDF properties on the fly
            'options' => ['title' => 'Báo cáo theo học lực - '.DSCap::getName($MaCap)],
            // call mPDF methods on the fly
            'methods' => [
                'SetFooter'=>['{PAGENO}'],
            ]
        ]);
        return $pdf->render();
    }

    /**
     * @param $MaLop
     * @param $MaHocKy
     * @return báo cáo theo lớp
     */
    public function actionReportClass($MaLop, $MaHocKy)
    {
       $content = $this->renderPartial('thong-ke-hoc-luc-lop', ['idClass' => $MaLop, 'idSemester' => $MaHocKy]);
        $date = new DateTime("now", new DateTimeZone('Asia/Ho_Chi_Minh') );
        $date=date_format($date,"d/m/Y H:i:s");
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_UTF8,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_LANDSCAPE,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            'marginTop'=>5,
            'marginRight'=>3,
            'marginLeft'=>4,
            'defaultFontSize'=>9,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            // set mPDF properties on the fly
            'options' => ['title' =>DsLop::getNameClass($MaLop).DSHocKy::getNameSemester($MaHocKy),'lag'=>'vi'],
            // call mPDF methods on the fly
            'methods' => [
                'SetFooter'=>["Trường TH, THCS, THPT Chu Văn An ".$date.'||{PAGENO}'],

            ]
        ]);
        return $pdf->render();
    }
    public function actionReportConductCaption()
    {
        $semester = new DSHocKy();
        $level = new DSCap();
        $report=new DSKhoi();
        return $this->render('report-conduct-caption',['semester'=>$semester,'report'=>$report,'level'=>$level]);
    }
    public function actionReportNation($level,$idSemester)
    {
        $date = new DateTime("now", new DateTimeZone('Asia/Ho_Chi_Minh') );
        $date=date_format($date,"d/m/Y H:i:s");
        $content = $this->renderPartial('thong-ke-dan-toc', ['idLevel' =>$level , 'idSemester' => $idSemester]);
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_ASIAN,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            'marginTop'=>5,
            'marginRight'=>3,
            'marginLeft'=>4,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            // set mPDF properties on the fly
            'options' => ['title' =>'ThongKeDanToc'.DSCap::getName($level)],
            // call mPDF methods on the fly
            'methods' => [

                'SetFooter'=>["Trường TH, THCS, THPT Chu Văn An ".$date.'||{PAGENO}'],
            ]
        ]);
        return $pdf->render();
    }
    public function actionReportAge($level,$semester)
    {

        $content = $this->renderPartial('thong-ke-theo-do-tuoi', ['idLevel' =>$level , 'idSemester' => $semester]);
        $date = new DateTime("now", new DateTimeZone('Asia/Ho_Chi_Minh') );
        $date=date_format($date,"d/m/Y H:i:s");
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_ASIAN,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            'marginTop'=>5,
            'marginRight'=>3,
            'marginLeft'=>4,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            // set mPDF properties on the fly
            'options' => ['title' =>'ThongKeDanToc'.DSCap::getName($level)],
            // call mPDF methods on the fly
            'methods' => [
                'SetFooter'=>["Trường TH, THCS, THPT Chu Văn An ".$date.'||{PAGENO}'],
            ]
        ]);
        return $pdf->render();
    }
    public function actionReportHanhKiemHocLuc($level,$semester)
    {
        $content = $this->renderPartial('thong-ke-hanh-kiem-hoc-luc', ['idLevel' =>$level , 'idSemester' => $semester]);
        $date = new DateTime("now", new DateTimeZone('Asia/Ho_Chi_Minh') );
        $date=date_format($date,"Y/m/d H:i:s");

        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_ASIAN,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_LANDSCAPE,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            'marginTop'=>5,
            'marginRight'=>3,
            'marginLeft'=>4,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            // set mPDF properties on the fly
            'options' => ['title' =>'ThongKeHanhKiemHanhLuc'.DSCap::getName($level)],
            // call mPDF methods on the fly
            'methods' => [
                'SetFooter'=>["Trường TH, THCS, THPT Chu Văn An ".$date.'||{PAGENO}'],
            ]
        ]);
        return $pdf->render();
    }

    /**
     * @return array
     */
    public function actionReportTheoKhoi($MaKhoi,$MaHocKy)
    {
        $content = $this->renderPartial('thong-ke-theo-khoi', ['idGroup' => $MaKhoi, 'idSemester' => $MaHocKy]);
        $date = new DateTime("now", new DateTimeZone('Asia/Ho_Chi_Minh') );
        $date=date_format($date,"d/m/Y H:i:s");
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_UTF8,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_LANDSCAPE,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            'marginTop'=>5,
            'marginRight'=>3,
            'marginLeft'=>4,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            // set mPDF properties on the fly
            'options' => ['title' =>"Khối ".DSKhoi::getNameGruop($MaKhoi)." ".DSHocKy::getNameSemester($MaHocKy),'lag'=>'vi'],
            // call mPDF methods on the fly
            'methods' => [
                'SetFooter'=>["Trường TH, THCS, THPT Chu Văn An ".$date.'||{PAGENO}'],
            ]
        ]);
        return $pdf->render();
    }
    public function actionReportDanhhieu()
    {
        $semester = new DSHocKy();
        $danhHieu=new DmDanhHieu();
        $idSemester=DSHocKy::getFistSemeter();
        $idDanhHieu=DmDanhHieu::getFistAppletion();
       /* if($semester->load(Yii::$app->request->post())&&$id->load(Yii::$app->request->post()))
        {
            $idLevel=$level['TenCap'];
            $idSemester=$semester['TenHocKy'];
        }*/
        return $this->render('report-danhhieu',['danhHieu'=>$danhHieu,'idSemester'=>$idSemester,'idDanhHieu'=>$idDanhHieu,'semester'=>$semester]);
    }
    public function actionReportDh($MaDH, $HocKy)
    {
        $content = $this->renderPartial('thong-ke-theo-danh-hieu', ['MaDanhHieu' => $MaDH, 'idSemester' => $HocKy]);
        $date = new DateTime("now", new DateTimeZone('Asia/Ho_Chi_Minh') );
        $date=date_format($date,"Y/m/d H:i:s");
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_ASIAN,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            'defaultFont'=>'Times New Roman',
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px}',
            // set mPDF properties on the fly
            'options' => ['title' => 'Báo cáo theo danh hiệu- '.DmDanhHieu::getNameAppellation($MaDH)],
            // call mPDF methods on the fly
            'methods' => [
                'SetFooter'=>["Trường TH, THCS, THPT Chu Văn An ".$date.'||{PAGENO}'],
            ]
        ]);
        return $pdf->render();
    }

    public function actionReportHlMonHoc()
    {
        $semester = new DSHocKy();
        $level=new DSCap();
        $idSemester=DSHocKy::getFistSemeter();
        $idLevel=DSCap::getLevelFist();
        if($semester->load(Yii::$app->request->post())&&$level->load(Yii::$app->request->post()))
        {
            $idLevel=$level['TenCap'];
            $idSemester=$semester['TenHocKy'];
        }
        return $this->render('report-hoc-luc-mh',['level'=>$level,'semester'=>$semester,'idSemester'=>$idSemester,'idLevel'=>$idLevel]);
    }
    public function actionReportHocLucMonHoc($MaCap, $HocKy)
    {
        $content = $this->renderPartial('thong-ke-hl-mon-hoc', ['MaCap' => $MaCap, 'idSemester' => $HocKy]);
        $date = new DateTime("now", new DateTimeZone('Asia/Ho_Chi_Minh') );
        $date=date_format($date,"Y/m/d H:i:s");
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_ASIAN,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_LANDSCAPE,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            'defaultFont'=>'Times New Roman',
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px}',
            // set mPDF properties on the fly
            'options' => ['title' => 'Báo cáo theo học lực - '.DSCap::getName($MaCap)],
            // call mPDF methods on the fly
            'methods' => [
                'SetFooter'=>["Trường TH, THCS, THPT Chu Văn An ".$date.'||{PAGENO}'],
            ]
        ]);
        return $pdf->render();
    }
    public function actionReportHkHl()
    {
        $semester = new DSHocKy();
        $level=new DSCap();
        $idSemester=DSHocKy::getFistSemeter();
        $idLevel=DSCap::getLevelFist();
        if($semester->load(Yii::$app->request->post())&&$level->load(Yii::$app->request->post()))
        {
            $idLevel=$level['TenCap'];
            $idSemester=$semester['TenHocKy'];
        }
        return $this->render('report-hk-hl',['level'=>$level,'semester'=>$semester,'idSemester'=>$idSemester,'idLevel'=>$idLevel]);
    }
    public function actionReportThongKeHkHl($level, $semester)
    {
        $content = $this->renderPartial('thong-ke-hl-hk', ['MaCap' => $level, 'MaHocKy' => $semester]);
        $date = new DateTime("now", new DateTimeZone('Asia/Ho_Chi_Minh') );
        $date=date_format($date,"Y/m/d H:i:s");
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_ASIAN,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            'defaultFont'=>'Times New Roman',
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px}',
            // set mPDF properties on the fly
            'options' => ['title' => 'Báo cáo theo học lực hạnh kiểm- '.DSCap::getName($level)],
            // call mPDF methods on the fly
            'methods' => [
                'SetFooter'=>["Trường TH, THCS, THPT Chu Văn An ".$date.'||{PAGENO}'],
            ]
        ]);
        return $pdf->render();
    }

    /**
     * @param $MaCap
     * @param $HocKy
     * @return Báo cáo theo học lưc
     */
    public function actionReportHocLuc($MaCap, $HocKy)
    {
        $content = $this->renderPartial('thong-ke-hoc-luc1', ['idLevel' => $MaCap, 'idSemester' => $HocKy]);
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_ASIAN,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_LANDSCAPE,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            'defaultFont'=>'Times New Roman',
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px}',
            // set mPDF properties on the fly
            'options' => ['title' => 'Báo cáo theo học lực - '.DSCap::getName($MaCap)],
            // call mPDF methods on the fly
            'methods' => [
                'SetFooter'=>['{PAGENO}'],
            ]
        ]);
        return $pdf->render();
    }
    public function actionReportHanhKiem($MaCap, $HocKy)
    {
        $content = $this->renderPartial('thong-ke-hanh-kiem', ['idLevel' => $MaCap, 'idSemester' => $HocKy]);
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_ASIAN,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_LANDSCAPE,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            'defaultFont'=>'Times New Roman',
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px}',
            // set mPDF properties on the fly
            'options' => ['title' => 'Báo cáo theo học lực - '.DSCap::getName($MaCap)],
            // call mPDF methods on the fly
            'methods' => [
                'SetFooter'=>['{PAGENO}'],
            ]
        ]);
        return $pdf->render();
    }
    public function actionReportTyLeKhaGioi($MaCap, $HocKy)
    {
        $content = $this->renderPartial('thong-ke-ty-le-kha-gioi', ['idLevel' => $MaCap, 'idSemester' => $HocKy]);
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_ASIAN,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            'defaultFont'=>'Times New Roman',
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px}',
            // set mPDF properties on the fly
            'options' => ['title' => 'Thống kê tỷ lệ khá giỏi - '.DSCap::getName($MaCap)],
            // call mPDF methods on the fly
            'methods' => [
                'SetFooter'=>['{PAGENO}'],
            ]
        ]);
        return $pdf->render();
    }

}
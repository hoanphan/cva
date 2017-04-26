<?php
/**
 * Created by PhpStorm.
 * User: HOANDHTB
 * Date: 9/24/2016
 * Time: 10:02 PM
 */

namespace backend\component;
use backend\models\DsHocSinh;
use backend\models\DsLoaiDiem;
use backend\models\DsLop;
use backend\models\DSNamHoc;
use frontend\models\DsDiem;
use frontend\models\DSHocSinhTheoLop;
use frontend\models\DsMonHoc;

use  frontend\models\DsMonHocTheoLop;

class ContentGmail
{
    public static function getTitle($idMonth)
    {
        return '<p class="MsoNormal" align="center" style="text-align:center"><b><span
                            style="font-size:12.0pt;font-family:&quot;Arial&quot;,sans-serif;color:#222222;background:white">Trường TH, THCS, THPT Chu Văn An kính gửi tới quý phụ huynh kết quả học tập của học sinh trong tháng '.$idMonth.'<u></u><u></u></span></b>
                </p>';
    }

    private static function getSubjectStudent($idStudent)
    {

        return '  <div align="center">
                    <table border="0" cellspacing="0" cellpadding="0" width="466"
                           style="width:349.4pt;border-collapse:collapse;border:solid #5b9bd5 1.0pt;border-spacing: 0 ">
                        <tbody>
                        <tr style="height:23.75pt">
                            <td width="162" valign="top"
                                style="width:121.65pt;padding:0in 5.4pt 0in 5.4pt;height:23.75pt;border:solid #5b9bd5 1.0pt"><p class="MsoNormal"
                                                                                                     align="center"
                                                                                                     style="text-align:center">
                                    <span style="color:#2f5496">Mã học sinh</span><span
                                        style="color:#2f5496"><u></u><u></u></span></p></td>
                            <td width="162" valign="top"
                                style="width:121.85pt;padding:0in 5.4pt 0in 5.4pt;height:23.75pt;border:solid #5b9bd5 1.0pt"><p class="MsoNormal"
                                                                                                     align="center"
                                                                                                     style="text-align:center">
                                    <span style="color:#2f5496">'.$idStudent.'<u></u><u></u></span></p></td>
                        </tr>
                        <tr style="height:22.35pt">
                            <td width="162" valign="top"
                                style="width:121.65pt;background:#d9e2f3;padding:0in 5.4pt 0in 5.4pt;height:22.35pt;border:solid #5b9bd5 1.0pt"><p
                                    class="MsoNormal" align="center" style="text-align:center"><span
                                        style="color:#2f5496">Tên học sinh<u></u><u></u></span></p></td>
                            <td width="162" valign="top"
                                style="width:121.85pt;background:#d9e2f3;padding:0in 5.4pt 0in 5.4pt;height:22.35pt;border:solid #5b9bd5 1.0pt"><p
                                    class="MsoNormal" align="center" style="text-align:center"><span
                                        style="color:#2f5496">'.Dshocsinh::getFullName($idStudent).'<u></u><u></u></span></p></td>
                        </tr>
                        <tr style="height:22.35pt">
                            <td width="162" valign="top"
                                style="width:121.65pt;padding:0in 5.4pt 0in 5.4pt;height:22.35pt;border:solid #5b9bd5 1.0pt"><p class="MsoNormal"
                                                                                                     align="center"
                                                                                                     style="text-align:center">
                                    <span style="color:#2f5496">Lớp<u></u><u></u></span></p></td>
                            <td width="162" valign="top"
                                style="width:121.85pt;padding:0in 5.4pt 0in 5.4pt;height:22.35pt;border:solid #5b9bd5 1.0pt"><p class="MsoNormal"
                                                                                                     align="center"
                                                                                                     style="text-align:center">
                                    <span style="color:#2f5496">'.DsLop::getNameClass(DSHocSinhTheoLop::getClassFollowStudent($idStudent)).'<u></u><u></u></span></p></td>
                        </tr>
                        </tbody>
                    </table>
                </div>';
    }
    private static function getContent($idStudent,$idSemsester,$idMonth)
    {
        $idClass=DSHocSinhTheoLop::getClassFollowStudent($idStudent);
        $idYearCurent=DSNamHoc::getCurrentYear();
        $listType=Dsloaidiem::find()->all();
        $str=' <table border="0" cellspacing="0" cellpadding="0" width="100%"
                       style="border-collapse:collapse">
                    <tbody>
                    <tr style="height:18.6pt">
                            <td rowspan="2" valign="top"
                            style="border:solid #5b9bd5 1.0pt;background:#2f5496;padding:0in 5.4pt 0in 5.4pt;height:18.6pt">
                            <p class="MsoNormal" align="center" style="text-align:center"><b><span style="color:white">STT<u></u><u></u></span></b>
                            </p></td>
                            <td  rowspan="2" valign="top"
                            style="widthborder:solid #5b9bd5 1.0pt;background:#2f5496;padding:0in 5.4pt 0in 5.4pt;height:18.6pt;width:10%">
                            <p class="MsoNormal" align="center" style="text-align:center"><b><span style="color:white">Tên môn học<u></u><u></u></span></b>
                            </p></td>';
                    for($i=0;$i<count($listType);$i++)
                    {
                       $str=$str.'<td colspan="'.$listType[$i]->SoDiemToiDa.'" valign="top"
                            style="border:solid #5b9bd5 1.0pt;background:#2f5496;padding:0in 5.4pt 0in 5.4pt;height:18.6pt">
                            <p class="MsoNormal" align="center" style="text-align:center"><b><span style="color:white">'.$listType[$i]->TenLoaiDiem.'<u></u><u></u></span></b>
                            </p></td>';
                            }
                    $str=$str.' </tr><tr>';
                    for($i=0;$i<count($listType);$i++) {
                        for($j=1;$j<=$listType[$i]->SoDiemToiDa;$j++)
                        $str = $str . '
                      
                                    <td  valign="top"
                                        style="border-top:none;border-left:none;border-bottom:solid #5b9bd5 1.0pt;border-right:solid #5b9bd5 1.0pt;background:#2f5496;padding:0in 5.4pt 0in 5.4pt;height:17.6pt">
                                        <p class="MsoNormal" align="center" style="text-align:center"><b><span style="color:white">'.$listType[$i]->HienThi.$j.'<u></u><u></u></span></b>
                                        </p></td>
                               ';
                    }
                    $str=$str.'</tr>';
                        $str=$str.\frontend\models\ListRescroses::getEmail($idStudent, $idSemsester, $idClass, $idYearCurent,$idMonth);

               $str=$str. '
                    </tbody>
                </table>';
        return $str;
    }
    public static function sendText($idStudent,$idSemester,$idMonth)
    {
        return '<div id=":l5" class="ii gt adP adO">
                    <div id=":ml" class="a3s aXjCH m1575d1ea18da2fda">
                        <div lang="EN-US" link="#0563C1" vlink="#954F72">
                            <div>
                               '.self::getTitle($idMonth).'
                                <p class="MsoNormal" align="center" style="text-align:center"><b><span style="font-size:12.0pt"><u></u>&nbsp;<u></u></span></b>
                                </p>
                                '.self::getSubjectStudent($idStudent).'
                <!--                information Student-->
                                <p class="MsoNormal"><u></u>&nbsp;<u></u></p>
                               '.self::getContent($idStudent,$idSemester,$idMonth).'
                                <p class="MsoNormal"><u></u>&nbsp;<u></u></p>
                                <p class="MsoNormal"><span
                                        style="font-size:9.5pt;font-family:&quot;Arial&quot;,sans-serif;color:#222222;background:white">Quy ước:</span><span
                                        style="font-size:9.5pt;font-family:&quot;Arial&quot;,sans-serif;color:#222222">
                                            <br><span style="background:white">&nbsp;&nbsp;&nbsp;&nbsp;  Điểm mầu da cam là điểm nhập trong tháng của học sinh.</span><br>
                                            <br><span style="background:white">&nbsp;&nbsp;&nbsp;&nbsp;  Điểm mầu đỏ là điểm dưới 5 của học sinh.</span><span
                                            <br><span
                                            style="background:white">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Quý phụ huynh vui lòng không trả lời thư này vì đây là hệ thống thư tự động.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><br><span
                                            style="background:white">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Để xem thông tin chi tiết vui lòng truy cập website:<span>&nbsp;</span></span></span><a
                                        href="http://cva.namnguyengt.com" target="_blank"
                                        data-saferedirecturl="https://www.google.com/url?hl=en-GB&amp;q=http://cva.utb.edu.vn/daotao&amp;source=gmail&amp;ust=1474822473141000&amp;usg=AFQjCNFiAw8_PG1o0qoVlv8O3jY0GIWXLQ"><span
                                            style="font-size:9.5pt;font-family:&quot;Arial&quot;,sans-serif;color:#1155cc;background:white">cva.namnguyengt.<wbr>com</span></a><span
                                        style="font-size:9.5pt;font-family:&quot;Arial&quot;,sans-serif;color:#222222"><br><br><span
                                            style="background:white">Nhà trường xin kính báo!</span></span><u></u><u></u></p>
                            </div>
                        </div>
                    </div>
                    <div class="yj6qo"></div>
                </div>';
    }

}
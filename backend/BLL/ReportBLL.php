<?php
/**
 * Created by PhpStorm.
 * User: HOANDHTB
 * Date: 11/9/2016
 * Time: 8:43 AM
 */

namespace backend\BLL;


class ReportBLL
{
    public static function getListReport()
    {
        $arr=[
            ['id'=>'DanToc','name'=>'Dân tộc'],
            ['id'=>'HocLuc','name'=>'Học lực'],
            ['id'=>'HanhKiem','name'=>'Hạnh kiểm'],
            ['id'=>'KhaGioi','name'=>'Tỷ lệ khá giỏi'],
            ['id'=>'KhaGioiHK','name'=>'Tỷ lệ khá giỏi theo điểm học kỳ'],
            ['id'=>'DoTuoi','name'=>'Độ tuổi'],
            ['id'=>'HlHk','name'=>'Học lực và hạnh kiểm'],
            ['id'=>'HlHk1','name'=>'Học lực và hạnh kiểm 2']
        ];
        return $arr;
    }
}
<?php

/**
 * Yii Excel File Reader (Yexcel) Class
 * by: Michel Kogan
 * --------------------
 * LICENSE
 * --------------------
 * This program is open source product; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License (GPL)
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * To read the license please visit http://www.gnu.org/copyleft/gpl.html
 *
 * --------------------
 * @package    Yexcel
 * @author     Michel Kogan <kogan.michel@gmail.com
 * @copyright  2012 Michel Kogan
 * @license    http://www.gnu.org/copyleft/gpl.html  GNU General Public License (GPL)
 * @link       http://www.sparta.ir
 * @see        FileSystem
 * @version    1.0.0
 *
 *
 */
/** Include path * */
set_include_path(get_include_path() . PATH_SEPARATOR . Yii::app()->basePath . '/extensions/yexcel/Classes/');

/** PHPExcel_IOFactory */
include 'PHPExcel/IOFactory.php';

class Yexcel
{

    function __construct()
    {
        
    }

    public function init()
    {
        
    }

    public function readActiveSheet($file)
    {
        $objPHPExcel = PHPExcel_IOFactory::load($file);
        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

        return $sheetData;
    }

    public function writeActiveSheet($data)
    {
        $objectPHPExcel = new PHPExcel();
        $objectPHPExcel->setActiveSheetIndex(0);

        $n = 0;
        
        //表格头的输出
        $objectPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', '菜品名称');
        $objectPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
        $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', '菜品价格（元）');
        $objectPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
        $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', '打包费（元）');
        $objectPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
        $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', '菜品类别');
        $objectPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
        $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('E1','简介');
        
        foreach ($data as $dish)
        {
            //if ( $n % $page_size === 0 )
            //{

//                //报表头的输出
//                $objectPHPExcel->getActiveSheet()->mergeCells('B1:G1');
//                $objectPHPExcel->getActiveSheet()->setCellValue('B1','产品信息表');
//   
//                $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('B2','产品信息表');
//                //$objectPHPExcel->setActiveSheetIndex(0)->setCellValue('B2','产品信息表');
//                $objectPHPExcel->setActiveSheetIndex(0)->getStyle('B1')->getFont()->setSize(24);
//                $objectPHPExcel->setActiveSheetIndex(0)->getStyle('B1')
//                    ->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//   
//                $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('B2','日期：'.date("Y年m月j日"));
//                $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('G2','第'.$current_page.'/'.$page_count.'页');
//                $objectPHPExcel->setActiveSheetIndex(0)->getStyle('G2')
//                    ->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//                //设置居中
//                $objectPHPExcel->getActiveSheet()->getStyle('B3:G3')
//                    ->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//   
//                //设置边框
//                $objectPHPExcel->getActiveSheet()->getStyle('B3:G3' )
//                    ->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
//                $objectPHPExcel->getActiveSheet()->getStyle('B3:G3' )
//                    ->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
//                $objectPHPExcel->getActiveSheet()->getStyle('B3:G3' )
//                    ->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
//                $objectPHPExcel->getActiveSheet()->getStyle('B3:G3' )
//                    ->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
//                $objectPHPExcel->getActiveSheet()->getStyle('B3:G3' )
//                    ->getBorders()->getVertical()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
//   
//                //设置颜色
//                $objectPHPExcel->getActiveSheet()->getStyle('B3:G3')->getFill()
//                    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF66CCCC');
            //}
            //明细的输出
            $objectPHPExcel->getActiveSheet()->setCellValue('A' . ($n + 2), $dish->dish_name);
            $objectPHPExcel->getActiveSheet()->setCellValue('B' . ($n + 2), $dish->dish_price);
            $objectPHPExcel->getActiveSheet()->setCellValue('C' . ($n + 2), $dish->dish_package_fee);
            $objectPHPExcel->getActiveSheet()->setCellValue('D' . ($n + 2), $dish->category_name);
            $objectPHPExcel->getActiveSheet()->setCellValue('E' . ($n + 2), $dish->dish_introduction);

//            //设置边框
//            $currentRowNum = $n+4;
//            $objectPHPExcel->getActiveSheet()->getStyle('B'.($n+4).':G'.$currentRowNum )
//                    ->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
//            $objectPHPExcel->getActiveSheet()->getStyle('B'.($n+4).':G'.$currentRowNum )
//                    ->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
//            $objectPHPExcel->getActiveSheet()->getStyle('B'.($n+4).':G'.$currentRowNum )
//                    ->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
//            $objectPHPExcel->getActiveSheet()->getStyle('B'.($n+4).':G'.$currentRowNum )
//                    ->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
//            $objectPHPExcel->getActiveSheet()->getStyle('B'.($n+4).':G'.$currentRowNum )
//                    ->getBorders()->getVertical()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $n = $n + 1;
        }

        //设置分页显示
        //$objectPHPExcel->getActiveSheet()->setBreak( 'I55' , PHPExcel_Worksheet::BREAK_ROW );
        //$objectPHPExcel->getActiveSheet()->setBreak( 'I10' , PHPExcel_Worksheet::BREAK_COLUMN );
        //$objectPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
        //$objectPHPExcel->getActiveSheet()->getPageSetup()->setVerticalCentered(false);
        ob_end_clean();
        ob_start();

        header('Content-Type : application/vnd.ms-excel');
        header('Content-Disposition:attachment;filename="' . 'xiaoqiang-' . date("Ymj") . '.xlsx"');
        header('Content-Disposition:attachment;filename="' . '菜品信息-' . date("Y年m月j日") . '.xlsx"');
        $objWriter = PHPExcel_IOFactory::createWriter($objectPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }

    public function writeActiveSheet_coupon($data)
    {
        $objectPHPExcel = new PHPExcel();
        $objectPHPExcel->setActiveSheetIndex(0);

        $n = 0;
        
        //表格头的输出
        $objectPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', '优惠券id');
        $objectPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
        $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', '优惠券No');
        $objectPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
        $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', '优惠券金额');
        $objectPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(50);
        $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', '优惠券生效时间');
        $objectPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(50);
        $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('E1','优惠券失效时间');
        $objectPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(50);
        $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('F1','优惠券状态  0 未激活； 1 已激活； 2 已失效；');
        $objectPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(50);
        $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('G1','使用人电话');
        $objectPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(50);
        $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('H1','使用人姓名（微信openid）');
        $objectPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(50);
        $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('I1','订单id');
        
        foreach ($data as $coupon)
        {
            //明细的输出
            $objectPHPExcel->getActiveSheet()->setCellValue('A' . ($n + 2), $coupon->coupon_id);
            $objectPHPExcel->getActiveSheet()->setCellValue('B' . ($n + 2), $coupon->coupon_no);
            $objectPHPExcel->getActiveSheet()->setCellValue('C' . ($n + 2), $coupon->coupon_value);
            $objectPHPExcel->getActiveSheet()->setCellValue('D' . ($n + 2), $coupon->coupon_start_time);
            $objectPHPExcel->getActiveSheet()->setCellValue('E' . ($n + 2), $coupon->coupon_end_time);
            $objectPHPExcel->getActiveSheet()->setCellValue('F' . ($n + 2), $coupon->coupon_status);
            $objectPHPExcel->getActiveSheet()->setCellValue('G' . ($n + 2), $coupon->customer_mobile);
            $objectPHPExcel->getActiveSheet()->setCellValue('H' . ($n + 2), $coupon->customer_name);
            $objectPHPExcel->getActiveSheet()->setCellValue('I' . ($n + 2), $coupon->order_id);

            $n = $n + 1;
        }

        ob_end_clean();
        ob_start();

        header('Content-Type : application/vnd.ms-excel');
        header('Content-Disposition:attachment;filename="' . 'youhuiquan-' . date("Ymj") . '.xlsx"');
        header('Content-Disposition:attachment;filename="' . '优惠券信息-' . date("Y年m月j日") . '.xlsx"');
        $objWriter = PHPExcel_IOFactory::createWriter($objectPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }
}

?>
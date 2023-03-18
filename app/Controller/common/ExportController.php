<?php
/**
 * Created by : VsCode
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/3/16
 * Time:  21:45
 */

namespace app\Controller\common;

use libs\db\Db;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExportController
{
    /**
     * @return void
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     * 导出指定数据库中的所有表结构简易信息
     * $dbname数据库名字
     */
    public function exportSql($dbname = '' )
    {
        $dbname = 'performance_schema';
        $tableSql = "SELECT TABLE_NAME,	TABLE_COMMENT FROM	information_schema.TABLES WHERE	table_schema = '$dbname'";
        $db = Db::connect_database();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
//        设置表头
        $filename = 'Database Doc';
        $spreadsheet->getActiveSheet()->setTitle($filename);

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth('40');
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth('40');
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth('40');

        $spreadsheet->getActiveSheet()->mergeCells('A1:C1');
        $sheet->setCellValue('A1','Database Doc');
        $spreadsheet->getActiveSheet()->getRowDimension(1)->setRowHeight(25);
        $spreadsheet->getDefaultStyle()->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $tableList = $db->query($tableSql);
        $row = 1;
        foreach ($tableList as $key => $value)
        {
            $row++;
            $spreadsheet->getActiveSheet()->getRowDimension($row)->setRowHeight(25);
            $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':C'.$row);
            $sheet->setCellValue('A'.$row,$value['TABLE_NAME'].'('.$value['TABLE_COMMENT'].')');
            $fieldListSql = "SELECT	COLUMN_NAME,EXTRA,COLUMN_COMMENT,COLUMN_TYPE FROM  information_schema.COLUMNS WHERE table_name = '".$value['TABLE_NAME']."'  AND table_schema = '$dbname'";

            $fieldList = $db->query($fieldListSql);
            $row++;
            $sheet->setCellValue('A'.$row,'field');
            $sheet->setCellValue('B'.$row,'type');
            $sheet->setCellValue('C'.$row,'comment');
            foreach ($fieldList as $k => $v)
            {
                $row++;
//                var_dump($v);exit;
                if($v['EXTRA'] == 'auto_increment'){
                    $v['COLUMN_COMMENT'] ='主键自增';
                }
                $sheet->setCellValue('A'.$row,$v['COLUMN_NAME']);
                $sheet->setCellValue('B'.$row,$v['COLUMN_TYPE']);
                $sheet->setCellValue('C'.$row,$v['COLUMN_COMMENT']);
            }
            $row = $row+1;
        }
        $spreadsheet->getDefaultStyle()->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $spreadsheet->getDefaultStyle()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $write = new Xlsx($spreadsheet);
        Header("Content-Type:application/vnd.ms-excel");
        Header("Content-Disposition:attachment;filename=".$filename.date('YmdHis').".xlsx");
        header("Cache-Control: max-age=0"); //
//        $write = IOFactory::createWriter($spreadsheet,'xlsx');
        $write->save('php://output');
        unset($spreadsheet);

    }

    public function pdf()
    {
        echo 'ceshi';
    }
}
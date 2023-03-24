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
use FPDF;
class ExportController
{

    public function pdf()
    {
        $title = 'Werbung / Vermittler:';
        $pdf = new FPDF();
        $pdf->AddPage();
        $this->Header($pdf);
        $pw=$pdf->GetPageWidth();
        $pw6 = $pw * 0.6;
//        标头
        $pdf->SetFont('Arial','B',10  );
        $pdf->Cell(122);
        $pdf->Cell(0,0,$title,0,0);
        $curY  = $pdf->GetY();
        $pdf->SetLineWidth(0.3);
        $pdf->Line(130,$curY+10,200,$curY+10);
        $pdf->Line(130,$curY+10,130,8);
        $curY  = $pdf->GetY();
        $pdf->Ln(18);
        $a = 'CARL ACH e.K . 92324 WEIDEN';
        $al = $pdf->GetStringWidth($a);
        $a1 = 'Seegasse 1a';
        $a2 = 'Tel:(0961) 67090-0· Telefax( 0961 )29910';
        $pdf->SetFont('Arial','B',11 );
        $pdf->Cell(0,0,$a,0,2);
        $pdf->Cell(140);
        $pdf->SetFont('Arial','',8 );
        $pdf->Cell(0,0,"qwewqe",0,2);

        $pdf->Ln(3);
        $pdf->Cell(140);
        $pdf->SetFont('Arial','',8 );
        $pdf->Cell(0,0,"qwewqe",0,1);


        $az = "Autovermietung";

        $pdf->Cell(66);
        $pdf->SetFont('Times','B',15 );;
        $pdf->Cell(0,0,$az,0,2);
        $pdf->SetFont('Times','',9 );
        $pdf->SetTextColor(0, 0, 23);
        $pdf->Write(10, 'Selbstfahrer·Mietvertrag und RechnungTel');



        $pdf->Ln(2);
        $pdf->Cell(18);
        $pdf->SetFont('Times','',9);
        $pdf->Cell(0,0,$a1,0,2);
        $pdf->Ln(1);
        $a2l = $pdf->GetStringWidth($a2);
        $pdf->SetLineWidth(0);
        $pdf->SetFont('Times','',10 );
        $pdf->Cell($a2l,6,$a2,'B',1);




        $curY  = $pdf->GetY();
        $curX  = $pdf->GetStringWidth($title);
//        $pdf->Line(10,$curY,$curX+25,$curY);
        $pdf->AddPage();
        $pdf->Output();

    }

    public function  Header(object $pdf)
    {
        $pdf->Image('./public/image/logo.jpg',5,9,75);

    }
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


}
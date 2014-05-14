<?php

class CrudGenerator extends CCodeGenerator
{
	public $codeModel='ext.heart.gii.crud.CrudCode';
	
	public function actionTemplate(){
		Yii::import('ext.heart.excel.EHeartExcel',true);
		EHeartExcel::init();
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getActiveSheet()->setCellValue('A1','No')
									  ->setCellValue('B1','ModelType')
									  ->setCellValue('C1','Model')
									  ->setCellValue('D1','Controller')
									  ->setCellValue('E1','ModelParent')
									  ->setCellValue('F1','ControllerParent');

		$modelPath=Yii::getPathOfAlias('application.models');
		$files=scandir($modelPath);
		$row=2;
		foreach($files as $file)
		{
			if(is_file($modelPath.'/'.$file) && CFileHelper::getExtension($file)==='php' && 
				!in_array($file,array('ContactForm.php','LoginForm.php','Admin.php','User.php')))
			{
				$file_arr=explode(".",$file);
				$filename=$file_arr[0];
				$objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$row-1)
									  ->setCellValue('B'.$row, "1")
									  ->setCellValue('C'.$row, $filename)
									  ->setCellValue('D'.$row, 'test/'.$filename)
									  ->setCellValue('E'.$row, '-')
									  ->setCellValue('F'.$row, '-');			
				$row++;					  
			}			
		}
		
		// Redirect output to a client’s web browser (Excel2007)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="models.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
		exit;
	}
	
	public function actionTemplate2(){
		Yii::import('ext.heart.opentbs.EHeartOpenTBS',true);
		EHeartOpenTBS::init();
		// Initalize the TBS instance
		$TBS = new clsTinyButStrong; // new instance of TBS
		$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN); // load the OpenTBS plugin
		$templatePath=Yii::getPathOfAlias('ext.heart.opentbs');
		$template=$templatePath.DIRECTORY_SEPARATOR.'template.docx';
		$TBS->LoadTemplate($template);
		
		$modelPath=Yii::getPathOfAlias('application.models');
		$files=scandir($modelPath);
		$row=2;
		$data=array();
		foreach($files as $file)
		{
			if(is_file($modelPath.'/'.$file) && CFileHelper::getExtension($file)==='php' && 
				!in_array($file,array('ContactForm.php','LoginForm.php','Admin.php','User.php')))
			{
				$file_arr=explode(".",$file);
				$filename=$file_arr[0];
				$data[$row-2]['no']=$row-1;
				$data[$row-2]['field1']=$filename;
				$data[$row-2]['field2']='test/'.$filename;				
				$row++;					  
			}			
		}
		
		$data2[0]['title']="Template Generator";
		$data2[0]['field1']='Model';
		$data2[0]['field2']='Controller';
		
		$TBS->NoErr = true;
		
		$TBS->MergeBlock('data', 'array', $data);
		$TBS->MergeBlock('data2', 'array', $data2);
		$TBS->Show(OPENTBS_DOWNLOAD,'template.docx'); 
	}
	
	/**
     * Returns the model names in an array.
     * Only non abstract and subclasses of AweActiveRecord models are returned.
     * The array is used to build the autocomplete field.
     * @return array The names of the models
     */
    protected function getModels()
    {
        $models = array();
        $files = scandir(Yii::getPathOfAlias('application.models'));
        foreach ($files as $file) {
            if ($file[0] !== '.' && CFileHelper::getExtension($file) === 'php') {
                $fileClassName = substr($file, 0, strpos($file, '.'));
                $models[] = $fileClassName;
            }
        }
        return $models;
    }
}
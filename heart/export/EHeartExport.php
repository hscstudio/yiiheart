<?php
	Yii::import('zii.widgets.grid.CGridView');

	/**
	* @author Hafid Mukhlasin
	* @license MIT License
	* @version 1.0.0
	*/	
	class EHeartExport extends CGridView
	{
		//Document properties
		public $creator = 'Hafid Mukhlasin';
		public $title = null;
		public $subject = 'Subject';
		public $description = '';
		public $category = '';

		//the PHPExcel object
		public $objPHPExcel = null;
		//the PDF object
		public $pdf = null;
		//the WORD/OpenTBS object
		public $TBS = null;
		public $data = array(); // DATA
		public $data2 = array(); // HEADER
		//config
		public $autoWidth = true;
		public $exportType = 'Excel5';
		public $disablePaging = true;
		public $filename = null; //export FileName
		public $stream = true; //stream to browser
		public $grid_mode = 'grid'; //Whether to display grid ot export it to selected format. Possible values(grid, export)
		public $grid_mode_var = 'grid_mode'; //GET var for the grid mode
		
		//buttons config
		public $exportButtonsCSS = 'summary';
		public $exportButtons = array('Excel2007');
		public $exportText = 'Export to: ';

		//callbacks
		public $onRenderHeaderCell = null;
		public $onRenderDataCell = null;
		public $onRenderFooterCell = null;
		
		//mime types used for streaming
		public $mimeTypes = array(
			'Excel5'	=> array(
				'Content-type'=>'application/vnd.ms-excel',
				'extension'=>'xls',
				'caption'=>'Excel(*.xls)',
			),
			'Excel2007'	=> array(
				'Content-type'=>'application/vnd.ms-excel',
				'extension'=>'xlsx',
				'caption'=>'Excel(*.xlsx)',				
			),
			'PDF'		=>array(
				'Content-type'=>'application/pdf',
				'extension'=>'pdf',
				'caption'=>'PDF(*.pdf)',								
			),
			'HTML'		=>array(
				'Content-type'=>'text/html',
				'extension'=>'html',
				'caption'=>'HTML(*.html)',												
			),
			'CSV'		=>array(
				'Content-type'=>'application/csv',			
				'extension'=>'csv',
				'caption'=>'CSV(*.csv)',												
			)
		);

		public function init()
		{
			if(isset($_GET[$this->grid_mode_var]))
				$this->grid_mode = $_GET[$this->grid_mode_var];
			if(isset($_GET['exportType']))
				$this->exportType = $_GET['exportType'];
				
			if($this->grid_mode == 'export')
			{			
				$this->title = $this->title ? $this->title : Yii::app()->getController()->getPageTitle();
				$this->initColumns();
			}

			if($this->exportType=="PDF"){
				Yii::import('ext.heart.pdf.EHeartPDF',true);
				EHeartPDF::init();
				// create new PDF document
				$this->pdf=new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
				$this->pdf->SetCreator(PDF_CREATOR);
				$this->pdf->SetAuthor('YiiHeart');
			}
			if($this->exportType=="WORD"){
				Yii::import('ext.heart.opentbs.EHeartOpenTBS',true);
				EHeartOpenTBS::init();
				$this->TBS = new clsTinyButStrong; // new instance of TBS
				$this->TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN); // load the OpenTBS plugin
				$templatePath=Yii::getPathOfAlias('ext.heart.opentbs');
				$template=$templatePath.DIRECTORY_SEPARATOR.'template.docx';
				$this->TBS->LoadTemplate($template);
			}
			else{
								
				if($this->grid_mode == 'export')
				{			
					Yii::import('ext.heart.excel.EHeartExcel',true);
					EHeartExcel::init();
					$this->objPHPExcel = new PHPExcel();
					// Creating a workbook
					$this->objPHPExcel->getProperties()->setCreator($this->creator);
					$this->objPHPExcel->getProperties()->setTitle($this->title);
					$this->objPHPExcel->getProperties()->setSubject($this->subject);
					$this->objPHPExcel->getProperties()->setDescription($this->description);
					$this->objPHPExcel->getProperties()->setCategory($this->category);
				} else
					parent::init();	
			}	
			
		}

		public function renderHeader()
		{
			$a=0;

			if($this->exportType=="PDF"){
				$tr = '<tr style="background-color:#ddd;font-weight:bold;">';
			}
			
			$b=1;
			foreach($this->columns as $column)
			{
				$a=$a+1;
				if($column instanceof CButtonColumn)
					$head = $column->header;
				elseif($column->header===null && $column->name!==null)
				{
					if($column->grid->dataProvider instanceof CActiveDataProvider)
						$head = $column->grid->dataProvider->model->getAttributeLabel($column->name);
					else
						$head = $column->name;
				} else
					$head =trim($column->header)!=='' ? $column->header : $column->grid->blankDisplay;

				if($this->exportType=="PDF"){
					$width="";
					if($head=="No")	$width='30px';
					$tr.=$this->renderColumn(strip_tags($head),$width,"center");
				}
				else if($this->exportType=="WORD"){					
					if($b<=5){
						$this->data2[0]['field'.($b-1)]=strip_tags($head);
						$b++;
					}	
				}
				else{
					$cell = $this->objPHPExcel->getActiveSheet()->setCellValue($this->columnName($a)."1" ,$head, true);
					if(is_callable($this->onRenderHeaderCell))
						call_user_func_array($this->onRenderHeaderCell, array($cell, $head));				
				}
				
			}
	
				
			if($this->exportType=="PDF"){
				$tr.="</tr>";
				return $tr;					
			}
			else if($this->exportType=="WORD"){
				$this->data2[0]['title']=strip_tags($this->title);
				$this->TBS->MergeBlock('data2', 'array', $this->data2);
			}
		}

		public function renderBody()
		{
			if($this->exportType=="PDF"){
				// DATA
				$this->pdf->SetFont('helvetica', '', 9);
				ob_start();
				echo '<table cellspacing="0" cellpadding="1" border="1" style="width:100%">';
				echo $this->renderHeader();			
				if($this->disablePaging) //if needed disable paging to export all data
					$this->dataProvider->pagination = false;

				$data=$this->dataProvider->getData();
				$n=count($data);

				if($n>0)
				{
					for($row=0;$row<$n;++$row)
						echo $this->renderRow($row);
				}

				echo '</table>';
				$table = ob_get_contents();
				//exit;
				ob_end_clean();			

				$this->pdf->writeHTML($table, true, false, false, false, '');
			}
			else if($this->exportType=="WORD"){
				// DATA						
				if($this->disablePaging) //if needed disable paging to export all data
					$this->dataProvider->pagination = false;

				$data=$this->dataProvider->getData();
				$n=count($data);

				if($n>0)
				{
					for($row=0;$row<$n;++$row)
						$this->renderRow($row);				
				}
				
				$this->TBS->MergeBlock('data', 'array', $this->data);
			}
			else{
				if($this->disablePaging) //if needed disable paging to export all data
					$this->dataProvider->pagination = false;

				$data=$this->dataProvider->getData();
				$n=count($data);

				if($n>0)
				{
					for($row=0;$row<$n;++$row)
						$this->renderRow($row);
				}
	            return $n;	
			}
		}

		public function renderRow($row)
		{
			$data=$this->dataProvider->getData();			

			if($this->exportType=="PDF"){
				$bgcolor="";
				if($row%2==0) $bgcolor="#eee";
				$tr='<tr style="background-color:'.$bgcolor.';">';
			}
				
			$a=0;
			$b=1;
			foreach($this->columns as $n=>$column)
			{
				if($column instanceof CLinkColumn)
				{
					if($column->labelExpression!==null)
						$value=$column->evaluateExpression($column->labelExpression,array('data'=>$data[$row],'row'=>$row));
					else
						$value=$column->label;
				} elseif($column instanceof CButtonColumn)
					$value = ""; //Dont know what to do with buttons
				elseif($column->value=="autonumber") {
					$value=$row+1;					
				}
				elseif($column->value!==null) 
					$value=$this->evaluateExpression($column->value ,array('data'=>$data[$row]));
				elseif($column->name!==null) { 
					//$value=$data[$row][$column->name];
					$value= CHtml::value($data[$row], $column->name);
				    $value=$value===null ? "" : $column->grid->getFormatter()->format($value,'raw');
                }             

				$a++;

				if($this->exportType=="PDF"){
					$tr.=$this->renderColumn(strip_tags($value));
				}
				else if($this->exportType=="WORD"){
					if($b<=5){
						$this->data[$row-1]['field'.($b-1)]=strip_tags($value);
						$b++;
					}	
				}
				else{
					$cell = $this->objPHPExcel->getActiveSheet()->setCellValue($this->columnName($a).($row+2) , strip_tags($value), true);				
					if(is_callable($this->onRenderDataCell))
						call_user_func_array($this->onRenderDataCell, array($cell, $data[$row], $value));
				}
			}

			if($this->exportType=="PDF"){
				$tr.="</tr>";
				return $tr;	
			}				
		}

		public function renderColumn($value="",$width="",$align="left"){
	    	$row  = '<td ';
	    	
	    	$row .= 'style="';
	    	$row .= (!empty($width))?'width:'.$width.';':'';
	    	$row .= (!empty($align))?'text-align:'.$align.';':'';
	    	$row .= '"';

	    	$row .= '>';
	    	$row .= $value;
	    	$row .= '</td>';
	    	return $row;
	    } 

		public function renderFooter($row)
		{
			$a=0;
			foreach($this->columns as $n=>$column)
			{
				$a=$a+1;
                if($column->footer)
                {
					$footer =trim($column->footer)!=='' ? $column->footer : $column->grid->blankDisplay;

				    $cell = $this->objPHPExcel->getActiveSheet()->setCellValue($this->columnName($a).($row+2) ,$footer, true);
				    if(is_callable($this->onRenderFooterCell))
					    call_user_func_array($this->onRenderFooterCell, array($cell, $footer));				
                }
			}  
		}		

		public function run()
		{
			if($this->grid_mode == 'export')
			{
				if($this->exportType=="PDF"){
					$this->pdf->addPage();
					// TITLE
					$this->pdf->SetFont('helvetica', 'B', 16);
					$this->pdf->Write(0, $this->title, '', 0, 'L', true, 0, false, false, 0);
					$this->pdf->Ln(3);
					$this->renderBody();
					$this->pdf->Output();
				}
				else if($this->exportType=="WORD"){					
					$this->TBS->NoErr = true;
					$this->renderHeader();					
					$this->renderBody();					
					$this->TBS->Show(OPENTBS_DOWNLOAD,'template.docx');
				}
				else{
					$this->renderHeader();
					$row = $this->renderBody();
					$this->renderFooter($row);

					//set auto width
					if($this->autoWidth)
						foreach($this->columns as $n=>$column)
							$this->objPHPExcel->getActiveSheet()->getColumnDimension($this->columnName($n+1))->setAutoSize(true);
					//create writer for saving
					$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel, $this->exportType);
					if(!$this->stream)
						$objWriter->save($this->filename);
					else //output to browser
					{
						if(!$this->filename)
							$this->filename = $this->title;
						$this->cleanOutput();
						header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
						header('Pragma: public');
						header('Content-type: '.$this->mimeTypes[$this->exportType]['Content-type']);
						header('Content-Disposition: attachment; filename="'.$this->filename.'.'.$this->mimeTypes[$this->exportType]['extension'].'"');
						header('Cache-Control: max-age=0');				
						$objWriter->save('php://output');			
						Yii::app()->end();
					}	
				}				
			} else
				parent::run();
		}

		/**
		* Returns the coresponding excel column.(Abdul Rehman from yii forum)
		* 
		* @param int $index
		* @return string
		*/
		public function columnName($index)
		{
			--$index;
			if($index >= 0 && $index < 26)
				return chr(ord('A') + $index);
			else if ($index > 25)
				return ($this->columnName($index / 26)).($this->columnName($index%26 + 1));
				else
					throw new Exception("Invalid Column # ".($index + 1));
		}		
		
		public function renderExportButtons()
		{
			foreach($this->exportButtons as $key=>$button)
			{
				$item = is_array($button) ? CMap::mergeArray($this->mimeTypes[$key], $button) : $this->mimeTypes[$button];
				$type = is_array($button) ? $key : $button;
				$url = parse_url(Yii::app()->request->requestUri);
				//$content[] = CHtml::link($item['caption'], '?'.$url['query'].'exportType='.$type.'&'.$this->grid_mode_var.'=export');
				if (key_exists('query', $url))
				    $content[] = CHtml::link($item['caption'], '?'.$url['query'].'&exportType='.$type.'&'.$this->grid_mode_var.'=export');          
				else
				    $content[] = CHtml::link($item['caption'], '?exportType='.$type.'&'.$this->grid_mode_var.'=export');				
			}
			if($content)
				echo CHtml::tag('div', array('class'=>$this->exportButtonsCSS), $this->exportText.implode(', ',$content));	

		}			
		
		/**
		* Performs cleaning on mutliple levels.
		* 
		* From le_top @ yiiframework.com
		* 
		*/
		private static function cleanOutput() 
		{
            for($level=ob_get_level();$level>0;--$level)
            {
                @ob_end_clean();
            }
        }		


	}
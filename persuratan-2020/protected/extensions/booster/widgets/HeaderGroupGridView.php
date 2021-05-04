<?php

Yii::import('booster.widgets.TbGridView');
/**
* A Header Group Grid View that groups header columns
*
* @category       User Interface
* @package        extensions
* @author         Muhammad Farid Fadhlan <farid.fadhlan@gmail.com>
* @version        2.0
*/

/**

Revision from version 1.0:
* display the filter field. Thank you Abbas :-) (el_abbasbenjelloun@hotmail.com)

*/

class HeaderGroupGridView extends TbGridView {
	
	public $mergeHeaders = array();
	public $subHeaders = array();
	private $_mergeindeks = array();
	private $_nonmergeindeks = array();

	public function init() {
		parent::init();
	}
	
	public function renderItems()
	{
		if($this->dataProvider->getItemCount()>0 || $this->showTableOnEmpty)
		{
			echo "<table class=\"{$this->itemsCssClass}\">\n";
			if(!empty($this->mergeHeaders)){
				echo "<thead>\n";
				$this->renderGroupHeaders();
				
				echo "</thead>\n";
			}
			else {
				$this->renderTableHeader();
			}
			$this->renderTableBody();
			$this->renderTableFooter();
			echo "</table>";
		}
		else
			$this->renderEmptyText();
	}
	
	public function renderGroupHeaders()
	{
		$this->setMergeIndeks();
		$this->setNonMergeIndeks();
		if($this->filterPosition===self::FILTER_POS_HEADER)
			$this->renderFilter();
		echo "<tr>\n";
		
		ob_start();
		echo "<tr>\n";
		$i=0;
		foreach($this->columns as $column){
			if(in_array($i, $this->_mergeindeks)):
				$column->headerHtmlOptions['colspan']='1';
				$column->renderHeaderCell();
			endif;
			$i++;
		}
		echo "</tr>\n";
		$header_bottom = ob_get_clean();
		
		$i=0;
		foreach($this->columns as $column){			
			for($m=0;$m<count($this->mergeHeaders);$m++){
				if($i==$this->mergeHeaders[$m]["start"]):
					$column->headerHtmlOptions['colspan']=$this->mergeHeaders[$m]["end"]-$this->mergeHeaders[$m]["start"]+1;
					if(!empty($this->mergeHeaders[$m]['rowspan'])) {
						$column->headerHtmlOptions['rowspan'] = $this->mergeHeaders[$m]['rowspan'];
					}
					$column->header = $this->mergeHeaders[$m]["name"];
					$column->id = NULL;
					$column->renderHeaderCell();
					// if(!empty($this->mergeHeaders[$m]['subHeaders'])) {
					// 	echo "</tr>\n";
					// 	for($j=0;$j<count($this->mergeHeaders[$m]["subHeaders"]);$j++) {
					// 		$column->headerHtmlOptions['colspan']=$this->mergeHeaders[$m]["subHeaders"][$j]["end"]-$this->mergeHeaders[$m]["subHeaders"][$j]["start"]+1;
					// 		$column->header = $this->mergeHeaders[$m]["subHeaders"][$j]["name"];
					// 		$column->id = NULL;
					// 		$column->renderHeaderCell();
					// 	}
					// }
				endif;
			}
			if(in_array($i, $this->_nonmergeindeks)){
				$column->headerHtmlOptions['rowspan']='3';
				$column->renderHeaderCell();
			}
			$i++;
		}
		echo "</tr>\n";

		if(!empty($this->subHeaders)) {
			$this->renderSubHeaders();
		}
		
		echo $header_bottom;
		if($this->filterPosition===self::FILTER_POS_BODY)
			$this->renderFilter();
	}

	public function renderSubHeaders()
	{
		// echo "<tr>\n";
		$g = 0;
		foreach($this->columns as $column) {
			for($a=0;$a<count($this->subHeaders);$a++) {
				// var_dump(count($this->subHeaders));die;
				if($g == $this->subHeaders[$a]['start']) {
					$column->headerHtmlOptions['colspan'] = $this->subHeaders[$a]['end'] - $this->subHeaders[$a]['start'] + 1;
					$column->header = $this->subHeaders[$a]['name'];
					$column->id = NULL;
					$column->renderHeaderCell();
				}
			}
			$g++;
		}
		echo "</tr>\n";
	}
	
	protected function setMergeIndeks()
	{
		for($i=0;$i<count($this->mergeHeaders);$i++)
			for($j=$this->mergeHeaders[$i]["start"];$j<= $this->mergeHeaders[$i]["end"];$j++)
				$this->_mergeindeks[] = $j;
	}
	
	protected function setNonMergeIndeks()
	{
		foreach($this->columns as $key=>$val) $h[] = $key;
		$this->_nonmergeindeks = array_diff($h, $this->_mergeindeks);
	}
}
<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

require_once($GLOBALS['dr']."classes/design/right_click.php");

class ShowResults {

	var $extra_cell;

	function __construct() {
		$this->display_data="";
		$this->display_table_title="";
		//="";
	}

	/* SET SOME PARAMETERS */
	public function SetParameters($show_row_break=False,$show_header=False) {
		$this->show_row_break=$show_row_break;
	}

	public function TableTitle($header_img,$header_desc) {
		if (!EMPTY($header_img) && !EMPTY($header_desc)) {
			$this->display_table_title.="<tr height='1' class='header'><td colspan='".count($this->friendly_cols)."' height='1'><img src='".$GLOBALS['wb']."images/".$header_img."'>".$header_desc."</td></tr>\n";
		}
		else {
			$this->display_table_title.="";
		}
	}

	/* QUERY THE DATABASE AND PUT THE RESULTS INTO A 2D ARRAY */
	public function Query($sql) {
		$db=$GLOBALS['db'];

		$this->count_rows=0;

		$result = $db->Query($sql);
		//$this->cols=pg_fetch_all_columns($result);

		if ($db->NumRows($result) > 0) {
			while($row = $db->FetchArray($result)) {
				for ($i=0;$i<count($this->cols);$i++) {
					$this->temp_col_data[$this->count_rows][$i]=$row[$this->cols[$i]];
				}
				$this->count_rows++;
			}
		}
	}

	/* CUSTOMISE THE COLUMN HEADS*/
	public function DrawFriendlyColHead($cols) {
		$this->friendly_cols=$cols;
		$this->display_data.="<tr class='colhead'>\n";
		for ($i=0;$i<count($cols);$i++) {
			$this->display_data.="<td>".$cols[$i]."</td>\n";
		}
		$this->display_data.="</tr>\n";
	}

	/* STORE THE COLUMNS IN AN ARRAY SOMEHOW THE PG_FETCH_ALL_COLUMNS ISNT WORKING */
	public function Columns($cols) {
		$this->cols=$cols;
	}

	/* COUNT ALL ROWS */
	public function CountRows() {
		return $this->count_rows;
	}

	/* THIS OVERRIDES A COLUMN FOR EXAMPLE YES NO / IMAGES / BUTTONS ETC */
	public function ColDefault($col_number,$type) {
		for ($i=0;$i<$this->count_rows;$i++) {
			if ($type=="yesno") {
				if ($this->temp_col_data[$i][$col_number]=="y") { $this->temp_col_data[$i][$col_number]="No"; } else { $this->temp_col_data[$i][$col_number]="Yes"; }
			}
			elseif ($type=="yesnoimage") {
				if ($this->temp_col_data[$i][$col_number]=="y") { $this->temp_col_data[$i][$col_number]="<img src='images/nuvola/16x16/actions/button_accept.png' border='0'>"; } else { $this->temp_col_data[$i][$col_number]="<img src='images/nuvola/16x16/actions/button_cancel.png' border='0'>"; }
			}
		}
	}

	/* THIS MODIFIES ONE OF THE VARIABLES */
	public function ModifyData($row_number,$col_number,$new_val) {
		$this->temp_col_data[$row_number][$col_number]=$new_val;
	}

	/* GET A COLUMN NAME FROM THE ARRAY */
	function GetColVar($col_no) {
		return $this->cols[$col_no];
	}

	/* GET A VALUE OF A ROW */
	public function GetRowVal($row_number,$col_number) {
		return $this->temp_col_data[$row_number][$col_number];
	}

	/* WRAP THE DATA IN OUR TABLE */
	public function WrapData() {
		$class="alternatecell1";
		for ($i=0;$i<$this->count_rows;$i++) {
			/* DO SOME CLASS MANIPULATION */
			if ($class=="alternatecell1") { $class="alternatecell2"; } else { $class="alternatecell1"; }
			$this->display_data.="<tr class='".$class."' onMouseOver=\"this.className='alternateover'\" onMouseOut=\"this.className='".$class."'\">\n";
			/* GET THE ARRAY AND PUT IT INTO A CELL */
			for ($j=0;$j<count($this->cols);$j++) {
				$this->display_data.="<td>".$this->temp_col_data[$i][$j]."</td>\n";
			}
			/* ADD ANY EXTRA COLUMNS */
			for ($k=0;$k<count($this->extra_cell);$k++) {
				$this->display_data.="<td>".$this->extra_cell[$k]."</td>\n";
			}
			$this->display_data.="</tr>\n";
			/* THIS ADDS A LINE BREAK BETWEEN EACH RECORD */
			if ($this->show_row_break) {
				$this->display_data.="<tr height='1'><td colspan='".count($this->friendly_cols)."' bgcolor='#dedede' height='1'></td></tr>\n";
			}
		}
	}

	/* METHOD TO ADD NEW CELLS TO EACH ROW */
	public function AddCell($v) {
		//echo count($this->extra_cell);
		$this->extra_cell[]=$v;
	}

	public function RemoveColumn($col_number) {
		for ($i=0;$i<$this->count_rows;$i++) {
			$this->temp_col_data[$i][$col_number]="";
		}
	}

	/* DRAW THE TABLE */
	public function Draw($width="100%",$border="0") {
		$table="<table width='".$width."' class='plain_white' border='".$border."' bordercolor='#BFBFBF' cellspacing='0' cellpading='0'>\n";
		$table.=$this->display_table_title;
		$table.=$this->display_data;
		$table.="</table>\n";
		return $table;
	}

	function __destruct() {
		$this->display_data="";
		$this->display_table_title="";
	}
}
?>
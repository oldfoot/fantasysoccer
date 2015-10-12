<?php
/* THIS ENSURES WE ARE ABLE TO CONTROL OUR INCLUDE FILES */
define( '_VALID_ALUMNI_', 1 );

class GetData {

	function GetData($sql) {

		$db=$GLOBALS['db'];		
		$result = $db->query($sql);

		if ($db->NumRows($result) > 0) {
			$this->i=0;
			while ($row = $db->FetchArray($result)) {
				if ($row['total'] > 0) {
					$total_chk=$row['total'];
				}
				else {
					$total_chk=0;
				}
				$this->AddSingleValue($total_chk, $row['legend']);
				$this->total_count+=$total_chk;
			}
		}
		else {
			return False;
		}
	}

	function AddSingleValue($add_total, $add_legend) {

		$this->array_total[]=$add_total;
		$this->array_legend[]=$add_legend;
	}

	function GetTotal() {
		return $this->array_total;
	}
	function GetLegend() {
		return $this->array_legend;
	}

	function GetTotalNoArray() {
		//return $this->total_noarray;
		$j=0;
		//return array;
	}
	function GetLegendNoArray() {return $this->legend_noarray; }

	function CountTotal() {
		return $this->total_count;
	}
}
?>
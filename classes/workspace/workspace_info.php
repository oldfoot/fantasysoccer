<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_SSTARS_' ) or die( 'Direct Access to this location is not allowed.' );

class WorkspaceInfo {

	function WorkspaceInfo($id) {

		$db=$GLOBALS['db'];

		$sql="SELECT wm.name, wm.description, wm.max_teamspaces, wm.max_size, wm.max_users, wm.available_start_date,
					wm.available_end_date, wm.status_id, wm.is_default, wm.enterprise
					FROM ".$GLOBALS['mysql_db']."workspace_master wm
					WHERE workspace_id = '".$id."'
					";
		//echo $sql."<br>";
		$result = $db->query($sql);
		if ($db->NumRows($result) > 0) {
			while($row = $db->FetchArray($result)) {
				$this->name=$row["name"];
				$this->description=$row["description"];
				$this->max_teamspaces=$row["max_teamspaces"];
				$this->max_size=$row["max_size"];
				$this->max_users=$row["max_users"];
				$this->available_start_date=$row["available_start_date"];
				$this->available_end_date=$row["available_end_date"];
				$this->status_id=$row["status_id"];
				$this->is_default=$row["is_default"];
				$this->enterprise=$row["enterprise"];
			}
		}
	}
	function Name() {	return $this->name; }
	function Description() { return $this->description;	}
	function MaxTeamspaces() {	return $this->max_teamspaces; }
	function MaxSize() { return $this->max_size;	}
	function MaxUsers() { return $this->max_users;	}
	function AvailableStartDate() { return $this->available_start_date;	}
	function AvailableEndDate() { return $this->available_end_date;	}
	function StatusID() { return $this->status_id;	}
	function IsDefault() { if ($this->is_default == "y") { return True; } else { return False; } }
	function Enterprise() { if ($this->enterprise == "y") { return True; } else { return False; } }
}
?>
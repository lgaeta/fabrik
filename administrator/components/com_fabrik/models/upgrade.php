<?php

defined('_JEXEC') or die;

jimport('joomla.application.component.modeladmin');


class FabrikModelUpgrade extends JModel
{

	public function __construct($config = array())
	{
		if (!$this->shouldUpgrade()) {
			JFactory::getApplication()->enqueueMessage('Already updated');
			return parent::__construct($config);
		}
		$this->backUp();
		$this->upgrade();
		JFactory::getApplication()->enqueueMessage('Upgraded OK!');
		return parent::__construct($config);
	}

	/**
	 * back up the fabrik db tables and make copies of the data tables they use
	 */

	protected function backUp()
	{
		$db = JFactory::getDbo(true);
		$query = $db->getQuery(true);
		$query->select('db_table_name, connection_id')->from('#__fabrik_tables');
		$db->setQuery($query);
		$tables = $db->loadObjectList('db_table_name') + $this->getFabrikTables();
		$listModel = JModel::getInstance('List', 'FabrikFEModel');
		$connModel = JModel::getInstance('Connection', 'FabrikFEModel');
		foreach ($tables as $dbName => $item) {
			$connModel->setId($item->connection_id);
			$connModel->getConnection($item->connection_id);
			$cDb = $connModel->getDb();
			$listModel->set('_oConn', $connModel);
			//drop the bkup table
			$cDb->setQuery("DROP TABLE IF EXISTS ".$cDb->nameQuote('bkup_'.$item->db_table_name));
			if (!$cDb->query()) {
				JError::raiseError(500, $cDb->getErrorMsg());
			}
			//create the bkup table (this method will also correctly copy table indexes
			$cDb->setQuery("CREATE TABLE IF NOT EXISTS ".$cDb->nameQuote('bkup_'.$item->db_table_name)." like ".$cDb->nameQuote($item->db_table_name));
			if (!$cDb->query()) {
				JError::raiseError(500, $cDb->getErrorMsg());
			}
			$cDb->setQuery("INSERT INTO ".$cDb->nameQuote('bkup_'.$item->db_table_name)." select * from ".$cDb->nameQuote($item->db_table_name));
			if (!$cDb->query()) {
				JError::raiseError(500, $cDb->getErrorMsg());
			}
		}
	}

	/**
	 * upgrade the database to fabrik3's structure.
	 */

	protected function upgrade(){
		$db = JFactory::getDbo(true);
		$updates = array('#__fabrik_elements', '#__fabrik_cron', '#__fabrik_forms', '#__fabrik_groups', '#__fabrik_joins', '#__fabrik_jsactions', '#__fabrik_tables', '#__fabrik_visualizations');
		foreach ($updates as $update) {
			$db->setQuery("SELECT * FROM $update");
			$rows = $db->loadObjectList();
			if ($db->getErrorNum()) {
				JError::raiseError(500, $db->getErrorMsg());
			}
			foreach ($rows as $row) {
				$json = json_decode($row->attribs);
				if ($json == false) {
					//only do this if the attribs are not already in json format
					$p = $this->fromAttribsToObject($row->attribs);
					switch($update) {
						case '#__fabrik_elements':
							//elements had some fields moved into the attribs/params json object
							if ($row->published == 0) {
								$row->published = -2;
							}
							$p->can_order = $row->can_order;
							$row->access = $this->mapACL($row->access);
							$p->view_access = $this->mapACL($p->view_access);
							$p->filter_access = $this->mapACL($p->filter_access);

							$p->sum_access = $this->mapACL($p->sum_access);
							$p->avg_access = $this->mapACL($p->avg_access);
							$p->median_access = $this->mapACL($p->median_access);
							$p->count_access = $this->mapACL($p->count_access);

							$p->sub_values = explode('|', $row->sub_values);
							$p->sub_labels = explode('|', $row->sub_labels);
							$p->sub_initial_selection = explode('|', $row->sub_intial_selection);
							break;
						case '#__fabrik_tables':
							$row->access = $this->mapACL($row->access);
							$p->allow_view_details = $this->mapACL($p->allow_view_details);
							$p->allow_edit_details = $this->mapACL($p->allow_edit_details);
							$p->allow_add = $this->mapACL($p->allow_add);
							$p->allow_drop = $this->mapACL($p->allow_drop);
							break;

						case '#__fabrik_visualizations':
							$row->access = $this->mapACL($row->access);
							break;
					}
					$row->attribs = json_encode($p);
					$db->updateObject($update, $row, 'id');
				}
			}
		}
		//get the upgrade script
		$sql = JFile::read(JPATH_SITE.'/administrator/components/com_fabrik/sql/updates/mysql/2.x-3.0.sql');
		$prefix = JFactory::getApplication()->getCfg('dbprefix');
		$sql = str_replace('#__', $prefix, $sql);
		$sql = explode("\n", $sql);
		foreach ($sql as $q) {
			if (trim($q) !== '') {
				if (!$db->query()){
					JError::raiseNotice(500, $db->getErrorMsg());
				}
			}
		}
	}

	/**
	 * convert old skool J1.5 attribs into json object
	 */

	protected function fromAttribsToObject($str) {
		$o = new stdClass();
		$a = explode("\n", $str);
		foreach ($a as $line){
			list($key, $val) = explode("=", $line);
			if (strstr($val, '//..*..//')) {
				$val = explode($val, '//..*..//');
			}
			if ($key) {
				$o->$key = $val;
			}
		}
		return $o;
	}

	/**
	 * maps the fabrik2 user gid to a roughly corresponding J1.7 acl group
	 * @param int $v gid
	 * @return int group id
	 */

	protected function mapACL($v)
	{
		switch ($v) {
			case 0:
			case 29:
				$group = 1;
				break;
			case 18:
				$group = 2;
				break;
			default:
				$group = 3;
				break;
		}
		return $group;
	}

	/**
	 * get all the db tables which have _fabrik_ as part of their names
	 * @return array of objects each with db_table_name and connection_id property
	 */

	protected function getFabrikTables()
	{
		$db = JFactory::getDbo(true);
		$r = array();
		$db->setQuery("SHOW TABLES");
		$rows = $db->loadResultArray();
		foreach ($rows as $row) {
			if (strstr($row, '_fabrik_') && !strstr($row, 'bkup_')) {
				$o = new stdClass();
				$o->db_table_name = $row;
				$o->connection_id = 1;
				$r[] = $o;
			}
		}
		return $r;
	}
	/**
	 * check for an existence of _fabrik_tables table if there is then we should upgrade
	 * @return bool
	 */

	protected function shouldUpgrade()
	{
		$db = JFactory::getDbo(true);
		$db->setQuery("SHOW TABLES");
		$rows = $db->loadResultArray();
		foreach ($rows as $row) {
			if (strstr($row, '_fabrik_tables') && !strstr($row, 'bkup_')) {
				return true;
			}
		}
		return false;
	}
}
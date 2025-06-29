<?php

/**

 * Inquiry Page Controller

 * @category  Controller

 */

class InquiryController extends SecureController
{

	function __construct()
	{

		parent::__construct();

		$this->tablename = "inquiry";
	}

	/**

	 * List page records

	 * @param $fieldname (filter record by a field) 

	 * @param $fieldvalue (filter field value)

	 * @return BaseView

	 */

	function index($fieldname = null, $fieldvalue = null)
	{

		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array(
			"id",
			"prospect_name",
			"prospect_phone",
			"total_room",
			"coverage_area",
			"package",
			"datetime",
			"assign_agent_name",
			"status",
			"platform"
		);

		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)

		//search table record

		if (!empty($request->search)) {

			$text = trim($request->search);

			$search_condition = "(

				inquiry.id LIKE ? OR 

				inquiry.prospect_name LIKE ? OR 

				inquiry.prospect_phone LIKE ? OR 

				inquiry.total_room LIKE ? OR 

				inquiry.coverage_area LIKE ? OR 

				inquiry.package LIKE ? OR 

				inquiry.platform LIKE ? OR 

				inquiry.datetime LIKE ? OR 

				inquiry.assign_agent_name LIKE ? OR 

				inquiry.assign_agent_phone LIKE ? OR 

				inquiry.status LIKE ?

			)";

			$search_params = array(

				"%$text%", "%$text%", "%$text%", "%$text%", "%$text%", "%$text%", "%$text%", "%$text%", "%$text%", "%$text%", "%$text%"
			);

			//setting search conditions

			$db->where($search_condition, $search_params);

			//template to use when ajax search

			$this->view->search_template = "inquiry/search.php";
		}

		if (!empty($request->orderby)) {

			$orderby = $request->orderby;

			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);

			$db->orderBy($orderby, $ordertype);
		} else {

			$db->orderBy("inquiry.id", ORDER_TYPE);
		}

		$allowed_roles = array('administrator');

		if (!in_array(strtolower(USER_ROLE), $allowed_roles)) {

			$db->where("inquiry.assign_agent_name", get_active_user('agent_name'));
		}

		if ($fieldname) {

			$db->where($fieldname, $fieldvalue); //filter by a single field name

		}

		if (!empty($request->inquiry_handled)) {

			$val = $request->inquiry_handled;

			$db->where("inquiry.handled", $val, "=");
		}

		$tc = $db->withTotalCount();

		$records = $db->get($tablename, $pagination, $fields);

		$records_count = count($records);

		$total_records = intval($tc->totalCount);

		$page_limit = $pagination[1];

		$total_pages = ceil($total_records / $page_limit);

		$data = new stdClass;

		$data->records = $records;

		$data->record_count = $records_count;

		$data->total_records = $total_records;

		$data->total_page = $total_pages;

		if ($db->getLastError()) {

			$this->set_page_error();
		}

		$page_title = $this->view->page_title = "Inquiry";

		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;

		$this->view->report_title = $page_title;

		$this->view->report_layout = "report_layout.php";

		$this->view->report_paper_size = "A4";

		$this->view->report_orientation = "portrait";

		$this->render_view("inquiry/list.php", $data); //render the full page

	}

	/**

	 * View record detail 

	 * @param $rec_id (select record by table primary key) 

	 * @param $value value (select record by value of field name(rec_id))

	 * @return BaseView

	 */

	function view($rec_id = null, $value = null)
	{

		$request = $this->request;

		$db = $this->GetModel();

		$rec_id = $this->rec_id = urldecode($rec_id);

		$tablename = $this->tablename;

		$fields = array(
			"id",

			"prospect_name",

			"prospect_phone",

			"total_room",

			"coverage_area",

			"package",

			"platform",

			"datetime",
			"status",
			"assign_agent_name",

			"assign_agent_phone"
		);

		$allowed_roles = array('administrator');

		if (!in_array(strtolower(USER_ROLE), $allowed_roles)) {

			$db->where("inquiry.assign_agent_name", get_active_user('agent_name'));
		}

		if ($value) {

			$db->where($rec_id, urldecode($value)); //select record based on field name

		} else {

			$db->where("inquiry.id", $rec_id);; //select record based on primary key

		}

		$record = $db->getOne($tablename, $fields);

		if ($record) {

			$page_title = $this->view->page_title = "View  Inquiry";

			$this->view->report_filename = date('Y-m-d') . '-' . $page_title;

			$this->view->report_title = $page_title;

			$this->view->report_layout = "report_layout.php";

			$this->view->report_paper_size = "A4";

			$this->view->report_orientation = "portrait";
		} else {

			if ($db->getLastError()) {

				$this->set_page_error();
			} else {

				$this->set_page_error("No record found");
			}
		}

		return $this->render_view("inquiry/view.php", $record);
	}

	/**

	 * Insert new record to the database table

	 * @param $formdata array() from $_POST

	 * @return BaseView

	 */

	function add($formdata = null)
	{
		if ($formdata) {
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$request = $this->request;
			//fillable fields
			$fields = $this->fields = array("prospect_name", "prospect_phone", "total_room", "coverage_area", "package",  "platform", "status", "datetime", "assign_agent_name", "assign_agent_phone");
			$postdata = $this->format_request_data($formdata);

			$this->rules_array = array(
				'prospect_name'     => 'required',
				'prospect_phone'    => 'required',
				'datetime'          => 'required',
				'assign_agent_name' => 'required',
			);

			$this->sanitize_array = array(
				'prospect_name'     => 'sanitize_string',
				'prospect_phone'    => 'sanitize_string',
				'total_room'        => 'sanitize_string',
				'coverage_area'     => 'sanitize_string',
				'package'           => 'sanitize_string',
				'platform'          => 'sanitize_string',
				'datetime'          => 'sanitize_string',
				'assign_agent_name' => 'sanitize_string'

			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if (1) {
				# Statement to execute before adding record
				$cname      = $modeldata['prospect_name'];
				$cphone     = $this->formatPhone($modeldata['prospect_phone']);
				$total_room = $modeldata['total_room'];
				$coverage_area = $modeldata['coverage_area'];
				$package  = $modeldata['package'];
				$agentcount = $db->rawQueryValue("SELECT COUNT(id) FROM agent WHERE status1 = '0' LIMIT 1");
				if ($agentcount == 0) {
					$db->rawQuery("UPDATE agent SET status1 = '0' WHERE status1 = '1'");
				}


				if (empty($modeldata['assign_agent_name'])) {
					$agentname                       = $db->rawQueryValue("SELECT agent_name FROM agent WHERE status1 = '0' limit 1");
					$agentphone                      = $this->formatPhone($db->rawQueryValue("SELECT agent_phone FROM agent WHERE status1 = '0' limit 1"));
					$agentid                         = $db->rawQueryValue("SELECT id FROM agent WHERE status1 = '0' limit 1");
					$db->rawQuery("UPDATE agent SET status1 ='1' WHERE id='$agentid'");
					$modeldata['assign_agent_name']  = $agentname;
					$modeldata['assign_agent_phone'] = $agentphone;
				} else {

					$agentname  = $modeldata['assign_agent_name'];
					$agentphone = $modeldata['assign_agent_phone'];
				}
				//$modeldata['agency']             = $agency;
				date_default_timezone_set("Asia/Kuala_Lumpur");
				$datetime              = date('Y-m-d H:i:s'); //Returns IST
				$modeldata['datetime'] = $datetime;
				# End of before add statement
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if ($rec_id) {
					if (!empty($_REQUEST['form_type'])) {
						header("Location: https://api.whatsapp.com/send?phone=&text=Hi $agentname, I'm looking for Package: $package with  Coverage Area: $coverage_area and Total Room: $total_room.");
						exit;
					}
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("inquiry");
				} else {
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Inquiry";
		$this->render_view("inquiry/add.php");
	}


	public function formatPhone($phoneNumber)

	{

		// Use regular expression to remove non-numeric characters

		$phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);

		if (preg_match('/^601/ ', $phoneNumber) === 1) {

			return $phoneNumber;
		} else if (preg_match('/^01/ ', $phoneNumber) === 1) {

			return '6' . $phoneNumber;
		}
	}



	public function locations()

	{

		$comp_model      = new SharedController;

		$select_location_options = $comp_model->inquiry_select_location_option_list();

		echo json_encode($select_location_options);
	}

	/**

	 * Update table record with formdata

	 * @param $rec_id (select record by table primary key)

	 * @param $formdata array() from $_POST

	 * @return array

	 */

	function edit($rec_id = null, $formdata = null)
	{

		$request = $this->request;

		$db = $this->GetModel();

		$this->rec_id = $rec_id;

		$tablename = $this->tablename;

		//editable fields

		$fields = $this->fields = array("id", "prospect_name", "prospect_phone", "total_room", "coverage_area", "package", "status", "datetime", "assign_agent_name", "assign_agent_phone");

		if ($formdata) {
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'prospect_name' => 'required',
				'prospect_phone' => 'required',
			);

			$this->sanitize_array = array(
				'prospect_name'     => 'sanitize_string',
				'prospect_phone'    => 'sanitize_string',
				'total_room'        => 'sanitize_string',
				'coverage_area'     => 'sanitize_string',
				'package'           => 'sanitize_string',
				'datetime'          => 'sanitize_string',
				'assign_agent_name' => 'sanitize_string'
			);

			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if ($this->validated()) {
				$allowed_roles = array('administrator');
				if (!in_array(strtolower(USER_ROLE), $allowed_roles)) {
					$db->where("inquiry.assign_agent_name", get_active_user('agent_name'));
				}
				$db->where("inquiry.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if ($bool && $numRows) {
					$this->set_flash_msg("Yeah! Record updated successfully", "success");
					return $this->redirect("inquiry");
				} else {
					if ($db->getLastError()) {
						$this->set_page_error();
					} elseif (!$numRows) {
						//not an error, but no record was updated
						$page_error = "No record updated";
						$this->set_page_error($page_error);
						$this->set_flash_msg($page_error, "warning");
						return	$this->redirect("inquiry");
					}
				}
			}
		}

		$allowed_roles = array('administrator');
		if (!in_array(strtolower(USER_ROLE), $allowed_roles)) {
			$db->where("inquiry.assign_agent_name", get_active_user('agent_name'));
		}
		$db->where("inquiry.id", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Inquiry";
		if (!$data) {
			$this->set_page_error();
		}
		return $this->render_view("inquiry/edit.php", $data);
	}

	/**

	 * Delete record from the database

	 * Support multi delete by separating record id by comma.

	 * @return BaseView

	 */

	function delete($rec_id = null)
	{

		Csrf::cross_check();

		$request = $this->request;

		$db = $this->GetModel();

		$tablename = $this->tablename;

		$this->rec_id = $rec_id;

		//form multiple delete, split record id separated by comma into array

		$arr_rec_id = array_map('trim', explode(",", $rec_id));

		$db->where("inquiry.id", $arr_rec_id, "in");

		$allowed_roles = array('administrator');

		if (!in_array(strtolower(USER_ROLE), $allowed_roles)) {

			$db->where("inquiry.assign_agent_name", get_active_user('agent_name'));
		}

		$bool = $db->delete($tablename);

		if ($bool) {

			$this->set_flash_msg("Record deleted successfully", "success");
		} elseif ($db->getLastError()) {

			$page_error = $db->getLastError();

			$this->set_flash_msg($page_error, "danger");
		}

		return	$this->redirect("inquiry");
	}
}

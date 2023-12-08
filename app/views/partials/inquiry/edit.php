<?php
$comp_model = new SharedController;
$page_element_id = "edit-page-" . random_str();
$current_page = $this->set_current_page_link();
$csrf_token = Csrf::$token;
$data = $this->view_data;
//$rec_id = $data['__tableprimarykey'];
$page_id = $this->route->page_id;
$show_header = $this->show_header;
$view_title = $this->view_title;
$redirect_to = $this->redirect_to;
?>
<section class="page" id="<?php echo $page_element_id; ?>" data-page-type="edit" data-display-type="" data-page-url="<?php print_link($current_page); ?>">
    <?php
    if ($show_header == true) {
    ?>
        <div class="bg-light p-3 mb-3">
            <div class="container">
                <div class="row ">
                    <div class="col ">
                        <h4 class="record-title">Edit Inquiry</h4>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
    <div class="">
        <div class="container">
            <div class="row ">
                <div class="col-md-7 comp-grid">
                    <?php $this::display_page_errors(); ?>
                    <div class="bg-light p-3 animated fadeIn page-content">
                        <form novalidate id="" role="form" enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("inquiry/edit/$page_id/?csrf_token=$csrf_token"); ?>" method="post">
                            <div>

                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="prospect_name">Your Name <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input id="ctrl-prospect_name" value="<?php echo $data['prospect_name']; ?>" type="text" placeholder="Enter Your Name" required="" name="prospect_name" class="form-control " />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="prospect_phone">Contact Number <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input id="ctrl-prospect_phone" value="<?php echo $data['prospect_phone']; ?>" type="text" placeholder="Enter Contact Number" required="" name="prospect_phone" class="form-control " />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="datetime">Total Room <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <input id="ctrl-total_room" class="form-control" required="" value="<?php echo $data['total_room']; ?>" type="datetime" name="total_room" placeholder="Total Room" />

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="datetime">Coverage Area <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <input id="ctrl-coverage_area" class="form-control" required="" value="<?php echo $data['coverage_area']; ?>" type="datetime" name="coverage_area" placeholder="Coverage Area" />

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                


                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="datetime">Package<span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <select required="" class="custom-select" name="package" id="package">
                                                    <?php $field_value = $data['status']; ?>
                                                    <option <?php echo ('Boosting' == $field_value ? 'selected' : null) ?> value="Boosting">Boosting</option>
                                                    <option <?php echo ('Feature Post' == $field_value ? 'selected' : null) ?> value="Feature Post">Feature Post</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="platform">Status </label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <select id="ctrl-status" name="status" placeholder="Select a value ..." class="custom-select">
                                                    <option value="">Select a value ...</option>
                                                    <?php
                                                    $field_value = $data['status'];
                                                    ?>
                                                    <option <?php echo ('Clash Date' == $field_value ? 'selected' : null) ?> value="Clash Date">Clash Date</option>
                                                    <option <?php echo ('Exceed Budget' == $field_value ? 'selected' : null) ?> value="Exceed Budget">Exceed Budget</option>
                                                    <option <?php echo ('Exceed Guest Limitation' == $field_value ? 'selected' : null) ?> value="Exceed Guest Limitation">Exceed Guest Limitation</option>
                                                    <option <?php echo ('No Response' == $field_value ? 'selected' : null) ?> value="No Response">No Response</option>
                                                    <option <?php echo ('Reserved' == $field_value ? 'selected' : null) ?> value="Reserved">Reserved</option>
                                                    <option <?php echo ('Site Recce' == $field_value ? 'selected' : null) ?> value="Site Recce">Site Recce</option>
                                                    <option <?php echo ('KIV' == $field_value ? 'selected' : null) ?> value="KIV">KIV</option>
                                                    <option <?php echo ('Unsuccessful' == $field_value ? 'selected' : null) ?> value="Unsuccessful">Unsuccessful</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="assign_agent_name">Assign Agent Name <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input id="ctrl-assign_agent_name" value="<?php echo $this->set_field_value('assign_agent_name', $data['assign_agent_name']); ?>" type="text" placeholder="Enter Assign Agent Name" required="" name="assign_agent_name" class="form-control " />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="assign_agent_phone">Assign Agent Phone </label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input id="ctrl-assign_agent_phone" value="<?php echo $this->set_field_value('assign_agent_phone', $data['assign_agent_phone']); ?>" type="text" placeholder="Enter Assign Agent Phone" name="assign_agent_phone" class="form-control " />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-ajax-status"></div>
                            <div class="form-group text-center">
                                <button class="btn btn-primary" type="submit">
                                    Update
                                    <i class="icon-paper-plane"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
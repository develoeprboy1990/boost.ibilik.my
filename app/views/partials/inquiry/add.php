<?php
$comp_model = new SharedController;
$page_element_id = "add-page-" . random_str();
$current_page = $this->set_current_page_link();
$csrf_token = Csrf::$token;
$show_header = $this->show_header;
$view_title = $this->view_title;
$redirect_to = $this->redirect_to;
?>
<section class="page" id="<?php echo $page_element_id; ?>" data-page-type="add" data-display-type="" data-page-url="<?php print_link($current_page); ?>">
    <?php
    if ($show_header == true) {
    ?>
        <div class="bg-light p-3 mb-3">
            <div class="container">
                <div class="row ">
                    <div class="col ">
                        <h4 class="record-title">Add New Inquiry</h4>
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
                        <form id="inquiry-add-form" role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("inquiry/add?csrf_token=$csrf_token") ?>" method="post">
                            <div>

                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="prospect_name">Your Name <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input id="ctrl-prospect_name" value="<?php echo $this->set_field_value('prospect_name', ""); ?>" type="text" placeholder="Enter Your Name" required="" name="prospect_name" class="form-control " />
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
                                                <input id="ctrl-prospect_phone" value="<?php echo $this->set_field_value('prospect_phone', ""); ?>" type="text" placeholder="Enter Contact Number" required="" name="prospect_phone" class="form-control " />
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
                                                <input id="ctrl-total_room" class="form-control" required="" value="" type="text" name="total_room" placeholder="Total Room" />

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
                                                <input id="ctrl-coverage_area" class="form-control" required="" value="" type="text" name="coverage_area" placeholder="Coverage Area" />

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
                                                    <option value="Boosting">Boosting</option>
                                                    <option value="Feature Post">Feature Post</option>
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
                                                    <option  value="">Select a value ...</option> 
                                                    <option  value="Clash Date">Clash Date</option>
                                                    <option  value="Exceed Budget">Exceed Budget</option>
                                                    <option  value="Exceed Guest Limitation">Exceed Guest Limitation</option>
                                                    <option  value="No Response">No Response</option>
                                                    <option  value="Reserved">Reserved</option>
                                                    <option  value="Site Recce">Site Recce</option>
                                                    <option  value="KIV">KIV</option>
                                                    <option  value="Unsuccessful">Unsuccessful</option>
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
                                                <input id="ctrl-assign_agent_name" value="<?php echo $this->set_field_value('assign_agent_name', USER_ID); ?>" type="text" placeholder="Enter Assign Agent Name" required="" name="assign_agent_name" class="form-control " />
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
                                                <input id="ctrl-assign_agent_phone" value="<?php echo $this->set_field_value('assign_agent_phone', $_SESSION[APP_ID . 'user_data']['phone_number']); ?>" type="text" placeholder="Enter Assign Agent Phone" name="assign_agent_phone" class="form-control " />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group form-submit-btn-holder text-center mt-3">
                                <div class="form-ajax-status"></div>
                                <button class="btn btn-primary" type="submit">
                                    Submit
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
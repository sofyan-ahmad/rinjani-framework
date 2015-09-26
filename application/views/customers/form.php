<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title"><?php echo $this->lang->line("customers_basic_information"); ?></h4>
</div>

<div class="modal-body">
    <?php echo form_open('customers/save/' . $person_info->person_id, array('id' => 'customer_form', "class" => 'form-horizontal')); ?>
    <span class="small"><?php echo $this->lang->line('common_fields_required_message'); ?></span>

    <ul id="error_message_box" class="warning"></ul>

    <fieldset id="customer_basic_info">

        <?php $this->load->view("people/form_basic_info"); ?>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <?php echo form_label($this->lang->line('customers_account_number') , 'account_number', array('class' => 'col-sm-4 control-label')); ?>
                    <div class='col-sm-8'>
                        <?php echo form_input(array(
                                'name' => 'account_number',
                                'id' => 'account_number',
                                'class' => 'form-control',
                                'value' => $person_info->account_number)
                        );?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <?php echo form_label($this->lang->line('customers_taxable') , 'taxable', array('class' => 'col-sm-4 control-label')); ?>
                    <div class='col-sm-8'>
                        <div class="checkbox">
                            <label>
                                <?php echo form_checkbox('taxable', '1', $person_info->taxable == '' ? TRUE : (boolean)$person_info->taxable); ?>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
    </fieldset>
    <?php
    echo form_close();
    ?>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="submit" form="customer_form" class="btn btn-primary">Save changes</button>
</div>

<script type='text/javascript'>

    //validation and submit handling
    $(document).ready(function () {
        $('#customer_form').validate({
            submitHandler: function (form) {
                $(form).ajaxSubmit({
                    success: function (response) {
                        tb_remove();
                        post_person_form_submit(response);
                    },
                    dataType: 'json'
                });

            },
            errorLabelContainer: "#error_message_box",
            wrapper: "li",
            rules: {
                first_name: "required",
                last_name: "required",
                email: "email"
            },
            messages: {
                first_name: "<?php echo $this->lang->line('common_first_name_required'); ?>",
                last_name: "<?php echo $this->lang->line('common_last_name_required'); ?>",
                email: "<?php echo $this->lang->line('common_email_invalid_format'); ?>"
            }
        });
    });
</script>



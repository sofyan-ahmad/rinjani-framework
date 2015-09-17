<?php $this->load->view("partial/header"); ?>
<script type="text/javascript">
$(document).ready(function() 
{ 
    init_table_sorting();
    enable_select_all();
    enable_row_selection();
    enable_search('<?php echo site_url("$controller_name/suggest")?>','<?php echo $this->lang->line("common_confirm_search")?>');
    enable_email('<?php echo site_url("$controller_name/mailto")?>');
    enable_delete('<?php echo $this->lang->line($controller_name."_confirm_delete")?>','<?php echo $this->lang->line($controller_name."_none_selected")?>');
}); 

function init_table_sorting()
{
	//Only init if there is more than one row
	if($('.tablesorter tbody tr').length >1)
	{
		$("#sortable_table").tablesorter(
		{ 
			sortList: [[1,0]], 
			headers: 
			{ 
				0: { sorter: false}, 
				5: { sorter: false} 
			} 

		}); 
	}
}

function post_person_form_submit(response)
{
	if(!response.success)
	{
		set_feedback(response.message,'error_message',true);	
	}
	else
	{
		//This is an update, just update one row
		if(jQuery.inArray(response.person_id,get_visible_checkbox_ids()) != -1)
		{
			update_row(response.person_id,'<?php echo site_url("$controller_name/get_row")?>');
			set_feedback(response.message,'success_message',false);	
			
		}
		else //refresh entire table
		{
			do_search(true,function()
			{
				//highlight new row
				hightlight_row(response.person_id);
				set_feedback(response.message,'success_message',false);		
			});
		}
	}
}
</script>

<div id="title_bar" class="">
	<div class="">
		<h1 class="">
			<?php echo $this->lang->line('common_list_of').' '.$this->lang->line('module_'.$controller_name); ?>
		</h1>
	</div>
	
	
	
</div>

<div class="">
		<div class="row">
		<div class="col-md-7 col-sm-7 ">
			<img src='<?php echo base_url()?>images/spinner_small.gif' alt='spinner' id='spinner' class="pull-left" />
			<?php echo form_open("$controller_name/search",array('id'=>'search_form')); ?>
			<input type="text" name="search"  class="form-control"/>
			</form>
		</div>
		<div class="col-md-5 col-sm-5 text-right">
			<div class="row">
			<div class="col-md-6 col-sm-6 col-xs-6">
			<a class="btn btn-primary btn-block" data-toggle="modal" href="<?php echo base_url()."index.php/"."$controller_name/view/-1/width:$form_width"; ?>" data-target="#modal-container">
				<i class="fa fa-plus"></i> <?php echo $this->lang->line($controller_name.'_new');?>
			</a>
			</div>
			
			<div class="col-md-6 col-sm-6 col-xs-6">
			<?php if ($controller_name =='customers') {?>
			<a class="btn btn-success btn-block" data-toggle="modal" href="<?php echo base_url()."index.php/"."$controller_name/excel_import/width:$form_width"; ?>" data-target="#modal-container">
				<i class="fa fa-file-excel-o"></i> Excel Import
			</a>
			</div>
			</div>
		<?php } ?>
		</div>
		</div>
		<?php  
		/*echo anchor("$controller_name/view/-1/width:$form_width",
		"<div class='big_button' style='float: left;'><span>".$this->lang->line($controller_name.'_new')."</span></div>",
		array('class'=>'thickbox none','title'=>$this->lang->line($controller_name.'_new')));
		*/
		?>
		
		<?php 
		/*if ($controller_name =='customers') {?>
			<?php echo anchor("$controller_name/excel_import/width:$form_width",
			"<div class='big_button' style='float: left;'><span>Excel Import</span></div>",
				array('class'=>'thickbox none','title'=>'Import Items from Excel'));
			?>	
		<?php } */
		?>
	</div>

<br class="clearfix"/>

<div class="">
	<a href="<?php echo "$controller_name/delete" ?>" class="btn btn-danger">
		<i class="fa fa-trash"></i> 
		<?php echo $this->lang->line("common_delete")?>
	</a>
	<button class="btn btn-success" id="email">
		<i class="fa fa-send"></i> 
		<?php echo $this->lang->line("common_email");?>
	</button>
</div>

<br/>

<div>
	<table class="table table-stripped table-bordered">
		<thead>
			<tr>
				<th><input type="checkbox" id="select_all"/></th>
				<th><?php echo $this->lang->line('common_last_name') ?></th>
				<th><?php echo $this->lang->line('common_first_name') ?></th>
				<th><?php echo $this->lang->line('common_email') ?></th>
				<th><?php echo $this->lang->line('common_phone_number') ?></th>
				<th>Action</th>
			</tr>
		</thead>
		
		<tbody>
			<?php
			$table_data_row = "";
			
			if(!$customer_data)
			{
				$table_data_row="<tr><td colspan='6'><div class='warning_message' style='padding:7px;'>".$this->lang->line('common_no_persons_to_display')."</div></td></tr>";
			}
			else{
			
				foreach($customer_data as $person)
				{
					$table_data_row.='<tr>';
					$table_data_row.="<td width='5%'><input type='checkbox' id='person_$person->person_id' value='".$person->person_id."'/></td>";
					$table_data_row.='<td width="20%">'.character_limiter($person->last_name,13).'</td>';
					$table_data_row.='<td width="20%">'.character_limiter($person->first_name,13).'</td>';
					$table_data_row.='<td width="30%">'.mailto($person->email,character_limiter($person->email,22)).'</td>';
					$table_data_row.='<td width="20%">'.character_limiter($person->phone_number,13).'</td>';		
					$table_data_row.='<td width="5%">'.anchor($controller_name."/view/$person->person_id/width:500", $this->lang->line('common_edit'),array('class'=>'thickbox','title'=>$this->lang->line($controller_name.'_update'))).'</td>';		
					$table_data_row.='</tr>';
				}
				
			}
			
			echo $table_data_row;				
			?>		
		</tbody>
	</table>
	
</div>

<div class id="table_holder">
<?php //echo $manage_table; ?>
</div>
<?php echo $this->pagination->create_links();?>

<div id="feedback_bar"></div>

<?php $this->load->view("partial/footer"); ?>

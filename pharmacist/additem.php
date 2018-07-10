<?php

require_once '../core/init.php';
$user = new User();
$errors=array();
if($user->isLoggedIn()) {
	$title='Pharmacist: Add Item';
include BASEURL.'includes/head.php';
include BASEURL.'includes/navigation_pharmacist.php';
if(Session::exists('success'))
{
	echo '<p class="text-success">' .Session::flash('success').'</p>';
}
?>

<div class="content-wrapper">
	<div class="container-fluid">
		<!-- Breadcrumbs-->
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="#">Good Life</a>
			</li>
			<li class="breadcrumb-item">
				<a href="stock.php">Stocks</a>
			</li>
			<li class="breadcrumb-item active">Add Item</li>
		</ol>
<?php

				if(isset($_GET['add'])){

					if(Input::exists()){
								if(Token::check(Input::get('token')) )
						{
							/*$validate = new Validation();
							$validation = $validate->check($_POST, array(
								'code'=>array(
									'required'=>true,
									'unique'=>'pharmacy',
									'integer'=>true
								),
								'description'=>array(
									'required'=>true
								),
								'packSize' => array(
									'required' => true,
									'integer'=>true
								),

								'unitPrice' => array(
									'required' => true,
									'integer'=>true
								),

								'activeGrades' => array(
									'required' => true,
									'integer'=>true
								),
								'sup_code'=>array(
									'required'=>true,
									'integer'=>true
								),
								'supplier'=>array(
									'required'=>true,
									'characters'=>true
								)
							));*/
							/*$required=array('code','description','packSize','unitPrice','activeGrades','sup_code','supplier');
								  foreach ($required as $key ) {
								    if (empty($_POST[$key])) {
								      $errors[].=$key.' is required';
								    }
								}
							/*$characters=array('description','supplier');
								foreach ($characters as $key) {
									$strings="/^[A-Za-z ]+$/";
									if(!(preg_match($strings, $key))){
								    	$errors[].=$key.' should contain only characters';
								    }
								}
								    
							$integer=array('code','packSize','unitPrice','activeGrades');
								foreach ($integer as $key ) {
									$num="/^[0-9 ]+$/";
									if(!(preg_match($num, $key))){
										$errors[].=$key.' should contain only numbers';
									}# code...
								}*/
							    /*if(!empty($errors)){
							    	foreach($errors as $error){
							    		echo ($error)."</br>";	
							    	}
									
								}*/

							/*if(empty($errors)){*/
								try{
									$db=DB::getInstance();
									$db->insert('pharmacy',array(
										'code'=>Input::get('code'),
										'description'=>Input::get('description'),
										'packsize'=>Input::get('packSize'),
										'unit_price'=>Input::get('unitPrice'),
										'active_grades'=>Input::get('activeGrades'),
										'sup_code'=>Input::get('sup_code'),
										'supplier'=>Input::get('supplier')
									));
									Session::flash('success', 'Successfully added.');
									Redirect::to('stock.php');

								}
								catch(Exception $e){
									die($e->getMessage());
								}
							//}
							/*else{
								foreach ($validate->errors() as $error) {
									echo $error, '<br />';
								}
							}*/
						}
					}
					?>
					<div class="container">
			      <div class="card card-register mx-auto mt-5">
			        <div class="card-header">Add Item</div>
			    <div class="card-body">
			     <div class="" id="order_medicine">
			       <form class="form" method="post" enctype="multipart/form-data">
							 <div class="form-group">
   			<label>Code</label>
   			<input type="number" min= 0 max=400 class="form-control" name="code" value="<?php echo Input::get('code'); ?>" required>
   		</div>
   		<div class="form-group">
   			<label>Description</label>
   			<input type="text"  class="form-control" name="description" value="<?php echo Input::get('description'); ?>" required>
   		</div>
   		<div class="form-group">
   			<label>Pack Size</label>
   			<input type="number" min=0 class="form-control" name="packSize" value="<?php echo Input::get('packSize'); ?>" required>
   		</div>
   		<div class="form-group">
   			<label>Unit price (Rs.)</label>
   			<input type="number" min=0 class="form-control" name="unitPrice" value="<?php echo Input::get('unitPrice'); ?>" required>
   		</div>
   		<div class="form-group">
   			<label>Active Grades</label>
   			<input type="text" class="form-control" name="activeGrades" value="<?php echo Input::get('activeGrades'); ?>" required>
   		</div>
   		<div class="form-group">
   			<label>Supplier Code</label>
   			<input type="text" maxlength=5 class="form-control" name="sup_code" value="<?php echo Input::get('sup_code'); ?>" required>
   		</div>
   		<div class="form-group">
   			<label>Supplier</label>
   			<input type="text" class="form-control" name="supplier" value="<?php echo Input::get('supplier'); ?>" required>
   		</div>

   		<div class="form-group col-md">
				<input type="hidden" name="token" value="<?php echo Token::generate(); ?>" >
   			<input type="submit" name="submit" value="Add" class="form-control btn btn-primary">
   		</div>

			       </form>

			          </div>
			        </div>
			      </div>
			    </div>



	</div>
</div>
<?php
}
include BASEURL.'includes/footer.php';

}else{
	Redirect::to('../login.php');
}

?>

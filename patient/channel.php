<?php

require_once '../core/init.php';
$user = new User();
if($user->isLoggedIn()) {
	$title='Patient:Channel a Doctor';
include BASEURL.'includes/head.php';
include BASEURL.'includes/navigation_patient.php';

if(Session::exists('home'))
{
	echo '<p class="text-success">' .Session::flash('home').'</p>';
}
if($_GET['channel']){
  $channelID=(int)$_GET['channel'];
  if(Input::exists()){
		if(Token::check(Input::get('token')) )
		{
  		$validate = new Validation();
  		$validation = $validate->check($_POST, array(
  			'booking_date'=>array(
  				'required'=>true
  			),
  			'booking_time' => array(
  				'required' => true
  			)
  		));

  		if($validate->passed()){

  			$db=DB::getInstance();
        $bookingDT=Input::get('booking_date').' '.Input::get('booking_time');
        $sd=$db->get('appointment',array(
          'date',
          '=',
          $bookingDT

        ))->count();
				$start_date=$bookingDT;
    		$expire=strtotime($start_date);
    		$today=strtotime(date("Y-m-d H:i"));
				if($today<=$expire){
        if(!$sd>0){
  			try{
  			     $db->insert('appointment',array(
            'user_id'=>$user->data()->id,
            'doctor_id'=>$channelID,
            'date'=>$bookingDT
          ));

  				Session::flash('success', 'Successfully Channeled.');
  				Redirect::to('appointment.php');
  			}
  			catch(Exception $e){
  				die($e->getMessage());
  			}
      }
      else{
        ?>
        <div class="content-wrapper">
          <div class="container-fluid">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Dashboard</a>
              </li>
              <li class="breadcrumb-item active">Channel</li>
            </ol>

        <?php
        echo '<p class="text-danger" >This time is already taken. </p>';
      }
		}else{
			?>
			<div class="content-wrapper">
				<div class="container-fluid">
					<!-- Breadcrumbs-->
					<ol class="breadcrumb">
						<li class="breadcrumb-item">
							<a href="#">Dashboard</a>
						</li>
						<li class="breadcrumb-item active">Channel</li>
					</ol>

			<?php
			echo '<p class="text-danger" >This date is invalid. </p>';

		}
  	}
  		else{
        ?>
        <div class="content-wrapper">
        	<div class="container-fluid">
        		<!-- Breadcrumbs-->
        		<ol class="breadcrumb">
        			<li class="breadcrumb-item">
        				<a href="#">Dashboard</a>
        			</li>
        			<li class="breadcrumb-item active">Channel</li>
        		</ol>

        <?php
  			foreach ($validate->errors() as $error) {
  				echo $error, '<br />';
  			}
  		}
		}

  }else {
    ?>
    <div class="content-wrapper">
    	<div class="container-fluid">
    		<!-- Breadcrumbs-->
    		<ol class="breadcrumb">
    			<li class="breadcrumb-item">
    				<a href="#">Dashboard</a>
    			</li>
    			<li class="breadcrumb-item active">Channel</li>
    		</ol>

    <?php
  }


?>
  <form method="post">
        <div class="form-group">
              <div class="form-row">
                <div class="col-md-6">
                  <label for="date">Date</label>
                  <input class="form-control" name="booking_date" type="date" aria-describedby="nameHelp" placeholder="Select a date" value="<?php echo escape(Input::get('booking_date')); ?>">
                </div>
                <div class="col-md-6">
                  <label for="time">Time</label>
                  <select class="form-control" name="booking_time">
                    <option value="16:00">4:00</option>
                    <option value="16:30">4:30</option>
                    <option value="17:00">5:00</option>
                    <option value="17:30">5:30</option>
                    <option value="18:00">6:00</option>
                    <option value="18:30">6:30</option>

                  </select>
                </div>
              </div>
            </hr>
              <div class="form-group">
                <hr>
								<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                <input class="form-control btn btn-primary btn-block" type="submit" name="channel" value="Channel Doctor">
              </div>
            </div>
          </form>




	</div>
</div>
<?php
}
include BASEURL.'includes/footer.php';

}else{
	Redirect::to('../login.php');
}

?>

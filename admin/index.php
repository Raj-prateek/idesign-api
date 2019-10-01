<?php session_start();
//session_destroy(); 
date_default_timezone_set('Asia/Dubai');
if(empty($_SESSION['user'])){
	header('Location:https://soopla.com/admin/login.php');
}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Alter & Sew Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
<!-- Custom Theme files -->
<link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
<!--js-->
<script src="https://code.jquery.com/jquery-3.3.1.js"></script> 
	<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script> 
	
<!--icons-css-->
<link href="css/font-awesome.css" rel="stylesheet"> 
<link href='https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css' rel='stylesheet' type='text/css'>
<!--Google Fonts-->
	
<link href='//fonts.googleapis.com/css?family=Carrois+Gothic' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Work+Sans:400,500,600' rel='stylesheet' type='text/css'>
<!--static chart-->
<script src="js/Chart.min.js"></script>
</head>
<body>	
<div class="page-container">	
   <div >
	   <div class="mother-grid-inner">
            <!--header start here-->
				<div class="header-main" style="width:100%!important;">
					<div class="header-left">
							<div class="logo-name">
									 <a href="index.html"> <h1>iDesign Dash</h1> 
									<!--<img id="logo" src="" alt="Logo"/>--> 
								  </a> 								
							</div>
							
								
							<div class="clearfix"> </div>
						 </div>
						 <div class="header-right">
							<!--notification menu end -->
							<div class="profile_details">		
								<ul>
									<li class="dropdown profile_details_drop">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
											<div class="profile_img">	
												<span class="prfil-img"><img src="images/p1.png" alt=""> </span> 
												<div class="user-name">
													<p><?php
														echo $_SESSION['user']['name']?></p>
												</div>
												<i class="fa fa-angle-down lnr"></i>
												<i class="fa fa-angle-up lnr"></i>
												<div class="clearfix"></div>	
											</div>	
										</a>
										<ul class="dropdown-menu drp-mnu">
											<li> <a href="#"><i class="fa fa-sign-out"></i> Logout</a> </li>
										</ul>
									</li>
								</ul>
							</div>
							<div class="clearfix"> </div>				
						</div>
				     <div class="clearfix"> </div>	
				</div>
<!--heder end here-->
<!-- script-for sticky-nav -->
		<script>
		$(document).ready(function() {
			 var navoffeset=$(".header-main").offset().top;
			 $(window).scroll(function(){
				var scrollpos=$(window).scrollTop(); 
				if(scrollpos >=navoffeset){
					$(".header-main").addClass("fixed");
				}else{
					$(".header-main").removeClass("fixed");
				}
			 });
			 
		});
		</script>
		<!-- /script-for sticky-nav -->
<!--inner block start here-->
<div class="inner-block">
<!--market updates updates-->
	 <div class="market-updates">
			<div class="col-md-4 market-update-gd">
				<div class="market-update-block clr-block-1">
					<div class="col-md-8 market-update-left">
						<h3>
							<?php 
							
							$totalCount = file_get_contents("https://soopla.com/api/Orders/count");
							$totalCount = json_decode($totalCount,true);
							echo $totalCount['count'];
							
							?></h3>
						<h4>Total Orders</h4>
					</div>
					<div class="col-md-4 market-update-right">
						<i class="fa fa-file-text-o"> </i>
					</div>
				  <div class="clearfix"> </div>
				</div>
			</div>
			<div class="col-md-4 market-update-gd">
				<div class="market-update-block clr-block-2">
				 <div class="col-md-8 market-update-left">
					<h3><?php 
							
							$totalCount = file_get_contents("https://soopla.com/api/Orders/count?where=%7B%22published%22%3A0%7D");
							$totalCount = json_decode($totalCount,true);
							echo $totalCount['count'];
							
							?></h3>
					<h4>Order pending</h4>
				  </div>
					<div class="col-md-4 market-update-right">
						<i class="fa fa-clock-o"> </i>
					</div>
				  <div class="clearfix"> </div>
				</div>
			</div>
			<div class="col-md-4 market-update-gd">
				<div class="market-update-block clr-block-3">
					<div class="col-md-8 market-update-left">
						<h3><?php 
							
							$totalCount = file_get_contents("https://soopla.com/api/Orders/count?where=%7B%22published%22%3A-1%7D");
							$totalCount = json_decode($totalCount,true);
							echo $totalCount['count'];
							
							?></h3>
						<h4>Order Cancelled</h4>
					</div>
					<div class="col-md-4 market-update-right">
						<i class="fa fa-ban"> </i>
					</div>
				  <div class="clearfix"> </div>
				</div>
			</div>
		   <div class="clearfix"> </div>
		</div>
<!--market updates end here-->
<!--mainpage chit-chating-->
<div class="chit-chat-layer1">
	<div class="col-md-12 chit-chat-layer1-left">
               <div class="work-progres">
                            <div class="chit-chat-heading">
                                  Order Management
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover" id ="myTable">
                                  <thead>
                                    <tr>
                                      <th>#</th>
                                      <th>Order Details</th>
									  <th>Total Price</th>  
                                      <th>Contact Details</th>                                                         
                                      <th>Order Status</th>
									<th>Order Date</th>
                                      <th>Action</th>
                                  </tr>
                              </thead>
                              <tbody>
								  <?php 
							
								  //echo 'https://soopla.com/api/orders?filter='.urlencode('{"include":["fkOrderUserrel"],"order":"created DESC"}');exit
									  ;
							$totalCount = file_get_contents('https://soopla.com/api/orders?filter='.urlencode('{"include":["fkOrderUserrel"],"order":"created DESC"}'));
							$totalCount = json_decode($totalCount,true);
								$category = file_get_contents('https://soopla.com/api/categories');
								  $category = json_decode($category,true);
								  
								if(count($totalCount)>0){
								
									foreach($totalCount as $key=>$value){
										$str = '<tr>';
                                  		$str .= '<td>'.$value['id'].'</td>';
										//print_r('https://soopla.com/api/Requirements?filter='.urlencode('{"where":{"id":{"inq":'.$value['requirementids'].'}} ,"include":["fkReqItemrel","fkCategoryrel"]}'));exit;
										$requirement =file_get_contents('https://soopla.com/api/Requirements?filter='.urlencode('{"where":{"id":{"inq":'.$value['requirementids'].'}} ,"include":["fkReqItemrel"]}'));
										$requirement = json_decode($requirement,true);
										$requirementStr ='';
										if(count($requirement)>0){
											switch($requirement[0]['requirementType']){
												case 1:
													$requirementStr.='<b>Stiching</b><br>';
													break;
												case 2:
													$requirementStr.='<b>Alteration</b><br>';
													break;
											}
											$requirementStr.='<p>Item Info</p>';
											$requirementStr.='<table>';
											$requirementStr.="<tr><th>Category</th><th>Item</th><th>Qty</th><th>Addon</th><th>Price</th></tr>";
											foreach($requirement as $key2=>$value2){
												$originalPrice =0;
												switch($value2['requirementType']){
												case 1:
													$originalPrice =$value2['fkReqItemrel']['pricePerStiching'];
													break;
												case 2:
													$originalPrice =$value2['fkReqItemrel']['pricePerAlteration'];
													break;
												}
												$diffInPrice = $value2['totalPrice'] - ($originalPrice * $value2['count']);
												$requirementStr.="<tr>";
												$categoryObj='';
												foreach($category as $key3=>$value3){
													if($value3['id']==$value2['fkReqItemrel']['category']){
														$categoryObj =$value3; 
														break;
													}
												}
												$requirementStr .='<td>'.$categoryObj['name'].'</td>';
												$requirementStr.='<td>'.$value2['fkReqItemrel']['name']."".($diffInPrice!=0?"<p class=\"text-muted\" style='font-size:12px;'>".$value2['fkReqItemrel']['addon']."</p>":"") ."</td> <td> ". $value2['count']. "</td><td>".($diffInPrice!=0?$diffInPrice:"-")."</td><td> ".($originalPrice * $value2['count']) ." </td>";
												$requirementStr.="</tr>";
											}
											$requirementStr.='</table>';
										}
										
											
										$str .= '<td>'.$requirementStr.'</td>';
										$str .= '<td><h4>AED <b>'.$value['totalPrice'].'</b></h4></td>';
										if(isset($value['fkOrderUserrel'])){
											
											$str .= '<td>'.$value['fkOrderUserrel']['name']."<br>".$value['fkOrderUserrel']['email']."<br>".$value['fkOrderUserrel']['phoneNumber'].'</td>';
										}else{
											$str .= '<td>--</td>';
										}
										switch($value['published']){
											case -1:
												$str .= '<td><span class="label label-danger">Cancelled</span></td>';
												break;
											case 0:
												$str .= '<td><span class="label label-info">Order Confirmation Awaiting</span></td>';
												break;
											case 1:
												$str .= '<td><span class="label label-warning">Order Confirmed</span></td>';
												break;
											case 2:
												$str .= '<td><span class="label label-primary">In process</span></td>';
												break;
											case 3:
												$str .= '<td><span class="label label-success">Delivered</span></td>';
												break;
										}
										
										$str .= '<td>'.date("d M, Y h:i A", strtotime($value['created'])).'</td>';
									
										$str .= '<td><div class="dropdown dropdown-inbox">
				            					<a href="#" title="" class="btn btn-default" data-toggle="dropdown" aria-expanded="false">
				                					<i class="fa fa-cog icon_8"></i>
				                					<i class="fa fa-chevron-down icon_8"></i>
				            						<div class="ripple-wrapper"></div></a>
													<ul class="dropdown-menu dropdown-menu-right">';
										switch($value['published']){
											case -1:
												$str .= '<li>-</li>';
												break;
											case 0:
												$str .='<li>
													<a href="javascript:void(0);" title="" onclick="changeStatus('.$value['id'].','.$value['published'].',1);">
														Confirm Order
													</a>
												</li><li>
															<a href="javascript:void(0);" title=""  onclick="changeStatus('.$value['id'].','.$value['published'].',-1);">
																Cancel Order
															</a>
														</li>';
												break;
											case 1:
												$str .= '<li>
															<a href="javascript:void(0);" title="" onclick="changeStatus('.$value['id'].','.$value['published'].',2);">
																In Process
															</a>
														</li>
														<li>
															<a href="javascript:void(0);" title=""  onclick="changeStatus('.$value['id'].','.$value['published'].',-1);">
																Cancel Order
															</a>
														</li>';
												break;
											case 2:
												$str .= '<li>
															<a href="javascript:void(0);" title=""  onclick="changeStatus('.$value['id'].','.$value['published'].',3);">
																Delivered
															</a>
														</li>';
														
												break;
											case 3:
												
												break;
										}
														
														
														
										$str .=			'</ul>
												</div>
											</td>';
										$str .= '</tr>';
										echo $str;
									}
								}else{
								echo '<tr><td colspan="6" class="text-center">Oops! no order found.</td></tr>';
								}
							
							?>
                                
                              
                          </tbody>
                      </table>
                  </div>
             </div>
	</div>
     <div class="clearfix"> </div>
</div>
<!--main page chit chating end here-->

</div>
<!--inner block end here-->
<!--copy rights start here-->
<div class="copyrights">
	 <p>© 2019 iDesign. All Rights Reserved</p>
</div>	
<!--COPY rights end here-->
</div>
</div>

	<div class="clearfix"> </div>
</div>
	<script>
	$(document).ready(function() {
   	$('#myTable thead tr').clone(true).appendTo( '#myTable thead' );
    $('#myTable thead tr:eq(1) th').each( function (i) {
        var title = $(this).text();
		if(i==0 || i==6){
						$(this).html( '' );
		}else{
			$(this).html( '<input type="text" placeholder="Search '+title+'" />' );
 
			$( 'input', this ).on( 'keyup change', function () {
				if ( table.column(i).search() !== this.value ) {
					table
						.column(i)
						.search( this.value )
						.draw();
				}
			} );
		}
        
    } );
 
    var table = $('#myTable').DataTable( {
        orderCellsTop: true,
        fixedHeader: true
    } );
	
} );

function changeStatus (orderId,currentStatus,changeStatusTo){
	$.ajax({
		url :"https://soopla.com/api/orders/"+orderId,
		type:"GET",
		dataType: "json",
        contentType: "application/json;charset=utf-8",
		success:function(d){
			d.published =changeStatusTo;
			$.ajax({
				url :"https://soopla.com/api/orders",
				type:"PUT",
				dataType: "json",
				contentType: "application/json;charset=utf-8",
				data:JSON.stringify(d),
				success:function(da){
					console.log(da);
					location.reload();
				}
			});
		}
	});
	
	
}
	</script>
	
	<script src="js/scripts.js"></script>
	<!--//scrolling js-->
<script src="js/bootstrap.js"> </script>
<!-- mother grid end here-->
</body>
</html>                     
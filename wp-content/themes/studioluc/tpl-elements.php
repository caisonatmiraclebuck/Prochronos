<?php
/*
Template Name: [Example Page Elements]
*/
/* =============================================================================
   THIS FILE SHOULD NOT BE EDITED
   ========================================================================== */ 

global  $CORE, $userdata; get_currentuserinfo(); // grabs the user info and puts into vars 

		get_header($CORE->pageswitch()); ?>
        
<div class="panel panel-default">
<div class="panel-heading">Example CSS Elements</div>
<div class="panel-body">
<div class="row">

<style>
.section-row.three-quarters-padding-top {
padding-top: 50px;
padding-bottom:50px;
}
.section-title, .section-separator-title, .section-subtitle {
position: relative;
text-transform: uppercase;
font-weight: 700;
display:block;
}
.section-title small {
margin-top: 10px;
}
.section-title small, .section-separator-title small, .section-subtitle small {
font-weight: 300;
font-size: 18px;
line-height: 1.6;
display: block;
text-transform: none;
}

.section-row.shadow-bg {
background: #fafafa;

}

</style>



<div class="section-row-container-fluid">

				<div class="section-row three-quarters-padding-bottom page-title">

					<div class="container-fluid">

						<div class="row">

							<div class="col-md-12">

								<h1 class="section-title text-center">
									Bootstrap 3 CSS Styles
									<small>Showcase of CSS elements built into this theme.</small>
								</h1>
                                
                                <hr />
                                
                                <div style=" text-align:center;">
                                For a full list visit: <a href="http://getbootstrap.com/components/" rel="nofollow" target="_blank">http://getbootstrap.com/components/</a>
</div>
                                
                                <hr />
                                
							</div>

						</div>

					</div>

				</div>
				
			</div>


<div class="section-row three-quarters-padding-top three-quarters-padding-bottom shadow-bg">

				<div class="container-fluid">

					<div class="row">

						<div class="col-md-3">
							<h4 class="section-subtitle">Buttons</h4>
						</div>

						<div class="col-md-9">
							<p><a href="#" class="btn btn-default btn-xs">Default</a> <a href="#" class="btn btn-primary btn-xs">Primary</a> <a href="#" class="btn btn-success btn-xs">Success</a> <a href="#" class="btn btn-info btn-xs">Info</a> <a href="#" class="btn btn-warning btn-xs">Warning</a> <a href="#" class="btn btn-danger btn-xs">Danger</a></p>

							<p><a href="#" class="btn btn-default btn-sm">Default</a> <a href="#" class="btn btn-primary btn-sm">Primary</a> <a href="#" class="btn btn-success btn-sm">Success</a> <a href="#" class="btn btn-info btn-sm">Info</a> <a href="#" class="btn btn-warning btn-sm">Warning</a> <a href="#" class="btn btn-danger btn-sm">Danger</a></p>

							<p><a href="#" class="btn btn-default btn-0">Default</a> <a href="#" class="btn btn-primary btn-0">Primary</a> <a href="#" class="btn btn-success btn-0">Success</a> <a href="#" class="btn btn-info btn-0">Info</a> <a href="#" class="btn btn-warning btn-0">Warning</a> <a href="#" class="btn btn-danger btn-0">Danger</a></p>

							<p><a href="#" class="btn btn-default btn-lg">Default</a> <a href="#" class="btn btn-primary btn-lg">Primary</a> <a href="#" class="btn btn-success btn-lg">Success</a> <a href="#" class="btn btn-info btn-lg">Info</a> <a href="#" class="btn btn-warning btn-lg">Warning</a> <a href="#" class="btn btn-danger btn-lg">Danger</a></p>
						</div>

					</div>

				</div>

			</div>
            
            
<div class="section-row three-quarters-padding-top three-quarters-padding-bottom">

				<div class="container-fluid">

					<div class="row">

						<div class="col-md-3">
							<h4 class="section-subtitle">Tabs</h4>
						</div>

						<div class="col-md-9">

							<div class="tab-widget">
								<ul class="nav nav-tabs">
									<li class="active"><a href="#home" data-toggle="tab">Home</a></li>
									<li class=""><a href="#profile" data-toggle="tab">Profile</a></li>
									<li class=""><a href="#social" data-toggle="tab">Social</a></li>
									<li class=""><a href="#settings" data-toggle="tab">Settings</a></li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane fade active in" id="home">
										<p>Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.</p>
									</div>
									<div class="tab-pane fade" id="profile">
										<p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo booth letterpress, commodo enim craft beer mlkshk aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic, assumenda labore aesthetic magna delectus mollit. Keytar helvetica VHS salvia yr, vero magna velit sapiente labore stumptown. Vegan fanny pack odio cillum wes anderson 8-bit, sustainable jean shorts beard ut DIY ethical culpa terry richardson biodiesel. Art party scenester stumptown, tumblr butcher vero sint qui sapiente accusamus tattooed echo park.</p>
									</div>
									<div class="tab-pane fade" id="social">
										<p>Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard locavore carles etsy salvia banksy hoodie helvetica. DIY synth PBR banksy irony. Leggings gentrify squid 8-bit cred pitchfork. Williamsburg banh mi whatever gluten-free, carles pitchfork biodiesel fixie etsy retro mlkshk vice blog. Scenester cred you probably haven't heard of them, vinyl craft beer blog stumptown. Pitchfork sustainable tofu synth chambray yr.</p>
									</div>
									<div class="tab-pane fade" id="settings">
										<p>Trust fund seitan letterpress, keytar raw denim keffiyeh etsy art party before they sold out master cleanse gluten-free squid scenester freegan cosby sweater. Fanny pack portland seitan DIY, art party locavore wolf cliche high life echo park Austin. Cred vinyl keffiyeh DIY salvia PBR, banh mi before they sold out farm-to-table VHS viral locavore cosby sweater. Lomo wolf viral, mustache readymade thundercats keffiyeh craft beer marfa ethical. Wolf salvia freegan, sartorial keffiyeh echo park vegan.</p>
									</div>
								</div>
							</div>

							<div class="tab-widget">
								<ul class="nav nav-pills">
									<li class="active"><a href="#home1" data-toggle="tab">Home</a></li>
									<li class=""><a href="#profile1" data-toggle="tab">Profile</a></li>
									<li class=""><a href="#social1" data-toggle="tab">Social</a></li>
									<li class=""><a href="#settings1" data-toggle="tab">Settings</a></li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane fade active in" id="home1">
										<p>Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh mi, qui irure terry richardson ex squid. Aliquip placeat salvia cillum iphone. Seitan aliquip quis cardigan american apparel, butcher voluptate nisi qui.</p>
									</div>
									<div class="tab-pane fade" id="profile1">
										<p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo booth letterpress, commodo enim craft beer mlkshk aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic, assumenda labore aesthetic magna delectus mollit. Keytar helvetica VHS salvia yr, vero magna velit sapiente labore stumptown. Vegan fanny pack odio cillum wes anderson 8-bit, sustainable jean shorts beard ut DIY ethical culpa terry richardson biodiesel. Art party scenester stumptown, tumblr butcher vero sint qui sapiente accusamus tattooed echo park.</p>
									</div>
									<div class="tab-pane fade" id="social1">
										<p>Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard locavore carles etsy salvia banksy hoodie helvetica. DIY synth PBR banksy irony. Leggings gentrify squid 8-bit cred pitchfork. Williamsburg banh mi whatever gluten-free, carles pitchfork biodiesel fixie etsy retro mlkshk vice blog. Scenester cred you probably haven't heard of them, vinyl craft beer blog stumptown. Pitchfork sustainable tofu synth chambray yr.</p>
									</div>
									<div class="tab-pane fade" id="settings1">
										<p>Trust fund seitan letterpress, keytar raw denim keffiyeh etsy art party before they sold out master cleanse gluten-free squid scenester freegan cosby sweater. Fanny pack portland seitan DIY, art party locavore wolf cliche high life echo park Austin. Cred vinyl keffiyeh DIY salvia PBR, banh mi before they sold out farm-to-table VHS viral locavore cosby sweater. Lomo wolf viral, mustache readymade thundercats keffiyeh craft beer marfa ethical. Wolf salvia freegan, sartorial keffiyeh echo park vegan.</p>
									</div>
								</div>
							</div>
						</div>

					</div>

				</div>
				
			</div>
            
            
<div class="section-row three-quarters-padding-top three-quarters-padding-bottom shadow-bg">

				<div class="container-fluid">

					<div class="row">

						<div class="col-md-3">
							<h4 class="section-subtitle">Message Boxes</h4>
						</div>

						<div class="col-md-9">
							<div class="alert alert-success">
								<button type="button" class="close" data-dismiss="alert">x</button>
								<strong>Well done!</strong> You successfully read this important alert message.
							</div>

							<div class="alert alert-info">
								<button type="button" class="close" data-dismiss="alert">x</button>
								<strong>Heads up!</strong> This alert needs your attention, but it's not super important.
							</div>

							<div class="alert alert-warning">
								<button type="button" class="close" data-dismiss="alert">x</button>
								<strong>Warning!</strong> Better check yourself, you're not looking too good.
							</div>

							<div class="alert alert-danger">
								<button type="button" class="close" data-dismiss="alert">x</button>
								<strong>Oh snap!</strong> Change a few things up and try submitting again.
							</div>
						</div>

					</div>

				</div>

			</div>
            
            
<div class="section-row three-quarters-padding-top three-quarters-padding-bottom">

				<div class="container-fluid">

					<div class="row">

						<div class="col-md-3">
							<h4 class="section-subtitle">Accordions</h4>
						</div>

						<div class="col-md-9">
							<div class="panel-group" id="accordion">
							  <div class="panel panel-default">
							    <div class="panel-heading">
							      <h4 class="panel-title">
							        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
							          Collapsible Group Item #1
							        </a>
							      </h4>
							    </div>
							    <div id="collapseOne" class="panel-collapse collapse in">
							      <div class="panel-body">
							        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
							      </div>
							    </div>
							  </div>
							  <div class="panel panel-default">
							    <div class="panel-heading">
							      <h4 class="panel-title">
							        <a data-toggle="collapse" class="collapsed" data-parent="#accordion" href="#collapseTwo">
							          Collapsible Group Item #2
							        </a>
							      </h4>
							    </div>
							    <div id="collapseTwo" class="panel-collapse collapse">
							      <div class="panel-body">
							        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
							      </div>
							    </div>
							  </div>
							  <div class="panel panel-default">
							    <div class="panel-heading">
							      <h4 class="panel-title">
							        <a data-toggle="collapse" class="collapsed" data-parent="#accordion" href="#collapseThree">
							          Collapsible Group Item #3
							        </a>
							      </h4>
							    </div>
							    <div id="collapseThree" class="panel-collapse collapse">
							      <div class="panel-body">
							        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
							      </div>
							    </div>
							  </div>
							</div>
						</div>

					</div>

					<div class="spacer-40"></div>

					<div class="row">

						<div class="col-md-3">
							<h4 class="section-subtitle">Toggles</h4>
						</div>

						<div class="col-md-9">
							<div class="panel-group">
							  <div class="panel panel-default">
							    <div class="panel-heading">
							      <h4 class="panel-title">
							        <a data-toggle="collapse" href="#collapseOne1">
							          Collapsible Group Item #1
							        </a>
							      </h4>
							    </div>
							    <div id="collapseOne1" class="panel-collapse collapse in">
							      <div class="panel-body">
							        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
							      </div>
							    </div>
							  </div>
							  <div class="panel panel-default">
							    <div class="panel-heading">
							      <h4 class="panel-title">
							        <a data-toggle="collapse" class="collapsed" href="#collapseTwo1">
							          Collapsible Group Item #2
							        </a>
							      </h4>
							    </div>
							    <div id="collapseTwo1" class="panel-collapse collapse">
							      <div class="panel-body">
							        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
							      </div>
							    </div>
							  </div>
							  <div class="panel panel-default">
							    <div class="panel-heading">
							      <h4 class="panel-title">
							        <a data-toggle="collapse" class="collapsed" href="#collapseThree1">
							          Collapsible Group Item #3
							        </a>
							      </h4>
							    </div>
							    <div id="collapseThree1" class="panel-collapse collapse">
							      <div class="panel-body">
							        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
							      </div>
							    </div>
							  </div>
							</div>
						</div>

					</div>

				</div>
				
			</div>
            
            
<div class="section-row three-quarters-padding-top three-quarters-padding-bottom shadow-bg">

				<div class="container-fluid">

					<div class="row">

						<div class="col-md-3">
							<h4 class="section-subtitle">Tables</h4>
						</div>

						<div class="col-md-9">
							<table class="table table-striped table-bordered">
								<thead>
								<tr>
								<th>#</th>
								<th>First Name</th>
								<th>Last Name</th>
								<th>Username</th>
								</tr>
								</thead>
								<tbody>
								<tr>
								<td>1</td>
								<td>Mark</td>
								<td>Otto</td>
								<td>@mdo</td>
								</tr>
								<tr>
								<td>2</td>
								<td>Jacob</td>
								<td>Thornton</td>
								<td>@fat</td>
								</tr>
								<tr>
								<td>3</td>
								<td>Larry</td>
								<td>the Bird</td>
								<td>@twitter</td>
								</tr>
								</tbody>
							</table>
						</div>

					</div>

				</div>

			</div>
            
            
< 
            
            
<div class="section-row three-quarters-padding-top three-quarters-padding-bottom shadow-bg">

				<div class="container-fluid">

					<div class="row">

						<div class="col-md-3">
							<h4 class="section-subtitle">Progressbars</h4>
						</div>

						<div class="col-md-9">

							<div class="progress-counter">
								<span class="progress-label">Default</span>
								<div class="progress" data-value="30">
									<div class="progress-bar" style="width: 70%">  </div>
								</div>
							</div>

							<div class="progress-counter">
								<span class="progress-label">Striped</span>
								<div class="progress progress-striped" data-value="20">
									<div class="progress-bar" style="width: 60%"></div>
								</div>
							</div>

							<div class="progress-counter">
								<span class="progress-label">Active</span>
								<div class="progress progress-striped active" data-value="60">
									<div class="progress-bar" style="width: 50%"></div>
								</div>
							</div>

						</div>

					</div>

					<div class="spacer-40"></div>

					<div class="row">

						<div class="col-md-3">
							<h4 class="section-subtitle">Progressbar Colors</h4>
						</div>

						<div class="col-md-9">

							<div class="progress-counter">
								<span class="progress-label">Default</span>
								<div class="progress" data-value="30">
									<div class="progress-bar" role="progressbar" style="width: 70%"></div>
								</div>
							</div>

							<div class="progress-counter">
								<span class="progress-label">Success</span>
								<div class="progress" data-value="40">
									<div class="progress-bar progress-bar-success" style="width: 70%"></div>
								</div>
							</div>

							<div class="progress-counter">
								<span class="progress-label">Info</span>
								<div class="progress" data-value="20">
									<div class="progress-bar progress-bar-info" style="width: 70%"></div>
								</div>
							</div>

							<div class="progress-counter">
								<span class="progress-label">Warning</span>
								<div class="progress" data-value="60">
									<div class="progress-bar progress-bar-warning" style="width: 70%"></div>
								</div>
							</div>

							<div class="progress-counter">
								<span class="progress-label">Danger</span>
								<div class="progress" data-value="80">
									<div class="progress-bar progress-bar-danger" style="width: 70%"></div>
								</div>
							</div>

						</div>

					</div>

				</div>

			</div>
     
     





<div class="section-row three-quarters-padding-bottom page-title">

					<div class="container-fluid-fluid">

						<div class="row">

							<div class="col-md-12">

								<h1 class="section-title text-center">
									Typography
									<small>Bootstrap Typography</small>
								</h1>

							</div>

						</div>

					</div>

				</div>




<div class="section-row three-quarters-padding-top three-quarters-padding-bottom shadow-bg">

					<div class="container-fluid-fluid">

						<div class="row">

							<div class="col-md-2">
								<h4 class="section-subtitle">Paragraph</h4>
							</div>

							<div class="col-md-10">

								<p class="lead">"Not forged!" and snatching Perth's levelled iron from the crotch, Ahab held it out, exclaiming-"Look ye, Nantucketer; here in this hand I hold his death! Tempered in blood, and tempered by lightning are these barbs; and I swear to temper them triply in that hot place behind the fin, where the White Whale most feels his accursed life!"</p>

								<p>"Then God keep thee, old man-see'st thou that"-pointing to the hammock-"I bury but one of five stout men, who were alive only yesterday; but were dead ere night. Only THAT one I bury; the rest were buried before they died; you sail upon their tomb." Then turning to his crew-"Are ye ready there? place the plank then on the rail, and lift the body; so, then-Oh! God"-advancing towards the hammock with uplifted hands-"may the resurrection and the life-"</p>

							</div>

						</div>

					</div>

				</div>
                
                
                
                <div class="section-row three-quarters-padding-top three-quarters-padding-bottom">

					<div class="container-fluid-fluid">

						<div class="row">

							<div class="col-md-2">
								<h4 class="section-subtitle">Quote</h4>
							</div>

							<div class="col-md-10">
								<blockquote>
									<p>If a nation values anything more than freedom, it will lose its freedom; and the irony of it is that if it is comfort or money that it values more, it will lose that too.</p>
									<small>W. Somerset Maugham</small>
								</blockquote>
							</div>

						</div>

					</div>

				</div>
                
                
     <div class="section-row three-quarters-padding-top three-quarters-padding-bottom shadow-bg">

					<div class="container-fluid-fluid">

						<div class="row">

							<div class="col-md-2">
								<h4 class="section-subtitle">Lists</h4>
							</div>

							<div class="col-md-10">

								<div class="row">

									<div class="col-md-3">
										<ul>
											<li>Donec at tellus malesuada</li>
											<li>Aenean lacinia mi varius</li>
											<li>Nam sagittis ante et dolor</li>
											<li>Nunc vitae nulla vitae justo</li>
											<li>Donec eget diam in turpis</li>
										</ul>
									</div>

									<div class="col-md-3">
										<ol>
											<li>Donec at tellus malesuada</li>
											<li>Aenean lacinia mi varius</li>
											<li>Nam sagittis ante et dolor</li>
											<li>Nunc vitae nulla vitae justo</li>
											<li>Donec eget diam in turpis</li>
										</ol>
									</div>

									<div class="col-md-3">
										<ul class="check-list">
											<li>Donec at tellus malesuada</li>
											<li>Aenean lacinia mi varius</li>
											<li>Nam sagittis ante et dolor</li>
											<li>Nunc vitae nulla vitae justo</li>
											<li>Donec eget diam in turpis</li>
										</ul>
									</div>

									<div class="col-md-3">
										<ul class="arrow-list">
											<li>Donec at tellus malesuada</li>
											<li>Aenean lacinia mi varius</li>
											<li>Nam sagittis ante et dolor</li>
											<li>Nunc vitae nulla vitae justo</li>
											<li>Donec eget diam in turpis</li>
										</ul>
									</div>

								</div>

							</div>

						</div>

					</div>

				</div>
                
                
                
                <div class="section-row three-quarters-padding-top three-quarters-padding-bottom">

					<div class="container-fluid-fluid">

						<div class="row">

							<div class="col-md-2">
								<h4 class="section-subtitle">Heading</h4>
							</div>

							<div class="col-md-5">
								<h1 class="text-highlight text-uppercase">Heading 1</h1>
								<h2 class="text-highlight text-uppercase">Heading 2</h2>
								<h3 class="text-highlight text-uppercase">Heading 3</h3>
								<h4 class="text-highlight text-uppercase">Heading 4</h4>
								<h5 class="text-highlight text-uppercase">Heading 5</h5>
								<h6 class="text-highlight text-uppercase">Heading 6</h6>
								<div class="spacer-60 hidden-md hidden-lg"></div>
							</div>

							<div class="col-md-5">
								<h1>Heading 1</h1>
								<h2>Heading 2</h2>
								<h3>Heading 3</h3>
								<h4>Heading 4</h4>
								<h5>Heading 5</h5>
								<h6>Heading 6</h6>
							</div>

						</div>

					</div>

				</div>
                
                
                
                
                <div class="section-row three-quarters-padding-top three-quarters-padding-bottom shadow-bg">

					<div class="container-fluid-fluid">

						<div class="row">

							<div class="col-md-2">
								<h4 class="section-subtitle">Tooltips &amp; Badges</h4>
							</div>

							<div class="col-md-5">
								<p>Sed ut perspiciatis unde omnis iste <a rel="tooltip" title="" data-html="1" data-trigger="hover focus" data-placement="top" href="#" data-original-title="This is a tooltip">natus</a> error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi <a rel="tooltip" title="" data-html="1" data-trigger="hover focus" data-placement="bottom" href="#" data-original-title="This is also a tooltip">architecto</a> beatae vitae dicta sunt explicabo.</p>
							</div>

							<div class="col-md-5">
								<p>Sed ut <span class="label label-primary">perspiciatis</span> unde omnis iste <span class="label label-default">natus</span> <span class="label label-warning">error</span> sit voluptatem accusantium doloremque laudantium, <span class="label label-info">totam</span> rem aperiam, eaque ipsa quae ab illo <span class="label label-danger">inventore</span> veritatis et quasi architecto beatae vitae dicta <span class="label label-success">sunt</span> explicabo.</p>
							</div>

						</div>

					</div>

				</div>







				
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
      <div class="section-row three-quarters-padding-bottom page-title">

					<div class="container-fluid">

						<div class="row">

							<div class="col-md-12">

								<h1 class="section-title text-center">
									Icons
									<small>Bootstrap includes 200+ icons</small>
								</h1>

							</div>

						</div>

					</div>

				</div>          
                
                
   <div class="section-row three-quarters-padding-top three-quarters-padding-bottom">

					<div class="container-fluid">

						<div class="row">

							<div class="col-md-12">
								<h4 class="section-subtitle">Glyphicons</h4>
<style>
.bs-glyphicons-list {
padding-left: 0;
list-style: none;
}
.bs-glyphicons {
margin: 0 -19px 20px -16px;
overflow: hidden;
}
.bs-glyphicons li {
float: left;
width: 25%;
height: 115px;
padding: 10px;
font-size: 10px;
line-height: 1.4;
text-align: center;
border: 1px solid #fff;
background-color: #f9f9f9;
}
.bs-glyphicons .glyphicon {
margin-top: 5px;
margin-bottom: 10px;
font-size: 45px;
}
.bs-glyphicons .glyphicon-class {
display: block;
text-align: center;
word-wrap: break-word;
}
</style>
<div class="bs-glyphicons">
    <ul class="bs-glyphicons-list">
      
        <li>
          <span class="glyphicon glyphicon-asterisk"></span>
          <span class="glyphicon-class">glyphicon glyphicon-asterisk</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-plus"></span>
          <span class="glyphicon-class">glyphicon glyphicon-plus</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-euro"></span>
          <span class="glyphicon-class">glyphicon glyphicon-euro</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-minus"></span>
          <span class="glyphicon-class">glyphicon glyphicon-minus</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-cloud"></span>
          <span class="glyphicon-class">glyphicon glyphicon-cloud</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-envelope"></span>
          <span class="glyphicon-class">glyphicon glyphicon-envelope</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-pencil"></span>
          <span class="glyphicon-class">glyphicon glyphicon-pencil</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-glass"></span>
          <span class="glyphicon-class">glyphicon glyphicon-glass</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-music"></span>
          <span class="glyphicon-class">glyphicon glyphicon-music</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-search"></span>
          <span class="glyphicon-class">glyphicon glyphicon-search</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-heart"></span>
          <span class="glyphicon-class">glyphicon glyphicon-heart</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-star"></span>
          <span class="glyphicon-class">glyphicon glyphicon-star</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-star-empty"></span>
          <span class="glyphicon-class">glyphicon glyphicon-star-empty</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-user"></span>
          <span class="glyphicon-class">glyphicon glyphicon-user</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-film"></span>
          <span class="glyphicon-class">glyphicon glyphicon-film</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-th-large"></span>
          <span class="glyphicon-class">glyphicon glyphicon-th-large</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-th"></span>
          <span class="glyphicon-class">glyphicon glyphicon-th</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-th-list"></span>
          <span class="glyphicon-class">glyphicon glyphicon-th-list</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-ok"></span>
          <span class="glyphicon-class">glyphicon glyphicon-ok</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-remove"></span>
          <span class="glyphicon-class">glyphicon glyphicon-remove</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-zoom-in"></span>
          <span class="glyphicon-class">glyphicon glyphicon-zoom-in</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-zoom-out"></span>
          <span class="glyphicon-class">glyphicon glyphicon-zoom-out</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-off"></span>
          <span class="glyphicon-class">glyphicon glyphicon-off</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-signal"></span>
          <span class="glyphicon-class">glyphicon glyphicon-signal</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-cog"></span>
          <span class="glyphicon-class">glyphicon glyphicon-cog</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-trash"></span>
          <span class="glyphicon-class">glyphicon glyphicon-trash</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-home"></span>
          <span class="glyphicon-class">glyphicon glyphicon-home</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-file"></span>
          <span class="glyphicon-class">glyphicon glyphicon-file</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-time"></span>
          <span class="glyphicon-class">glyphicon glyphicon-time</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-road"></span>
          <span class="glyphicon-class">glyphicon glyphicon-road</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-download-alt"></span>
          <span class="glyphicon-class">glyphicon glyphicon-download-alt</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-download"></span>
          <span class="glyphicon-class">glyphicon glyphicon-download</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-upload"></span>
          <span class="glyphicon-class">glyphicon glyphicon-upload</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-inbox"></span>
          <span class="glyphicon-class">glyphicon glyphicon-inbox</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-play-circle"></span>
          <span class="glyphicon-class">glyphicon glyphicon-play-circle</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-repeat"></span>
          <span class="glyphicon-class">glyphicon glyphicon-repeat</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-refresh"></span>
          <span class="glyphicon-class">glyphicon glyphicon-refresh</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-list-alt"></span>
          <span class="glyphicon-class">glyphicon glyphicon-list-alt</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-lock"></span>
          <span class="glyphicon-class">glyphicon glyphicon-lock</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-flag"></span>
          <span class="glyphicon-class">glyphicon glyphicon-flag</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-headphones"></span>
          <span class="glyphicon-class">glyphicon glyphicon-headphones</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-volume-off"></span>
          <span class="glyphicon-class">glyphicon glyphicon-volume-off</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-volume-down"></span>
          <span class="glyphicon-class">glyphicon glyphicon-volume-down</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-volume-up"></span>
          <span class="glyphicon-class">glyphicon glyphicon-volume-up</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-qrcode"></span>
          <span class="glyphicon-class">glyphicon glyphicon-qrcode</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-barcode"></span>
          <span class="glyphicon-class">glyphicon glyphicon-barcode</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-tag"></span>
          <span class="glyphicon-class">glyphicon glyphicon-tag</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-tags"></span>
          <span class="glyphicon-class">glyphicon glyphicon-tags</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-book"></span>
          <span class="glyphicon-class">glyphicon glyphicon-book</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-bookmark"></span>
          <span class="glyphicon-class">glyphicon glyphicon-bookmark</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-print"></span>
          <span class="glyphicon-class">glyphicon glyphicon-print</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-camera"></span>
          <span class="glyphicon-class">glyphicon glyphicon-camera</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-font"></span>
          <span class="glyphicon-class">glyphicon glyphicon-font</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-bold"></span>
          <span class="glyphicon-class">glyphicon glyphicon-bold</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-italic"></span>
          <span class="glyphicon-class">glyphicon glyphicon-italic</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-text-height"></span>
          <span class="glyphicon-class">glyphicon glyphicon-text-height</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-text-width"></span>
          <span class="glyphicon-class">glyphicon glyphicon-text-width</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-align-left"></span>
          <span class="glyphicon-class">glyphicon glyphicon-align-left</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-align-center"></span>
          <span class="glyphicon-class">glyphicon glyphicon-align-center</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-align-right"></span>
          <span class="glyphicon-class">glyphicon glyphicon-align-right</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-align-justify"></span>
          <span class="glyphicon-class">glyphicon glyphicon-align-justify</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-list"></span>
          <span class="glyphicon-class">glyphicon glyphicon-list</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-indent-left"></span>
          <span class="glyphicon-class">glyphicon glyphicon-indent-left</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-indent-right"></span>
          <span class="glyphicon-class">glyphicon glyphicon-indent-right</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-facetime-video"></span>
          <span class="glyphicon-class">glyphicon glyphicon-facetime-video</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-picture"></span>
          <span class="glyphicon-class">glyphicon glyphicon-picture</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-map-marker"></span>
          <span class="glyphicon-class">glyphicon glyphicon-map-marker</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-adjust"></span>
          <span class="glyphicon-class">glyphicon glyphicon-adjust</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-tint"></span>
          <span class="glyphicon-class">glyphicon glyphicon-tint</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-edit"></span>
          <span class="glyphicon-class">glyphicon glyphicon-edit</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-share"></span>
          <span class="glyphicon-class">glyphicon glyphicon-share</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-check"></span>
          <span class="glyphicon-class">glyphicon glyphicon-check</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-move"></span>
          <span class="glyphicon-class">glyphicon glyphicon-move</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-step-backward"></span>
          <span class="glyphicon-class">glyphicon glyphicon-step-backward</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-fast-backward"></span>
          <span class="glyphicon-class">glyphicon glyphicon-fast-backward</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-backward"></span>
          <span class="glyphicon-class">glyphicon glyphicon-backward</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-play"></span>
          <span class="glyphicon-class">glyphicon glyphicon-play</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-pause"></span>
          <span class="glyphicon-class">glyphicon glyphicon-pause</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-stop"></span>
          <span class="glyphicon-class">glyphicon glyphicon-stop</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-forward"></span>
          <span class="glyphicon-class">glyphicon glyphicon-forward</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-fast-forward"></span>
          <span class="glyphicon-class">glyphicon glyphicon-fast-forward</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-step-forward"></span>
          <span class="glyphicon-class">glyphicon glyphicon-step-forward</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-eject"></span>
          <span class="glyphicon-class">glyphicon glyphicon-eject</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-chevron-left"></span>
          <span class="glyphicon-class">glyphicon glyphicon-chevron-left</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-chevron-right"></span>
          <span class="glyphicon-class">glyphicon glyphicon-chevron-right</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-plus-sign"></span>
          <span class="glyphicon-class">glyphicon glyphicon-plus-sign</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-minus-sign"></span>
          <span class="glyphicon-class">glyphicon glyphicon-minus-sign</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-remove-sign"></span>
          <span class="glyphicon-class">glyphicon glyphicon-remove-sign</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-ok-sign"></span>
          <span class="glyphicon-class">glyphicon glyphicon-ok-sign</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-question-sign"></span>
          <span class="glyphicon-class">glyphicon glyphicon-question-sign</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-info-sign"></span>
          <span class="glyphicon-class">glyphicon glyphicon-info-sign</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-screenshot"></span>
          <span class="glyphicon-class">glyphicon glyphicon-screenshot</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-remove-circle"></span>
          <span class="glyphicon-class">glyphicon glyphicon-remove-circle</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-ok-circle"></span>
          <span class="glyphicon-class">glyphicon glyphicon-ok-circle</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-ban-circle"></span>
          <span class="glyphicon-class">glyphicon glyphicon-ban-circle</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-arrow-left"></span>
          <span class="glyphicon-class">glyphicon glyphicon-arrow-left</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-arrow-right"></span>
          <span class="glyphicon-class">glyphicon glyphicon-arrow-right</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-arrow-up"></span>
          <span class="glyphicon-class">glyphicon glyphicon-arrow-up</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-arrow-down"></span>
          <span class="glyphicon-class">glyphicon glyphicon-arrow-down</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-share-alt"></span>
          <span class="glyphicon-class">glyphicon glyphicon-share-alt</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-resize-full"></span>
          <span class="glyphicon-class">glyphicon glyphicon-resize-full</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-resize-small"></span>
          <span class="glyphicon-class">glyphicon glyphicon-resize-small</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-exclamation-sign"></span>
          <span class="glyphicon-class">glyphicon glyphicon-exclamation-sign</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-gift"></span>
          <span class="glyphicon-class">glyphicon glyphicon-gift</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-leaf"></span>
          <span class="glyphicon-class">glyphicon glyphicon-leaf</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-fire"></span>
          <span class="glyphicon-class">glyphicon glyphicon-fire</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-eye-open"></span>
          <span class="glyphicon-class">glyphicon glyphicon-eye-open</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-eye-close"></span>
          <span class="glyphicon-class">glyphicon glyphicon-eye-close</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-warning-sign"></span>
          <span class="glyphicon-class">glyphicon glyphicon-warning-sign</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-plane"></span>
          <span class="glyphicon-class">glyphicon glyphicon-plane</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-calendar"></span>
          <span class="glyphicon-class">glyphicon glyphicon-calendar</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-random"></span>
          <span class="glyphicon-class">glyphicon glyphicon-random</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-comment"></span>
          <span class="glyphicon-class">glyphicon glyphicon-comment</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-magnet"></span>
          <span class="glyphicon-class">glyphicon glyphicon-magnet</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-chevron-up"></span>
          <span class="glyphicon-class">glyphicon glyphicon-chevron-up</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-chevron-down"></span>
          <span class="glyphicon-class">glyphicon glyphicon-chevron-down</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-retweet"></span>
          <span class="glyphicon-class">glyphicon glyphicon-retweet</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-shopping-cart"></span>
          <span class="glyphicon-class">glyphicon glyphicon-shopping-cart</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-folder-close"></span>
          <span class="glyphicon-class">glyphicon glyphicon-folder-close</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-folder-open"></span>
          <span class="glyphicon-class">glyphicon glyphicon-folder-open</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-resize-vertical"></span>
          <span class="glyphicon-class">glyphicon glyphicon-resize-vertical</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-resize-horizontal"></span>
          <span class="glyphicon-class">glyphicon glyphicon-resize-horizontal</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-hdd"></span>
          <span class="glyphicon-class">glyphicon glyphicon-hdd</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-bullhorn"></span>
          <span class="glyphicon-class">glyphicon glyphicon-bullhorn</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-bell"></span>
          <span class="glyphicon-class">glyphicon glyphicon-bell</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-certificate"></span>
          <span class="glyphicon-class">glyphicon glyphicon-certificate</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-thumbs-up"></span>
          <span class="glyphicon-class">glyphicon glyphicon-thumbs-up</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-thumbs-down"></span>
          <span class="glyphicon-class">glyphicon glyphicon-thumbs-down</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-hand-right"></span>
          <span class="glyphicon-class">glyphicon glyphicon-hand-right</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-hand-left"></span>
          <span class="glyphicon-class">glyphicon glyphicon-hand-left</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-hand-up"></span>
          <span class="glyphicon-class">glyphicon glyphicon-hand-up</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-hand-down"></span>
          <span class="glyphicon-class">glyphicon glyphicon-hand-down</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-circle-arrow-right"></span>
          <span class="glyphicon-class">glyphicon glyphicon-circle-arrow-right</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-circle-arrow-left"></span>
          <span class="glyphicon-class">glyphicon glyphicon-circle-arrow-left</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-circle-arrow-up"></span>
          <span class="glyphicon-class">glyphicon glyphicon-circle-arrow-up</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-circle-arrow-down"></span>
          <span class="glyphicon-class">glyphicon glyphicon-circle-arrow-down</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-globe"></span>
          <span class="glyphicon-class">glyphicon glyphicon-globe</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-wrench"></span>
          <span class="glyphicon-class">glyphicon glyphicon-wrench</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-tasks"></span>
          <span class="glyphicon-class">glyphicon glyphicon-tasks</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-filter"></span>
          <span class="glyphicon-class">glyphicon glyphicon-filter</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-briefcase"></span>
          <span class="glyphicon-class">glyphicon glyphicon-briefcase</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-fullscreen"></span>
          <span class="glyphicon-class">glyphicon glyphicon-fullscreen</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-dashboard"></span>
          <span class="glyphicon-class">glyphicon glyphicon-dashboard</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-paperclip"></span>
          <span class="glyphicon-class">glyphicon glyphicon-paperclip</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-heart-empty"></span>
          <span class="glyphicon-class">glyphicon glyphicon-heart-empty</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-link"></span>
          <span class="glyphicon-class">glyphicon glyphicon-link</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-phone"></span>
          <span class="glyphicon-class">glyphicon glyphicon-phone</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-pushpin"></span>
          <span class="glyphicon-class">glyphicon glyphicon-pushpin</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-usd"></span>
          <span class="glyphicon-class">glyphicon glyphicon-usd</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-gbp"></span>
          <span class="glyphicon-class">glyphicon glyphicon-gbp</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-sort"></span>
          <span class="glyphicon-class">glyphicon glyphicon-sort</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-sort-by-alphabet"></span>
          <span class="glyphicon-class">glyphicon glyphicon-sort-by-alphabet</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-sort-by-alphabet-alt"></span>
          <span class="glyphicon-class">glyphicon glyphicon-sort-by-alphabet-alt</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-sort-by-order"></span>
          <span class="glyphicon-class">glyphicon glyphicon-sort-by-order</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-sort-by-order-alt"></span>
          <span class="glyphicon-class">glyphicon glyphicon-sort-by-order-alt</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-sort-by-attributes"></span>
          <span class="glyphicon-class">glyphicon glyphicon-sort-by-attributes</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-sort-by-attributes-alt"></span>
          <span class="glyphicon-class">glyphicon glyphicon-sort-by-attributes-alt</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-unchecked"></span>
          <span class="glyphicon-class">glyphicon glyphicon-unchecked</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-expand"></span>
          <span class="glyphicon-class">glyphicon glyphicon-expand</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-collapse-down"></span>
          <span class="glyphicon-class">glyphicon glyphicon-collapse-down</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-collapse-up"></span>
          <span class="glyphicon-class">glyphicon glyphicon-collapse-up</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-log-in"></span>
          <span class="glyphicon-class">glyphicon glyphicon-log-in</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-flash"></span>
          <span class="glyphicon-class">glyphicon glyphicon-flash</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-log-out"></span>
          <span class="glyphicon-class">glyphicon glyphicon-log-out</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-new-window"></span>
          <span class="glyphicon-class">glyphicon glyphicon-new-window</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-record"></span>
          <span class="glyphicon-class">glyphicon glyphicon-record</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-save"></span>
          <span class="glyphicon-class">glyphicon glyphicon-save</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-open"></span>
          <span class="glyphicon-class">glyphicon glyphicon-open</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-saved"></span>
          <span class="glyphicon-class">glyphicon glyphicon-saved</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-import"></span>
          <span class="glyphicon-class">glyphicon glyphicon-import</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-export"></span>
          <span class="glyphicon-class">glyphicon glyphicon-export</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-send"></span>
          <span class="glyphicon-class">glyphicon glyphicon-send</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-floppy-disk"></span>
          <span class="glyphicon-class">glyphicon glyphicon-floppy-disk</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-floppy-saved"></span>
          <span class="glyphicon-class">glyphicon glyphicon-floppy-saved</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-floppy-remove"></span>
          <span class="glyphicon-class">glyphicon glyphicon-floppy-remove</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-floppy-save"></span>
          <span class="glyphicon-class">glyphicon glyphicon-floppy-save</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-floppy-open"></span>
          <span class="glyphicon-class">glyphicon glyphicon-floppy-open</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-credit-card"></span>
          <span class="glyphicon-class">glyphicon glyphicon-credit-card</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-transfer"></span>
          <span class="glyphicon-class">glyphicon glyphicon-transfer</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-cutlery"></span>
          <span class="glyphicon-class">glyphicon glyphicon-cutlery</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-header"></span>
          <span class="glyphicon-class">glyphicon glyphicon-header</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-compressed"></span>
          <span class="glyphicon-class">glyphicon glyphicon-compressed</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-earphone"></span>
          <span class="glyphicon-class">glyphicon glyphicon-earphone</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-phone-alt"></span>
          <span class="glyphicon-class">glyphicon glyphicon-phone-alt</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-tower"></span>
          <span class="glyphicon-class">glyphicon glyphicon-tower</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-stats"></span>
          <span class="glyphicon-class">glyphicon glyphicon-stats</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-sd-video"></span>
          <span class="glyphicon-class">glyphicon glyphicon-sd-video</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-hd-video"></span>
          <span class="glyphicon-class">glyphicon glyphicon-hd-video</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-subtitles"></span>
          <span class="glyphicon-class">glyphicon glyphicon-subtitles</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-sound-stereo"></span>
          <span class="glyphicon-class">glyphicon glyphicon-sound-stereo</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-sound-dolby"></span>
          <span class="glyphicon-class">glyphicon glyphicon-sound-dolby</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-sound-5-1"></span>
          <span class="glyphicon-class">glyphicon glyphicon-sound-5-1</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-sound-6-1"></span>
          <span class="glyphicon-class">glyphicon glyphicon-sound-6-1</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-sound-7-1"></span>
          <span class="glyphicon-class">glyphicon glyphicon-sound-7-1</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-copyright-mark"></span>
          <span class="glyphicon-class">glyphicon glyphicon-copyright-mark</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-registration-mark"></span>
          <span class="glyphicon-class">glyphicon glyphicon-registration-mark</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-cloud-download"></span>
          <span class="glyphicon-class">glyphicon glyphicon-cloud-download</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-cloud-upload"></span>
          <span class="glyphicon-class">glyphicon glyphicon-cloud-upload</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-tree-conifer"></span>
          <span class="glyphicon-class">glyphicon glyphicon-tree-conifer</span>
        </li>
      
        <li>
          <span class="glyphicon glyphicon-tree-deciduous"></span>
          <span class="glyphicon-class">glyphicon glyphicon-tree-deciduous</span>
        </li>
      
    </ul>
  </div>


							</div>

						</div>

					</div>

				</div>             
                
                
                
                
                
                
                
           	
</div>	
<div class="clearfix"></div>     
</div>             
</div>                  
                
 
		
		<?php get_footer($CORE->pageswitch());
	
	// THAT'S ALL FOLKS! 
 
/* =============================================================================
   -- END FILE
   ========================================================================== */
?>
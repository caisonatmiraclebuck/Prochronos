<?php

class PT_Users extends PT_Shortcode{
	
	public $icon = '<span class="fa fa-user"></span>';
	public $name = 'Users';
	public $description = 'Add a display of users';
	public $category = 'MISC';
	public $image;
	public $default_options = array(
	 
		'style' => '1', 
		'userids' => '0',
		'element_name' => 'Users',
		'extra_class' => ''
	);		

	function __construct(){
		parent::__construct();
	}
	

	public function shortcode_frontend( $atts, $content ){
		extract( shortcode_atts( $this->default_options, $atts ) ); $i =1; $demoUsers = false;
		
		$demousers = array(
		
		1 => array("name" => "John Doe", "desc" => "CEO Founder", "img" => "http://premiumpress.com/_builder/img/u1.jpg"),
		2 => array("name" => "Jane Doe", "desc" => "General Manager", "img" => "http://premiumpress.com/_builder/img/u2.jpg"),
		3 => array("name" => "Pete Tong", "desc" => "Marketing", "img" => "http://premiumpress.com/_builder/img/u3.jpg"),
		4 => array("name" => "Marie Jane", "desc" => "Sales Team", "img" => "http://premiumpress.com/_builder/img/u4.jpg"),
		
		);
		 
		if($userids == "0"){ $userids = "1,2,3,4"; $demoUsers = true; }
		// GET USER DATA
		$userbits = explode(",", $userids);
		ob_start();
		?>

        <div class="clearfix"></div>
        
        <?php		
		if(!empty($userbits)){
			
			foreach($userbits as $id){
			
			if($userids != "0"){
			$user = get_userdata( $id );
			} 
			
		?>
 
        <div class="aboutus1">
        
            <div class="col-md-3">
            
                <div class="userbox">
                
                    <div class="userimg">
                    
                    <?php if($demoUsers){ ?>
                    
                    <img src="<?php echo $demousers[$i]['img']; ?>" class="img-responsive" />
                    
                    <?php }else{ echo str_replace("avatar ","avatar img-responsive ",get_avatar( $id, 250 )); } ?>
                    
                    </div>
                
                    <div class="userinfo">
                    
                    <h5><?php if($demoUsers){ echo $demousers[$i]['name'];  }else{ echo $user->display_name; } ?></h5>
                    
                    <small><?php if($demoUsers){ echo $demousers[$i]['desc'];  }else{ echo $user->description; } ?></small>
                    
                    <ul class="list-inline">           
                    
                       <?php
                        
                        // URL
                        $data = get_user_meta( $id, 'url', true);
                        if(strlen($data) > 0 || $demoUsers){ 
                        echo "<li><a href='".$data."' rel='nofollow' target='_blank'><i class='fa fa-link'></i></a></li>"; 
                        } 
                        
                        // FACEBOOK
                        $data = get_user_meta( $id, 'facebook', true);
                        if(strlen($data) > 0 || $demoUsers){ 
                        echo "<li><a href='".$data."' rel='nofollow' target='_blank'><i class='fa fa-facebook'></i></a></li>"; 
                        }  	
                        
                        // TWITTER
                        $data = get_user_meta( $id, 'twitter', true);
                        if(strlen($data) > 0 || $demoUsers){ 
                        echo "<li><a href='".$data."' rel='nofollow' target='_blank'><i class='fa fa-twitter'></i></a></li>"; 
                        }  		
                        
                        // LINKEDIN
                        $data = get_user_meta( $id, 'linkedin', true);
                        if(strlen($data) > 0 || $demoUsers){ 
                        echo "<li><a href='".$data."' rel='nofollow' target='_blank'><i class='fa fa-linkedin'></i></a></li>"; 
                        }
                        
                        ?>
                      
                     </ul>
                     
                    </div>
                    
                </div>
                
            </div>
        
        </div>
        
        <?php
		
		$i++; } }
		
		
		return ob_get_clean();
	}

	public function shortcode_options( $atts ){
		extract( shortcode_atts( $this->default_options, $atts ) );
		$options = array(
			array(
				'id' => 'element_name',
				'title' => __( 'Element Name', 'pt-builder' ),
				'desc' => __( 'Input custom element name for easy recognition.', 'pt-builder' ),
				'type' => 'textfield',
				'value' => $element_name
			),
	 
			array(
				'id' => 'style',
				'title' => __( 'Display Style', 'pt-builder' ),
				'desc' => __( 'Select progressbar style.', 'pt-builder' ),
				'type' => 'select',
				'options' => array(
					'1' => __( 'Style 1', 'pt-builder' ),
					//'2' => __( 'Style 2', 'pt-builder' ),
					 
				),
				'value' => $style
			),
			array(
				'id' => 'userids',
				'title' => __( 'User ID', 'pt-builder' ),
				'desc' => __( 'Input user ID, seperate with a comma for multple users.', 'pt-builder' ),
				'type' => 'textfield',
				'value' => $userids
			),
 		
			array(
				'id' => 'extra_class',
				'title' => __( 'Extra Class', 'pt-builder' ),
				'desc' => __( 'Input extra class for the element.', 'pt-builder' ),
				'type' => 'textfield',
				'value' => $extra_class
			),			
		);
		
		$options_html = new PT_Options( $options );
		
		return $options_html->get_options();
	}	
}

?>
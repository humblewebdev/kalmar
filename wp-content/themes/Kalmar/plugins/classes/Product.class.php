<?php
class Product {
	public static function addProduct($productName, $productImage, $productDescription, $isMil) {
		/* ##### Checking to see if name already exists ##### */
		global $wpdb;
		$table = ($isMil ? 'mil_product' : 'comm_product');
		
		$item = ($isMil ? 'mil_product_name' : 'comm_product_name');
		$myrows = $wpdb->get_results ( "SELECT $item from  $wpdb->prefix$table where $item = '$productName'" );
		if (count ( $myrows ) > 0) {
			return (- 1);
		} else {
			try {
				$name = $productName;
				$image = $productImage;
				$description = $productDescription;
				$wpdb->insert ( 'wp_dummy_sitemil_product', array (
						'mil_product_name' => $productName,
						'mil_product_image' => $productImage,
						'mil_product_desc' => $productDescription 
				) );
				return $wpdb->insert_id;
			} catch ( Exception $e ) {
				
				$fh = fopen ( get_theme_root () . '/Kalmar/plugins/errorlog.txt', 'a+' );
				
				$error = <<<EOL

timeStamp: "time()"
Message: {$e->getMessage()}
Code: {$e->getCode()}
File: {$e->getFile()}
Line: {$e->getLine()}

EOL;
				
				fwrite ( $fh, $error ); // write to txtfile
				
				fclose ( $fh );
				
				return (- 1);
			}
		}
	}
	
	public static function addCommProduct($productName, $productImage, $productDescription, $isMil) {
		/* ##### Checking to see if name already exists ##### */
		global $wpdb;
		$myrows = $wpdb->get_results ( "SELECT 'comm_product_name' from  $wpdb->prefix'comm_product' where $item = '$productName'" );
		if (count ( $myrows ) > 0) {
			return (- 1);
		} else {
			try {
				$name = $productName;
				$image = $productImage;
				$description = $productDescription;
				$wpdb->insert ( 'wp_dummy_sitecomm_product', array (
						'comm_product_name' => $productName,
						'comm_product_image' => $productImage,
						'comm_product_desc' => $productDescription 
				) );
				return $wpdb->insert_id;
			} catch ( Exception $e ) {
				
				$fh = fopen ( get_theme_root () . '/Kalmar/plugins/errorlog.txt', 'a+' );
				
				$error = <<<EOL

timeStamp: "time()"
Message: {$e->getMessage()}
Code: {$e->getCode()}
File: {$e->getFile()}
Line: {$e->getLine()}

EOL;
				
				fwrite ( $fh, $error ); // write to txtfile
				
				fclose ( $fh );
				
				return (- 1);
			}
		}
	}
	
	public static function deleteProduct($productID) {
		return boolean;
	}
	public static function editProduct($productID, $productName, $productImage, $productDescription) {
		return boolean;
	}
	public static function createProductPage($product, $features, $specs, $gallery) {
		
$menu = <<<EOL
			<ul>
				<li><a href="#collapseOne" data-toggle="collapse"
					data-parent="#accordion">Features</a></li>
				<li><a href="#collapseTwo" data-toggle="collapse"
					data-parent="#accordion">Specs</a></li>
				<li><a href="#collapseThree" data-toggle="collapse"
					data-parent="#accordion">Gallery</a></li>
				<li><a href="#">Download Brochure</a></li>
			</ul>		
EOL;


$features = <<<EOL

	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a href="#collapseOne" data-toggle="collapse"
					data-parent="#accordion"> Features </a>
			</h4>
		</div>
		<div class="panel-collapse collapse" id="collapseThree">
			<div class="panel-body">
				
			</div>
		</div>
	</div>
		
EOL;

$SpecsTables;//create specs tables from supplied info

$specs = <<<EOL

	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a href="#collapseTwo" data-toggle="collapse"
					data-parent="#accordion"> Specs </a>
			</h4>
		</div>
		<div class="panel-collapse collapse" id="collapseThree">
			<div class="panel-body">
				<table class="table table-striped">
					<th>
						<td>Engine</td>
					</th>
					<tr>
						<td>
						<td>
					</tr>
				</table>
		
				<table class="table table-striped">
					<th>
						<td>Performance</td>
					</th>
					<tr>
						<td>
						<td>
					</tr>
				</table>
		
		
				<table class="table table-striped">
					<th>
						<td>Transmission</td>
					</th>
					<tr>
						<td>
						<td>
					</tr>
				</table>
		
		
				<table class="table table-striped">
					<th>
						<td>Weight</td>
					</th>
					<tr>
						<td>
						<td>
					</tr>
				</table>
		
		
				<table class="table table-striped">
					<th>
						<td>Axles</td>
					</th>
					<tr>
						<td>
						<td>
					</tr>
				</table>
		
		
				<table class="table table-striped">
					<th>
						<td>Service Capabilities</td>
					</th>
					<tr>
						<td>
						<td>
					</tr>
				</table>
		
		
				<table class="table table-striped">
					<th>
						<td>Brakes</td>
					</th>
					<tr>
						<td>
						<td>
					</tr>
				</table>
		
		
				<table class="table table-striped">
					<th>
						<td>Additional Data</td>
					</th>
					<tr>
						<td>
						<td>
					</tr>
				</table>
		
				<a class="btn btn-primary" href="#">Download Specs</a>
			</div>
		</div>
	</div>

EOL;

$Gallery = <<<EOL
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a href="#collapseThree" data-toggle="collapse"
					data-parent="#accordion"> GALLERY </a>
			</h4>
		</div>
		<div class="panel-collapse collapse" id="collapseThree">
			<div class="panel-body">
				<div class="row">
					<img class="img-rounded" alt="..." src="..." />
					<img class="img-rounded" alt="..." src="..." /> 
					<img class="img-rounded" alt="..." src="..." /> 
					<img class="img-rounded" alt="..." src="..." />
				</div>
				
				<div class="row">
					<iframe></iframe>
					<iframe></iframe>
					<iframe></iframe>
				</div>
			</div>
		</div>
	</div>
EOL;
		
		
		
		$template = <<<EOL

<div class="row">
	<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
		<div class="red_box">
			{$menu}
		</div>
		<div class="black_box">
			<h1>For MORE INFO</h1>
			<a class="btn btn-danger" href="#">REQUEST A QUOTE</a> OR CALL
			<h2>800-232-1236</h2>
		</div>
	</div>
	<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
		<div class="panel-group" id="accordion">
			{$features}
			{$specs}
			{$gallery}
		</div>
	</div>
</div>

EOL;
		
		
		
		/*$post = array(
				'comment_status' => [ 'closed'], // 'closed' means no comments.
				'ping_status'    => ['open' ], // 'closed' means pingbacks or trackbacks turned off
				'post_author'    => [ ''], //The user ID number of the author.###
				'post_content'   => [ $template], //The full text of the post.###
				'post_date'      => [ Y-m-d H:i:s ], //The time post was made.###
				'post_date_gmt'  => [ Y-m-d H:i:s ], //The time post was made, in GMT.###
				'post_name'      => [ <the name> ], // The name (slug) for your post###
				'post_status'    => [ 'publish'], //Set the status of the new post.
				'post_title'     => [ <the title> ], //The title of your post.###
				'post_type'      => [ 'page'] //You may want to insert a regular post, page, link, a menu item or some custom post type
		);*/
	}
}
?>
<?php 
require_once '../core/init.php';
$id = $_POST['id'];
$id = (int)$id;
$sql = "SELECT * FROM products WHERE id = '$id'";
$result = $db->query($sql);
$product = mysqli_fetch_assoc($result);
$brand_id = $product['brand'];
$sql = "SELECT brand FROM brands WHERE id = '$brand_id'";
$brand_query = $db->query($sql);
$brand = mysqli_fetch_assoc($brand_query);
$sizestring = $product['sizes'];
$sizestring = rtrim($sizestring,',');
$size_array = explode(',', $sizestring);
?>
<!-- Details Modal -->
<?php ob_start(); ?>
<div class="modal fade details-1" id="details-modal" tabindex="-1" role="dialog" aria-labelledby="details-1" aria-hidden="true">

	<div class="modal-dialog modal-lg">
		<div class="modal-content">
		<div class="modal-header">
			<h4 class="modal-title text-center"><?= $product['title']; ?></h4>
			<button class="close" type="button" onclick="closeModal()" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<div class="container-fluid">
				<span id="modal_errors"></span>
				<div class="row">
					<div class="col-sm-6">
						<div class="d-flex justify-content-center align-items-center">
							<img src="<?= $product['image']; ?>" alt="<?= $product['title']; ?>" class="details img-responsive">
						</div>
					</div>
					<div class="col-sm-6">
						<h4>Details</h4>
						<p><?= nl2br($product['description']); ?></p>
						<hr>
						<p>Price: $<?= $product['price']; ?></p>
						<p>Brand: <?= $brand['brand']; ?></p>
						<form action="add_cart.php" method="post" id="add_product_form">
							<input type="hidden" name="product_id" value="<?=$id;?>">
							<input type="hidden" name="available" id="available" value="">					
							<div class="form-group">
								<div class="col-xs-3">
									<label for="quantity">Quantity:</label>
									<input type="number" class="form-control" id="quantity" name="quantity" min="1">
								</div>
							</div>
							<div class="form-group">
								<label for="size">Size:</label>
								<select name="size" id="size" class="form-control">
									<option value=""></option>
									<?php foreach ($size_array as $string) {
									$string_array = explode(':', $string);
									$size = $string_array[0];
									$available = $string_array[1];
									echo '<option value="'.$size.'" data-available="'.$available.'">'.$size.' ('.$available.' Available)</option>';
									}?>
								</select>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button class="btn btn-default" onclick="closeModal()">Close</button>
			<button class="btn btn-warning" onclick="add_to_cart();return false;">
				<i class="fa fa-shopping-cart icon-white" aria-hidden="true" id="shopping-cart"></i>
				Add To Cart
			</button>
		</div>
	</div>
	</div>
</div>
<script>

	jQuery('#size').change(function(){
		var available = jQuery('#size option:selected').data("available");
		jQuery('#available').val(available);
	});

	function closeModal(){
	jQuery('#details-modal').modal('hide');
	setTimeout(function(){
		jQuery('#details-modal').remove();
		jQuery('.modal-backdrop').remove();
	},500);
	}
</script>
<?php echo ob_get_clean(); ?>

<style>
	img.details{
	width: 70%;
	margin: 15px auto;
}
</style>
<?php
if(isset($_GET)){
	$key=$_GET["kl"];
}
?>


<form metod="post" action="anul_zm_update.php" name="form">
	<table align="" class="zmview">
			<tbody>
				<tr>
					<th colspan="4" style="font-size: 35px;"><b>Анулювання замовлення </b></th>
				</tr>
				<tr>
					<td>Вкажіть причину:</td>
					<td colspan="3">
						<input type="text" name="comment" id="comment" required="" size="35">
						<input type="hidden" name="key" value="<?php echo $key; ?>">
						<input type="hidden" name="pr" value="<?php echo $pr_prie; ?>">
						<input type="hidden" name="im" value="<?php echo $im_prie; ?>">
						<input type="hidden" name="pb" value="<?php echo $pb_prie; ?>">
					</td>
				</tr>
				<tr>
					<td colspan="4" align="center">
						<div id="fizpl"><input type="submit" id="submit" value="Анулювати"></div>
					</td>
				</tr>
		</tbody>
	</table>
</form>
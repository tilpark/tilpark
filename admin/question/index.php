<?php include('../../tilpark.php'); ?>
<?php get_header(); ?>
<?php
add_page_info( 'title', 'Soru-Cevap' );
add_page_info( 'nav', array('name'=>'Soru-Cevap') );
?>


<style>
.question-single {}
.question-single .question {
	font-size: 18px;
}
</style>

<?php
if(isset($_POST['send_question'])) {

	print_r($_POST);
}

?>


<div class="question-single">
	<form name="form-question" id="form-question" action="" method="POST">
		<div class="question">Tanzimat Döneminde "Hürriyet" gazetesini hangi iki sanatçımız çıkartmıştır?</div>
		<div class="h-20"></div>

		<div class="form-group">
			<label><input type="radio" name="answer" id="a" value="a"> Ahmet Mithat Efendi - Ziya Paşa</label>
		</div> <!-- /.form-group -->

		<div class="form-group">
			<label><input type="radio" name="answer" id="b" value="b"> Şinasi - Namık Kemal</label>
		</div> <!-- /.form-group -->

		<div class="form-group">
			<label><input type="radio" name="answer" id="c" value="c"> Namık Kemal - Ziya Paşa</label>
		</div> <!-- /.form-group -->

		<div class="form-group">
			<label><input type="radio" name="answer" id="d" value="d"> Direktör Ali Bey - A. Tarhan</label>
		</div> <!-- /.form-group -->

		<div class="form-group">
			<label><input type="radio" name="answer" id="e" value="e"> Recaizade Mahmut Ekrem - Şinasi</label>
		</div> <!-- /.form-group -->

		<div class="">
			<input type="hidden" name="send_question">
			<button class="btn btn-success">Sıradaki Soru <i class="fa fa-angle-double-right" aria-hidden="true"></i></button>
		</div>
	</form>
</div>


<?php get_footer(); ?>
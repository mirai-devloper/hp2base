<div class="post-password">
	<form action="<?= esc_url(site_url('wp-login.php?action=postpass', 'login_post')); ?>" method="post" class="post-password-form form-inline">
		<p>こちらのコンテンツはパスワードが必要です。<br>パスワードを入力してください。</p>
		<div class="form-group">
			<label for="<?= $label; ?>" class="sr-only">パスワード</label>
			<div class="input-group">
				<input type="password" name="post_password" id="<?= $label; ?>" class="form-control" size="20" placeholder="パスワードを入力" />
				<button type="submit" name="Submit" class="btn btn-theme">送 信</button>
			</div>
		</div>
	</form>
</div>
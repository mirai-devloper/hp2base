<?php

class Lira_Comment extends Walker_Comment
{
	public $tree_type = 'comment';

	public $db_fields = array('parent' => 'comment_parent', 'id' => 'comment_ID');

	// コメントの通し番号を初期化
	public $number = 0;

	public function __construct()
	{
		if ($this->number == 0)
		{
			$comment_count = get_comment_count(get_the_ID());
			$this->number = $comment_count['total_comments'] + 1;
		}
	}
	// Children Start Tag
	public function start_lvl(&$output, $depth = 0, $args = array())
	{
		$GLOBALS['comment_depth'] = $depth + 1;

		$output .= '<ul class="children">';
	}

	// Children End Tag
	public function end_lvl(&$output, $depth = 0, $args = array())
	{
		$GLOBALS['comment_depth'] = $depth + 1;

		$output .= '</ul><!-- .children -->';
	}

	public function start_el(&$output, $comment, $depth = 0, $args = array(), $id = 0)
	{
		$depth++;

		$GLOBALS['comment_depth'] = $depth;
		$GLOBALS['comment'] = $comment;

		// callback/pingback/trackback/short_pingの場合はコメントを出力しない
		if (
			 ! empty($args['callback'])
			or ( 'pingback' == $comment->comment_type or 'trackback' == $comment->comment_type )
			and $args['short_ping']
		)
		{
			return;
		}

		// コメントの通し番号をカウントする
		$this->number--;
		

		ob_start();
		$this->comment($comment, $depth, $args);
		$output .= ob_get_clean();
	}

	public function end_el(&$output, $comment, $depth = 0, $args = array())
	{
		$output .= '</li><!-- #comment-## -->';
	}

	public function comment($comment, $depth, $args)
	{
		// コメントの通し番号をページ単位で調整する
		$cpage = get_query_var('cpage');
		$per_page = get_query_var('comments_per_page');
		$num = $cpage > 1 ? $this->number - ($per_page * ($cpage - 1) ) : $this->number;

		$comment_user = get_userdata($comment->user_id);

		$comment_title = (function_exists('get_field') and get_field('comment_title', $comment)) ? '<h4 class="comment-title">'.get_field('comment_title', $comment).'</h4>' : '';

		$day = array('日','月','火','水','木','金','土');

		$get_comment_args = array(
			'a' => array(
				'href' => array(),
				'title' => array(),
				'target' => array(),
			),
			'em' => array(),
			'strong' => array(),
			'br' => array(),
		);
		?>
		<li <?php comment_class($this->has_children ? 'parent' : '', $comment) ?> id="comment-<?php comment_ID(); ?>">
			<span class="comment-number"><?= $num; ?></span>
			<div class="comment-body">
				<div class="comment-header">
					<?= $comment_title; ?>
					<div class="comment-meta">
						<span class="comment-author">投稿者名：<em><?= (isset($comment_user->display_name) ? $comment_user->display_name : '匿名'); ?></em></span>
						<time class="comment-datetime" datetime="<?php comment_time('c'); ?>">投稿日時：<span class="comment-date"><?php comment_date('Y年m月d日'); ?><?= ' ('.$day[get_comment_date('w')].')'; ?></span></time>
					</div>
				</div>
				<div class="comment-content">
					<p><?= wp_kses(nl2br(get_comment_text()), $get_comment_args); ?></p>
				</div>
				<?php if (is_user_logged_in() and current_user_can('manage_options')) : ?>
					<div class="comment-footer">
						<?php edit_comment_link(__('Edit'), '', ''); ?>
					</div>
				<?php endif; ?>
			</div>
		<?php
	}
}
//<span class="comment-time"> comment_time('H時i分s秒'); </span>

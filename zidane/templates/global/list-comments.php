<?php

$GLOBALS['comment'] = $comment;
$add_below = '';

?>
<li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">

	<div class="the-comment clearfix">
		

		<div class="comment-meta text-center pull-left">
			<?php 

				echo '<div class="avatar">' . get_avatar( $comment, 85 ) . '</div>';
				echo '<span class="title">' . get_comment_author_link() . '</span>';
				echo '<time>' . human_time_diff( get_comment_date('U'), current_time('timestamp') ) . esc_html__(' ago', 'zidane') . '</time>'; 

			?>
		</div>

		<div class="comment-box">

			<div class="comment-text">
				<?php if ($comment->comment_approved == '0') : ?>
				<em><?php echo esc_html__('Your comment is awaiting moderation.', 'zidane') ?></em>
				<br />
				<?php endif; ?>
				<?php comment_text() ?>
			</div>
			<div class="comment-action">
				<?php 
					edit_comment_link( esc_html__('Edit', 'zidane') . ' - ', '  ', '') ;
					
					comment_reply_link( array_merge( 
						$args, 
						array( 
							'reply_text' 	=> esc_html__('Reply', 'zidane') . ' <i class="fa fa-long-arrow-right"></i>', 
							'add_below' 	=> 'comment', 
							'depth' 		=> $depth, 
							'max_depth' 	=> $args['max_depth']
						)
					)); 
				?>
			</div>
		</div>

	</div>
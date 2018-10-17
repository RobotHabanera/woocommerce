<?php echo $args['before_widget']; ?>

	<?php if ( $instance['block'] ) : ?>
		<?php foreach ( $posts as $post ) : ?>
			<div class="latest-news  latest-news--<?php echo esc_attr( $instance['type'] ); ?>">
				<!-- Featured Image -->
				<?php if ( isset( $post['image_url'] ) ) : ?>
					<a  href="<?php echo esc_url( $post['link'] ); ?>">
						<img src="<?php echo esc_url( $post['image_url'] ); ?>" width="<?php echo esc_attr( $post['image_width'] ); ?>" height="<?php echo esc_attr( $post['image_height'] ); ?>" srcset="<?php echo esc_attr( $post['srcset'] ); ?>" sizes="(min-width: 1200px) 350px, (min-width: 992px) 290px, (min-width: 768px) 690px, (min-width: 576px) 510px, calc(100vw - 30px)" class="latest-news__image  wp-post-image" alt="<?php echo esc_attr( $post['title'] ); ?>">
					</a>
				<?php endif; ?>

				<div class="latest-news__content">
					<div class="latest-news__header">
						<!-- Title -->
						<a class="latest-news__title-link" href="<?php echo esc_url( $post['link'] ); ?>">
							<h2 class="latest-news__title">
								<?php echo wp_kses_post( $post['title'] ); ?>
							</h2>
						</a>
						<?php if ( WoonderShopHelpers::is_skin_active( array( 'default' ) ) ) : ?>
							<!-- Categories -->
							<div class="latest-news__categories">
								<?php echo get_the_category_list( ' ', '', $post['id'] ); ?>
							</div>
						<?php endif; ?>
					</div>
					<?php if ( ! empty( $instance['more_news'] ) ) : ?>
						<a href="<?php echo esc_url( $post['link'] ); ?>" class="latest-news__more-news">
							<?php echo wp_kses_post( $text['more_news'] ); ?>
						</a>
					<?php endif; ?>
				</div>
			</div>
		<?php endforeach; ?>
	<?php else : ?>
		<div class="latest-news__container">
			<?php foreach ( $posts as $post ) : ?>
				<a href="<?php echo esc_url( $post['link'] ); ?>" class="latest-news  latest-news--<?php echo esc_attr( $instance['type'] ); ?>">
					<div class="latest-news__content">
						<time class="latest-news__date" datetime="<?php echo esc_attr( $post['full_date_time'] ); ?>">
							<?php echo esc_html( $post['full_date'] ); ?>
						</time>
						<h2 class="latest-news__title"><?php echo wp_kses_post( $post['title'] ); ?></h2>
					</div>
				</a>
			<?php endforeach; ?>

			<?php if ( ! empty( $instance['more_news'] ) ) : ?>
				<a href="<?php echo esc_url( $instance['link_to_more_news'] ); ?>" class="latest-news  latest-news--more-news">
					<?php echo wp_kses_post( $text['more_news'] ); ?>
				</a>
			<?php endif; ?>
		</div>
	<?php endif; ?>

<?php echo $args['after_widget']; ?>

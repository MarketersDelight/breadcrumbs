<nav class="breadcrumbs" aria-label="<?php echo esc_attr__( 'Breadcrumbs', 'md' ); ?>">
	<ol>
		<?php
		$current = count( $breadcrumbs ) - 1;
		$position = 0;

		foreach ( $breadcrumbs as $key => $breadcrumb ) :
			$is_current = $position === $current && empty( $breadcrumb['url'] );
			$class = $key === 'home' ? 'breadcrumbs-home' : 'breadcrumb-' . sanitize_html_class( $key );

			if ( $is_current )
				$class .= ' is-current';
		?>
			<li class="<?php echo esc_attr( $class ); ?>"<?php echo $is_current ? ' aria-current="page" title="' . esc_attr( $breadcrumb['label'] ) . '"' : ''; ?>>
				<?php if ( ! empty( $breadcrumb['url'] ) ) : ?>
					<a href="<?php echo esc_url( $breadcrumb['url'] ); ?>"><?php echo esc_html( $breadcrumb['label'] ); ?></a>
				<?php else : ?>
					<?php echo esc_html( $breadcrumb['label'] ); ?>
				<?php endif; ?>
			</li>
		<?php
			$position++;
		endforeach;
		?>
	</ol>
</nav>

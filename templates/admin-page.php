<div class="md-widget md-toggle mb-single">

    <h3 class="md-widget-title"><?php echo function_exists( 'md_get_dropin_icon' ) ? md_get_dropin_icon( 'breadcrumbs', 'small' ) : ''; ?><span><?php echo __( 'Breadcrumbs', 'md-breadcrumbs' ); ?><span class="md-widget-description"><?php echo __( 'Home label, link style and placement', 'md-breadcrumbs' ); ?></span></span></h3>

    <div class="md-widget-item">

        <div class="mb-third">
            <?php $this->fields->field( 'home_label', array(
                'placeholder' => __( 'Home', 'md-breadcrumbs' ),
                'description' => __( 'Change the first link label in a full breadcrumb trail.', 'md-breadcrumbs' )
            ) ); ?>
        </div>

        <div class="mb-third">
            <?php $this->fields->field( 'simple_link' ); ?>
        </div>

        <div class="mb-third">
            <?php $this->fields->field( 'force_below' ); ?>
        </div>

    </div>

</div>
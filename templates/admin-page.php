<div class="md-widget md-toggle md-sep-small">

    <h3 class="md-widget-title"><?php echo function_exists( 'md_get_dropin_icon' ) ? md_get_dropin_icon( 'breadcrumbs', 'small' ) : ''; ?><?php echo __( 'Breadcrumbs', 'md-breadcrumbs' ); ?></h3>

    <div class="md-widget-item">

        <div class="md-sep-micro">
            <?php $this->fields->field( 'home_label', array(
                'placeholder' => __( 'Home', 'md-breadcrumbs' ),
                'description' => __( 'Change the first link label in a full breadcrumb trail.', 'md-breadcrumbs' )
            ) ); ?>
        </div>

        <div class="md-sep-micro">
            <?php $this->fields->field( 'simple_link' ); ?>
        </div>

        <div class="md-sep-micro">
            <?php $this->fields->field( 'force_below' ); ?>
        </div>

    </div>

</div>
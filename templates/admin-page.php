<div class="md-widget md-toggle md-sep-small">

    <h3 class="md-widget-title"><?php echo __( 'Breadcrumbs', 'md-breadcrumbs' ); ?></h3>

    <div class="md-widget-item">

        <div class="md-sep-micro">
            <?php $this->fields->field( 'home_label', array(
                'type' => 'text',
                'label' => __( 'Home text', 'md-breadcrumbs' ),
                'placeholder' => __( 'Home', 'md-breadcrumbs' ),
                'description' => __( 'Change the first link label in a full breadcrumb trail.', 'md-breadcrumbs' )
            ) ); ?>
        </div>

        <div class="md-sep-micro">
            <?php $this->fields->field( 'simple_link', array(
                'type' => 'checkbox',
                'options' => array(
                    'enable' => __( 'Show a simple Go back link on single posts <b>← All {post type}</b>', 'md-breadcrumbs' )
                )
            ) ); ?>
        </div>

    </div>

</div>
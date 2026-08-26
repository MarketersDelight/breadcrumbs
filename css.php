<style type="text/css">

.breadcrumbs {
	font-size: var(--md-font-size-sm);
	line-height: var(--md-line-height-sm);
	margin-block-end: var(--md-half);
}

.breadcrumbs ol {
	list-style: none;
	overflow-x: scroll;
	scrollbar-width: none;
	white-space: nowrap;
}

.breadcrumbs li {
	display: inline-block;
	margin-block-end: 0;
}

.breadcrumbs li:not(:last-child):after {
	content: '\e80f';
	margin-inline: var(--md-third);
}

.breadcrumbs-home:before {
	content: '\e907';
	margin-inline-end: var(--md-third);
}

.breadcrumbs a { text-decoration: underline; }

.breadcrumbs a:hover { text-decoration: none; }

@media (max-width: 900px) {
	.is-box-style .expanded .breadcrumbs:first-child,
	.is-box-style .cover + .breadcrumbs,
	.is-box-style .compact .breadcrumbs:first-child { margin-block-start: -<?php echo $half; ?>px; }
}

</style>

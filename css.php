<style type="text/css">

.breadcrumbs {
	font-size: var(--md-font-size-sm);
	line-height: var(--md-line-height-sm);
	margin-block-end: var(--md-half);
}

.breadcrumbs ol {
	display: flex;
	list-style: none;
	max-width: 100%;
	overflow-x: scroll;
	scrollbar-width: none;
	white-space: nowrap;
}

.breadcrumbs li {
	flex-shrink: 0;
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

@media (min-width: 800px) {
	.breadcrumbs .is-current {
		flex-shrink: 1;
		min-width: 0;
		overflow: hidden;
		text-overflow: ellipsis;
	}
	body:not(.is-box-style) .expanded .breadcrumbs ol,
	body.archive .expanded .breadcrumbs ol { justify-content: center; }
}

@media (max-width: 900px) {
	.is-box-style .expanded .breadcrumbs:first-child,
	.is-box-style .cover + .breadcrumbs,
	.is-box-style .compact .breadcrumbs:first-child { margin-block-start: -<?php echo $half; ?>px; }
}

</style>

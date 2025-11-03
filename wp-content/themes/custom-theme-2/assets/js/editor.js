( () => {
	window.addEventListener( 'load', () => {
		const toc = document.querySelector( '.acf-editor-toc-placeholder' );
		if ( toc ) {
			toc.textContent = wp.i18n ? wp.i18n.__('Table of contents is generated on the front end.', 'acme') : 'Table of contents is generated on the front end.';
		}
	} );
} )();

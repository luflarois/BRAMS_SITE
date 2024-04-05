/* global vc */
var templatera_editor;
(function ( $ ) {
	'use strict';
	var templateraOptions, templateraPanelSelector, TemplateraPanelEditorBackend, TemplateraPanelEditorFrontend;
	templateraOptions = {
		save_template_action: 'vc_templatera_save_template',
		appendedClass: 'templatera_templates',
		appendedTemplateType: 'templatera_templates',
		delete_template_action: 'vc_templatera_delete_template'
	};
	if ( vc.TemplateWindowUIPanelBackendEditor ) {
		TemplateraPanelEditorBackend = vc.TemplateWindowUIPanelBackendEditor.extend( templateraOptions );
		TemplateraPanelEditorFrontend = vc.TemplateWindowUIPanelFrontendEditor.extend( templateraOptions );
		templateraPanelSelector = '#vc_ui-panel-templates';
	} else {
		TemplateraPanelEditorBackend = vc.TemplatesPanelViewBackend.extend( templateraOptions );
		TemplateraPanelEditorFrontend = vc.TemplatesPanelViewFrontend.extend( templateraOptions );
		templateraPanelSelector = '#vc_templates-panel';
	}

	$( document ).ready( function () {
		// we need to update currect template panel to new one (extend functionality)
		if ( vc_mode && vc_mode === 'admin_page' ) {
			if ( vc.templates_panel_view ) {
				vc.templates_panel_view.undelegateEvents(); // remove is required to detach event listeners and clear memory
				vc.templates_panel_view = templatera_editor = new TemplateraPanelEditorBackend( { el: templateraPanelSelector } );

				$( '#vc-templatera-editor-button' ).click( function ( e ) {
					e && e.preventDefault && e.preventDefault();
					vc.templates_panel_view.render().show(); // make sure we show our window :)
				} );
			}
		}
	} );

	$( window ).on( 'vc_build', function () {
		if ( vc.templates_panel_view ) {
			vc.templates_panel_view.undelegateEvents(); // remove is required to detach event listeners and clear memory
			vc.templates_panel_view = templatera_editor = new TemplateraPanelEditorFrontend( { el: templateraPanelSelector } );

			$( '#vc-templatera-editor-button' ).click( function ( e ) {
				e && e.preventDefault && e.preventDefault();
				vc.templates_panel_view.render().show(); // make sure we show our window :)
			} );
		}
	} );
})( window.jQuery );
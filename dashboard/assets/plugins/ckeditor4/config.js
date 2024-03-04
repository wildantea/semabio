/**
 * @license Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.skin = 'office2013';
	config.extraPlugins = 'lineheight,codemirror,copyformatting,dialog,table,tableresize,liststyle,pagebreak';
	config.contentsCss = 'https://fonts.googleapis.com/css2?family=EB+Garamond&display=swap';
	config.font_names =  'Garamond;'+config.font_names;
	
};
/*
Copyright (c) 2003-2010, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	config.uiColor = '#C4B8A5';

config.toolbar = 'JM1';

	config.toolbar_JM1 =
	[
		['Source','-','NewPage','Preview'],
		['Cut','Copy','Paste','PasteText','PasteFromWord','-','Scayt'],
		['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
		['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
		'/',
		['Styles','Format','FontSize'],
		['Bold','Italic','Strike','-','Subscript','Superscript'],
		['TextColor','BGColor'],
		['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
		['Link','Unlink','Anchor'],
		['Maximize']
	];
};

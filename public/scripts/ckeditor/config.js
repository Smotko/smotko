/*
Copyright (c) 2003-2010, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
    config.toolbar = 'Smotko';
    config.extraPlugins = 'syntaxhighlight';
    config.language = 'sl';
    config.uiColor = '#e5ecf9';
    config.font_style =
    {

        styles		: { 'font-family' : 'Arial, sans-serif', 'font-size' : '16px' }
    };
    config.toolbar_Smotko =
    [

        ['Source'],
        ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
        ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote','CreateDiv'],
        ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
        ['TextColor','BGColor'],
        ['Link','Unlink','Anchor'],
        ['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
        ['Styles','Format','Font','FontSize'],
        ['Maximize']
    ];

};

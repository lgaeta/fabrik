<?php
header('Content-type: text/css');
$c = (int)$_REQUEST['c'];
echo "

#form_$c legend{
	background-color:#2E2E2E;
	font-size:1.3em;
	line-height:20px;
	margin:0;
	color:#E6F2FF;
	padding:10px 20px;
	width:100%;
	margin-top:40px;
}

#form_$c .fabrikGroup{
	padding-bottom:10px;
	background:#ABDB6C url(images/bg.gif) repeat-x;
	color:#2E2E2E;
	margin-bottom:10px;
}

#form_$c .fabrikGroupRepeater{
	position:absolute;
	top:-9px;
	right:0;
	padding-right:20px;
}

#form_$c .fabrikSubGroup{
	clear:both;
	border:1px dotted #E6F2FF;
	margin:10px;
}

#form_$c .addoption{
	background-color:#E3FFBF;
	color:#333;
}


#form_$c fieldset ul,
#details_$c fieldset ul{
	margin-top:-30px;
	list-style:none;
}

#form_$c .fabrikForm .fabrikGroup ul{
	list-style:none;
}

#form_$c .fabrikSubElementContainer,
#details_$c .fabrikSubElementContainer{
	display:-moz-box;
	display:box;
	display:-webkit-box;
}

#details_$c .fabrikGalleryImage{
	border:1px solid #ccc;
	margin:5px;
	padding:5px;
}

/* START: align google map sub elements vertically */

.googlemap .fabrikSubElementContainer{
	-moz-box-orient:vertical;
	-webkit-box-orient:vertical;
	box-orient:vertical;
}

.googlemap .fabrikSubElementContainer > div{
	-mox-box-flex: 1;
	-webkit-box-flex: 1;
	box-flex: 1;
}

/* END: align google map sub elements vertically */
/* START : radio button sub element alignments */

#form_$c .radiobutton .fabrikSubElementContainer{
	display:block;
	margin-left:130px;
}

/* END : radio button sub element alignments */

.floating-tip {
	background-color: black;
	padding: 5px 15px;
	color: #dddddd;
	font-weight: bold;
	font-size: 11px;
	-moz-border-radius: 3px;
	-webkit-border-radius: 3px;
	border-radius: 3px;
}

#form_$c fieldset ul li{
	margin-bottom:10px;
}

#form_$c  .related_data_norecords{
	display:inline;
}

#form_$c .fabrikForm .fabrikGroup ul,
#form_$c .fabrikForm .fabrikGroup li{
	padding:0;
	margin:0;
}


#form_$c .fabrikForm .fabrikGroup ul li.fabrikElementContainer,
#details_$c li.fabrikElementContainer,
#form_$c li.fabrikElementContainer{
	padding:5px 10px;
	margin-top:10px;
	background:none !important;
}

#form_$c .fabrikActions{
	padding-top:15px;
	clear:left;
	padding-bottom:15px;
}


#form_$c .fabrikElement{
	margin-right: 200px;
}

#form_$c .fabrikLabel{
	/*ensures label text doesnt overrun validation icons*/
	padding-right:10px;
	z-index:99999;
}

#form_$c .fabrikValidating{
	color: #476767;
	background: #EFFFFF url(../images/ajax-loader.gif) no-repeat right 7px !important;
}

#form_$c .fabrikSuccess{
	color: #598F5B;
	background: #DFFFE0 url(../images/action_check.png) no-repeat right 7px !important;
}

/*** slide out add option
section for dropdowns radio buttons etc**/

#form_$c .addoption dl{
	display:inline;
	width:75%;
}
#form_$c .addoption{
	clear:left;
	padding:8px;
	margin:3px 0;
}

#form_$c  a.toggle-addoption, a.toggle-selectoption{
	padding:0 0 0 10px;
}

/*** end slide out add option section **/


#form_$c  .inputbox:focus{
	background-color:#ffffcc;
	border:1px solid #aaaaaa;
}

#form_$c .addoption dd, .addoption dt{
	padding:2px;
	display:inline;
}

#form_$c .fabrikSubGroup{
	clear:both;
}

#form_$c .fabrikSubGroupElements{
	width:80%;
	float:left;
}

#form_$c .geo{
	visibility:hidden;
}



#form_$c .fabrikGroup .readonly,
#form_$c .fabrikGroup .disabled{
	background-color:#DFDFDF !important;
	color:#8F8F8F;
}

/*** fileupload folder select css **/
#form_$c ul.folderselect{
	border:1px dotted #eee;
	background-color:#efefef;

#form_$c .folderselect-container{
	border:1px dotted #666;width:350px;
}

#form_$c .fabrikForm .breadcrumbs{
	background: transparent url(../images/folder_open.png) no-repeat center left;
	padding:2px 2px 2px 26px ;
}

#form_$c .fabrikForm .fabrikGroup li.fileupload_folder{
	background: transparent url(../images/folder.png) no-repeat center left;
	padding:2px 2px 2px 26px ;
	margin:2px;
}

#form_$c .fabrik_characters_left{
clear:left;
}

/** bump calendar above mocha window in mootools 1.2**/
#form_$c div.calendar{
	z-index:115 !important;
}

/** special case for 'display' element with 'show label: no' option **/
#form_$c .fabrikPluginElementDisplayLabel {
	width: 100% !important;
}

/** autocomplete container inject in doc body not in #forn_$c */
.auto-complete-container{
	overflow-y: hidden;
	border:1px solid #ddd;
	z-index:100;
}

.auto-complete-container ul{
list-style:none;
padding:0;
margin:0;
}

.auto-complete-container li.unselected{
	padding:2px 10px !important;
	background-color:#fff !important;
	margin:0 !important;
	border-top:1px solid #ddd;
	cursor:pointer;
}

.auto-complete-container li:hover,
.auto-complete-container li.selected{
	background-color:#DFFAFF !important;
	cursor:pointer;
}
#form_$c .leftCol,
#details_$c .leftCol,
#form_$c .fabrikSubLabel{
	width: 130px;
	float:left;
}
#details_$c .leftCol{
	color:#999;
}

#form_$c .fabrikElement {
	margin-left: 10px;
	margin-right:0;
}

#form_$c .addbutton {
	background: transparent url(images/add.png) no-repeat left;
	padding: 2px 5px 0 20px;
	margin-left:7px;
}

#details_$c .fabrikElementContainer{
	/*clear:left;*/
}

#form_$c .fabrikError,#form_$c .fabrikNotice,#form_$c .fabrikValidating,#form_$c .fabrikSuccess{
	margin: 0;
	font-weight: bold;
	margin-bottom: 10px;
	padding:7px;
}

#form_$c .fabrikMainError{
	height:2em;
	line-height:2em;
}

#form_$c .fabrikMainError img{
	padding:0.35em 1em;
	float:left;
}

#form_$c .fabrikNotice{
	color: #009FBF;
	background: #DFFDFF url(images/alert.png) no-repeat center left !important;
}

#form_$c .fabrikError,
#form_$c .fabrikGroup li.fabrikError{
	color: #c00;
	background: #EFE7B8;
}

#form_$c .fabrikErrorMessage{
	padding-right: 5px;
}



#form_$c .fabrikLabel {
	min-height:1px; /*for elements with no label txt*/
}

#form_$c .fabrikActions {
	padding-top: 15px;
	clear: left;
	padding-bottom: 15px;
}

#form_$c .fabrikGroupRepeater {
	float: left;
	width: 19%;
}

/** used by password element */
#form_$c .fabrikSubLabel {
	margin-left: -10px;
	clear: left;
	margin-top: 10px;
	float: left;
}

#form_$c .fabrikSubElement {
	display: block;
	margin-top: 10px;
	margin-left: 100px;
}
";
?>
/* This section of the code registers a new block, sets an icon and a category, and indicates what type of fields it'll include. */
function lx_carousel_block_course() {
"use strict";

	const { registerBlockType } = wp.blocks;
	const {
		RichText,
		AlignmentToolbar,
		BlockControls,
		BlockDescription,
		ToggleControl
	} = wp.editor;

	const {
	  InspectorControls
	} = wp.blockEditor;

	const {
	  serverSideRender: ServerSideRender
	} = wp;

	var el = wp.element.createElement;
	registerBlockType('lx-course-blocks/lx-block', {
		title: lx_block_data_lite.custom_block_title,
		icon: 'admin-generic',
		category: 'lx-blocks',
		description: lx_block_data_lite.custom_block_desc,
		attributes: {
			lx_selection : {type: 'string',default: 'courses'},
			lx_course_selection : {type: 'string',default: 'categories'},
			lx_category_selection : {type: 'string',default: ''},
			lx_need_login : {type: 'string',default: ''},
			lx_view_selection : {type: 'string',default: 'List'},
			lx_section_class : {type: 'string',default: ''},
			lx_course_status : {type: 'string',default: ''},
			lx_course_access : {type: 'string',default: ''},
			lx_section_title : {type: 'string',default: ''},
			className : {type: 'string'}
		},

		/* This configures how the content field will work, and sets up the necessary elements */

		edit: function(props) {
			var lx_selections_change;
			jQuery('.block-editor-writing-flow').addClass('custom_block');
			jQuery('.components-placeholder').hide();
			var lx_selections_change = [];
			function changeCourseSelection(event) {
				props.setAttributes({lx_course_selection: event.target.value});
			}
			function changecategorySelections(event) {
				var category_chk = [];
				jQuery('input[name="chk_category_info"]:checked').each(function(key,value) {
					category_chk[key] = this.value;
				});
				props.setAttributes({ lx_category_selection: category_chk.toString()});
			}
			function changeNeedLogin(event){
				if(props.attributes.lx_need_login == 'need_login'){
					props.setAttributes({lx_need_login: ''});
				} else{
					props.setAttributes({lx_need_login: event.target.value});
				}
			}
			
			function changeViewSelection(event){
				props.setAttributes({lx_view_selection: event.target.value});
			}
			
			function changeCourseStatusSelection(event) {
				var category_chk = [];
				jQuery('input[name="lx_course_status"]:checked').each(function(key,value) {
					category_chk[key] = this.value;
				});
				props.setAttributes({ lx_course_status: category_chk.toString()});
			}
			
			function changeCourseAccessSelection(event) {
				var category_chk = [];
				jQuery('input[name="lx_course_access"]:checked').each(function(key,value) {
					category_chk[key] = this.value;
				});
				props.setAttributes({ lx_course_access: category_chk.toString()});
			}
			
			function setSectionTitle(event) {
				props.setAttributes({lx_section_title: event.target.value});
			}
			
			var view_selection = [];
			if( props.attributes.lx_selection == 'courses' ){
				if(props.attributes.lx_course_selection == 'categories'){
					var cat_info = props.attributes.lx_course_selection;
				} else if(props.attributes.lx_course_selection == 'not_in_categories'){ 
					var cat_not_in_info = props.attributes.lx_course_selection;
					var section_title = [];
					var title_main_class;
					section_title.push(el("input", { onChange: setSectionTitle, style:{width:'100%'}, type: "text",placeholder:'Add section title here' ,className:'add_section_title',value : props.attributes.lx_section_title }) );
					title_main_class = props.attributes.lx_selection;
				} else{
					cat_info = '';
					cat_not_in_info = '';
					props.setAttributes({lx_course_selection: cat_info});
				}
				if( props.attributes.lx_view_selection == 'Tab' ){
					var tab_info =  props.attributes.lx_view_selection;
				} else if( props.attributes.lx_view_selection == 'List' ){
					var list_info =  props.attributes.lx_view_selection;
				} else{
					tab_info = '';
					list_info = 'List';
					props.setAttributes({lx_view_selection: "List"});
				}
				/* console.log('view selection:-',props.attributes.lx_view_selection); */
				if(props.attributes.lx_course_selection == 'categories'){
					view_selection.push(el("input", { onChange: changeViewSelection,type: "radio", value: "Tab",name:'lx_view_selection_info',checked: tab_info }),el("label", null, lx_block_data_lite.tab_view),el("br"));
				} else{
					props.setAttributes({lx_view_selection: "List"});
				}
				
				view_selection.push(el("input", { onChange: changeViewSelection, type: "radio", value: "List",name:'lx_view_selection_info',checked: list_info}),el("label", null, lx_block_data_lite.list_view));
					
				lx_selections_change.push(el("input", { onChange: changeCourseSelection,  type: "radio", value: "categories",name:'lx_course_selection_info',checked: cat_info}),el("label", null, lx_block_data_lite.categories),el("br"));
				
				lx_selections_change.push(el("input", { onChange: changeCourseSelection,  type: "radio", value: "not_in_categories",name:'lx_course_selection_info',checked: cat_not_in_info}),el("label", null, lx_block_data_lite.not_in_categories),el("br"));
				
				props.setAttributes({lx_parent_invite_only: null});
				props.setAttributes({lx_articulate_web_selection: null});
			}else{
				props.setAttributes({lx_course_selection: "categories"});
			}
			
			var result;
			var catSelections = [];
			
			if( props.attributes.lx_course_selection == 'categories' ){
				jQuery.each(lx_block_data_lite.category_info, function( key, value ) {
					var category_info = props.attributes.lx_category_selection;
					var checked = category_info.indexOf(value.slug) < 0? "":"checked";
					catSelections.push(el("input", { onChange: changecategorySelections, type: "checkbox", name:'chk_category_info',value: value.slug,  checked: checked}),el("label",{style:{wordWrap: 'break-word', width: '92%'}}, value.name),el("br"));
				});
			}
			var lx_selections_need_login = [];
			if(props.attributes.lx_selection != null){
				lx_selections_need_login.push(el("hr"),el("input", { onChange: changeNeedLogin,  type: "checkbox", value: "need_login",name: "chk_need_login",checked: props.attributes.lx_need_login }),el("label", null, lx_block_data_lite.need_login),el("br"));
			}
			
			var lx_course_status_info = [];
			var course_status = props.attributes.lx_course_status;
			var publish_status = course_status.indexOf('publish') < 0? "":"checked";
			var draft_status = course_status.indexOf('draft') < 0? "":"checked";
	
			lx_course_status_info.push(el("input", { onChange: changeCourseStatusSelection,  type: "checkbox", value: "publish",name:'lx_course_status',checked: publish_status }),el("label", null, lx_block_data_lite.lx_course_publish),el("br"));
			
			lx_course_status_info.push(el("input", { onChange: changeCourseStatusSelection,  type: "checkbox", value: "draft",name:'lx_course_status' ,checked: draft_status }),el("label", null, lx_block_data_lite.lx_course_draft),el("br"));
			
			var lx_course_access_info = [];
			var course_access = props.attributes.lx_course_access;
			var paid_access = course_access.indexOf('paid') < 0? "":"checked";
			var free_access = course_access.indexOf('free') < 0? "":"checked";
	
			lx_course_access_info.push(el("input", { onChange: changeCourseAccessSelection,  type: "checkbox", value: "paid",name:'lx_course_access',checked: paid_access }),el("label", null, lx_block_data_lite.lx_course_paid),el("br"));
			
			lx_course_access_info.push(el("input", { onChange: changeCourseAccessSelection,  type: "checkbox", value: "free",name:'lx_course_access' ,checked: free_access }),el("label", null, lx_block_data_lite.lx_course_free),el("br"));
			
			const controls = [
				el(
				  InspectorControls,
				  {},
				  el(
					"div",
					{ style: {padding: "15px" }},
					el(
					  "hr",
					  null
					),
					el("span", {style:{fontWeight: 600, width: '100%'}},lx_block_data_lite.selection_content+":"),
					el("br"),
					el("br"),
					el("div", null, lx_selections_change),
					el("br"),
					el("div", null,catSelections),
					el("hr"),
					el("span", {style:{fontWeight: 600, width: '100%'}},lx_block_data_lite.course_status_selection+":"),
					el("br"),
					el("br"),
					el("div", null,lx_course_status_info),
					el("hr"),
					el("span", {style:{fontWeight: 600, width: '100%'}},lx_block_data_lite.course_access_selection+":"),
					el("br"),
					el("br"),
					el("div", null,lx_course_access_info),
					el("hr"),
					el("span", {style:{fontWeight: 600, width: '100%'}},lx_block_data_lite.view_selection_lbl+":"),
					el("br"),
					el("br"),
					el("div", null,view_selection),
					el("div", null,lx_selections_need_login),
					el("br"),
				  ),
				),
			];
		
      return [
              controls,
				el(
					"div",
					{ className: props.attributes.lx_selection },
					el("div", null, section_title),
					el("br"),
					el(ServerSideRender, {
						block: "lx-course-blocks/lx-block",
						key: "lx-course-blocks/lx-block",
						attributes: props.attributes,
						className: 'main_class_div'
					} )
				)
			
            ];
		return null;

		},
		save: function(props) {
		return null;
		}
	})
} 
lx_carousel_block_course();
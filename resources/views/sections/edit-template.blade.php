@extends('maileclipse::layout.app')

@section('title', 'Edit Template ' . ucfirst($template['name']))

@section('content')

     <style type="text/css">
         
        .CodeMirror {
            height: 400px;
        }

        .editor-preview-active,
        .editor-preview-active-side {
            /*display:block;*/
        }
        .editor-preview-side>p,
        .editor-preview>p {
            margin:inherit;
        }
        .editor-preview pre,
        .editor-preview-side pre {
             background:inherit;
             margin:inherit;
        }
        .editor-preview table td,
        .editor-preview table th,
        .editor-preview-side table td,
        .editor-preview-side table th {
         border:inherit;
         padding:inherit;
        }
        .view_data_param {
            cursor: pointer;
        }

     </style>

     {{-- {{ dd($template) }} --}}

<div class="col-lg-12 col-md-12">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        {{-- <li class="breadcrumb-item"><a href="#">Home</a></li> --}}
        <li class="breadcrumb-item"><a href="{{ route('templateList') }}">Templates</a></li>
        <li class="breadcrumb-item active">{{ ucfirst($template['name']) }}</li>
      </ol>
    </nav>
        <div class="container">
            <div class="row my-4">
                <div class="col-12 mb-2 d-block d-lg-none">
                    <div id="accordion">
                      <div class="card">
                        <div class="card-header" id="headingOne">
                          <h5 class="mb-0 dropdown-toggle" style="cursor: pointer;" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Details
                          </h5>
                        </div>

                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                          <div class="card-body">
                            <p style="font-size: .9em;"><b class="font-weight-sixhundred">Name:</b> {{ ucfirst($template['name']) }}</p>
                            <p style="font-size: .9em;"><b class="font-weight-sixhundred">Slug:</b> {{ $template['slug'] }}</p>
                            <p style="font-size: .9em;"><b class="font-weight-sixhundred">Description:</b> {{ $template['description'] }}</p>
                            <p style="font-size: .9em;"><b class="font-weight-sixhundred">Template Type:</b> {{ ucfirst($template['template_type']) }}</p>
                            <p style="font-size: .9em;"><b class="font-weight-sixhundred">Template Name:</b> {{ ucfirst($template['template_view_name']) }}</p>
                            <p style="font-size: .9em;"><b class="font-weight-sixhundred">Template Skeleton:</b> {{ ucfirst($template['template_skeleton']) }}</p>
                            <p class="text-primary edit-template"><i class="fas fa-trash"></i> Edit Details</p>
                            <p class="text-danger delete-template"><i class="fas fa-trash "></i> Delete Template</p>
                        </div>
                        </div>
                      </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-12">
                    <div class="card mb-2">
                        <div class="card-header p-3" style="border-bottom:1px solid #e7e7e7e6;">
                            <button type="button" class="btn btn-success float-right save-template">Update</button>
                            <button type="button" class="btn btn-secondary float-right preview-toggle mr-2"><i class="far fa-eye"></i> Preview</button>
                            <button type="button" class="btn btn-light float-right mr-2 save-draft disabled">Save Draft</button>
                        </div>
                    </div>

                    <div class="card">
                    
                    <ul class="nav nav-pills" id="pills-tab" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Editor</a>
                      </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                      <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <textarea id="template_editor" cols="30" rows="10">{{ $template['template'] }}</textarea>
                      </div>
                    </div>

                    </div>
                </div>
                <div class="col-lg-3 d-none d-lg-block">
                    <div class="card">
                        <div class="card-header"><h5>Details</h5></div>
                        <div class="card-body">
                            <p style="font-size: .9em;"><b class="font-weight-sixhundred">Name:</b> {{ ucfirst($template['name']) }}</p>
                            <p style="font-size: .9em;"><b class="font-weight-sixhundred">Slug:</b> {{ $template['slug'] }}</p>
                            <p style="font-size: .9em;"><b class="font-weight-sixhundred">Description:</b> {{ $template['description'] }}</p>
                            <p style="font-size: .9em;"><b class="font-weight-sixhundred">Template Type:</b> {{ ucfirst($template['template_type']) }}</p>
                            <p style="font-size: .9em;"><b class="font-weight-sixhundred">Template Name:</b> {{ ucfirst($template['template_view_name']) }}</p>
                            <p style="font-size: .9em;"><b class="font-weight-sixhundred">Template Skeleton:</b> {{ ucfirst($template['template_skeleton']) }}</p>
                            <p class="text-primary edit-template"><i class="fas fa-trash"></i> Edit Details</p>
                            <p class="text-danger delete-template"><i class="fas fa-trash"></i> Delete Template</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>       
 </div>

<script type="text/javascript">

$(document).ready(function(){

	 var templateID = "{{ "template_view_".$template['slug'] }}";

	 $('.edit-template').click(function(){

		var title = prompt('Title');

		if ( title !== null ){

		var description = prompt('Description');

			if (confirm('Update?')){
				$.ajax({
				  method: "POST",
				  url: "{{ route('updateTemplate') }}",
				  data: {
				  	templateslug: '{{ $template['slug'] }}',
				  	title: title,
				  	description: description,
				  }
				
			}).done(function( data ) {
			    if (data.status == 'ok'){

		    		window.location.replace(data.template_url);

			    } else {
			    	alert(data.message);
			    }
			});
			}
		}
	});

	$('.delete-template').click(function(){

		if (confirm('Are you sure you want to delete?')){

		$.ajax({
				  method: "POST",
				  url: "{{ route('deleteTemplate') }}",
				  data: { 
				  	templateslug: '{{ $template['slug'] }}',
				  }
				
			}).done(function( data ) {
			    if (data.status == 'ok'){

		    	alert('Deleted!');
		    	window.location.replace('{{ route('templateList') }}');

			    } else {
			    	alert(data.message);
			    }
			});

		}

	});

	@if ($template['template_type'] === 'markdown')

	var simplemde = new SimpleMDE(
		{
		element: $("#template_editor")[0],
		toolbar: [
		{
				name: "bold",
				action: SimpleMDE.toggleBold,
				className: "fa fa-bold",
				title: "Bold",
		},
		{
				name: "italic",
				action: SimpleMDE.toggleItalic,
				className: "fa fa-italic",
				title: "Italic",
		},
		{
				name: "strikethrough",
				action: SimpleMDE.toggleStrikethrough,
				className: "fa fa-strikethrough",
				title: "Strikethrough",
		},
		{
				name: "heading",
				action: SimpleMDE.toggleHeadingSmaller,
				className: "fa fa-header",
				title: "Heading",
		},
		{
				name: "code",
				action: SimpleMDE.toggleCodeBlock,
				className: "fa fa-code",
				title: "Code",
		},
		/*{
				name: "quote",
				action: SimpleMDE.toggleBlockquote,
				className: "fa fa-quote-left",
				title: "Quote",
		},*/
		"|",
		{
				name: "unordered-list",
				action: SimpleMDE.toggleBlockquote,
				className: "fa fa-list-ul",
				title: "Generic List",
		},
		{
				name: "uordered-list",
				action: SimpleMDE.toggleOrderedList,
				className: "fa fa-list-ol",
				title: "Numbered List",
		},
		{
				name: "clean-block",
				action: SimpleMDE.cleanBlock,
				className: "fa fa-eraser fa-clean-block",
				title: "Clean block",
		},
		"|",
		{
				name: "link",
				action: SimpleMDE.drawLink,
				className: "fa fa-link",
				title: "Create Link",
		},
		{
				name: "image",
				action: SimpleMDE.drawImage,
				className: "fa fa-picture-o",
				title: "Insert Image",
		},
		{
				name: "horizontal-rule",
				action: SimpleMDE.drawHorizontalRule,
				className: "fa fa-minus",
				title: "Insert Horizontal Line",
		},
		"|",
		{
			name: "button-component",
			action: setButtonComponent,
			className: "fa fa-hand-pointer-o",
			title: "Button Component",
		},
		{
			name: "table-component",
			action: setTableComponent,
			className: "fa fa-table",
			title: "Table Component",
		},
		{
			name: "promotion-component",
			action: setPromotionComponent,
			className: "fa fa-bullhorn",
			title: "Promotion Component",
		},
		{
			name: "panel-component",
			action: setPanelComponent,
			className: "fa fa-thumb-tack",
			title: "Panel Component",
		},
		"|",
		{
				name: "side-by-side",
				action: SimpleMDE.toggleSideBySide,
				className: "fa fa-columns no-disable no-mobile",
				title: "Toggle Side by Side",
		},
		{
				name: "fullscreen",
				action: SimpleMDE.toggleFullScreen,
				className: "fa fa-arrows-alt no-disable no-mobile",
				title: "Toggle Fullscreen",
		},
		{
				name: "preview",
				action: SimpleMDE.togglePreview,
				className: "fa fa-eye no-disable",
				title: "Toggle Preview",
		},
		],
		renderingConfig: { singleLineBreaks: true, codeSyntaxHighlighting: true,},
		hideIcons: ["guide"],
		spellChecker: false,
		promptURLs: true,
		placeholder: "Write your Beautiful Email",
		previewRender: function(plainText, preview) {
			 // return preview.innerHTML = 'sacas';
			$.ajax({
				  method: "POST",
				  url: "{{ route('previewTemplateMarkdownView') }}",
				  data: { markdown: plainText, name: '{{ $template['slug'] }}' }
				
			}).done(function( HtmledTemplate ) {
			    preview.innerHTML = HtmledTemplate;
			});

			return '';
		},
	});

	function setButtonComponent(editor) {

		link = prompt('Button Link');

	    var cm = editor.codemirror;
	    var output = '';
	    var selectedText = cm.getSelection();
	    var text = selectedText || 'Button Text';

	    output = `
[component]: # ('mail::button',  ['url' => '`+ link +`'])
` + text + `
[endcomponent]: # 
	    `;
	    cm.replaceSelection(output);

	}

	function setPromotionComponent(editor) {

	    var cm = editor.codemirror;
	    var output = '';
	    var selectedText = cm.getSelection();
	    var text = selectedText || 'Promotion Text';

	    output = `
[component]: # ('mail::promotion')
` + text + `
[endcomponent]: # 
	    `;
	    cm.replaceSelection(output);

	}

	function setPanelComponent(editor) {

	    var cm = editor.codemirror;
	    var output = '';
	    var selectedText = cm.getSelection();
	    var text = selectedText || 'Panel Text';

	    output = `
[component]: # ('mail::panel')
` + text + `
[endcomponent]: # 
	    `;
	    cm.replaceSelection(output);

	}

	function setTableComponent(editor) {

	    var cm = editor.codemirror;
	    var output = '';
	    var selectedText = cm.getSelection();

	    output = `
[component]: # ('mail::table')
| Laravel       | Table         | Example  |
| ------------- |:-------------:| --------:|
| Col 2 is      | Centered      | $10      |
| Col 3 is      | Right-Aligned | $20      |
[endcomponent]: # 
	    `;
	    cm.replaceSelection(output);

	}

	simplemde.codemirror.on("change", function(){
		if ($('.save-draft').hasClass('disabled')){
			$('.save-draft').removeClass('disabled').text('Save Draft');
		}
		// alert('Hello');
	});

	$('.save-draft').click(function(){
		if (!$('.save-draft').hasClass('disabled')){
			localStorage.setItem(templateID, simplemde.codemirror.getValue());
			$(this).addClass('disabled').text('Draft Saved');
		}
	});

	if (localStorage.getItem(templateID) !== null) {
		simplemde.value(localStorage.getItem(templateID));
	}

	$('.save-template').click(function(){
		$.ajax({
		  method: "POST",
		  url: "{{ route('parseTemplate') }}",
		  data: { markdown: simplemde.codemirror.getValue(), viewpath: "{{ $template['slug'] }}", template: true }
		})
		  .done(function( data ) {
		    if (data.status == 'ok'){
				    	$('.template-edit-status').removeClass('alert-warning d-none').addClass('alert-success').html('Template Saved successfully');
		    } else {
		    	$('.template-edit-status').removeClass('alert-success d-none').addClass('alert-warning').text('Error, cannot save the template');
		    }
		  });
	});

	$('.preview-toggle').click(function(){
		simplemde.togglePreview();
		$(this).toggleClass('active');
	});


	@else

		tinymce.init({
	        selector: "textarea#template_editor",
	        menubar : true,
	        visual: false,
	        height:600,
	        plugins: [
	             "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
	             "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
	             "save table directionality emoticons template paste fullpage"
	       ],
	       content_css: "css/content.css",
	       toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image fullpage table | forecolor backcolor emoticons | preview",
	       fullpage_default_encoding: "UTF-8",
	       fullpage_default_doctype: "<!DOCTYPE html>",
	       init_instance_callback: function (editor) 
	       {
	    		editor.on('Change', function (e) {
	      			if ($('.save-draft').hasClass('disabled')){
						$('.save-draft').removeClass('disabled').text('Save Draft');
					}
	    		});

	    		if (localStorage.getItem(templateID) !== null) {
					editor.setContent(localStorage.getItem(templateID));
				}

				setTimeout(function(){ 
					editor.execCommand("mceRepaint");
				}, 2000);

	    	}
	    });


	$('.save-template').click(function(){
		$.ajax({
		  method: "POST",
		  url: "{{ route('parseTemplate') }}",
		  data: { markdown: tinymce.get('template_editor').getContent(), viewpath: "{{ $template['slug'] }}", template: true }
		})
		  .done(function( data ) {
		    if (data.status == 'ok'){
				    	$('.template-edit-status').removeClass('alert-warning d-none').addClass('alert-success').html('Template Saved successfully');

				    	localStorage.removeItem(templateID);
		    } else {
		    	$('.template-edit-status').removeClass('alert-success d-none').addClass('alert-warning').text('Error, cannot save the template');
		    }
		  });
	});

	$('.save-draft').click(function(){
		if (!$('.save-draft').hasClass('disabled')){
			localStorage.setItem(templateID, tinymce.get('template_editor').getContent());
			$(this).addClass('disabled').text('Draft Saved');
		}
	});

	 $('.preview-toggle').click(function(){
		tinyMCE.execCommand('mcePreview');return false;
	});

	@endif

});
                
</script>
   
@endsection
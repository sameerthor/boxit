@extends('layouts.app')

@section('content')
<link rel="stylesheet" type="text/css" media="screen" href="https://bootswatch.com/3/paper/bootstrap.min.css" />
<div id="content">
  <div class="container">
    <div class="row">
      <div class="col-md-9">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <div class="form-head">
                  <span>{{$template->ProjectStatusLabel->label}} ({{$template->status==1?'Yes':'No'}}) Template</span>
                </div>
              </div>
            </div>
            <form method="post" action="{{url('foreman-template/update/'.$template->id)}}">

              @csrf

              <div class="form-group" wire:ignore>
                <label>Email Content</label>


                <textarea class="form-control" name="body" id="editor">{{$template->body}}</textarea>
                @error('body') <span class="invalid-feedback">{{ $message }}</span> @enderror
              </div>


              <button type="submit" class="save_button btn btn-secondary">Save</button>

            </form>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <h3 class="text-center">Preview</h3>
        @php
        $html=$template->body;
        @endphp
        <iframe srcdoc="{{$html}}" id="myFrame" style="border: 3px solid #ccc; border-radius: 5px;padding: 5px; height: 500px; overflow: scroll">
        </iframe>
      </div>
    </div>

  </div>
  <div class="hidden_html" style="display:none">
    <div class="items">
      <div class="item-content">
        <input type="text" value="" name="product[][name]" class="form-control product" id="product" placeholder="Product name">
      </div>
      <div class="pull-right repeater-remove-btn">
        <button id="remove-btn" class="btn btn-danger" onclick="$(this).parents('.items').remove()">
          Remove
        </button>
      </div>
    </div>
  </div>

  <script>
    CKEDITOR.replace('editor', {
      // Make the editing area bigger than default.
      height: 450,
      // Allow pasting any content.
      allowedContent: true,
      fillEmptyBlocks: false,

      // Fit toolbar buttons inside 3 rows.
      toolbarGroups: [{
          name: 'document',
          groups: ['mode', 'document', 'doctools']
        },
        {
          name: 'clipboard',
          groups: ['clipboard', 'undo']
        },
        {
          name: 'editing',
          groups: ['find', 'selection', 'spellchecker', 'editing']
        },
        {
          name: 'forms',
          groups: ['forms']
        },
        '/',
        {
          name: 'paragraph',
          groups: ['list', 'indent', 'blocks', 'align', 'bidi', 'paragraph']
        },
        {
          name: 'links',
          groups: ['links']
        },
        {
          name: 'insert',
          groups: ['insert']
        },
        '/',
        {
          name: 'styles',
          groups: ['styles']
        },
        {
          name: 'basicstyles',
          groups: ['basicstyles', 'cleanup']
        },
        {
          name: 'colors',
          groups: ['colors']
        },
        {
          name: 'tools',
          groups: ['tools']
        },
        {
          name: 'others',
          groups: ['others']
        },
        {
          name: 'about',
          groups: ['about']
        }
      ],

      // Remove buttons irrelevant for pasting from external sources.
      removeButtons: 'ExportPdf,Form,Checkbox,Radio,TextField,Select,Textarea,Button,ImageButton,HiddenField,NewPage,CreateDiv,Flash,Iframe,About,ShowBlocks,Maximize',
    });

    CKEDITOR.instances.editor.on('change', function() {
      getIframehtml()
    });

    function getIframehtml() {
      var html = CKEDITOR.instances["editor"].getData().trim();
      document.getElementById("myFrame").srcdoc = html;
    }
  </script>
  @endsection
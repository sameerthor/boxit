@extends('layouts.app')

@section('content')
<div id="content">
  <div class="container">
  <div class="row">
  <div class="col-md-9">
    <div class="card">
    <div class="card-body">
      <div class="row">
        <div class="col-md-12">
          <div class="form-head">
            <span>{{$template->department->title}} Template</span>
          </div>
        </div>
      </div>
      <form method="post" action="{{url('mail-template/update/'.$template->id)}}">

@csrf

<div class="form-group">
    <label>Subject</label>
    <input type="text"  value="{{$template->subject}}" class="form-control @error('subject') is-invalid @endif" name="subject"  />
    @error('subject') <span class="invalid-feedback">{{ $message }}</span> @enderror
</div>

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
    <iframe srcdoc="{{$template->body}}" id="myFrame" style="border: 3px solid #ccc; border-radius: 5px;padding: 5px; height: 500px; overflow: scroll">
    </iframe> 
    </div>
  </div>

</div>
<script src="/js/tinymce/js/tinymce/tinymce.min.js"></script>

<script src="https://cdn.tiny.cloud/1/jq9mby0hzla0mq6byj05yjmflbj55i7tl74g9v8w8no32jb6/tinymce/6/plugins.min.js" referrerpolicy="origin"></script>

<script>
       tinymce.init({
selector: "textarea",
plugins: 'print fullpage preview code powerpaste casechange importcss tinydrive searchreplace autolink autosave save directionality advcode visualblocks visualchars fullscreen image link media mediaembed template codesample table charmap hr pagebreak nonbreaking anchor insertdatetime advlist lists checklist wordcount tinymcespellchecker a11ychecker textpattern noneditable help formatpainter permanentpen pageembed charmap  mentions quickbars linkchecker emoticons advtable export',
            menubar: 'file edit view insert format tools table tc help',
            toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist checklist | forecolor backcolor casechange permanentpen formatpainter removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media pageembed template link anchor codesample | a11ycheck ltr rtl | showcomments addcomment',
            autosave_ask_before_unload: true,
            image_advtab: true,
            height: 500,
            image_caption: true,
            toolbar_mode: 'sliding',
            contextmenu: 'link image imagetools table configurepermanentpen',
            setup:function(editor) {
        editor.on('Paste Change input Undo Redo', function (e) {
          var text=editor.getContent();
          console.log(text);
             setTimeout(function(){document.getElementById("myFrame").srcdoc = text;},100);
               
        });
    }
});
        </script>
@endsection
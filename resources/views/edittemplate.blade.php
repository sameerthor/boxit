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
                  <span>{{$template->department->title}} Template</span>
                </div>
              </div>
            </div>
            <form method="post" action="{{url('mail-template/update/'.$template->id)}}">

              @csrf

              <div class="form-group">
                <label>Subject</label>
                <input type="text" value="{{$template->subject}}" class="form-control @error('subject') is-invalid @endif" name="subject" />
                @error('subject') <span class="invalid-feedback">{{ $message }}</span> @enderror
              </div>

              <div class="form-group" wire:ignore>
                <label>Email Content</label>


                <textarea class="form-control" name="body" id="editor">{{$template->body}}</textarea>
                @error('body') <span class="invalid-feedback">{{ $message }}</span> @enderror
              </div>

              <div class="form-group">
                <label>Product</label>
                <div id="repeater">
                  <!-- Repeater Heading -->
                  <div class="repeater-heading">
                    <button type="button" class="pull-right btn btn-primary repeater-add-btn"> Add</button>
                  </div>
                  @if(!empty($template->products))
                  @foreach($template->products as $pro)
                  <div class="items">
                    <div class="item-content">
                      <input type="text" value="{{$pro}}" name="product[][name]" class="form-control product" id="product" placeholder="Product name">
                    </div>
                    <div class="pull-right repeater-remove-btn">
                      <button id="remove-btn" class="btn btn-danger" onclick="$(this).parents('.items').remove()">
                        Remove
                      </button>
                    </div>
                  </div>
                  @endforeach
                  @endif
                </div>
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
        if(!empty($template->products))
        {
        $html.="<br>";
        foreach($template->products as $product)
        {
        $html.="<p class='product'>$product- [qty]</p>";
        }
        }
        $html.='<br>
        For<br>
        [address]
        <br>
        <br>
        At
        <br>[date]
        <br>[time]
        <br><br>
        [link]
        <br>
        Thanks,</br>
        Jules,</br>
        BOXIT Sales</br>
        <a href="mailto:admin@boxitfoundations.co.nz">admin@boxitfoundations.co.nz</a>
        </br>
        <a href="https://boxitfoundations.co.nz
">https://boxitfoundations.co.nz</a></br>' ;
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
  <script src="/js/tinymce/js/tinymce/tinymce.min.js"></script>

  <script src="https://cdn.tiny.cloud/1/jq9mby0hzla0mq6byj05yjmflbj55i7tl74g9v8w8no32jb6/tinymce/6/plugins.min.js" referrerpolicy="origin"></script>

  <script>
    tinymce.init({
      selector: "textarea",
      plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
      menubar: 'file edit view insert format tools table tc help',
      toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist checklist | forecolor backcolor casechange permanentpen formatpainter removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media pageembed template link anchor codesample | a11ycheck ltr rtl | showcomments addcomment',
      autosave_ask_before_unload: true,
      image_advtab: true,
      height: 500,
      image_caption: true,
      toolbar_mode: 'sliding',
      contextmenu: 'link image imagetools table configurepermanentpen',
      setup: function(editor) {
        editor.on('Paste Change input Undo Redo', function(e) {
          var text = editor.getContent();
          console.log(text);
          setTimeout(function() {
            getIframehtml()
          }, 100);

        });
      }
    });
    $(function() {
      $(".product").on("keyup", function() {
        getIframehtml();
      });
      $('.repeater-add-btn').click(function() {
        $("#repeater").append($(".hidden_html").html());
      })
    });

    function getIframehtml() {
      var html= tinymce.get("editor").getContent();
      html+="<br>";
      $(".items").each(function(){
        var p_name=$(this).find("input").val();
        html+="<p>"+p_name+"- [qty]</p>";
      });
      html+='<br>For<br>[address]<br><br>At<br>[date]<br>[time]<br><br>[link]<br>Thanks,</br>Jules,</br>BOXIT Sales</br><a href="mailto:admin@boxitfoundations.co.nz">admin@boxitfoundations.co.nz</a></br><a href="https://boxitfoundations.co.nz">https://boxitfoundations.co.nz</a></br>';
      document.getElementById("myFrame").srcdoc = html;

    }
  </script>
  @endsection
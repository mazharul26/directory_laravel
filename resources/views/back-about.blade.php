@extends("master") 
@section("content")
<!--Start of Feature Product-->
<section class="single section-padding">
   <div class="container">
      <!--End of row-->
      <div class="row">  
         @include('submenu') 
         <div class="col-sm-9">
            <div class="panel panel-default place-an-ads">
               <div class="panel-heading">
                  <h3 class="panel-title" style="display: inline-block">About Us</h3>
               </div>
               <div class="panel-body">                                    
                  @if (session('msg'))
                  <div class="alert alert-success">
                     {{ session('msg') }}
                  </div>
                  @endif
                  <form action="{{url('/')}}/admin-about" method="post">
                     {{ csrf_field() }}
                     <label> Left Section</label>
                     <textarea name="about-left">{{File::get(storage_path("app/public/about-left.txt"))}}</textarea>

                     <br /><br />
                     <label>Right Section</label>
                     <textarea name="about-right">{{File::get(storage_path("app/public/about-right.txt"))}}</textarea>
                     <br />

                     <input type="submit" name="sub" value="&nbsp;&nbsp;Update&nbsp;&nbsp;" class="btn btn-success" />
                  </form>
               </div>
            </div>
         </div>         
      </div>
      <!--End of row-->
   </div>
   <!--End of container-->
</section>
<!--end of Feature Product-->
<script type="text/javascript" src="https://tinymce.cachefly.net/4.1/tinymce.min.js"></script>
<style>
   textarea{
      min-height: 300px;;
   }
</style>
<script type="text/javascript">

tinymce.init({
   selector: "textarea",
   theme: "modern",
   setup: function (editor) {
      editor.on('change', function () {
         editor.save();
      });
   },
   plugins: [
      "advlist autolink lists link image charmap print preview hr anchor pagebreak",
      "searchreplace wordcount visualblocks visualchars code fullscreen",
      "insertdatetime media nonbreaking save table contextmenu directionality",
      "emoticons template paste textcolor colorpicker textpattern"
   ],
   toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
   toolbar2: "print preview media | forecolor backcolor emoticons",
   image_advtab: true,
   templates: [
      {title: 'Test template 1', content: 'Test 1'},
      {title: 'Test template 2', content: 'Test 2'}
   ],
   image_title: true,
   convert_urls: false,
   content_css: ""
});

</script>
@endsection
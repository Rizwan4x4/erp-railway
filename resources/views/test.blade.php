<h1>Image Test</h1>
 <form action="{{url('test_image/submit')}}" enctype="multipart/form-data"  method="post" >
 	 		<div class="form-group">
                <label for="exampleFormControlFile1">Choose Image</label> 
                <input type="file" id="exampleFormControlFile1" name="image" class="form-control-file">
               
            </div>
 <button type="submit" class="btn btn-secondary" style="border-radius: 20px;">
                                      Update Profile
                                    </button>    

@csrf
</form>
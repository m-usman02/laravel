@extends('layouts.master')
@section('content')
<div class="pagetitle">
      <h1>Posts</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
          <li class="breadcrumb-item">Posts</li>
          <li class="breadcrumb-item active">Create</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Create Post</h5>

              <!-- Horizontal Form -->
              <form action="{{route('post.store')}}" method="POST" enctype="multipart/form-data">
                  @csrf
                <div class="row mb-3">
                  <label for="inputEmail3" class="col-sm-2 col-form-label">Post Title</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control"  name="title" value="{{old('title')}}">
                    @error('title')
                     <div class="text-danger">{{$message}}</div>
                    @enderror
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputEmail3" class="col-sm-2 col-form-label">Body</label>
                  <div class="col-sm-10">
                    <textarea class="form-control" rows="10"  name="body">{{old('body')}}</textarea>
                    @error('body')
                     <div class="text-danger">{{$message}}</div>
                    @enderror
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="inputEmail3" class="col-sm-2 col-form-label">Image</label>
                  <div class="col-sm-10">
                   <input type="file" class="form-control"  name="image">
                    @error('image')
                     <div class="text-danger">{{$message}}</div>
                    @enderror
                  </div>
                </div>
           

        
                
                <div class="text-center">
                  <button type="submit" class="btn btn-primary">Submit</button>
                
                </div>
              </form><!-- End Horizontal Form -->

            </div>
          </div>

        

        </div>

       
      </div>
    </section>
@endsection

